<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$task = new clsTask($db);


$task->id = $_POST['id'];
$assignee = $task->assignee_byid();
while ($row = $assignee->fetch(PDO::FETCH_ASSOC)) {
    echo json_encode($row['ids']);
}
