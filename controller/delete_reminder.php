<?php
include '../config/connection.php';
include '../objects/clsreminder.php';
$database = new clsConnection();
$db = $database->connect();

$reminder = new clsreminder($db);

$reminder->status = 0;
$reminder->id = $_POST['id'];
$delete = $reminder->remove();

echo $delete ? 1 : 0;
