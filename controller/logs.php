<?php
include '../config/connection.php';
include '../objects/clstask.php';
include '../objects/clsusers.php';
$database = new clsConnection();
$db = $database->connect();
$data = array();

$logs = new clsTask($db);
$users = new clsUsers($db);

$logs->task_id = $_POST['task_id'];
$log = $logs->logs();
while ($row = $log->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $days = $row['days'];
    $date_logs = $row['date_logs'];
    $context = $row['context'];

    $users->id = $row['name'];
    $user = $users->user_byid();
    while ($row2 =  $user->fetch(PDO::FETCH_ASSOC)) {
        $name = $row2['fullname'];
    }
    $data[] = array(
        'id' => $id,
        'days' => $days,
        'date_logs' => $date_logs,
        'context' => $context,
        'name' => $name,
    );
}

echo json_encode($data);
