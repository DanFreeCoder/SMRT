<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$task = new clsTask($db);


$task->status = $_POST['status'];
$task->id = $_POST['id'];
$update = $task->update_task();

echo $update ? 1 : 0;
