<?php
//include "./config.php";
require_once __DIR__ . '/Controller/ArticleController.php';
require_once __DIR__ . '/Controller/AuthController.php';

class Router
{
    public $route = [
        'Article' => array('index', 'deleteView', 'delete', 'createView', "add", 'updateView', 'update'),
        'Author' => array('getAll', 'getById'),
        'Auth' => array('login', 'loginView', 'register', 'registerView', 'logout')
    ];

    public function route($url)
    {
        try {
            if (empty($url)) {
                $_SESSION['message'] = "<h3>empty URL <br></h3>";
                require_once __DIR__ . '/views/error_page.php';
            }
            // split url
            $arrayOfUrl = explode("?", $url, 2);
            $target = $arrayOfUrl[1];
            $target = explode("&", $target);

            $controller = str_replace("controller=", "", $target[0]);
            $action = str_replace("action=", "", $target[1]);

            //check if controller exist
            if ($this->isControllerExist($controller)) {
                $arrayOfActions = $this->route[$controller];
                if ($this->isActionExist($action, $arrayOfActions)) {
                    $controller = $controller . 'Controller';
                    $controllerInstance = new $controller();
                    $controllerInstance->$action();
                } else {
                    $_SESSION['message'] = "<h3>action not found <br></h3>";
                    require_once __DIR__ . '/views/error_page.php';
                }
            } else {
                $_SESSION['message'] = "<h3>controller not found<br></h3>";
                require_once __DIR__ . '/views/error_page.php';
            }
        } catch (Exception $e) {
            $_SESSION['message'] = "<h3>sorry, error happen you can go to articles page ....  <br></h3>";
            require_once __DIR__ . '/views/error_page.php';
        }
    }

    private function isControllerExist($controller)
    {
        return array_key_exists($controller, $this->route);
    }

    private function isActionExist($action, $arrayOfActions)
    {
        return in_array($action, $arrayOfActions);
    }
}
