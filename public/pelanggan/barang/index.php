<?php

use controllers\BarangController;
use controllers\TransaksiController;

require_once __DIR__ . "/../../../app/bootstrap.php";

$barang = new BarangController();
$transaksi = new TransaksiController();

$data = $barang->getAllBarang();
$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
}
if (isset($_GET['check-out'])) {
    if ($transaksi->checkoutTransaksi($_POST)) {
        header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
    } else {
        $error = true;
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
                        <td><?= $brg['harga_beli'] ?></td>
                        <td><?= $brg['harga_jual'] ?></td>
                        <td><?= $brg['jumlah'] ?></td>
                        <td style="width: 200px;">
                            <a href="?check-out=<?= $brg['kode'] ?>" class="btn btn-primary">Check-Out</a>
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