<?php
include '../config/connection.php';
include '../objects/clsusers.php';
$database = new clsConnection();
$db = $database->connect();

$users = new clsUsers($db);

$data = array();
$fullname = array(); // Initialize arrays to store data
$email = array();
$arrayid = explode(',', $_POST['id']);

foreach ($arrayid as $value) {
    $users->id = $value;
    $user = $users->user_byid();
    while ($row = $user->fetch(PDO::FETCH_ASSOC)) {
        $fullname[] = $row['firstname'] . ' ' . $row['lastname'];
        $email[] = $row['email'];
    }
}
$data[] = array('fullname' => $fullname, 'email' => $email);



echo json_encode($data);
