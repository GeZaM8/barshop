<?php

namespace controllers;

use models\Database;

class UserController extends Database
{
    function login($data)
    {
        $username = $data['username'];
        $password = $data['password'];

        $query = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($this->db, $query);
        $user = mysqli_fetch_assoc($result);

        if ($user == null) return mysqli_affected_rows($this->db);
        if ($user['password'] != $password) return 0;

        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['level'] = $user['level'];

        if ($_SESSION['level'] == 'Pelanggan') self::setPelanggan();
        else if ($_SESSION['level'] == 'Pemasok') self::setPemasok();

        return mysqli_affected_rows($this->db);
    }

    function registerUser($data)
    {
        $username = $data['username'];
        $password = $data['password'];
        $cPassword = $data['cPassword'];
        $level = $data['level'];

        if ($password != $cPassword) return 0;

        $query = "INSERT INTO user VALUES (0, '$username', '$password', '$level')";
        $result = mysqli_query($this->db, $query);

        return mysqli_affected_rows($this->db);
    }

    function logout()
    {
        global $con;

        session_destroy();
    }

    function getAllUser()
    {
        $query = "SELECT * FROM user";
        $result = mysqli_query($this->db, $query);

        return $result;
    }

    function getUserByUsername($username)
    {
        $query = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($this->db, $query);

        return mysqli_fetch_assoc($result);
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
            case 'Manager':
                return header('Location: ' . BASE_URL . '/manager/');
            default:
                return http_response_code(404);
        }
    }

    function setPelanggan()
    {
        $pelanggan = new PelangganController();
        $plg = mysqli_fetch_assoc($pelanggan->checkPelangganById($_SESSION['id']));
        $_SESSION['pelanggan'] = $plg;
    }

    function setPemasok()
    {
        $pemasok = new PemasokController();
        $pms = mysqli_fetch_assoc($pemasok->checkPemasokById());
        $_SESSION['pemasok'] = $pms;
    }
}
