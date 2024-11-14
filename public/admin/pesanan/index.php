<?php

use controllers\TransaksiControllers;

require_once __DIR__ . "/../../../app/bootstrap.php";

$transaksi = new TransaksiControllers();
$data = $transaksi->getAllPesanan();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan</title>
</head>

<body class="bg-secondary-subtle">
    <?php require_once BASE_PATH . '/template/navbar.php' ?>
    <div class="container mt-5">
        <table class="table table-striped table-bordered shadow-sm caption-top">
            <caption>
                <h3>Data Pesanan</h3>
            </caption>
            <thead>
                <tr>
                    <th scope="col">Nomor</th>
                    <th scope="col">Tanggal Order</th>
                    <th scope="col">Kode Pelanggan</th>
                    <th scope="col">Nama Pelanggan</th>
                    <th scope="col">Kode Barang</th>
                    <th scope="col">Jenis Barang</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Nomor PO</th>
                    <th scope="col">Tanggal PO</th>
                    <th scope="col">Jumlah Barang</th>
                    <th scope="col">Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($psn = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <th scope="row"><?= $psn['nomor_order'] ?></th>
                        <td><?= $psn['tanggal_order'] ?></td>
                        <td><?= $psn['kode_pelanggan'] ?></td>
                        <td><?= $psn['nama_pelanggan'] ?></td>
                        <td><?= $psn['kode_barang'] ?></td>
                        <td><?= $psn['jenis_barang'] ?></td>
                        <td><?= $psn['nama_barang'] ?></td>
                        <td><?= $psn['nomor_po'] ?></td>
                        <td><?= $psn['tanggal_po'] ?></td>
                        <td><?= $psn['jumlah_barang'] ?></td>
                        <td><?= $psn['harga'] ?></td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</body>

</html>