<?php

// database config
const DB_NAME = 'db';
const DB_USER = 'root';
const DB_PASSWORD = 'root';

// pdo connect
$db = new PDO(
    'mysql:host=localhost;dbname=' . DB_NAME,
    DB_USER,
    DB_PASSWORD
);