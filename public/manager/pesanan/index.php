<?php

use controllers\PesananController;

require_once __DIR__ . "/../../../app/bootstrap.php";

$pesanan = new PesananController();
$data = $pesanan->getAllPesanan();

if (isset($_GET['cancel'])) {
    if ($pesanan->deletePesanan($_GET['cancel'])) {
    }
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order</title>
</head>

<body class="bg-secondary-subtle">
    <?php require_once BASE_PATH . '/template/navbar.php' ?>
    <div class="container mt-5">
        <table class="table table-striped table-bordered shadow-sm caption-top align-middle">
            <caption>
                <h3>Purchase Order</h3>
            </caption>
            <thead>
                <tr>
                    <th scope="col">Nomor</th>
                    <th scope="col">Tanggal PO</th>
                    <th scope="col">Kode Pemasok</th>
                    <th scope="col">Nama Pemasok</th>
                    <th scope="col">Kode Barang</th>
                    <th scope="col">Jenis Barang</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Jumlah Barang</th>
                    <th scope="col">Total Harga</th>
                    <th scope="col" class="bg-info-subtle">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($psn = mysqli_fetch_assoc($data)): ?>
                    <?php
                    $status = match ($psn['status']) {
                        'Pending' => 'bg-warning-subtle',
                        'Accepted' => 'bg-success-subtle',
                        'Rejected' => 'bg-danger-subtle'
                    }
                    ?>
                    <tr>
                        <th scope="row"><?= $psn['nomor_po'] ?></th>
                        <td><?= $psn['tanggal_po'] ?></td>
                        <td><?= $psn['kode_pemasok'] ?></td>
                        <td><?= $psn['nama_pemasok'] ?></td>
                        <td><?= $psn['kode_barang'] ?></td>
                        <td><?= $psn['jenis_barang'] ?></td>
                        <td><?= $psn['nama_barang'] ?></td>
                        <td><?= $psn['jumlah_barang'] ?></td>
                        <td><?= $psn['harga'] ?></td>
                        <td class="<?= $status ?>"><?= $psn['status'] ?></td>
                        <td>
                            <?php if ($psn['status'] == 'Pending'): ?>
                                <a href="?cancel=<?= $psn['nomor_po'] ?>" class="btn btn-danger">Cancel</a>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</body>

</html>