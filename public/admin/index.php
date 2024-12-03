<?php

use controllers\BarangController;
use controllers\DetailTransaksiController;
use controllers\PesananController;
use controllers\UserController;

require_once __DIR__ . "/../../app/bootstrap.php";

if (!isset($_SESSION['username']))
    return header('Location: ' . BASE_URL . '/index.php');

$user = new UserController();
$barang = new BarangController();
$detail = new DetailTransaksiController();
$pesanan = new PesananController();

$pengeluaran = mysqli_fetch_assoc($pesanan->getTotalHarga());
$pemasukan = mysqli_fetch_assoc($detail->getTotalHarga());
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Document</title>
</head>

<body class="bg-secondary-subtle">
    <?php require_once BASE_PATH . '/template/navbar.php' ?>
    <div class="container mt-5">

        <div class="row">
            <div class="card text-bg-success mb-3 me-3 fs-3" style="max-width: 18rem;">
                <div class="card-header">
                    <i class="bi bi-wallet2"></i>
                    Pemasukan
                </div>
                <div class="card-body">
                    <h5 class="card-title">Rp. <?= number_format($pemasukan['Total']) ?></h5>
                </div>
            </div>
            <div class="card text-bg-danger mb-3 me-3 fs-3" style="max-width: 18rem;">
                <div class="card-header">
                    <i class="bi bi-cash"></i>
                    Pengeluaran
                </div>
                <div class="card-body">
                    <h5 class="card-title">Rp. -<?= number_format($pengeluaran['Total']) ?></h5>
                </div>
            </div>
        </div>
    </div>
</body>

</html>