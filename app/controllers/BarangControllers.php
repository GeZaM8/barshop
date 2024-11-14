<?php

namespace controllers;

use models\Database;

class BarangControllers extends Database
{
    function getAllBarang()
    {
        global $con;

        $query = "SELECT * FROM barang";
        $result = mysqli_query($this->db, $query);

        return $result;
    }
}
