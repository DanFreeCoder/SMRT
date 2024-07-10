<?php
include '../config/connection.php';
include '../objects/clstask.php';
$database = new clsConnection();
$db = $database->connect();

$task = new clsTask($db);

$task->id = $_POST['id'];
$getid = $task->assignerid_byTask();
while ($row = $getid->fetch(PDO::FETCH_ASSOC)) {
    echo $row['assigner'];
}
