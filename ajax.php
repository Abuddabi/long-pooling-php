<?php

require_once "db.php";

function out($arg, $method = 1) {
    echo "<pre>";
    if ($method === 1) var_dump($arg);
    else print_r($arg);
    exit();
}

if (isset($_GET['get_messages'])) {
	header('Content-type: application/json');

	$messagesList = $db->query("select * from messages");

	$messagesList = $messagesList->fetchAll();
	foreach ($messagesList as &$item) {
		$item['created_at'] = date("H:i:s" ,strtotime($item['created_at']));
	}

	$json = json_encode($messagesList);

	echo $json;
}
elseif (isset($_GET['listen'])) {
	header('Content-type: application/json');
	
	$rows_count = $_GET['rows_count'];

	$i = 0;

	while (true) {

    if ($i === 25) {

      $json = json_encode(["status" => false]);

      echo $json;
      break;
    }

    $messagesList = $db->query('select * from messages');

    if ((int)$messagesList->rowCount() > (int)$rows_count) {

    		$messagesList = $messagesList->fetchAll();
    		foreach ($messagesList as &$item) {
    			$item['created_at'] = date("H:i:s" ,strtotime($item['created_at']));
    		}

        $json = json_encode([
            "status" => true,
            "messages" => $messagesList
        ]);

        echo $json;
        break;
    }

    $i++;

    sleep(0.8);
	}
}
elseif (isset($_GET['send'])) {

	// out($_GET['name']);

	header('Content-type: application/json');

	$stmt = $db->prepare(
		"insert into messages 
			set 
				name = :name, 
				message = :message "
	);

	$res = $stmt->execute([
		'name' => $_GET['name'],
		'message' => $_GET['message']
	]);

	if ($res) {
		echo json_encode(["status" => "success"]);
	}
	else {
		echo json_encode(["status" => "error", "errorText" => $db->errorInfo()]);
	}

	// if ($res) {
	// 	echo "success";
	// }
	// else {
	// 	echo "Error ".$db->errorInfo();
	// }
}