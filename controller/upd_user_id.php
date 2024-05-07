<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$tasks = new clsTask($db);

$tasks->user_id = $_POST['user_id'];
$tasks->id = $_POST['task_id'];
$upd_task = $tasks->upd_task_user_id();

echo $upd_task ? 1 : 0;
