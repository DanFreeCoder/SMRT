<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$logs = new clsTask($db);

$logs->date_logs = date('Y-m-d', strtotime($_POST['upd_date_logs']));
$logs->context = $_POST['context'];
$logs->id = $_POST['id'];
$log = $logs->upd_date_logs();

echo $logs ? 1 : 0;
