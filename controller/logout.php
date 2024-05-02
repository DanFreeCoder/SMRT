<?php
include '../config/connection.php';
include '../objects/clsusers.php';
$database = new clsConnection();
$db = $database->connect();

$logout = new clsUsers($db);

$logout->logout();
if ($logout) {
    header("Location:../index.php");
}
