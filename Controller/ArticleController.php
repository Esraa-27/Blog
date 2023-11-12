<?php

//require_once __DIR__.'/../config.php';
require_once __DIR__ . '/../Repos/ArticleRepo.php';
require_once __DIR__ . '/../Repos/AuthorRepo.php';
require_once __DIR__ . '/../Helper.php';

session_start();

class ArticleController
{

    protected $articleRepo;
    protected $helper;

    public function __construct()
    {
        $this->articleRepo = new ArticleRepo();
        $this->authorRepo = new AuthorRepo();
        $this->helper = new Helper();
    }

    public function index()
    {
        $articles = $this->articleRepo->getAll();
        $authors = $this->authorRepo->getAll();

        if (empty($articles) || empty($authors)) {
            $_SESSION['message'] = "<h3>can't load articles <br></h3>";
            require_once __DIR__ . '/../views/error_page.php';
        } else
            require_once __DIR__ . '/../views/display_articles_table.php';
    }

    public function createView()
    {
        $authors = $this->authorRepo->getAll();
        if (empty($authors)) {
            $_SESSION['message'] = "<h3>can't load Create Form  <br></h3>";
            require_once __DIR__ . '/../views/error_page.php';
        } else
            require_once __DIR__ . '/../views/create_article_form.php';

    }

    public function updateView()
    {
        $authors = $this->authorRepo->getAll();
        if (empty($authors)) {
            $_SESSION['message'] = "<h3>can't load Create Form  <br></h3>";
            require_once __DIR__ . '/../views/error_page.php';
        } else {
            $updated_article_id = (int)$_GET['id'];
            if (empty($updated_article_id)) {
                $_SESSION['message'] = "<h3>can't load Update Form  <br></h3>";
                require_once __DIR__ . '/../views/error_page.php';
            } else {
                $updated_article = $this->articleRepo->getById($updated_article_id);
                if (empty($updated_article)) {
                    $_SESSION['message'] = "<h3>this Article not found <br></h3>";
                    require_once __DIR__ . '/../views/error_page.php';
                } else
                    require_once __DIR__ . '/../views/update_article_form.php';
            }
        }
    }

    public function deleteView()
    {
        $deleted_article_id = (int)$_GET['id'];
        if (empty($deleted_article_id)) {
            $_SESSION['message'] = "<h3>can't load Delete Page  <br></h3>";
            require_once __DIR__ . '/../views/error_page.php';
        } else {
            $deleted_article = $this->articleRepo->getById($deleted_article_id);
            if (empty($deleted_article)) {
                $_SESSION['message'] = "<h3>this Article not found <br></h3>";
                require_once __DIR__ . '/../views/error_page.php';
            } else {
                require_once __DIR__ . '/../views/delete_article_page.php';
            }
        }
    }

    function add()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
            try {
                if (empty($_POST["title"]) || empty($_POST["body"]) || !is_int((int)$_POST["author"])) {
                    $_SESSION['data'] = ['title' => $_POST["title"], 'body' => $_POST["body"], 'error' => "Invalid or Empty Values"];
                    $this->helper->redirectTo('./../views/index.php?controller=Article&action=createView');
                } else {
                    $title = $this->helper->filterStringInput($_POST["title"]);
                    $body = $this->helper->filterStringInput($_POST["body"]);
                    $author_id = (int)$_POST["author"];
                    $new_article = ["title" => $title, "body" => $body, "author_id" => $author_id];
                    $res = $this->articleRepo->create($new_article);
                    if ($res) {
                        $this->helper->redirectTo('./../views/index.php?controller=Article&action=index');
                    } else {
                        $_SESSION['message'] = "<h3>can't create this Article <br></h3>";
                        require_once __DIR__ . '/../views/error_page.php';
                    }
                }
            } catch (Exception $e) {
                $_SESSION['message'] = "<h3>sorry, error happen you can go to articles page ....  <br></h3>";
                require_once __DIR__ . '/../views/error_page.php';
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['create'])) {
            $_SESSION['message'] = "<h3>sorry, error happen  <br></h3>";
            require_once __DIR__ . '/../views/error_page.php';
        }
    }

    function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
            try {
                //access the Data of article went to update
                $updated_article_id = (int)$_GET['id'];

                if (empty($updated_article_id) || !is_int($updated_article_id)) {
                    $_SESSION['message'] = "<h3>can't load update page ,you can go to articles page .... <br></h3>";
                    require_once __DIR__ . '/../views/error_page.php';
                }
                $updated_article = $this->articleRepo->getById($updated_article_id);
                if ($updated_article == null) {
                    $_SESSION['message'] = "<h3>this article not found ,you can go to articles page .... <br></h3>";
                    require_once __DIR__ . '/../views/error_page.php';
                } else {
                    if (empty($_POST["title"]) || empty($_POST["body"]) || !is_int((int)$_POST["author"])) {
                        $_SESSION['data'] = ['title' => $_POST["title"], 'body' => $_POST["body"], 'author' => (int)$_POST["author"], 'error' => "Invalid or Empty Values"];
                        $this->helper->redirectTo('./../views/index.php?controller=Article&action=updateView&id=' . $updated_article_id);
                    } else {
                        $updated_article['title'] = $this->helper->filterStringInput($_POST["title"]);
                        $updated_article['body'] = $this->helper->filterStringInput($_POST["body"]);
                        $updated_article['author'] = (int)$_POST["author"];

                        if ($this->articleRepo->update($updated_article)) {
                            $this->helper->redirectTo('./../views/index.php?controller=Article&action=index');
                        } else
                            $_SESSION['message'] = "<h3>sorry, error happen you can go to articles page ....  <br></h3>";
                        require_once __DIR__ . '/../views/error_page.php';

                    }
                }
            } catch (Exception $e) {
                $_SESSION['message'] = "<h3>sorry, error happen you can go to articles page ....  <br></h3>";
                require_once __DIR__ . '/../views/error_page.php';
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['update'])) {
            $_SESSION['message'] = "<h3>sorry, error happen you can go to articles page ....  <br></h3>";
            require_once __DIR__ . '/../views/error_page.php';
        }
    }

    function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
            try {
                $deleted_article_id = (int)$_GET['id'];
                if (empty($deleted_article_id) || !is_int($deleted_article_id)) {
                    $_SESSION['message'] = "<h3>this Article not found <br></h3>";
                    require_once __DIR__ . '/../views/error_page.php';
                } elseif ($this->articleRepo->getById($deleted_article_id) == null) {
                    $_SESSION['message'] = "<h3>this Article not found <br></h3>";
                    require_once __DIR__ . '/../views/error_page.php';
                } else {
                    if ($this->articleRepo->delete($deleted_article_id)) {
                        $this->helper->redirectTo('./../views/index.php?controller=Article&action=index');
                    } else {
                        $_SESSION['message'] = "<h3>can't delete this article <br></h3>";
                        require_once __DIR__ . '/../views/error_page.php';

                    }
                }
            } catch (Exception $e) {
                $_SESSION['message'] = "<h3>Error happen ,you can go to articles page .... <br></h3>";
                require_once __DIR__ . '/../views/error_page.php';
            }
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['confirm_delete'])) {
            $_SESSION['message'] = "<h3>sorry, error happen ,you can go to articles page ....   <br></h3>";
            require_once __DIR__ . '/../views/error_page.php';
        }

    }
}

