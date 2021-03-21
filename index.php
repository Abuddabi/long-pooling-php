<?php

function out($arg, $method = 1) {
    echo "<pre>";
    if ($method === 1) var_dump($arg);
    else print_r($arg);
    exit();
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Polling</title>
</head>
<body>
<ul id="messages">
</ul>

<script src="/main.js"></script>
</body>
</html>