<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$task = new clsTask($db);

$task->id = $_POST['id'];
$get = $task->get_date_createdTask();
while ($row = $get->fetch(PDO::FETCH_ASSOC)) {
    echo $row['created_at'];
}
