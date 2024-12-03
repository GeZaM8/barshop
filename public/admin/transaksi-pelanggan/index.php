<?php

use controllers\DetailTransaksiController;
use controllers\TransaksiController;

require_once __DIR__ . "/../../../app/bootstrap.php";

if (!isset($_SESSION['username']))
    return header('Location: ' . BASE_URL . '/index.php');
if ($_SESSION['level'] != "Admin") return header('Location: ' . BASE_URL . '/index.php');

$transaksi = new TransaksiController();
$detail = new DetailTransaksiController();
$data = $transaksi->getAllTransaksi();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['save'])) {
        if ($transaksi->updateTransaksi($_POST, $_GET['save'])) {
        }
    }
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
</head>

<body class="bg-secondary-subtle">
    <?php require_once BASE_PATH . '/template/navbar.php' ?>
    <div class="container mt-5">
        <table class="table table-striped table-bordered shadow-sm caption-top align-middle">
            <caption>
                <h3>Data Transaksi</h3>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Insert
                </button>
            </caption>
            <thead>
                <tr>
                    <th scope="col" class="text-center" style="width: 50px;">Nomor</th>
                    <th scope="col">Tanggal Order</th>
                    <th scope="col">Kode Pelanggan</th>
                    <th scope="col">Nama Pelanggan</th>
                    <th scope="col">Barang</th>
                    <th scope="col">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $harga = 0;
                while ($trs = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td scope="row" class="text-center"><?= $trs['nomor_order'] ?></td>
                        <td><?= $trs['tanggal_order'] ?></td>
                        <td><?= $trs['kode_pelanggan'] ?></td>
                        <td><?= $trs['nama_pelanggan'] ?></td>
                        <td>
                            <ul class="list-group">
                                <?php
                                $dataDetail = $detail->getDetailByOrder($trs['nomor_order']);
                                $harga = 0;
                                while ($dtl = mysqli_fetch_assoc($dataDetail)):
                                    $harga += $dtl['total_harga'];
                                ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= $dtl['kode_barang'] ?>. <?= $dtl['nama_barang'] ?> (<?= $dtl['jenis_barang'] ?>): Rp<?= number_format($dtl['total_harga'], 0, ',', '.') ?>
                                        <span class="badge text-bg-primary rounded-pill" style="font-size: 15px"><?= $dtl['jumlah_barang'] ?></span>
                                    </li>
                                <?php endwhile ?>
                            </ul>
                        </td>
                        <td>Rp. <?= number_format($harga) ?></td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>


    <!-- Modal insert -->
    <div class="modal fade" id="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="post">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Insert Transaksi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-3" name="nama" placeholder="">
                    <input type="text" class="form-control mb-3" name="alamat" placeholder="">
                    <input type="number" class="form-control mb-3" name="no_telp" placeholder="Jumlah Barang">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="insert">Insert</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>