<?php
require_once BASE_PATH . "/app/bootstrap.php";
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary bg-body-tertiary shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Barshop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php if (isset($_SESSION['username'])): ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= BASE_URL ?>">Home</a>
                    </li>
                    <?php if ($_SESSION['level'] == 'Admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Data
                            </a>
                            <ul class="dropdown-menu">
                                <a class="dropdown-item" href="<?= BASE_URL ?>/admin/pelanggan">Pelanggan</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/admin/barang">Barang</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/admin/pesanan">Pesanan</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/admin/pembayaran">Pembayaran</a>
                            </ul>
                        </li>
                    <?php endif ?>
                </ul>
                <ul class="navbar-nav d-flex mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $_SESSION['username'] ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="<?= BASE_URL ?>?logout">Logout</a>
                        </ul>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    </li>
                </ul>
                <ul class="navbar-nav d-flex mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>?login">Login</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>?register">Register</a></li>
                        </ul>
                    </li>
                </ul>
            <?php endif ?>

        </div>
    </div>
</nav>