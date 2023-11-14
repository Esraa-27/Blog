<?php
require_once 'connect_DB.php';
$conn = DBConnection::getInstance();
$pdo = $conn->connect();

$statement =
    'CREATE TABLE user(
        id   INT AUTO_INCREMENT PRIMARY KEY ,
        name  VARCHAR(100) NOT NULL,
        email  VARCHAR(50) NOT NULL,
        password  VARCHAR(500) NOT NULL
        );';

$pdo->exec($statement);