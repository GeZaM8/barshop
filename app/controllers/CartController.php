<?php

namespace controllers;

use controllers\PelangganController;
use models\Database;

class CartController extends Database
{
    function getAllCart()
    {
        $query = "SELECT * FROM cart WHERE id_account = $_SESSION[id]";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function insertCart($barang, $jumlah)
    {
        $pelanggan = new PelangganController();

        $dataPelanggan = $_SESSION['pelanggan'];
        if ($dataPelanggan == null) {
            return false;
        }
        $kode_pelanggan = $dataPelanggan['kode'];

        $query = "INSERT INTO cart VALUES (0, $kode_pelanggan, $_SESSION[id], $barang, $jumlah)";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function deleteAllCart($id)
    {
        $query = "DELETE FROM cart WHERE id_account = $id";
        $result = mysqli_query($this->db, $query);
        mysqli_query($this->db, "ALTER TABLE cart AUTO_INCREMENT = 1");

        return $result;
    }
}
