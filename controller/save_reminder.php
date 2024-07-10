<?php
include '../config/connection.php';
include '../objects/clsreminder.php';
$database = new clsConnection();
$db = $database->connect();

$reminder = new clsreminder($db);
session_start();
$date = date('Y-m-d', strtotime($_POST['datepicker']));
$time =  date('H:i:s', strtotime($_POST['time']));
$reminder->date = $date;
$reminder->next_date = $date;
$reminder->time = $time;
$reminder->title = $_POST['title'];
$reminder->notes = $_POST['notes'];
$reminder->day_repeat = $_POST['repeat'];
$reminder->is_repeat = $_POST['is_repeat'];
$reminder->status = 2;
$reminder->user_id = $_SESSION['id'];
$save = $reminder->save_reminder();

echo $save ? 1 : 0;
