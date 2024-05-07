<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$logs = new clsTask($db);

$logs->task_id = $_POST['task_id'];
$last = $logs->last_logs_byid();
while ($row = $last->fetch(PDO::FETCH_ASSOC)) {
    echo $row['last_logs'];
}
