<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$logs = new clsTask($db);

$logs->id = $_POST['id'];
$log = $logs->get_date_logs();
while ($row = $log->fetch(PDO::FETCH_ASSOC)) {
    echo $row['date_logs'];
}
