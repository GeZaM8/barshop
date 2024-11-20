<?php

namespace controllers;

use models\Database;
use mysqli_sql_exception;

class PelangganController extends Database
{
    function getAllPelanggan()
    {
        $query = "SELECT * FROM pelanggan";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function insertPelanggan($data)
    {
        $nama = $data['nama'];
        $alamat = $data['alamat'];
        $no_telp = $data['no_telp'];
        $id = isset($data['id']) ? $data['id'] : null;

        $query = "INSERT INTO pelanggan VALUES (0";
        if ($id != null) $query .= ", $id";
        else $query .= ", null";
        $query .= ", '$nama', '$alamat', '$no_telp')";

        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function updatePelanggan($data, $kode)
    {
        $nama = $data['nama'];
        $alamat = $data['alamat'];
        $no_telp = $data['no_telp'];
        $id = isset($data['id']) ? $data['id'] : null;

        $query = "UPDATE pelanggan SET nama = '$nama', alamat = '$alamat', no_telp = '$no_telp'";
        if ($id != null) $query .= ", id_account = '$id'";
        $query .= " WHERE kode = '$kode'";

        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function deletePelanggan($kode)
    {
        try {
            $query = "DELETE FROM pelanggan WHERE kode = '$kode'";
            $result = mysqli_query($this->db, $query);
        } catch (mysqli_sql_exception $e) {
            echo $e->getCode();
            return $result;
        }

        return $result;
    }

    function checkPelangganById($id = 0)
    {
        $user = ($id == 0) ? $_SESSION['id'] : $id;
        $query = "SELECT * FROM pelanggan p 
                INNER JOIN user u 
                ON p.id_account = u.id 
                WHERE u.id = $user";
        $result = mysqli_query($this->db, $query);
        return mysqli_num_rows($result) > 0;
    }
}
