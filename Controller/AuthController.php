<?php
require_once __DIR__ . '/../Repos/AuthRepo.php';
require_once __DIR__ . '/../Helper/Helper.php';
require_once __DIR__ . '/../Helper/AuthValidation.php';

class AuthController
{
    public $authRepo;
    public $helper;
    public $authValidation;

    public function __construct()
    {
        $this->authRepo = new AuthRepo();
        $this->helper = new Helper();
        $this->authValidation = new AuthValidation();
    }

    public function registerView()
    {
        //check if id exist redirect to index
        if (empty($_SESSION['user_id'])) {
            require_once __DIR__ . '/../views/register.php';
            exit;
        }
        $this->helper->redirectTo('./../views/index.php?controller=Article&action=index');

    }

    public function loginView()
    {
        //check if token exist redirect to index
        if (empty($_SESSION['user_id'])) {
            require_once __DIR__ . '/../views/login.php';
            exit();
        }
        $this->helper->redirectTo('./../views/index.php?controller=Article&action=index');
    }

    public function register()
    {
        if (!$this->authValidation->isFormSubmitted('register')) {
            $this->authValidation->setErrorOfFormInSession("<h3>sorry, error happen  <br></h3>");
            require_once __DIR__ . '/../views/error_page.php';
            exit;
        }
        try {
            if (!$this->authValidation->isRegisterFormValid()) {
                $this->helper->redirectTo('./../views/index.php?controller=Auth&action=registerView');
            }
            $user = [
                'name' => $_POST["name"],
                'email' => $_POST["email"],
                'password' => password_hash($_POST["password"], PASSWORD_DEFAULT)
            ];
            if (!$this->authRepo->create($user)) {
                $this->authValidation->setErrorOfFormInSession("unknown error happen ");
                $this->helper->redirectTo('./../views/index.php?controller=Auth&action=registerView');
            }
            $this->helper->redirectTo('./../views/index.php?controller=Auth&action=loginView');
        } catch (Exception $e) {
            $this->authValidation->setErrorOfFormInSession("unknown error happen  ");
            $this->helper->redirectTo('./../views/index.php?controller=Auth&action=registerView');
        }
    }


    public function login()
    {
        if (!$this->authValidation->isFormSubmitted('login')) {
            $this->authValidation->setErrorOfFormInSession("<h3>sorry, error happen  <br></h3>");
            require_once __DIR__ . '/../views/error_page.php';
            exit;
        }
        if (!$this->authValidation->isLoginFormValid()) {
            $this->helper->redirectTo('./../views/index.php?controller=Auth&action=loginView');
        }
        $user = $this->authRepo->getByEmail($_POST["email"]);
        if (!password_verify($_POST["password"], $user["password"])) {
            $this->authValidation->setErrorOfFormInSession("Invalid Email or Password");
            $this->helper->redirectTo('./../views/index.php?controller=Auth&action=loginView');
        }
        unset($_SESSION['user_id']);
        $_SESSION['user_id'] = $user['id'];
        $this->helper->redirectTo('./../views/index.php?controller=Article&action=index');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        $this->helper->redirectTo('./../views/index.php?controller=Auth&action=loginView');
    }
}














