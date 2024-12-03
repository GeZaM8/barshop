<?php

namespace controllers;

use models\Database;

class PesananController extends Database
{
    function getAllPesanan($queryPlus = "")
    {
        $query = "SELECT * FROM pesananView $queryPlus ORDER BY status";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function getAllPesananByPemasok($queryPlus = "")
    {
        $query = "SELECT * FROM pesananView WHERE kode_pemasok = {$_SESSION['pemasok']['kode']} $queryPlus";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function getPesanan($nomor_po)
    {
        $query = "SELECT * FROM pesanan WHERE nomor_po = $nomor_po";
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

    function acceptPesanan($nomor_po)
    {
        $query = "UPDATE pesanan SET status = 'Accepted' WHERE nomor_po = $nomor_po";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function deletePesanan($nomor)
    {
        $query = "DELETE FROM pesanan WHERE nomor_po = $nomor";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function paidPesanan($nomor)
    {
        $query = "UPDATE pesanan SET status = 'Paid', deleted_at = NOW() WHERE nomor_po = $nomor";
        $result = mysqli_query($this->db, $query);

        $pesanan = mysqli_fetch_assoc(self::getPesanan($nomor));
        $barang = new BarangController();
        $brg = $barang->setStok($pesanan['kode_barang'], $pesanan['jumlah_barang']);

        return $result;
    }

    function getTotalHarga()
    {
        $query = "SELECT SUM(harga) as Total FROM pesananView";
        $result = mysqli_query($this->db, $query);

        return $result;
    }
}
