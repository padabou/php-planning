<?php
include("dbconnect.php");
try{
}catch(PDOException $e){
    var_dump($e->getMessage());
    echo "Database connexion error";
}
$bdd->query("SET NAMES 'utf8'");

if(isset($_GET['month'])) {
    $dateToGet = $_GET['month'];
} else {
    $dateToGet = date("W-Y");
}
$param = explode("-", $dateToGet);
$week = $param[0];
$year = $param[1];

$date = new DateTime();
$date->setISODate((int) $year, (int) $week);
$date_next_month = new DateTime();
$date_next_month = $date_next_month->setISODate((int) $year, (int) $week)->add(new DateInterval('P1W'));
$date_previous_month = new DateTime();
$date_previous_month = $date_previous_month->setISODate((int) $year, (int) $week)->sub(new DateInterval('P1W'));
$labelMonth = array("00" => "December", "01" => "January", "02" => "Februar", "03" => "March", "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December", "13" => "January");
$labelWeek = array("1" => "Monday", "2" => "Tuesday", "3" => "Wednesday", "4" => "Thursday", "5" => "Friday", "6" => "Saturday", "0" => "Sunday");

?>

<!DOCTYPE html>
<html lang="fr" xmlns:og="http://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>My best schedule</title>
    <meta name="description"
          content="My schedule :-)">
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet"  type="text/css" href="css/normalize.css">
    <link rel="stylesheet"  type="text/css" href="css/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
<?php include "header.php"; ?>
<section>

    <article>
        <div class="wrapper">

            <div class="logo">
                <img src="img/calendar.png" alt="Logo" title="Logo"/>
            </div>
            <div class="content">
                <div id="titre" class="titre">
                    <h1><?php echo "Schedule"; ?></h1>
                    <h2><?php echo $date->format("W") . " " . $date->format("Y") ?></h2>
                </div>
                <div>
                    <a rel="nofollow" href="/schedule-week.php?month=<?php echo $date_previous_month->format("W-Y"); ?>"><< Previous Week</a> - <a rel="nofollow" href="/schedule-week.php?month=<?php echo $date_next_month->format("W-Y"); ?>">Next Week >></a>
                </div>
                <div>
                        <h2 class="titre">
                            My Schedule
                        </h2>
                        <?php
                        $event = array();
                        $sql = "SELECT e.date_event, e.description, e.label FROM `event` e  WHERE '" . $date->format("Y") . ((int) $date->format("W") - 1) ."' = YEARWEEK(e.date_event) order by e.date_event";
                        foreach  ($bdd->query($sql) as $row) {
                            $eventDate = date_create_from_format("Y-m-d", $row['date_event']);

                            $event[$eventDate->format("d")] = $row;
                        }
                        ?><div class="week">
                        <?php
                        $dateTmp = new DateTime();
                        for ($i = 0; $i <= 6; $i++) {
                            $dateTmp->setISODate((int) $year, (int) $week, $i);
                            $cellStyle = "day";
                            echo '<div class="'.$cellStyle.'"><div class="labelDay">' . $labelWeek[$dateTmp->format("w")] . " " . $dateTmp->format("d") . "</div>";
                            if(!isset($event[ $dateTmp->format("d")])) {
                                echo "<div class='labelDayNoEvent'>No Event</div>";
                            } else {
                                if(isset($event[ $dateTmp->format("d")])) {
                                    echo "<div class='labelDayEvent'>".$event[$dateTmp->format("d")]["label"]."</div>";
                                    echo "<div class='labelDayEvent'>".$event[$dateTmp->format("d")]["description"]."</div>";
                                }
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>



            </div>
        </div>
    </article>
</section>
<footer>
    <div style="text-align: center">
    Image by <a href="https://pixabay.com/fr/users/skeeze-272447/?utm_source=link-attribution&utm_medium=referral&utm_campaign=image&utm_content=1237237">skeeze</a>
    </div>
</footer>
</body>
</html>
