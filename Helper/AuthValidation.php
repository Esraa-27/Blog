<?php
require_once __DIR__ . '/FormValidation.php';

class AuthValidation extends FormValidation
{

    public $authRepo;
    public $helper;

    function __construct()
    {
        $this->authRepo = new AuthRepo();
        $this->helper = new Helper();
    }


    public function isRegisterFormValid(): bool
    {
        //check form not empty
        if ($this->isFormEmpty(['name', 'email', 'password', 'confirm-password'])) {
            $this->setErrorOfFormInSession("Invalid or Empty Values");
            return false;
        } //check email not exist
        if ($this->isEmailExist()) {
            $this->setErrorOfFormInSession("This Email already Exist  ");
            return false;
        } //check email not valid
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $this->setErrorOfFormInSession("This Email not valid");
            return false;
        } //check password & confirm-password are same
        if ($_POST["password"] !== $_POST["confirm-password"]) {
            $this->setErrorOfFormInSession("Password and Confirm Password not same ");
            return false;
        } //check Password not valid
        if (!preg_match("/^([a-zA-Z0-9\_\-\.\@]+){6,15}$/", $_POST["password"])) {
            $this->setErrorOfFormInSession("Password is not strong enough");
            return false;
        }
        return true;
    }


    public function setErrorOfFormInSession(string $ms): void
    {
        unset($_SESSION['data']);
        $_SESSION['data'] = [
            'name' => $_POST["name"],
            'email' => $_POST["email"],
            'password' => $_POST["password"],
            'confirm-password' => $_POST["confirm-password"],
            'error' => $ms
        ];
    }

    public function isEmailExist(): bool
    {
        return $this->authRepo->getByEmail($_POST["email"]) != null;
    }

    public function isLoginFormValid(): bool
    {
        if ($this->isFormEmpty(["email", "password"])) {
            $this->setErrorOfFormInSession("Invalid or Empty Values");
            return false;
        }
        if (!$this->isEmailExist()) {
            $this->setErrorOfFormInSession(" Email not exist ");
            return false;
        }
        return true;
    }
}