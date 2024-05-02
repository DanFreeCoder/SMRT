<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$logs = new clsTask($db);

$last = $logs->last_logs();
while ($row = $last->fetch(PDO::FETCH_ASSOC)) {
    $previousDate = $row['last_logs'];
}
$currentDate = date('Y-m-d'); // Get current date
// Set date_logs to $_POST['date-logs'] if it's defined and not empty, otherwise use $currentDate
$dateLogs = (!empty($_POST['date-logs']) && $_POST['date-logs'] !== 'undefined') ? $_POST['date-logs'] : $currentDate;
$previousDateTime = new DateTime($previousDate);
$currentDateTime = new DateTime($currentDate);
$timeDifference = $previousDateTime->diff($currentDateTime); // Calculate difference
$logs->task_id = $_POST['task_id'];
$logs->days = $timeDifference->format('%d days');
$logs->name = $_SESSION['id'];
$logs->context = $_POST['context'];
$logs->status = 1;
$logs->date_logs = $dateLogs;
$store = $logs->store_logs();

echo $store ? 1 : 0;
