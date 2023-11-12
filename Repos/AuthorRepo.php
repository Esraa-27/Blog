<?php

class AuthorRepo
{
    protected $pdo;

    public function __construct()
    {
        $conn = DBConnection::getInstance();
        $this->pdo = $conn->connect();
    }

    public function getAll(): ?array
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

    function getById ($id ){
        $sql = 'SELECT * FROM author where id=:id';
        $statement = $GLOBALS['pdo']->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $author = $statement->fetch(PDO::FETCH_ASSOC);
        if(!empty($author)){
            return $author;
        }
        return null;
    }
}