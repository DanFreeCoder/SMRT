<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();
$data = array();

$task = new clsTask($db);

$all = $task->all_task();
while ($row = $all->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $task_name = $row['task'];
    $timeline = $row['timeline'];
    $urgency = $row['urgency'];
    $add_comment = $row['add_comment'];
    $assigned_by = $row['assigned_by'];
    $status = $row['status'];

    $data[] = array(
        'id' => $id,
        'task_name' => $task_name,
        'timeline' => $timeline,
        'urgency' => $urgency,
        'add_comment' => $add_comment,
        'assigned_by' => $assigned_by,
        'status' => $status
    );
}

echo json_encode($data);
