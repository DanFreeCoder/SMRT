<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$logs = new clsTask($db);


$currentDate = date('Y-m-d'); // Get current date

if (isset($_POST['date-logs'])) {
    $date_log = date('Y-m-d', strtotime($_POST['date-logs']));
    // Set date_logs to $date_log if it's defined and not empty, otherwise use $currentDate
    $dateLogs = (!empty($_POST['date-logs']) && $_POST['date-logs'] !== 'undefined') ? $date_log : $currentDate;
}

$logs->task_id = $_POST['task_id'];
$logs->name = $_SESSION['id'];
$logs->context = $_POST['context'];
$logs->status = 1;
$logs->date_logs = isset($_POST['date-logs']) ? $dateLogs : $currentDate;
$store = $logs->store_logs();

echo $store ? 1 : 0;
