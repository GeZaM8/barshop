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
</body>

</html>