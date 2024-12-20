<?php

use controllers\BarangController;
use controllers\CartController;
use controllers\PelangganController;
use controllers\TransaksiController;

require_once __DIR__ . "/../../../app/bootstrap.php";

if (!isset($_SESSION['username']))
    return header('Location: ' . BASE_URL . '/index.php');
if ($_SESSION['level'] != "Pelanggan") return header('Location: ' . BASE_URL . '/index.php');

$barang = new BarangController();
$transaksi = new TransaksiController();
$cart = new CartController();

$plg = $_SESSION['pelanggan'];
$data = $cart->getAllCart();

if (isset($_GET['beli'])) {
    if ($transaksi->beli($_GET)) {
    }
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
}
if (isset($_GET['cancel'])) {
    if ($cart->deleteCart($_GET['cancel'])) {
    }
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
</head>

<body class="bg-secondary-subtle">
    <?php require_once BASE_PATH . '/template/navbar.php' ?>
    <div class="container mt-5">
        <table class="table table-striped table-bordered shadow-sm caption-top">
            <caption>
                <h3>Data Barang</h3>
            </caption>
            <thead>
                <tr>
                    <th scope="col" class="text-center">Id Cart</th>
                    <th scope="col">Kode Barang</th>
                    <th scope="col">Jumlah Barang</th>
                    <th scope="col">Harga Barang</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $harga = 0;
                while ($crt = mysqli_fetch_assoc($data)):
                    $harga += $crt['total_harga']; ?>
                    <tr>
                        <th scope="row" class="text-center" style="width: 70px;"><?= $crt['id_cart'] ?></th>
                        <td><?= $crt['kode_barang'] ?></td>
                        <td><?= $crt['jumlah_barang'] ?></td>
                        <td>Rp. <?= number_format($crt['harga_jual']) . "/" . $crt['satuan'] ?></td>
                        <td>Rp. <?= number_format($crt['total_harga']) ?></td>
                        <td style="width: 200px;" class="">
                            <a href="?cancel=<?= $crt['id_cart'] ?>" class="btn btn-danger" name="check-out">Cancel</a>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">
                        <div class="p-2">Total harga: Rp.<?= number_format($harga) ?></div>
                        <a href="?beli=<?= $plg['kode'] ?>" class="btn btn-primary">Beli</a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>