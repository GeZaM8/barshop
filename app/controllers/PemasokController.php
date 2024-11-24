<?php

namespace controllers;

use models\Database;
use mysqli;

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

    function insertPemasok($data)
    {
        $nama = $data['nama'];
        $alamat = $data['alamat'];
        $no_telp = $data['no_telp'];
        $email = $data['email'];

        $data['level'] = 'Pemasok';
        $user = new UserController();
        $user->registerUser($data);
        $id = $user->getUserByUsername($data['username'])['id'];

        $query = "INSERT INTO pemasok VALUES (0, $id, '$nama', '$alamat', '$no_telp', '$email', 'Aktif')";
        $result = mysqli_query($this->db, $query);

        return $result;
    }
}
