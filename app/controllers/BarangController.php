<?php

namespace controllers;

use models\Database;

class BarangController extends Database
{
    function getAllBarang($queryPlus = "")
    {
        global $con;

        $query = "SELECT * FROM barang $queryPlus";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function insertBarang($data)
    {
        $nama = $data['nama'];
        $jenis = $data['jenis'];
        $satuan = $data['satuan'];
        $harga_beli = $data['harga_beli'];
        $harga_jual = $data['harga_jual'];
        $jumlah = $data['jumlah'];

        $query = "INSERT INTO barang VALUES (0, '$nama', '$jenis', '$satuan', $harga_beli, $harga_jual, $jumlah)";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function updateBarang($data, $kode)
    {
        $nama = $data['nama'];
        $jenis = $data['jenis'];
        $satuan = $data['satuan'];
        $harga_beli = $data['harga_beli'];
        $harga_jual = $data['harga_jual'];
        $jumlah = $data['jumlah'];

        $query = "UPDATE barang SET nama = '$nama', jenis = '$jenis', satuan = '$satuan', harga_beli = $harga_beli, harga_jual = $harga_jual, jumlah = $jumlah WHERE kode = $kode";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function getBarangByKode($kode)
    {
        $query = "SELECT * FROM barang WHERE kode = $kode";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function setStok($kode, $jumlah)
    {
        $query = "UPDATE barang SET jumlah = jumlah + $jumlah WHERE kode = $kode";
        $result = mysqli_query($this->db, $query);

        return $result;
    }
}
