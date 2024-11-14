<?php

namespace controllers;

use models\Database;

class UserController extends Database
{
    function login($data)
    {
        $username = $data['username'];
        $password = $data['password'];

        $query = "SELECT * FROM account WHERE username = '$username'";
        $result = mysqli_query($this->db, $query);
        $user = mysqli_fetch_assoc($result);

        if ($user == null) return mysqli_affected_rows($this->db);
        if ($user['password'] != $password) return 0;

        $_SESSION['username'] = $user['username'];
        $_SESSION['level'] = $user['level'];

        return mysqli_affected_rows($this->db);
    }

    function registerUser($data)
    {
        $username = $data['username'];
        $password = $data['password'];
        $cPassword = $data['cPassword'];

        if ($password != $cPassword) return 0;

        $query = "INSERT INTO account VALUES (0, '$username', '$password', '')";
        $result = mysqli_query($this->db, $query);

        return mysqli_affected_rows($this->db);
    }

    function logout()
    {
        global $con;

        session_destroy();
    }

    function checkLevel()
    {
        switch ($_SESSION['level']) {
            case 'Admin':
                return header('Location: ' . BASE_URL . '/admin/');
            case 'Pelanggan':
                return header('Location: ' . BASE_URL . '/pelanggan/');
            case 'Pemasok':
                return header('Location: ' . BASE_URL . '/pemasok/');
        }
    }
}
