<?php


class Author extends BaseEntity
{
    public $name;
    public function __construct($id , $name)
    {
        parent::__construct($id);
        $this->name=$name;
    }
}