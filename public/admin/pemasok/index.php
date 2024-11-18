<?php

use controllers\PemasokController;

require_once __DIR__ . "/../../../app/bootstrap.php";

$pemasok = new PemasokController();
$data = $pemasok->getAllpemasok();

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
</body>

</html>