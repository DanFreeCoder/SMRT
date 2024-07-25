<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();
$task = new clsTask($db);

$user_ids = array();
$userArr_id = array();
$array_id = explode(',', $_POST['user_id']);


$task->id = $_POST['id'];
$check = $task->check_to_reassign();
while ($row = $check->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $user_idArr = explode(',', $user_id);
    $newAssignee = array_diff($array_id, $user_idArr);
    $user_ids[] = $newAssignee;
}


$data = json_encode($user_ids);
echo $data;
