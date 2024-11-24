<?php

use controllers\PelangganController;
use controllers\UserController;

require_once __DIR__ . "/../../../app/bootstrap.php";

$user = new UserController();
$pelanggan = new PelangganController();

$data = $user->getAllUser();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['insert'])) {
        if ($user->registerUser($_POST)) {
        }
        header('Location: ' . $_SERVER['REQUEST_URI']);
    }

    if (isset($_POST['lengkapi'])) {
        if ($pelanggan->insertPelanggan($_POST)) {
        }
        header('Location: ' . $_SERVER['REQUEST_URI']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
</head>

<body class="bg-secondary-subtle">
    <?php require_once BASE_PATH . '/template/navbar.php' ?>
    <div class="container mt-5">
        <table class="table table-striped table-bordered shadow-sm caption-top align-middle">
            <caption>
                <h3>Data User</h3>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Insert
                </button>
            </caption>
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Level</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usr = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <th scope="row"><?= $usr['id'] ?></th>
                        <td><?= $usr['username'] ?></td>
                        <td><?= $usr['password'] ?></td>
                        <td><?= $usr['level'] ?></td>
                        <td style="width: 120px;">
                            <?php if ($usr['level'] == 'Pelanggan' && !(mysqli_num_rows($pelanggan->checkPelangganById($usr['id'])) > 0)): ?>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#lengkapiData" data-id-account="<?= $usr['id'] ?>">
                                    Melengkapi
                                </button>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Insert User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-3" name="username" placeholder="Username">
                    <input type="password" class="form-control mb-3" name="password" placeholder="Password">
                    <input type="password" class="form-control mb-3" name="cPassword" placeholder="Confirm Password">
                    <select name="level" id="level" class="form-select">
                        <option value="Admin">Admin</option>
                        <option value="Pelanggan">Pelanggan</option>
                        <option value="Pemasok">Pemasok</option>
                        <option value="Manager">Manager</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="insert">Insert</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Lengkapi Data -->
    <div class="modal fade" id="lengkapiData" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="post">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Melengkapkan Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <input type="text" class="form-control mb-3" name="nama" placeholder="Nama">
                    <input type="text" class="form-control mb-3" name="alamat" placeholder="alamat">
                    <input type="tel" class="form-control mb-3" name="no_telp" placeholder="No. Telepon">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="lengkapi">Lengkapi</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        const modal = document.getElementById('lengkapiData');
        modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Tombol yang diklik
            const id = button.getAttribute('data-id-account');

            modal.querySelector('#id').value = id;
        });
    </script>
</body>

</html>