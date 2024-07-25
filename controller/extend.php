<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$task = new clsTask($db);

$task->extend_due = date('Y-m-d', strtotime($_POST['extend']));
$task->id = $_POST['id'];

$extend = $task->extend_due();

echo $extend ? 1 : 0;
