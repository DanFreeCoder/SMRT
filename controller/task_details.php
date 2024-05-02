<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();
$data = array();

$task = new clsTask($db);

$task->id = $_POST['id'];
$task_detail = $task->task_details();
while ($row = $task_detail->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $task_name = $row['task'];
    $timeline = $row['timeline'];
    $urgency = $row['urgency'];
    $created_at = $row['created_at'];
    $add_comment = $row['add_comment'];
    $assigned_by = $row['assigned_by'];
    $status = $row['status'];

    $data[] = array(
        'id' => $id,
        'task_name' => $task_name,
        'timeline' => $timeline,
        'urgency' => $urgency,
        'created_at' => $created_at,
        'add_comment' => $add_comment,
        'assigned_by' => $assigned_by,
        'status' => $status
    );
}

echo json_encode($data);
