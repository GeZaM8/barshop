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

        $query = "INSERT INTO pelanggan VALUES (0, '$nama', '$alamat', '$no_telp')";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function updatePelanggan($data, $kode)
    {
        $nama = $data['nama'];
        $alamat = $data['alamat'];
        $no_telp = $data['no_telp'];

        $query = "UPDATE pelanggan SET nama = '$nama', alamat = '$alamat', no_telp = '$no_telp' WHERE kode = '$kode'";
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
}
