<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$task = new clsTask($db);

$res = $task->lastAddTask();
while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    echo $row['lastTaskId'];
}
