<?php
try{
    include "dbconnect.php";
}catch(PDOException $e){
    var_dump($e->getMessage());
    echo "Database connexion error";
}
$bdd->query("SET NAMES 'utf8'");
if($_POST["add"]) {
    $insert = "INSERT INTO `event` (`id`, `date_event`, `label`, `description`) VALUES (NULL, '" . $_POST["event-date"] . "', '" . $_POST["label"] . "', '" . $_POST["description"] . "');";
    try{
        $bdd->query($insert);
    }catch(PDOException $e){
        var_dump($e->getMessage());
    }
    header('Location: /scheduleManagement.php');
} else if($_POST["remove"]) {
    $delete = "DELETE FROM `event` where `id` = " . $_POST["id"] . ";";
    try{
        $bdd->query($delete);
    }catch(PDOException $e){
        var_dump($e->getMessage());
    }
    header('Location: /scheduleManagement.php');
}
?>
<html>
<head>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
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
                <div class='site-flex-item admin'>
                    <h1>create event</h1>
                    <form method="POST" class="form-event">
                        <div class="form-group">
                            <label for="label">Label</label>
                            <input type="text" id="label" class="form-control" name="label" placeholder="Event Label"/>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" id="description" class="form-control" name="description" placeholder="Event Description"/>
                        </div>
                        <div class="form-group">
                                <label for="event-date">Event Date</label>
                                <input id="event-date" name="event-date" class="form-control" type="date" value="<?php echo date('d') . "-" . date('m') . "-" . date('Y'); ?>">
                        </div>
                        <div>
                            <p>
                                <input class="btn btn-primary" type="submit" value="add" name="add">
                            </p>
                        </div>

                    </form>
                </div>
                <?php
                $sql =  'SELECT e.id, e.date_event, e.description, e.label FROM `event` e  order by date_event desc limit 100';
                echo "<div class='site-flex-item admin'>";
                foreach  ($bdd->query($sql) as $row) {
                    echo "<div class='event-detail'>ID : " . $row['id'] . "&nbsp Date : " . $row['date_event'] . "&nbsp" . "&nbsp Label : " . $row['label'] . "&nbsp Description : " . $row['description'] . "<form method='post'><input type='hidden' name='id' value='" .  $row['id'] ."'/><input type='submit' class='btn btn-danger'  name='remove' value='Remove'/></form></div>";
                }?>
            </div>
        </div>
    </article>
</section>
</body>
</html>
