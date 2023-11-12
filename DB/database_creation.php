<?php

// for connect with DB
$pdo = require_once 'connect_DB.php';

// SQL statement for creating new tables
$statements = [
    'CREATE TABLE author(
        id   INT AUTO_INCREMENT PRIMARY KEY ,
        name  VARCHAR(100) NOT NULL
        );',
    'CREATE TABLE article (
        id   INT AUTO_INCREMENT PRIMARY KEY ,
        title varchar(200) NOT NULL,
        body varchar(10000) NOT NULL,
        author_id INT NOT NULL,
        FOREIGN KEY(author_id)  REFERENCES author(id)  ON DELETE CASCADE
    )'];


// execute SQL statements
foreach ($statements as $statement) {
    $pdo->exec($statement);
}


// insert a single author

$name = 'user 2';
$sql = 'INSERT INTO author(name) VALUES(:name)';

$statement = $pdo->prepare($sql);

$statement->execute([
    ':name' => $name
]);

