<?php

use controllers\PelangganController;

require_once __DIR__ . "/../../../app/bootstrap.php";

$pelanggan = new PelangganController();
$data = $pelanggan->getAllPelanggan();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan</title>
</head>

<body class="bg-secondary-subtle">
    <?php require_once BASE_PATH . '/template/navbar.php' ?>
    <div class="container mt-5">
        <table class="table table-striped table-bordered shadow-sm caption-top">
            <caption>
                <h3>Data Pelanggan</h3>
            </caption>
            <thead>
                <tr>
                    <th scope="col">Kode</th>
                    <th scope="col">Nama Pelanggan</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">No. Telp</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($plg = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <th scope="row"><?= $plg['kode'] ?></th>
                        <td><?= $plg['nama'] ?></td>
                        <td><?= $plg['alamat'] ?></td>
                        <td><?= $plg['no_telp'] ?></td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</body>

</html>