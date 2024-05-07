<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();
$data = array();
$logs = new clsTask($db);

$logs->id = $_POST['id'];
$log = $logs->get_date_logs();
while ($row = $log->fetch(PDO::FETCH_ASSOC)) {
    $date_logs =  $row['date_logs'];
}
$logs->id = $_POST['id'];
$log = $logs->get_prev_date_logs();
while ($row = $log->fetch(PDO::FETCH_ASSOC)) {
    $date_logs_prev =  $row['date_logs_prev'];
}

$array = array(
    'date_logs' => $date_logs,
    'date_logs_prev' => $date_logs_prev
);

echo json_encode($array);
