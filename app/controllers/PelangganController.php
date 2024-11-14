<?php

namespace controllers;

use models\Database;

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

        return mysqli_affected_rows($this->db);
    }

    function updatePelanggan($data, $kode)
    {
        $nama = $data['nama'];
        $alamat = $data['alamat'];
        $no_telp = $data['no_telp'];

        $query = "UPDATE pelaggan SET nama = '$nama', alamat = '$alamat', $no_telp = '$no_telp' WHERE kode = '$kode'";
        $result = mysqli_query($this->db, $query);

        return mysqli_affected_rows($this->db);
    }

    function deletePelanggan($kode)
    {
        $query = "DELETE FROM pelaggan WHERE kode = '$kode'";
        $result = mysqli_query($this->db, $query);

        return mysqli_affected_rows($this->db);
    }
}
