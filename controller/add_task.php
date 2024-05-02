<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$task = new clsTask($db);

$task->user_id = $_POST['user_id'];
$task->task = $_POST['task_name'];
$task->timeline = $_POST['due-date'];
$task->urgency = $_POST['urgency'];
$task->add_comment = $_POST['description'];
$task->assigned_by = $_SESSION['id'];
$task->created_at = date('Y-m-d');
$task->status = 1;
$store = $task->store();

echo $store ? 1 : 0;
