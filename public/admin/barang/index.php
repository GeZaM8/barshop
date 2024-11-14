<?php

use controllers\BarangControllers;

require_once __DIR__ . "/../../../app/bootstrap.php";

$barang = new BarangControllers();
$data = $barang->getAllBarang();
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
                    <th scope="col">Kode</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Jenis Barang</th>
                    <th scope="col">Satuan</th>
                    <th scope="col">Harga Beli</th>
                    <th scope="col">Harga Jual</th>
                    <th scope="col">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($brg = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <th scope="row"><?= $brg['kode'] ?></th>
                        <td><?= $brg['nama'] ?></td>
                        <td><?= $brg['jenis'] ?></td>
                        <td><?= $brg['satuan'] ?></td>
                        <td><?= $brg['harga_beli'] ?></td>
                        <td><?= $brg['harga_jual'] ?></td>
                        <td><?= $brg['jumlah'] ?></td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</body>

</html>