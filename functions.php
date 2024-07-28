<?php
include 'config.php'; 

if (!function_exists('registerUser')) {
    function registerUser($name, $email, $password, $access_level) {
        global $conn;
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, access_level) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die("Erro na preparação da consulta: " . $conn->error);
        }
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $access_level);
        return $stmt->execute();
    }
}

if (!function_exists('loginUser')) {
    function loginUser($email, $password) {
        global $conn;
        $stmt = $conn->prepare("SELECT id, name, email, password, access_level FROM users WHERE email = ?");
        if ($stmt === false) {
            die("Erro na preparação da consulta: " . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['access_level'] = $user['access_level'];
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('isLoggedIn')) {
    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin() {
        return isset($_SESSION['access_level']) && $_SESSION['access_level'] === 'admin';
    }
}

if (!function_exists('createRoom')) {
    function createRoom($name, $capacity, $location) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO rooms (name, capacity, location) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Erro na preparação da consulta: " . $conn->error);
        }
        $stmt->bind_param("sis", $name, $capacity, $location);
        return $stmt->execute();
    }
}

if (!function_exists('makeReservation')) {
    function makeReservation($room_id, $user_id, $start_time, $end_time) {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO reservations (room_id, user_id, start_time, end_time) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die("Erro na preparação da consulta: " . $conn->error);
        }
        $stmt->bind_param("iiss", $room_id, $user_id, $start_time, $end_time);
        return $stmt->execute();
    }
}
?>
