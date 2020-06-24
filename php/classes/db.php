<?php

/**
 * Class Db
 * @property mysqli $conn
 */

class Db {
    private $con;
    public function __construct()
    {
        $this->con = new mysqli('localhost', 'root', '', 'sensor-opdracht');
    }

    /**
     * @return mysqli
     */
    public function getConnection() {
        return $this->con;
    }
}
