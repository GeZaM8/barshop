<?php

use controllers\PemasokController;

require_once __DIR__ . "/../../../app/bootstrap.php";

if (!isset($_SESSION['username']))
    return header('Location: ' . BASE_URL . '/index.php');
if ($_SESSION['level'] != "Admin") return header('Location: ' . BASE_URL . '/index.php');

$pemasok = new PemasokController();
$data = $pemasok->getAllpemasok();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['insert'])) {
        if ($pemasok->insertPemasok($_POST)) {
        }
        header('Location: ' . $_SERVER['REQUEST_URI']);
    }
}

if (isset($_GET['aktifkan'])) {
    if ($pemasok->activatePemasok($_GET['kode'], $_GET['aktifkan'])) {
    }
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemasok</title>
</head>

<body class="bg-secondary-subtle">
    <?php require_once BASE_PATH . '/template/navbar.php' ?>
    <div class="container mt-5">
        <table class="table table-striped table-bordered shadow-sm caption-top align-middle">
            <caption>
                <h3>Data Pemasok</h3>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Insert
                </button>
            </caption>
            <thead>
                <tr>
                    <th scope="col">Kode</th>
                    <th scope="col">Id Account</th>
                    <th scope="col">Nama Pemasok</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">No. Telp</th>
                    <th scope="col">Email</th>
                    <th scope="col" class="bg-info-subtle">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pmk = mysqli_fetch_assoc($data)): ?>
                    <?php
                    $status = match ($pmk['status']) {
                        'Aktif' => 'bg-success-subtle',
                        'Tidak Aktif' => 'bg-danger-subtle',
                    }
                    ?>
                    <tr>
                        <th scope="row"><?= $pmk['kode'] ?></th>
                        <td><?= $pmk['id_account'] ?></td>
                        <td><?= $pmk['nama'] ?></td>
                        <td><?= $pmk['alamat'] ?></td>
                        <td><?= $pmk['no_telp'] ?></td>
                        <td><?= $pmk['email'] ?></td>
                        <td class="<?= $status ?>"><?= $pmk['status'] ?></td>
                        <td style="width: 200px;">
                            <a href="?update=<?= $pmk['kode'] ?>" class="btn btn-primary">Edit</a>
                            <?php if ($pmk['status'] == 'Aktif'): ?>
                                <a href="?aktifkan=0&kode=<?= $pmk['kode'] ?>" class="btn btn-danger">Nonaktifkan</a>
                            <?php else: ?>
                                <a href="?aktifkan=1&kode=<?= $pmk['kode'] ?>" class="btn btn-success">Aktifkan</a>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>


    <!-- Modal insert -->
    <div class="modal fade" id="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="post">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Insert Pemasok</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-3" name="nama" placeholder="Nama">
                    <input type="text" class="form-control mb-3" name="alamat" placeholder="alamat">
                    <input type="text" class="form-control mb-3" name="no_telp" placeholder="No. Telepon">
                    <input type="email" class="form-control mb-5" name="email" placeholder="Email">

                    <label class="form-label mb-3">Account</label>
                    <input type="text" class="form-control mb-3" name="username" placeholder="Username">
                    <input type="password" class="form-control mb-3" name="password" placeholder="Password">
                    <input type="password" class="form-control mb-3" name="cPassword" placeholder="Confirm Password">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="insert">Insert</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>