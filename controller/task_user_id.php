<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$tasks = new clsTask($db);

$tasks->id = $_POST['id'];
$task = $tasks->get_user_id();
while ($row = $task->fetch(PDO::FETCH_ASSOC)) {
    echo $row['user_id'];
}
