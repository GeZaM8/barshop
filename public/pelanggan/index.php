<?php

use controllers\PelangganController;
use controllers\UserController;

require_once __DIR__ . "/../../app/bootstrap.php";

if (!isset($_SESSION['username']))
    return header('Location: ' . BASE_URL . '/index.php');

$user = new UserController();
$pelanggan = new PelangganController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit'])) {
        $_POST['id'] = $_SESSION['id'];
        $data = $pelanggan->checkPelangganById($_SESSION["id"]);
        $plg = mysqli_fetch_assoc($data);
        if (!mysqli_num_rows($data) > 0) {
            $pelanggan->insertPelanggan($_POST);
        } else {
            $pelanggan->updatePelanggan($_POST, $plg['kode']);
        }
    }
    header('Location: ?profile');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body class="bg-secondary-subtle">
    <?php require_once BASE_PATH . '/template/navbar.php' ?>
    <div class="container mt-5">
        <?php if (isset($_GET['profile'])): ?>
            <?php
            $data = $pelanggan->checkPelangganById($_SESSION["id"]);
            $plg = mysqli_fetch_assoc($data);

            ?>

            <form action="" method="post" class="container mt-5 w-75 border p-5 rounded-4 bg-body shadow">
                <h4 class="mb-5 text-center" style="font-weight: bold;">Profile</h4>

                <div class="row mb-3 align-items-center gap-3 justify-content-md-center">
                    <div class="col col-lg-4 d-flex align-items-center">
                        <label class="w-auto text-nowrap">Id Account:</label>
                        <input type="text" class="form-control ms-2" value="<?= $_SESSION['id'] ?>" disabled>
                    </div>
                    <div class="col col-lg-4 d-flex align-items-center">
                        <label class="w-auto text-nowrap">Kode plg:</label>
                        <input type="text" class="form-control ms-2" value="<?= $plg != null ? $plg['kode'] : "" ?>" disabled>
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label for="username" class="col-sm-2">Username</label>
                    <div class="col-auto">:</div>
                    <div class="col">
                        <input type="text" class="form-control" id="username" name="username" disabled value="<?= $_SESSION['username'] ?>">
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label for="nama" class="col-sm-2">Nama</label>
                    <div class="col-auto">:</div>
                    <div class="col">
                        <input type="text" class="form-control" id="nama" name="nama" <?= !isset($_GET['edit']) ? 'disabled' : '' ?> value="<?= $plg != null ? $plg['nama'] : "" ?>">
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label for="alamat" class="col-sm-2">Alamat</label>
                    <div class="col-auto">:</div>
                    <div class="col">
                        <input type="text" class="form-control" id="alamat" name="alamat" <?= !isset($_GET['edit']) ? 'disabled' : '' ?> value="<?= $plg != null ? $plg['alamat'] : "" ?>">
                    </div>
                </div>

                <div class="row mb-3 align-items-center">
                    <label for="no_telp" class="col-sm-2">No. Telepon</label>
                    <div class="col-auto">:</div>
                    <div class="col">
                        <input type="tel" class="form-control" id="no_telp" name="no_telp" <?= !isset($_GET['edit']) ? 'disabled' : '' ?> value="<?= $plg != null ? $plg['no_telp'] : "" ?>">
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <?php if (!isset($_GET['edit'])): ?>
                        <a class="btn btn-info w-25" href="?profile&edit">Edit</a>
                    <?php else: ?>
                        <a class="btn btn-danger w-25" href="?profile">Cancel</a>
                        <button type="submit" class="btn btn-primary w-25" name="edit">Save</button>
                    <?php endif ?>
                </div>
            </form>

        <?php endif ?>
    </div>
</body>

</html>