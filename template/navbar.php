<?php

use controllers\PelangganController;

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
                                Master
                            </a>
                            <ul class="dropdown-menu">
                                <a class="dropdown-item" href="<?= BASE_URL ?>/admin/user">User</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/admin/pelanggan">Pelanggan</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/admin/pemasok">Pemasok</a>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Transaksi
                            </a>
                            <ul class="dropdown-menu">
                                <a class="dropdown-item" href="<?= BASE_URL ?>/admin/barang">Barang</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/admin/pesanan">Purchase Order</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/admin/transaksi-pelanggan">Transaksi Pelanggan</a>
                            </ul>
                        </li>

                    <?php elseif ($_SESSION['level'] == 'Manager'): ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Transaksi
                            </a>
                            <ul class="dropdown-menu">
                                <a class="dropdown-item" href="<?= BASE_URL ?>/manager/barang">Barang</a>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/manager/pesanan">Purchase Order</a>
                            </ul>
                        </li>

                    <?php elseif ($_SESSION['level'] == 'Pelanggan'): ?>

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= BASE_URL ?>/pelanggan/barang">Barang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= BASE_URL ?>/pelanggan/cart">Cart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= BASE_URL ?>/pelanggan/transaksi">Tarnsaksi</a>
                        </li>
                    <?php endif ?>

                </ul>
                <ul class="navbar-nav d-flex mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $_SESSION['username'] ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php
                            $pelanggan = new PelangganController();
                            ?>
                            <?php if ($_SESSION['level'] == "Pelanggan" && $pelanggan->checkPelangganById($_SESSION['id'])): ?>
                                <a class="dropdown-item" href="<?= BASE_URL ?>/pelanggan?profile">Profile</a>
                            <?php endif ?>

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