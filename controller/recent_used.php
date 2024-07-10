<?php
session_start();
include '../config/connection.php';
include '../objects/clsreminder.php';
$database = new clsConnection();
$db = $database->connect();

$reminder = new clsreminder($db);

$dayName = [7 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat', 8 => 'Daily', 9 => 'Weekdays', 10 => 'Weekends', 11 => 'Weekly', 12 => 'Biweekly', 13 => 'Monthly', 14 => 'Every 3 months', 15 => 'Every 6 months', 16 => 'Yearly'];
$reminders = $reminder->recent_used();
while ($row = $reminders->fetch(PDO::FETCH_ASSOC)) {
    $dayhtml = '';
    extract($row);
    $days = explode(',', $day_repeat);

    $count = count($dayName);
    foreach ($dayName as $i => $dname) {
        if (in_array($i, $days)) { //if days value is equal to the index of dayName , do below
            $dayhtml .= $dayName[$i];
            $dayhtml .= $count > $i ? ',' : ''; //concat comma until the last iteration
        }
    }
    if (empty($dayhtml)) {
        $dayhtml .= date('F j, Y', strtotime($date));
    }
    echo '
    <li class="list-group-item list-group-item-action d-flex justify-content-between"><a href="#" class="recentList" value="' . $id . '" style="color:black; text-decoration:none; width:100%;">' . $title . '</a><span id="dayhtml">' . $dayhtml . '</span><i class="fa-regular fa-circle-xmark text-danger delete" value="' . $id . '"></i></li>
';
}
