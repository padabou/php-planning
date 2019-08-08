CREATE TABLE `event` (
    `id` int(11) NOT NULL,
    `label` varchar(128) NOT NULL,
    `date_event` date NOT NULL,
    `description` varchar(256) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE `event`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `event`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;