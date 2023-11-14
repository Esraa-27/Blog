<?php
require_once __DIR__ . '/../DB/connect_DB.php';

class AuthRepo
{
    protected $pdo;

    public function __construct()
    {
        $conn = DBConnection::getInstance();
        $this->pdo = $conn->connect();
    }

    public function getById(int $id)
    {
        if (empty($id)) {
            return null;
        }
        $sql = 'SELECT * FROM user where id=:id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $article = $statement->fetch(PDO::FETCH_ASSOC);
        if (!empty($article)) {
            return $article;
        }
        return null;
    }

    public function getByEmail($email)
    {
        if (empty($email)) {
            return null;
        }
        $sql = 'SELECT * FROM user where email=:email';
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $article = $statement->fetch(PDO::FETCH_ASSOC);
        if (!empty($article))
            return $article;
        else
            return null;
    }

    public function create($user)
    {
        if (empty($user)) {
            return null;
        }
        $sql = 'INSERT INTO user( name ,email ,password) VALUES( :name ,:email ,:password)';
        $statement = $this->pdo->prepare($sql);
        //bind prams
        $statement->bindParam(':name', $user['name']);
        $statement->bindParam(':email', $user['email']);
        $statement->bindParam(':password', $user['password']);

        return $statement->execute();
    }

}