<?php

header('Content-type: application/json');

require_once "db.php";

$messages = $db->query("select * from messages");

$messagesList = [];

while ($message = $messages->fetchObject()) {
    $messagesList[] = $message;
}

$json = json_encode($messagesList);

echo $json;


