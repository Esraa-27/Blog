<?php

class AuthorRepo
{
    protected $pdo;

    public function __construct()
    {
        $conn = DBConnection::getInstance();
        $this->pdo = $conn->connect();
    }

    public function getAllAuthor(): ?array
    {
        $sql = 'SELECT * FROM author';
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $articles = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($articles))
            return $articles;
        else
            return null;
    }
}