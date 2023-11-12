<?php


class BaseEntity
{
    public $id;

    public function __construct($id)
    {
        $this->id=$id;
    }
}