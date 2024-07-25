<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$task = new clsTask($db);

$action = $_GET['action'];

switch ($action) {
    case $action == 'done':
        $task->date_done = date('Y-m-d');
        $task->id = $_POST['id'];
        $update = $task->mark_done();
        echo $update ? 1 : 0;
        break;
    case $action == 'close':
        $task->date_close = date('Y-m-d');
        $task->id = $_POST['id'];
        $update2 = $task->mark_close();
        echo $update2 ? 1 : 0;
        break;
}
