<?php

namespace controllers;

use models\Database;

class DetailTransaksiController extends Database
{
    function insertDetail() {}

    function getDetailByOrder($nomor)
    {
        $query = "SELECT * FROM detail_transaksiview WHERE nomor_order = $nomor";;
        $result = mysqli_query($this->db, $query);

        return $result;
    }
}
