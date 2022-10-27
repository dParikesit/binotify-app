<?php

error_reporting(E_ALL);

session_start();
$_SESSION["count"]=0;

define("ROOT", dirname(__DIR__).DIRECTORY_SEPARATOR);

define("BASEPATH", TRUE);

define("URL", "http://localhost:3000");

spl_autoload_register(function ($className) 
{
    $fileName = sprintf("%s%s.php", ROOT, str_replace("\\", "/", $className));

    if (file_exists($fileName)) 
    {
        require ($fileName);
    } 
    else 
    {
        echo "file not found {$fileName}";
    }
});
