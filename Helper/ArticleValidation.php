<?php
require_once __DIR__ . '/FormValidation.php';

class ArticleValidation extends FormValidation
{
    public function __construct()
    {
    }

    public function error(string $ms)
    {
        unset($_SESSION['message']);
        $_SESSION['message'] = $ms;
        require_once __DIR__ . '/../views/error_page.php';
        exit;
    }

    public function setErrorOfFormInSession(string $ms): void
    {
        unset($_SESSION['data']);
        $_SESSION['data'] = [
            'title' => $_POST["title"],
            'body' => $_POST["body"],
            'author' => $_POST["author"],
            'error' => $ms
        ];
    }

}