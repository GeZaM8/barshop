<?php

use controllers\BarangController;
use controllers\CartController;
use controllers\TransaksiController;

require_once __DIR__ . "/../../../app/bootstrap.php";

if (!isset($_SESSION['username']))
    return header('Location: ' . BASE_URL . '/index.php');
if ($_SESSION['level'] != "Pelanggan") return header('Location: ' . BASE_URL . '/index.php');

$barang = new BarangController();
$transaksi = new TransaksiController();
$cart = new CartController();

$data = $barang->getAllBarang();
$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['check-out'])) {
        if ($_POST['jumlah'] == 0) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }

        if ($cart->insertCart($_POST['check-out'], $_POST['jumlah'])) {
            header('Location: ' . $_SERVER['REQUEST_URI']);
        } else {
            $error = true;
        }
    }
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
                    <th scope="col" class="text-center">Kode</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Jenis Barang</th>
                    <th scope="col">Satuan</th>
                    <th scope="col">Harga Beli</th>
                    <th scope="col">Harga Jual</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($brg = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <th scope="row" class="text-center" style="width: 70px;"><?= $brg['kode'] ?></th>
                        <td><?= $brg['nama'] ?></td>
                        <td><?= $brg['jenis'] ?></td>
                        <td><?= $brg['satuan'] ?></td>
                        <td>Rp. <?= number_format($brg['harga_beli']) ?></td>
                        <td>Rp. <?= number_format($brg['harga_jual']) ?></td>
                        <td><?= $brg['jumlah'] ?></td>
                        <td style="width: 200px;" class="">
                            <form class="d-flex" method="post">
                                <input type="number" class="form-control me-3" name="jumlah" value="0" style="width: 50px;" min="0" max="<?= $brg['jumlah'] ?>">
                                <button type="submit" class="btn btn-primary" name="check-out" value="<?= $brg['kode'] ?>">Check-Out</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>


    <?php if ($error): ?>
        <script>
            alert('Anda belum melengkapi data Anda');
            window.location.href = "<?= strtok($_SERVER["REQUEST_URI"], '?') ?>"
        </script>
    <?php
        $error = false;
    endif ?>
</body>

</html>