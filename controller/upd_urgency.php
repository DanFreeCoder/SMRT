<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$task = new clsTask($db);

$task->urgency = $_POST['urgency'];
$task->id = $_POST['id'];
$urg = $task->update_urgency();

echo $urg ? 1 : 0;
