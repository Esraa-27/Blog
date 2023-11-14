<?php

class FormValidation
{

    public function isFormEmpty(array $inputs): bool
    {
        foreach ($inputs as $input) {
            if (empty($_POST[$input])) return true;
        }
        return false;
    }

    public function isFormSubmitted(string $form): bool
    {
        return $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST[$form]);
    }

}