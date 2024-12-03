<?php

namespace controllers;

use models\Database;

class DetailTransaksiController extends Database
{
    function  insertDetail($id_transaksi, $crt)
    {
        $query = "INSERT INTO detail_transaksi VALUES (0, $id_transaksi, $crt[kode_barang], $crt[jumlah_barang])";
        $result = mysqli_query($this->db, $query);

        if ($result) return mysqli_insert_id($this->db);
        else $result;
    }

    function getDetailByOrder($nomor)
    {
        $query = "SELECT * FROM detail_transaksiview WHERE nomor_order = $nomor";;
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function getDetail($detail)
    {
        $query = "SELECT * FROM detail_transaksiView WHERE nomor_detail = $detail";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function deleteDetail($id_detail)
    {
        $query = "DELETE FROM detail_transaksi WHERE nomor_detail = $id_detail";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function getTotalHarga($queryPlus = "")
    {
        $query = "SELECT SUM(total_harga) as Total FROM detail_transaksiview $queryPlus";
        $result = mysqli_query($this->db, $query);

        return $result;
    }
}
