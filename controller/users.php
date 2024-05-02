<?php
include '../config/connection.php';
include '../objects/clsusers.php';
$database = new clsConnection();
$db = $database->connect();

$users = new clsUsers($db);

$data = array();
$user = $users->users();
while ($row = $user->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];

    $data[] = array(
        'id' => $id,
        'firstname' => $firstname,
        'lastname' => $lastname
    );
}

echo json_encode($data);
