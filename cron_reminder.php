<?php
include 'config/connection.php';
include 'objects/clsreminder.php';
$database = new clsConnection();
$db = $database->connect();

$reminder = new clsreminder($db);

$today = date('Y-m-d H:i:s');
$now = date('Y-m-d');
$list = $reminder->cron_reminders();
while ($row = $list->fetch(PDO::FETCH_ASSOC)) {
    extract($row); // make the data with the index => value
    $start_date = $next_date;
    $to = $email;
    $days = explode(',', $day_repeat); //seperate the value and put in array
    // check if reminder is on_repeat
    if ($is_repeat > 0) {
        $currentday = date("N", strtotime($today)); //get the number of current days
        $currentdayName = date("l", strtotime($today)); //get the name of current days
        // Check if the current day matches any of the days in $days
        if (in_array($currentday, $days)) {
            $date = 'Repeats ' . $currentdayName; //set date to on repeat
            // Send an email
            email($date, $time, $notes, $title, $fullname, $to);
        }

        switch (true) {
            case in_array(8, $days):
                // daily
                email($date, $time, $notes, $title, $fullname, $to);
                break;
            case in_array(9, $days):
                weekdays($today, $date, $time, $notes, $title, $fullname, $to);
                break;
            case in_array(10, $days):
                weekends($today, $date, $time, $notes, $title, $fullname, $to);
                break;
            case in_array(11, $days):
                weekly($today, $start_date, $date, $time, $notes, $title, $fullname, $to, $id);
                break;
            case in_array(12, $days):
                biweekly($today, $start_date, $date, $time, $notes, $title, $fullname, $to, $id);
                break;
            case in_array(13, $days):
                monthly($today, $start_date, $date, $time, $notes, $title, $fullname, $to, $id);
                break;
            case in_array(14, $days):
                every_3month($today, $start_date, $date, $time, $notes, $title, $fullname, $to, $id);
                break;
            case in_array(15, $days):
                every_6month($today, $start_date, $date, $time, $notes, $title, $fullname, $to, $id);
                break;
            case in_array(16, $days):
                yearly($today, $start_date, $date, $time, $notes, $title, $fullname, $to, $id);
                break;
        }
    }
    // if there is no repeat the date will be use to email
    if ($now == $date) {
        email($date, $time, $notes, $title, $fullname, $to);
    }
}

// mon to fri
function weekdays($today, $date, $time, $notes, $title, $fullname, $to)
{
    $currentday = date("N", strtotime($today));
    if ($currentday < 6) {
        email($date . ' Repeats Weekdays', $time, $notes, $title, $fullname, $to);
    }
}
// sat & sunday
function weekends($today, $date, $time, $notes, $title, $fullname, $to)
{
    $currentday = date("N", strtotime($today));
    if ($currentday > 5) {
        email($date . ' Repeats Weekends', $time, $notes, $title, $fullname, $to);
    }
}
// every 7 days
function weekly($today, $start_date, $date, $time, $notes, $title, $fullname, $to, $id)
{
    global $reminder;
    $next_send_date = date('Y-m-d', strtotime($start_date . ' +7 days'));
    if ($today == $next_send_date) {
        // update next date;
        $reminder->next_date = $next_send_date;
        $reminder->id = $id;
        $upd = $reminder->update_next_date();

        return $upd ? email($date . ' Repeats Weekly', $time, $notes, $title, $fullname, $to) : false;
    }
}
// every two weeks 
function biweekly($today, $start_date, $date, $time, $notes, $title, $fullname, $to, $id)
{
    global $reminder;
    $next_send_date = date('Y-m-d', strtotime($start_date . ' +14 days'));
    if ($today == $next_send_date) {
        // update next date;
        $reminder->next_date = $next_send_date;
        $reminder->id = $id;
        $upd = $reminder->update_next_date();

        return $upd ? email($date . ' Repeats Biweekly', $time, $notes, $title, $fullname, $to) : false;
    }
}
// every months
function monthly($today, $start_date, $date, $time, $notes, $title, $fullname, $to, $id)
{
    global $reminder;
    $next_send_date = date('Y-m-d', strtotime($start_date . ' +1 month'));
    if ($today == $next_send_date) {
        // update next date;
        $reminder->next_date = $next_send_date;
        $reminder->id = $id;
        $upd = $reminder->update_next_date();

        return $upd ? email($date . ' Repeats Monthly', $time, $notes, $title, $fullname, $to) : false;
    }
}
// every 3 months
function every_3month($today, $start_date, $date, $time, $notes, $title, $fullname, $to, $id)
{
    global $reminder;
    $next_send_date = date('Y-m-d', strtotime($start_date . ' +3 months'));
    if ($today == $next_send_date) {
        // update next date;
        $reminder->next_date = $next_send_date;
        $reminder->id = $id;
        $upd = $reminder->update_next_date();

        return $upd ? email($date . ' Repeats Every 3 months', $time, $notes, $title, $fullname, $to) : false;
    }
}

function every_6month($today, $start_date, $date, $time, $notes, $title, $fullname, $to, $id)
{
    global $reminder;
    $next_send_date = date('Y-m-d', strtotime($start_date . ' +6 months'));
    if ($today == $next_send_date) {
        // update next date;
        $reminder->next_date = $next_send_date;
        $reminder->id = $id;
        $upd = $reminder->update_next_date();

        return $upd ? email($date . ' Repeats Every 6 months', $time, $notes, $title, $fullname, $to) : false;
    }
}
function yearly($today, $start_date, $date, $time, $notes, $title, $fullname, $to, $id)
{
    global $reminder;
    $next_send_date = date('Y-m-d', strtotime($start_date . ' +1 year'));
    if ($today == $next_send_date) {
        // update next date;
        $reminder->next_date = $next_send_date;
        $reminder->id = $id;
        $upd = $reminder->update_next_date();

        return $upd ? email($date . ' Repeats Yearly', $time, $notes, $title, $fullname, $to) : false;
    }
}



function email($date, $time, $notes, $title, $fullname, $to)
{
    $from = "system.administrator<(it@innogroup.com.ph)>";
    $subject = "SMRT|Reminder: $title";
    $message = '<html>
    <body style="margin: 0 auto; padding: 10px; border: 1px solid #e1e1e1; font-family:Calibri">
        <div style="background-color: #00C957; padding: 5px; color: white">
            <h3 style="padding: 0; margin: 0;">  Message: </h3>
        </div>
        <div style="border: 1px solid #e1e1e1; padding: 5px">    
        Dear ' . $fullname . ',<br><br>
        This is a reminder that today is the day for your scheduled task: "' . $title . '".<br><br>
        <ul>
            <li>Date: ' . $date . '</li>
            <li>Time: ' . date('h:i A', strtotime($time)) . '</li>
            <li>Notes: ' . $notes . '</li>
        </ul>  
        <br><br>Best regards,
        <br><br>Sales & Marketing Request Tracker System Administrator
        </div>
        <br/>
        <br/>
        <div style="padding:10px 0px; text-align: center; font-size: 11px; border-top: 1px solid #e1e1e1">
        SRMT &middot; <a href="http://www.innogroup.com.ph/smrt">Innogroup</a>
        </div>
    </body>
</html>';


    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $headers .= "From: " . $from . "" . "\r\n";

    echo (mail($to, $subject, $message, $headers)) ? 1 : 0;
}
