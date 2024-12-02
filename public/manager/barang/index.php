<?php

use controllers\BarangController;
use controllers\PemasokController;
use controllers\PesananController;

require_once __DIR__ . "/../../../app/bootstrap.php";

if (!isset($_SESSION['username']))
    return header('Location: ' . BASE_URL . '/index.php');
if ($_SESSION['level'] != "Manager") return header('Location: ' . BASE_URL . '/index.php');

$barang = new BarangController();
$data = $barang->getAllBarang();

$pesan = new PesananController();

$pemasok = new PemasokController();
$dataPemasok = $pemasok->getAllPemasok();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['pesan'])) {
        if ($pesan->insertPesanan($_POST, $_GET['pesan'])) {
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
                    <tr>
                        <th scope="row" class="text-center" style="width: 70px;"><?= $brg['kode'] ?></th>
                        <td><?= $brg['nama'] ?></td>
                        <td><?= $brg['jenis'] ?></td>
                        <td><?= $brg['satuan'] ?></td>
                        <td><?= $brg['harga_beli'] ?></td>
                        <td><?= $brg['harga_jual'] ?></td>
                        <td class="<?php if ($brg['jumlah'] == 0) echo 'bg-danger-subtle' ?>">
                            <?= $brg['jumlah'] ?>
                        </td>
                        <td style="width: 100px;">
                            <!-- Button trigger modal -->
                            <?php if ($brg['jumlah'] <= 5): ?>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPesan" data-kode-barang="<?= $brg['kode'] ?>">
                                    Pesan
                                </button>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>


    <!-- Modal Pesan -->
    <div class="modal fade" id="modalPesan" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" method="post" action="?pesan=">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Insert Pelanggan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kodeBarang" class="form-label">Kode Barang</label>
                        <input type="text" id="kodeBarang" class="form-control" name="kodeBarang" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="kodePemasok" class="form-label">Nama Pemasok</label>
                        <select name="kodePemasok" id="kodePemasok" class="form-select">
                            <?php foreach ($dataPemasok as $pmk): ?>
                                <option value="<?= $pmk['kode'] ?>"><?= $pmk['nama'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <input type="number" class="form-control mb-3" name="jumlah" placeholder="Jumlah Barang">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="insert">Insert</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modalPesan');
        modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Tombol yang diklik
            const kodeBarang = button.getAttribute('data-kode-barang');

            modal.querySelector('#kodeBarang').value = kodeBarang;
            modal.querySelector('form').action = `?pesan=${kodeBarang}`;
        });
    </script>
</body>

</html>