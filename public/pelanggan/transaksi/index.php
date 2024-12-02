<?php

use controllers\DetailTransaksiController;
use controllers\TransaksiController;

require_once __DIR__ . "/../../../app/bootstrap.php";

if (!isset($_SESSION['username']))
    return header('Location: ' . BASE_URL . '/index.php');
if ($_SESSION['level'] != "Pelanggan") return header('Location: ' . BASE_URL . '/index.php');

$transaksi = new TransaksiController();
$detail = new DetailTransaksiController();

$data = $transaksi->getTransaksiById($_SESSION['pelanggan']['kode']);
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
            </caption>
            <thead>
                <tr>
                    <th scope="col" class="text-center" style="width: 50px;">Nomor</th>
                    <th scope="col">Tanggal Order</th>
                    <th scope="col">Barang</th>
                    <!-- <th scope="col">Total Harga</th> -->
                    <th scope="col" class="bg-info-subtle">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($trs = mysqli_fetch_assoc($data)): ?>
                    <?php
                    $status = match ($trs['status']) {
                        'Pending' => 'bg-warning-subtle',
                        'Paid' => 'bg-success-subtle',
                        'Cancelled' => 'bg-danger-subtle'
                    }
                    ?>
                    <tr>
                        <th scope="row" class="text-center"><?= $trs['nomor_order'] ?></th>
                        <td><?= $trs['tanggal_order'] ?></td>
                        <td>
                            <ul class="list-group">
                                <?php
                                $dataDetail = $detail->getDetailByOrder($trs['nomor_order']);
                                while ($dtl = mysqli_fetch_assoc($dataDetail)):
                                ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <?= $dtl['kode_barang'] ?>. <?= $dtl['nama_barang'] ?> (<?= $dtl['jenis_barang'] ?>): Rp<?= number_format($dtl['total_harga'], 0, ',', '.') ?>
                                        <span class="badge text-bg-primary rounded-pill" style="font-size: 15px"><?= $dtl['jumlah_barang'] ?></span>
                                    </li>
                                <?php endwhile ?>
                            </ul>
                        </td>
                        <!-- <td><?= $trs['harga'] ?></td> -->
                        <td class="<?= $status ?>"><?= $trs['status'] ?></td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</body>

</html>