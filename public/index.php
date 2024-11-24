<?php

use controllers\UserController;

require_once __DIR__ . "/../app/bootstrap.php";

$user = new UserController();

if (isset($_GET['logout'])) {
  $user->logout();
  header('Location: ' . BASE_URL);
}

if (isset($_SESSION['username']))
  $user->checkLevel();

$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['login'])) {
    if ($user->login($_POST) > 0) {
      $user->checkLevel();
    } else
      $error = true;
  }
  if (isset($_POST['register'])) {
    $_POST['level'] = 'Pelanggan';
    if ($user->registerUser($_POST) > 0)
      return header('Location: ' . BASE_URL . '?login&success');
    else
      $error = true;
  }
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
  <?php require_once __DIR__ . '/../template/navbar.php'; ?>

  <?php if ($_SERVER['REQUEST_URI'] == '/?register'): ?>
    <form action="" method="post" class="container mt-5 w-25 border p-5 rounded-4 bg-body shadow">
      <h4 class="mb-5 text-center" style="font-weight: bold;">REGISTER</h4>
      <div class=" mb-3">
        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
      </div>
      <div class="mb-3">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
      </div>
      <div class="mb-3">
        <input type="password" class="form-control" id="cPassword" name="cPassword" placeholder="Confirm Password">
      </div>
      <div class="mb-3 text-center" style="color: red; font-style: italic;">
        <?php if ($error): ?>
          <?= "Confirm Password doesn't Match" ?>
        <?php endif ?>
      </div>
      <button type="submit" class="btn btn-primary w-100 mt-3" name="register">Submit</button>
    </form>
  <?php else: ?>
    <?php if (isset($_GET['success'])): ?>
      <div class="container mt-5 w-50 border rounded bg-success-subtle shadow text-success p-3">
        <h4>Register Success</h4>
        <div>You can login now</div>
      </div>
    <?php endif ?>
    <form action="" method="post" class="container mt-5 w-25 border p-5 rounded-4 bg-body shadow">
      <h4 class="mb-5 text-center" style="font-weight: bold;">LOGIN</h4>
      <div class=" mb-3">
        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
      </div>
      <div class="mb-3">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
      </div>
      <div class="mb-3 text-center" style="color: red; font-style: italic;">
        <?php if ($error): ?>
          <?= "Username atau Password Salah!" ?>
        <?php endif ?>
      </div>
      <button type="submit" class="btn btn-primary w-100 mt-3" name="login">Submit</button>
    </form>
  <?php endif; ?>

</body>

</html>