<?php

use controllers\BarangController;

require_once __DIR__ . "/../../../app/bootstrap.php";

$barang = new BarangController();
$data = $barang->getAllBarang();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['save'])) {
        if ($barang->updateBarang($_POST, $_GET['save'])) {
        }
        header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
    }
    if (isset($_POST['insert'])) {
        if ($barang->insertBarang($_POST)) {
        }
        header('Location: ' . $_SERVER["REQUEST_URI"]);
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
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insert">
                    Insert
                </button>
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
                    <?php if (isset($_GET['edit']) && $_GET['edit'] == $brg['kode']): ?>
                        <tr>
                            <form action="?save=<?= $brg['kode'] ?>" method="post">
                                <th scope="row"><input type="text" class="form-control text-center" value="<?= $brg['kode'] ?>" disabled></th>
                                <td><input type="text" class="form-control" name="nama" value="<?= $brg['nama'] ?>" required></td>
                                <td><input type="text" class="form-control" name="jenis" value="<?= $brg['jenis'] ?>" required></td>
                                <td><input type="text" class="form-control" name="satuan" value="<?= $brg['satuan'] ?>"></td>
                                <td><input type="number" class="form-control" name="harga_beli" value="<?= $brg['harga_beli'] ?>" required></td>
                                <td><input type="number" class="form-control" name="harga_jual" value="<?= $brg['harga_jual'] ?>"></td>
                                <td><input type="number" class="form-control" name="jumlah" value="<?= $brg['jumlah'] ?>" required></td>
                                <td>
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="?" class="btn btn-danger">Cancel</a>
                                </td>
                            </form>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <th scope="row" class="text-center" style="width: 70px;"><?= $brg['kode'] ?></th>
                            <td><?= $brg['nama'] ?></td>
                            <td><?= $brg['jenis'] ?></td>
                            <td><?= $brg['satuan'] ?></td>
                            <td><?= $brg['harga_beli'] ?></td>
                            <td><?= $brg['harga_jual'] ?></td>
                            <td><?= $brg['jumlah'] ?></td>
                            <td style="width: 200px;">
                                <a href="?edit=<?= $brg['kode'] ?>" class="btn btn-primary">Edit</a>
                            </td>
                        </tr>
                    <?php endif ?>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>


    <!-- Modal insert -->
    <div class="modal fade" id="insert" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="post">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Insert Transaksi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-3" name="nama" placeholder="Nama Barang">
                    <input type="text" class="form-control mb-3" name="jenis" placeholder="Jenis Barang">
                    <input type="text" class="form-control mb-3" name="satuan" placeholder="Jenis Satuan">
                    <input type="number" class="form-control mb-3" name="harga_beli" placeholder="Harga Beli">
                    <input type="number" class="form-control mb-3" name="harga_jual" placeholder="Harga Jual">
                    <input type="number" class="form-control mb-3" name="jumlah" placeholder="Total Barang" min="0" value="">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="insert">Insert</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>