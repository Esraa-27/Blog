<?php


require_once './../DB/connect_DB.php';
$conn=DBConnection::getInstance();
$pdo =$conn->connect();
class AuthorController
{
    function getAll(){
        $sql = 'SELECT id, name FROM author';
        $statement = $GLOBALS['pdo']->prepare($sql);
        if ($statement->execute()){
            return  $statement->fetchAll(PDO::FETCH_ASSOC);
        }else
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