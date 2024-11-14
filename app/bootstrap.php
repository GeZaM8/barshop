<?php
spl_autoload_register(function ($class) {
    require_once __DIR__ .  "/" .  $class . ".php";
});

require_once __DIR__ . '/../config/constant.php';
require_once BASE_PATH . '/config/bootstrap_css.php';
