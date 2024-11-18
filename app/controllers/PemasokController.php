<?php

namespace controllers;

use models\Database;

class PemasokController extends Database
{

    function getAllPemasok()
    {
        $query = "SELECT * FROM pemasok";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function activatePemasok($kode, $activate)
    {
        $status = $activate == 1 ? 'Aktif' : 'Tidak Aktif';

        $query = "UPDATE pemasok SET status = '$status' WHERE kode = $kode";
        $result = mysqli_query($this->db, $query);

        return $result;
    }
}
