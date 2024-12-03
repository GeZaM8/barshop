<?php

use controllers\PesananController;

require_once __DIR__ . "/../../../app/bootstrap.php";

if (!isset($_SESSION['username']))
    return header('Location: ' . BASE_URL . '/index.php');
if ($_SESSION['level'] != "Admin") return header('Location: ' . BASE_URL . '/index.php');

$pesanan = new PesananController();
$data = $pesanan->getAllPesanan();

if (isset($_GET['status'])) {
    $data = $pesanan->getAllPesanan("WHERE status = '$_GET[status]'");
}

if (isset($_GET['accept'])) {
    if ($pesanan->acceptPesanan($_GET['accept'])) {
    }
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Purchase Order</title>
</head>

<body class="bg-secondary-subtle">
    <?php require_once BASE_PATH . '/template/navbar.php' ?>
    <div class="container mt-5">
        <table class="table table-striped table-bordered shadow-sm caption-top">
            <caption>
                <h3>Purchase Order</h3>
                <div width="100%" class="bg-light p-2 d-flex gap-3 align-items-center">
                    <a href="<?= (isset($_GET['status']) && $_GET['status'] == 'Pending') ? "?" : "?status=Pending" ?>" class="btn <?= (isset($_GET['status']) && $_GET['status'] == 'Pending') ? "btn active" : "btn" ?>">Pending</a>
                    <a href="<?= (isset($_GET['status']) && $_GET['status'] == 'Accepted') ? "?" : "?status=Accepted" ?>" class="btn <?= (isset($_GET['status']) && $_GET['status'] == 'Accepted') ? "btn active" : "btn" ?>">Accepted</a>
                    <a href="<?= (isset($_GET['status']) && $_GET['status'] == 'Rejected') ? "?" : "?status=Rejected" ?>" class="btn <?= (isset($_GET['status']) && $_GET['status'] == 'Rejected') ? "btn active" : "btn" ?>">Rejected</a>
                    <a href="<?= (isset($_GET['status']) && $_GET['status'] == 'Paid') ? "?" : "?status=Paid" ?>" class="btn <?= (isset($_GET['status']) && $_GET['status'] == 'Paid') ? "btn active" : "btn" ?>">Paid</a>

                    <a href="?" class="ms-auto"><i class="bi bi-x-lg text-danger fs-3"></i></a>
                </div>
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
                        'Rejected' => 'bg-danger-subtle',
                        'Paid' => 'bg-info-subtle'
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
                        <td>Rp. <?= number_format($psn['harga']) ?></td>
                        <td class="<?= $status ?>"><?= $psn['status'] ?></td>
                        <td>
                            <?php if ($psn['status'] != 'Accepted' && $psn['status'] != 'Paid'): ?>
                                <a href="?accept=<?= $psn['nomor_po'] ?>" class="btn btn-success">Accept</a>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</body>

</html>