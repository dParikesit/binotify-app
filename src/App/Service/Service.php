<?php

namespace App\Service;
use \PDO;
if (!defined('BASEPATH')){
    require_once "../../inc/config.php";
}


class Service
{
    protected $db;

    private $DB_OPTIONS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    /**
     * Make a connection to the resource.
     */
    public function __construct()
    {
        try {
            $this->db = new PDO("pgsql:host={$_ENV['POSTGRES_HOST']};dbname={$_ENV['POSTGRES_DB']}", $_ENV['POSTGRES_USER'], $_ENV['POSTGRES_PASSWORD'], $this->DB_OPTIONS);
            return "Successfully Connected";
        } catch (\PDOException $e) {
            die("Error ! " . $e->getMessage());
        }
    }

    /**
     * Close connection to the resource.
     */
    public function __destruct()
    {
    $this->db = null;
    }
}

?>