<?php
include '../config/connection.php';
include '../objects/clsusers.php';
$database = new clsConnection();
$db = $database->connect();

$users = new clsUsers($db);

$data = array();
$users->id = $_POST['id'];
$user = $users->user_byid();
while ($row = $user->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $fullname = $row['firstname'] . ' ' . $row['lastname'];
    $email = $row['email'];

    $data[] = array(
        'id' => $id,
        'fullname' => $fullname,
        'email' => $email
    );
}

echo json_encode($data);
