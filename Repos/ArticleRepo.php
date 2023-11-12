<?php

require_once __DIR__ . '/../DB/connect_DB.php';
require_once __DIR__ . '/../Model/Article.php';

class ArticleRepo
{
    protected $pdo;

    public function __construct()
    {
        $conn = DBConnection::getInstance();
        $this->pdo = $conn->connect();
    }

    public function getById(int $id)
    {
        $sql = 'SELECT * FROM article where id=:id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $article = $statement->fetch(PDO::FETCH_ASSOC);
        if (!empty($article)) {
            return $article;
        }
        return null;
    }

    public function getAll(): ?array
    {
        $sql = 'SELECT * FROM article';
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $articles = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($articles))
            return $articles;
        else
            return null;
    }

    public function create( $new_article)
    {
        if (empty($new_article)) {
            return null;
        }
        $sql = 'INSERT INTO article( title ,body ,author_id) VALUES( :title ,:body ,:author)';
        $statement = $this->pdo->prepare($sql);
        //bind prams
        $statement->bindParam(':title', $new_article['title']);
        $statement->bindParam(':body', $new_article['body']);
        $statement->bindParam(':author', $new_article['author_id']);

        return $statement->execute();
    }

    public function update($updated_article)
    {
        if (empty($updated_article)) {
            return null;
        }
        $sql = 'UPDATE article ' .
            'set title =:title , body =:body  ,author_id= :author ' .
            'where id= :updated_article_id ';
        $statement = $this->pdo->prepare($sql);
        //bind prams
        $statement->bindParam(':updated_article_id', $updated_article['id'], PDO::PARAM_INT);
        $statement->bindParam(':title', $updated_article['title']);
        $statement->bindParam(':body', $updated_article['body']);
        $statement->bindParam(':author', $updated_article['author']);

        return $statement->execute();
    }

    public function delete(int $id)
    {
        if (empty($id)) {
            return null;
        }
        $sql = 'DELETE FROM article WHERE id=:deleted_id';
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':deleted_id', $id, PDO::PARAM_INT);
        return $statement->execute();
    }

}