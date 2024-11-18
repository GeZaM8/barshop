<?php

use controllers\UserController;

require_once __DIR__ . "/../../../app/bootstrap.php";

$user = new UserController();
$data = $user->getAllUser();
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
        <table class="table table-striped table-bordered shadow-sm caption-top">
            <caption>
                <h3>Data User</h3>
            </caption>
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Level</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usr = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <th scope="row"><?= $usr['id'] ?></th>
                        <td><?= $usr['username'] ?></td>
                        <td><?= $usr['password'] ?></td>
                        <td><?= $usr['level'] ?></td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</body>

</html>