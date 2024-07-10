<?php
// session_start();
include '../config/connection.php';
include '../objects/clstask.php';
include '../objects/clsusers.php';

$database = new clsConnection();
$db = $database->connect();
$data = array();

$logs = new clsTask($db);
$users = new clsUsers($db);

$logs->task_id = $_POST['task_id'];
$log = $logs->logs();
$length = $log->rowcount();
$html = '';

$html .= '
    <thead> 
        <tr>
            <th class="text-center no-sort vip-edit"><i class="fa-solid fa-location-arrow"></i></th>
            <th class="text-center no-sort">DATE</th>
            <th class="text-center no-sort">NAME</th>
            <th class="text-center no-sort">CONTENT</th>
            <th class="text-center no-sort">Days</th>
        </tr>
    </thead>
    <tbody>
';
while ($row = $log->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $date_logs = $row['date_logs'];
    $context = $row['context'];

    $users->id = $row['name'];
    $user = $users->user_byid();
    $user_row = $user->fetch(PDO::FETCH_ASSOC);
    $name = $user_row['firstname'] . ' ' . $user_row['lastname'];



    $data[] = array(
        'id' => $id,
        'date_logs' => $date_logs,
        'context' => $context,
        'name' => $name,
    );
}
$first = '';
for ($i = 0; $i < $length; $i++) {
    $d = $data[$i];
    if ($length == $i + 1) {
        $first = $d['date_logs'];
    }
    // Check if the next row exists
    $nextIndex =  $i + 1;
    if ($nextIndex < $length) {
        $nextDateLogs = $data[$nextIndex]['date_logs'];
        // Calculate the time difference
        $formatDate = new DateTime($nextDateLogs);
        $Interval = $formatDate->diff(new DateTime($d['date_logs']));
        $Daydiff = $Interval->days;

        $html .= '<tr>';
        $html .= '<td class="vip-edit"><a href="javascript:void(0)" class="text-warning edit-logs" value="' . $d['id'] . '"><i class="fa-solid fa-pen penbtn"></i></a></td>';
        $html .= '<td>' . date('F, d Y', strtotime($d['date_logs'])) . '</td>';
        $html .= '<td>' . $d['name'] . '</td>';
        $html .= '<td>' . $d['context'] . '</td>';
        $html .= '<td>' . $Daydiff . '</td>';
        $html .= '</tr>';
    }
}
// appending the first logs
if ($length > 0) {
    $html .= '<tr>';
    $html .= '<td class="vip-edit"></td>';
    $html .= '<td>' . date('F, d Y', strtotime($first)) . '</td>';
    $html .= '<td>' . $name . '</td>';
    $html .= '<td>' . $context  . '</td>';
    $html .= '<td>0</td>';
    $html .= '</tr>';
}
$html .= '</tbody>';
echo $html;
