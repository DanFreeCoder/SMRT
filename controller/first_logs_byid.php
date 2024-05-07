<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$logs = new clsTask($db);

$logs->task_id = $_POST['task_id'];
$log = $logs->first_logs_byid();
while ($row = $log->fetch(PDO::FETCH_ASSOC)) {
    echo $row['first_logs'];
}
