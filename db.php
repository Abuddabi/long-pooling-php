<?php

// database config
$env = require ".env";
$env = $env['DB'];

// pdo connect
$dsn = "{$env['DB_CONNECTION']}:host={$env['DB_HOST']};port={$env['DB_PORT']};";

try{  
	$db = new PDO(
	    "{$dsn}dbname=" . $env['DB_DATABASE'] . ";charset=utf8;",
	    $env['DB_USERNAME'],
	    $env['DB_PASSWORD'],
	   	[
	   		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8",
	   		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	   	]
	);

	// PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
}
catch(PDOException $e) {
	die($e->getMessage());
}