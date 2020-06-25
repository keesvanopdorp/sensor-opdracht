<?php

use Dotenv\Dotenv;

require_once "vendor/autoload.php";
$dotenv = Dotenv::createImmutable(__dir__);
$dotenv->load();

/**
 * Class Db
 * @property mysqli $conn
 */

class Db {
    private $con;
    public function __construct()
    {
        $this->con = new mysqli($_ENV['MYSQL_HOST'], $_ENV['MYSQL_USERNAME'], $_ENV['MYSQL_PASSWORD'], $_ENV['MYSQL_DATABASE']);
    }

    /**
     * @return mysqli
     */
    public function getConnection() {
        return $this->con;
    }
}
