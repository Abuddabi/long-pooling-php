<?php

header('Content-type: application/json');

require_once "db.php";

$rows_count = $_GET['rows_count'];

$i = 0;

while (true) {

    if ($i === 25) {

        $json = json_encode([
            "status" => false
        ]);

        echo $json;

        break;
    }

    $messages = $db->query('select * from messages');

    if ((int)$messages->rowCount() > (int)$rows_count) {
        $messagesList = [];

        while ($message = $messages->fetchObject()) {
            $messagesList[] = $message;
        }

        $json = json_encode([
            "status" => true,
            "messages" => $messagesList
        ]);

        echo $json;
        break;
    }

    $i++;

    sleep(1);
}
