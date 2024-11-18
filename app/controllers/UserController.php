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

        $query = "INSERT INTO user VALUES (0, '$username', '$password', '')";
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
}
