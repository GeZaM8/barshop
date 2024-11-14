<?php

namespace models;

class Database
{
    public $db;
    const HOST = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DATABASE = "Barshop";

    public function __construct()
    {
        $this->db = mysqli_connect(self::HOST, self::USERNAME, self::PASSWORD, self::DATABASE);
    }
}
