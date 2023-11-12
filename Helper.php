<?php

class Helper
{
    public function filterStringInput($data): ?string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    public  function redirectTo($url){
        header('Location: '. $url);
        exit;
    }
}