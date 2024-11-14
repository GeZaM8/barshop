<?php

namespace controllers;

use models\Database;
use mysqli;

class TransaksiControllers extends Database
{
    function getAllPesanan()
    {
        $query = "SELECT * FROM transaksiView where terbayar = 'N'";

        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function getAllPembayaran()
    {
        $query = "SELECT * FROM transaksiView where terbayar = 'Y'";

        $result = mysqli_query($this->db, $query);

        return $result;
    }
}
