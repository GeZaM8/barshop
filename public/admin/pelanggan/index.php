<?php

use controllers\PelangganController;
use controllers\UserController;

require_once __DIR__ . "/../../../app/bootstrap.php";

$pelanggan = new PelangganController();
$user = new UserController();

$data = $pelanggan->getAllPelanggan();
$error = "";
$code = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['save'])) {
        if ($pelanggan->updatePelanggan($_POST, $_GET['save'])) {
        }
        header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
    }
    if (isset($_POST['insert'])) {
        if ($pelanggan->insertPelanggan($_POST)) {
        }
        header('Location: ' . $_SERVER['REQUEST_URI']);
    }
}

if (isset($_GET['delete'])) {
    if ($code = $pelanggan->deletePelanggan($_GET['delete'])) {
        if ($code == 1451) {
            $error = "Pelanggan gagal dihapus, pelanggan masih terdapat transaksi";
        }
    }
    header('Location: ' .  strtok($_SERVER['REQUEST_URI'], '?'));
}
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
        <table class="table table-striped table-bordered shadow-sm caption-top align-middle">
            <caption>
                <h3>Data Pelanggan</h3>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Insert
                </button>
            </caption>
            <thead>
                <tr>
                    <th scope="col" class="text-center">Kode</th>
                    <th scope="col">Id Account</th>
                    <th scope="col">Nama Pelanggan</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">No. Telp</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($plg = mysqli_fetch_assoc($data)): ?>
                    <?php if (isset($_GET['edit']) && $_GET['edit'] == $plg['kode']): ?>
                        <tr>
                            <form action="?save=<?= $plg['kode'] ?>" method="post">
                                <th scope="row"><input type="text" class="form-control text-center" value="<?= $plg['kode'] ?>" disabled></th>
                                <th>
                                    <?php if ($plg['id_account'] == null): ?>
                                        <select name="id" id="id" class="form-select">
                                            <?php
                                            $dataUser = $user->getAllUser();
                                            while ($usr = mysqli_fetch_assoc($dataUser)): ?>
                                                <?php if ($usr['level'] == 'Pelanggan' && !(mysqli_num_rows($pelanggan->checkPelangganById($usr['id'])) > 0)): ?>
                                                    <option value="<?= $usr['id'] ?>"><?= $usr['username'] ?></option>
                                                <?php endif ?>
                                            <?php endwhile ?>
                                        <?php else: ?>
                                            <input type="text" name="id" class="form-control" value="<?= $plg['id_account'] ?>" disabled>
                                        </select>
                                    <?php endif ?>
                                </th>
                                <td><input type="text" class="form-control" name="nama" value="<?= $plg['nama'] ?>" required></td>
                                <td><input type="text" class="form-control" name="alamat" value="<?= $plg['alamat'] ?>" required></td>
                                <td><input type="tel" class="form-control" name="no_telp" value="<?= $plg['no_telp'] ?>" required></td>
                                <td>
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="?" class="btn btn-danger">Cancel</a>
                                </td>
                            </form>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <th scope="row" class="text-center" style="width: 70px;"><?= $plg['kode'] ?></th>
                            <th scope="row"><?= $plg['id_account'] ?></th>
                            <td><?= $plg['nama'] ?></td>
                            <td><?= $plg['alamat'] ?></td>
                            <td><?= $plg['no_telp'] ?></td>
                            <td style="width: 200px;">
                                <a href="?edit=<?= $plg['kode'] ?>" class="btn btn-primary">Edit</a>
                                <a href="?delete=<?= $plg['kode'] ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapusnya?')">Delete</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>


    <!-- Modal insert -->
    <div class="modal fade" id="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="post">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Insert Pelanggan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-3" name="nama" placeholder="Nama">
                    <input type="text" class="form-control mb-3" name="alamat" placeholder="Alamat">
                    <input type="tel" class="form-control mb-3" name="no_telp" placeholder="Nomor Telepon">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="insert">Insert</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>