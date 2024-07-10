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
    $dateTime = new DateTime($row['timeline']);
    $modifydate = $dateTime->modify('-2 day'); // Subtract 2 day from the date
    $warnDate = $modifydate->format('Y-m-d');
    if ($row['timeline'] == $currentDate || $warnDate == $currentDate) {
        $from = "system.administrator<(it@innogroup.com.ph)>";
        $to = $row['email'];

        $subject = "SMRT|Reminder: Task Due Today";
        $message = '<html>
                            <body style="margin: 0 auto; padding: 10px; border: 1px solid #e1e1e1; font-family:Calibri">
                                <div style="background-color: #00C957; padding: 5px; color: white">
                                    <h3 style="padding: 0; margin: 0;">  Message: </h3>
                                </div>
                                <div style="border: 1px solid #e1e1e1; padding: 5px">    
                                Hi, ' . $row['fullname'] . '<br><br>
                                Just a quick reminder that ' . $warnDate != $currentDate ? 'today' : 'tommorow' . ' is the deadline for the task you assigned. Please ensure it`s done by the end of the day.<br><br>
                                The details of the task are as follow:<br><br>
                                Task Name: ' . $row['task'] . '<br>
                                Description:  ' . $row['add_comment'] . '<br>
                                Deadline:  ' . date('F d, Y', strtotime($row['timeline'])) . '<br><br>
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
    $dateTime = new DateTime($row['timeline']);
    $modifydate = $dateTime->modify('-2 day'); // Subtract 2 day from the date
    $warnDate = $modifydate->format('Y-m-d');
    if ($row['timeline'] == $currentDate || $warnDate == $currentDate) {
        $from = "system.administrator<(it@innogroup.com.ph)>";
        $to = $row2['email'];

        $subject = "SMRT|Reminder: Task Due Today";
        $message = '<html>
                            <body style="margin: 0 auto; padding: 10px; border: 1px solid #e1e1e1; font-family:Calibri">
                                <div style="background-color: #00C957; padding: 5px; color: white">
                                    <h3 style="padding: 0; margin: 0;">  Message: </h3>
                                </div>
                                <div style="border: 1px solid #e1e1e1; padding: 5px">    
                                Hi, ' . $row2['fullname'] . '<br><br>
                                Just a quick reminder that ' . $warnDate != $currentDate ? 'today' : 'tommorow' . ' is the deadline for completing your assigned task. Please ensure it`s done by the end of the day.<br><br>
                                The details of the task are as follow:<br><br>
                                Task Name: ' . $row2['task'] . '<br>
                                Description:  ' . $row2['add_comment'] . '<br>
                                Deadline:  ' . date('F d, Y', strtotime($row2['timeline'])) . '<br><br>
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
