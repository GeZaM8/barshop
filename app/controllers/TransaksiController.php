<?php

namespace controllers;

use models\Database;

class TransaksiController extends Database
{
    private $pelanggan;

    function __construct()
    {
        $this->pelanggan = new PelangganController();
    }

    function getAllTransaksi()
    {
        $query = "SELECT * FROM transaksiView";

        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function checkoutTransaksi($data)
    {
        $dataPelanggan = mysqli_fetch_assoc($this->pelanggan->checkPelangganById($_SESSION['id']));
        if ($dataPelanggan == null) {
            return false;
        }
        $kode_pelanggan = $data['kode'];

        $query = "INSERT INTO transaksi (tanggal_order, kode_pelanggan) VALUES ('NOW()', $kode_pelanggan)";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function updateTransaksi($data, $nomor)
    {
        $tanggal_order = $data['tanggal_order'];
        $kode_pelanggan = $data['kode_pelanggan'];
        $kode_barang = $data['kode_barang'];
        $jumlah_barang = $data['jumlah_barang'];
        $status = $data['status'];

        $query = "UPDATE transaksi SET tanggal_order = '$tanggal_order', kode_pelanggan = $kode_pelanggan, kode_barang = $kode_barang, jumlah_barang = $jumlah_barang, status = '$status'
                WHERE nomor_order = $nomor";
        $result = mysqli_query($this->db, $query);

        return $result;
    }
}
