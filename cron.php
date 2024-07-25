<?php
include 'config/connection.php';
include 'objects/clstask.php';
include 'objects/clsreminder.php';
$database = new clsConnection();
$db = $database->connect();

$tasks = new clsTask($db);
$reminder = new clsreminder($db);

$currentDate = date('Y-m-d');
$email_to_assigner = $tasks->automatic_email_to_assigner();
while ($row = $email_to_assigner->fetch(PDO::FETCH_ASSOC)) {
    $duedate = new DateTime($row['extend_due'] != null ? $row['extend_due'] : $row['timeline']);
    $modifydate = clone $duedate;  // Create a clone to keep original $dateTime unchanged

    $current_date = new DateTime();
    // Calculate difference in seconds between due date and current date
    $difference = $current_date->getTimestamp() - $duedate->getTimestamp();

    // Calculate halfway timestamp
    $halfway_timestamp = $duedate->getTimestamp() + ($difference / 2);

    // Create DateTime object for halfway date
    $halfway_date = new DateTime();
    $halfway_date->setTimestamp($halfway_timestamp);

    // Format halfway date as needed (e.g., 'Y-m-d')
    $halfway_date_formatted = $halfway_date->format('Y-m-d');

    $overduedate = clone $duedate; // Create another clone to calculate 1 days after due
    $overduedate->modify('+1 day');

    $overduedates = $overduedate->format('Y-m-d');
    $timeline = $row['extend_due'] != null ? $row['extend_due'] : $row['timeline'];
    if ($halfway_date_formatted == $currentDate || $overduedates == $currentDate) {
        $from = "system.administrator<(it@innogroup.com.ph)>";
        $to = $row['email'];

        $subject = "SMRT|Reminder: Task Due Reminder";
        $message = '<html>
                        <body style="margin: 0 auto; padding: 10px; border: 1px solid #e1e1e1; font-family:Calibri">
                            <div style="background-color: #00C957; padding: 5px; color: white">
                                <h3 style="padding: 0; margin: 0;">  Message: </h3>
                            </div>
                            <div style="border: 1px solid #e1e1e1; padding: 5px">    
                            Hi, ' . $row['fullname'] . ',<br><br>
                            Just a friendly reminder about the upcoming deadline for the task you assigned. Please ensure it`s completed by the end of the day on ' . date('F d, Y', strtotime($timeline)) . '.<br><br>
                            The details of the task are as follow:<br><br>
                            Task Name: ' . $row['task'] . '<br>
                            Description:  ' . $row['add_comment'] . '<br><br>
                            Thank you for your dedication and commitment.
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
}

$email_to_handler = $tasks->automatic_email_to_handler();
while ($row2 = $email_to_handler->fetch(PDO::FETCH_ASSOC)) {
    $duedate = new DateTime($row2['extend_due'] != null ? $row2['extend_due'] : $row2['timeline']);
    $modifydate = clone $duedate;  // Create a clone to keep original $dateTime unchanged
    $modifydate->modify('-2 day'); // Subtract 2 day from the date

    $current_date = new DateTime();
    // Calculate difference in seconds between due date and current date
    $difference = $current_date->getTimestamp() - $duedate->getTimestamp();

    // Calculate halfway timestamp
    $halfway_timestamp = $duedate->getTimestamp() + ($difference / 2);

    // Create DateTime object for halfway date
    $halfway_date = new DateTime();
    $halfway_date->setTimestamp($halfway_timestamp);

    // Format halfway date as needed (e.g., 'Y-m-d')
    $halfway_date_formatted2 = $halfway_date->format('Y-m-d');

    $overduedate = clone $duedate; // Create another clone to calculate 1 days after due
    $overduedate->modify('+1 day');

    $overduedates = $overduedate->format('Y-m-d');
    $user_id = explode(',', $row2['user_id']);
    $timeline = $row2['extend_due'] != null ? $row2['extend_due'] : $row2['timeline'];
    foreach ($user_id as $ud) {
        if ($halfway_date_formatted2 == $currentDate || $overduedates == $currentDate) {
            $from = "system.administrator<(it@innogroup.com.ph)>";
            $to = $row2['email'];
            $subject = "SMRT|Reminder: Task Due Reminder";
            $message = '<html>
                            <body style="margin: 0 auto; padding: 10px; border: 1px solid #e1e1e1; font-family:Calibri">
                                <div style="background-color: #00C957; padding: 5px; color: white">
                                    <h3 style="padding: 0; margin: 0;">  Message: </h3>
                                </div>
                                <div style="border: 1px solid #e1e1e1; padding: 5px">    
                                Hi, ' . $row2['fullname'] . ',<br><br>
                                Just a friendly reminder about the upcoming deadline for the task assigned to you. Please ensure it`s completed by the end of the day on ' . date('F d, Y', strtotime($timeline)) . '.<br><br>
                                The details of the task are as follow:<br><br>
                                Task Name: ' . $row2['task'] . '<br>
                                Description:  ' . $row2['add_comment'] . '<br><br>
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

            echo (mail($to, $subject, $message, $headers)) ? 2 : 0;
        }
    }
}
