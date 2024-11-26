<?php

use controllers\DetailTransaksiController;
use controllers\TransaksiController;

require_once __DIR__ . "/../../../app/bootstrap.php";

$transaksi = new TransaksiController();
$detail = new DetailTransaksiController();
$data = $transaksi->getAllTransaksi();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['save'])) {
        if ($transaksi->updateTransaksi($_POST, $_GET['save'])) {
        }
    }
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
}
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
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Insert
                </button>
            </caption>
            <thead>
                <tr>
                    <th scope="col" class="text-center" style="width: 50px;">Nomor</th>
                    <th scope="col">Tanggal Order</th>
                    <th scope="col">Barang</th>
                    <!-- <th scope="col">Total Harga</th> -->
                    <th scope="col" class="bg-info-subtle">Status</th>
                    <th scope="col">Aksi</th>
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
                    <?php if (isset($_GET['edit']) && $_GET['edit'] == $trs['nomor_order']): ?>
                        <tr>
                            <form action="?save=<?= $trs['nomor_order'] ?>" method="post">
                                <th scope="row"><input type="text" class="form-control text-center" value="<?= $trs['nomor_order'] ?>" disabled></th>
                                <td><input type="date" class="form-control" name="tanggal_order" value="<?= $trs['tanggal_order'] ?>" required></td>
                                <td><input type="text" class="form-control" name="kode_pelanggan" value="<?= $trs['kode_pelanggan'] ?>" required></td>
                                <td><input type="text" class="form-control" name="nama_pelanggan" value="<?= $trs['nama_pelanggan'] ?>" disabled></td>
                                <td><input type="text" class="form-control" name="kode_barang" value="<?= $trs['kode_barang'] ?>" required></td>
                                <td><input type="text" class="form-control" name="jenis_barang" value="<?= $trs['jenis_barang'] ?>" disabled></td>
                                <td><input type="text" class="form-control" name="nama_barang" value="<?= $trs['nama_barang'] ?>" disabled></td>
                                <td><input type="number" class="form-control" name="jumlah_barang" value="<?= $trs['jumlah_barang'] ?>" required></td>
                                <td><input type="number" class="form-control" name="harga" value="<?= $trs['harga'] ?>" disabled></td>
                                <td>
                                    <select class="form-control" name="status" required>
                                        <option value="Pending" <?= $trs['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="Paid" <?= $trs['status'] == 'Paid' ? 'selected' : '' ?>>Paid</option>
                                        <option value="Cancelled" <?= $trs['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="?" class="btn btn-danger">Cancel</a>
                                </td>
                            </form>
                        </tr>

                    <?php else: ?>
                        <tr>
                            <td scope="row" class="text-center"><?= $trs['nomor_order'] ?></td>
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
                            <td style="width: 200px;">
                                <a href="?edit=<?= $trs['nomor_order'] ?>" class="btn btn-primary">Edit</a>
                                <a href="?delete=<?= $trs['nomor_order'] ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapusnya?')">Delete</a>
                            </td>
                        </tr>
                    <?php endif ?>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>


    <!-- Modal insert -->
    <div class="modal fade" id="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="post">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Insert Transaksi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-3" name="nama" placeholder="">
                    <input type="text" class="form-control mb-3" name="alamat" placeholder="">
                    <input type="number" class="form-control mb-3" name="no_telp" placeholder="Jumlah Barang">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="insert">Insert</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>