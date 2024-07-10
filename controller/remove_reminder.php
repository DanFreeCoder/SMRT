<?php
include '../config/connection.php';
include '../objects/clsreminder.php';
$database = new clsConnection();
$db = $database->connect();

$reminder = new clsreminder($db);

$reminder->status = 1;
$reminder->id = $_POST['id'];
$remove = $reminder->remove();

echo $remove ? 1 : 0;
