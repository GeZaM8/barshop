<?php

use controllers\UserController;

require_once __DIR__ . "/../../app/bootstrap.php";

if (!isset($_SESSION['username']))
    return header('Location: ' . BASE_URL . '/index.php');
if ($_SESSION['level'] != "Pemasok") return header('Location: ' . BASE_URL . '/index.php');

$user = new UserController();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>

<body class="bg-secondary-subtle">
    <?php require_once BASE_PATH . '/template/navbar.php' ?>
    <div class="container mt-5">
    </div>
</body>

</html>