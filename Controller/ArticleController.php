<?php

//require_once __DIR__.'/../config.php';
require_once __DIR__ . '/../Repos/ArticleRepo.php';
require_once __DIR__ . '/../Repos/AuthorRepo.php';
require_once __DIR__ . '/../Helper/Helper.php';
require_once __DIR__ . '/../Helper/ArticleValidation.php';

session_start();

class ArticleController
{

    protected $articleRepo;
    protected $authorRepo;
    protected $helper;
    protected $articleValidation;

    public function __construct()
    {
        $this->articleRepo = new ArticleRepo();
        $this->authorRepo = new AuthorRepo();
        $this->helper = new Helper();
        $this->articleValidation = new ArticleValidation();
    }

    public function index()
    {
        if (empty($_SESSION['user_id'])) {
            $this->helper->redirectTo('./../views/index.php?controller=Auth&action=loginView');
        }
        $articles = $this->articleRepo->getAll();
        $authors = $this->authorRepo->getAll();
        if (empty($articles) || empty($authors))
            $this->articleValidation->error("<h3>can't load articles <br></h3>");
        require_once __DIR__ . '/../views/display_articles_table.php';
    }

    public function createView()
    {
        if (empty($_SESSION['user_id'])) {
            $this->helper->redirectTo('./../views/index.php?controller=Auth&action=loginView');
        }
        $authors = $this->authorRepo->getAll();
        if (empty($authors))
            $this->articleValidation->error("<h3>can't load Create Form  <br></h3>");
        require_once __DIR__ . '/../views/create_article_form.php';
    }

    public function updateView()
    {
        if (empty($_SESSION['user_id'])) {
            $this->helper->redirectTo('./../views/index.php?controller=Auth&action=loginView');
        }
        $authors = $this->authorRepo->getAll();
        if (empty($authors)) {
            $this->articleValidation->error("<h3>can't load Create Form  <br></h3>");
        }
        $updated_article_id = (int)$_GET['id'];
        if (empty($updated_article_id)) {
            $this->articleValidation->error("<h3>can't load Update Form  <br></h3>");
        }
        $updated_article = $this->articleRepo->getById($updated_article_id);
        if (empty($updated_article)) {
            $this->articleValidation->error("<h3>this Article not found <br></h3>");
        }
        require_once __DIR__ . '/../views/update_article_form.php';
        exit;
    }

    public function deleteView()
    {
        if (empty($_SESSION['user_id'])) {
            $this->helper->redirectTo('./../views/index.php?controller=Auth&action=loginView');
        }
        $deleted_article_id = (int)$_GET['id'];
        if (empty($deleted_article_id)) {
            $this->articleValidation->error("<h3>can't load Delete Page  <br></h3>");
        }
        $deleted_article = $this->articleRepo->getById($deleted_article_id);
        if (empty($deleted_article)) {
            $this->articleValidation->error("<h3>this Article not found <br></h3>");
        }
        require_once __DIR__ . '/../views/delete_article_page.php';
    }

    function add()
    {
        if (empty($_SESSION['user_id'])) {
            $this->helper->redirectTo('./../views/index.php?controller=Auth&action=loginView');
        }
        if (!$this->articleValidation->isFormSubmitted('create')) {
            $this->articleValidation->error("<h3>sorry, error happen  <br></h3>");
        }
        try {
            if ($this->articleValidation->isFormEmpty(["title", "body"]) || !is_int((int)$_POST["author"])) {
                $this->articleValidation->setErrorOfFormInSession("Invalid or Empty Values");
                $this->helper->redirectTo('./../views/index.php?controller=Article&action=createView');
            }
            $title = $this->helper->filterStringInput($_POST["title"]);
            $body = $this->helper->filterStringInput($_POST["body"]);
            $author_id = (int)$_POST["author"];
            $new_article = ["title" => $title, "body" => $body, "author_id" => $author_id];
            if (!$this->articleRepo->create($new_article)) {
                $this->articleValidation->error("<h3>can't create this Article <br></h3>");
            }
            $this->helper->redirectTo(/*__DIR__ .*/ './../views/index.php?controller=Article&action=index');
        } catch (Exception $e) {
            $this->articleValidation->error("<h3>sorry, error happen you can go to articles page ....  <br></h3>");
        }
    }

    function update()
    {
        if (empty($_SESSION['user_id'])) {
            $this->helper->redirectTo('./../views/index.php?controller=Auth&action=loginView');
        }
        if (!$this->articleValidation->isFormSubmitted('update')) {
            $this->articleValidation->error("<h3>sorry, error happen you can go to articles page ....  <br></h3>");
        }
        try {
            //access the Data of article went to update
            $updated_article_id = (int)$_GET['id'];
            if (empty($updated_article_id) || !is_int($updated_article_id)) {
                $this->articleValidation->error("<h3>can't load update page ,you can go to articles page .... <br></h3>");
            }
            $updated_article = $this->articleRepo->getById($updated_article_id);
            if ($updated_article == null) {
                $this->articleValidation->error("<h3>this article not found ,you can go to articles page .... <br></h3>");
            }
            if ($this->articleValidation->isFormEmpty(["title", "body"]) || !is_int((int)$_POST["author"])) {
                $this->articleValidation->setErrorOfFormInSession("Invalid or Empty Values");
                $this->helper->redirectTo('./../views/index.php?controller=Article&action=updateView&id=' . $updated_article_id);
            }
            $updated_article['title'] = $this->helper->filterStringInput($_POST["title"]);
            $updated_article['body'] = $this->helper->filterStringInput($_POST["body"]);
            $updated_article['author'] = (int)$_POST["author"];

            if (!$this->articleRepo->update($updated_article)) {
                $this->articleValidation->error("<h3>sorry, error happen you can go to articles page ....  <br></h3>");
            }
            $this->helper->redirectTo('./../views/index.php?controller=Article&action=index');
        } catch (Exception $e) {
            $this->articleValidation->error("<h3>sorry, error happen you can go to articles page ....  <br></h3>");
        }
    }

    function delete()
    {
        if (empty($_SESSION['user_id'])) {
            $this->helper->redirectTo('./../views/index.php?controller=Auth&action=loginView');
        }
        if (!$this->articleValidation->isFormSubmitted('confirm_delete')) {
            $this->articleValidation->error("<h3>sorry, error happen ,you can go to articles page ....   <br></h3>");
        }
        try {
            $deleted_article_id = (int)$_GET['id'];
            if (empty($deleted_article_id) || !is_int($deleted_article_id)) {
                $this->articleValidation->error("<h3>this Article not found <br></h3>");
            }
            if ($this->articleRepo->getById($deleted_article_id) == null) {
                $this->articleValidation->error("<h3>this Article not found <br></h3>");
            }
            if (!$this->articleRepo->delete($deleted_article_id)) {
                $this->articleValidation->error("<h3>can't delete this article <br></h3>");
            }
            $this->helper->redirectTo('./../views/index.php?controller=Article&action=index');
        } catch (Exception $e) {
            $this->articleValidation->error("<h3>Error happen ,you can go to articles page .... <br></h3>");
        }

    }
}

