<?php

namespace controllers;

use models\Database;

class PesananController extends Database
{
    function getAllPesanan()
    {
        $query = "SELECT * FROM pesananView";

        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function acceptPesanan($nomor_po)
    {
        $query = "UPDATE pesanan SET status = 'Accepted'";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function insertPesanan($data, $kodeBarang)
    {
        $kodePemasok = $data['kodePemasok'];
        $jumlah = $data['jumlah'];

        $query = "INSERT INTO pesanan (kode_supplier, kode_barang, jumlah_barang)
                 VALUES ($kodePemasok, $kodeBarang, $jumlah)";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function deletePesanan($nomor)
    {
        $query = "DELETE FROM pesanan WHERE nomor_po = $nomor";
        $result = mysqli_query($this->db, $query);

        return $result;
    }
}
