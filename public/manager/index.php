<?php

use controllers\UserController;

require_once __DIR__ . "/../../app/bootstrap.php";

if (!isset($_SESSION['username']))
    return header('Location: ' . BASE_URL . '/index.php');
if ($_SESSION['level'] != "Manager") return header('Location: ' . BASE_URL . '/index.php');

$user = new UserController();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Home Manager</title>
</head>

<body class="bg-secondary-subtle">

    <?php require_once BASE_PATH . '/template/navbar.php' ?>
    <div class="container mt-5">
        <?php if ($jumlah > 0): ?>
            <div class="w-100 rounded bg-warning-subtle p-5">
                <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                <span class="fs-3 mb-3">Ada stok kosong</span>
                <div>
                    <ul class="list-group mb-5">
                        <?php while ($row = mysqli_fetch_assoc($navBrg)): ?>
                            <li class="list-group-item"><?= $row['nama'] ?></li>
                        <?php endwhile ?>
                    </ul>
                    <a href="<?= BASE_URL ?>/manager/barang" class="btn btn-primary">Pergi ke Halaman Beli</a>
                </div>
            </div>
        <?php endif ?>
    </div>
</body>

</html>