<?php
require_once __DIR__ . '/../config.php';
class DBConnection{
    private static $instance=null;
    private function __construct(){}

    public static function getInstance(){
        if(!self::$instance)
            self::$instance = new DBConnection();

        return self::$instance;

    }
    public  function connect(){
        try {
            $dsn = 'mysql:host='. HOST .';dbname='.DBNAME.';charset='.CHARSET;
            $pdo = new PDO($dsn, USERNAME, PASSWORD);
            if ($pdo) {
                return $pdo ;
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }
}



