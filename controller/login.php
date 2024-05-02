<?php
include '../config/connection.php';
include '../objects/clsusers.php';
session_start();
$database = new clsConnection();
$db = $database->connect();

$users = new clsUsers($db);

$users->username = $_POST['username'];
$users->password = md5($_POST['password']);
$user = $users->login();
if ($user->rowcount() > 0) {
    while ($row = $user->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['firstname'] = $row['firstname'];
        $_SESSION['lastname'] = $row['lastname'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['access_type'] = $row['access_type'];
        $_SESSION['fullname'] = $row['firstname'] . ' ' . $row['lastname'];
    }
    echo 1;
} else {
    echo 0;
}
