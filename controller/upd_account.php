<?php
include '../config/connection.php';
include '../objects/clsusers.php';
$database = new clsConnection();
$db = $database->connect();
session_start();

$users = new clsUsers($db);

$type = $_GET['type'];

switch ($type) {
    case 'with':
        $users->id = $_SESSION['id'];
        $users->firstname = $_POST['firstname'];
        $users->lastname = $_POST['lastname'];
        $users->username = $_POST['username'];
        $users->password = md5($_POST['password']);
        $user1 = $users->update_account();
        echo $user1 ? 1 : 0;
        break;
    case 'out':
        $users->id = $_SESSION['id'];
        $users->firstname = $_POST['firstname'];
        $users->lastname = $_POST['lastname'];
        $users->username = $_POST['username'];
        $user2 = $users->update_account_np();
        echo $user2 ? 1 : 0;
        break;
}
