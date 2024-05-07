<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$tasks = new clsTask($db);

$tasks->created_at = date('Y-m-d', strtotime($_POST['task_created_at']));
$tasks->id = $_GET['id'];
$update = $tasks->upd_date_createdTask();

echo $update ? 1 : 0;
