<?php

$notification = $_POST['notification'];

$from = "system.administrator<(it@innogroup.com.ph)>";
$to = $_POST['email'];

$subject = "SMRT Message";
$message = '<html>
                    <body style="margin: 0 auto; padding: 10px; border: 1px solid #e1e1e1; font-family:Calibri">
                        <div style="background-color: #00C957; padding: 5px; color: white">
                            <h3 style="padding: 0; margin: 0;">  Message: </h3>
                        </div>
                        <div style="border: 1px solid #e1e1e1; padding: 5px">    
                        Hi, ' . $_POST['fullname'] . ',<br><br>
                        ' . $notification . '
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
