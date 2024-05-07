<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$logs = new clsTask($db);

$logs->status = 0;
$logs->id = $_POST['id'];
$delete = $logs->delete_task();

echo $delete ? 1 : 0;
