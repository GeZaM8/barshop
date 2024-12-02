<?php

namespace controllers;

use models\Database;

class TransaksiController extends Database
{
    private $pelanggan;

    function __construct()
    {
        $this->pelanggan = new PelangganController();
        parent::__construct();
    }

    function getAllTransaksi()
    {
        $query = "SELECT * FROM transaksiView";

        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function getTransaksi($nomor_order)
    {
        $query = "SELECT * FROM transaksiview WHERE nomor_order = $nomor_order";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function beli($data)
    {
        $kode_pelanggan = $data['beli'];
        $query = "INSERT INTO transaksi(kode_pelanggan) VALUES ($kode_pelanggan)";
        $result = mysqli_query($this->db, $query);
        $id_transaksi = mysqli_insert_id($this->db);

        $cart = new CartController();
        $detail = new DetailTransaksiController();
        $barang = new BarangController();
        $dataCart = $cart->getAllCart();
        while ($crt = mysqli_fetch_assoc($dataCart)) {
            if ($crt['jumlah_barang'] == 0) continue;
            $id_detail = $detail->insertDetail($id_transaksi, $crt);

            $dtl = mysqli_fetch_assoc($detail->getDetail($id_detail));
            $dataBarang = mysqli_fetch_assoc($barang->getBarangByKode($dtl['kode_barang']));
            if ($dataBarang['jumlah'] - $dtl['jumlah_barang'] < 0) {
                $detail->deleteDetail($id_detail);
            } else $barang->setStok($dtl['kode_barang'], -$dtl['jumlah_barang']);
        }
        $cart->deleteAllCart($_SESSION['id']);

        return true;
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

    function getTransaksiById($id)
    {
        $query = "SELECT * FROM transaksiview WHERE kode_pelanggan = $id";
        $result = mysqli_query($this->db, $query);

        return $result;
    }
}
