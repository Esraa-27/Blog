<?php

require_once __DIR__ . '/BaseEntity.php';

class Article extends BaseEntity
{
    public $title;
    public $body;
    public $author_id;


    public function __construct($id , $title ,$body , $author_id)
    {
        parent::__construct($id);
        $this->title=$title;
        $this->body=$body;
        $this->author_id=$author_id;
    }
}