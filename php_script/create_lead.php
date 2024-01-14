<?php

session_start();

require('DBConnect.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../mail_src/Exception.php';
require '../mail_src/PHPMailer.php';
require '../mail_src/SMTP.php';


function gen_uuid()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}

$name = $_REQUEST['name'];
$contact = $_REQUEST['contact'];
$generated_from_link = $_REQUEST['link'];

$sql_contact_check = "SELECT * FROM leads WHERE contact_number='$contact'";
$query_contact_check = $con_new->query($sql_contact_check);
if (mysqli_num_rows($query_contact_check) == 0) {
    $id = gen_uuid();

    date_default_timezone_set('Asia/Kolkata');

    $time_stamp = date("Y-m-d H:i:s");

    $sql = "INSERT INTO leads(id,name,contact_number,entry_id,entry_category,generated_by,generated_from_link,lead_type,assigned_by,assigned_to,lead_status,created_at,updated_at) VALUES('$id','$name','$contact','[]','[]','tawk','$generated_from_link','2','09afac27-6337-4659-972c-d4615c2d6c2c','09afac27-6337-4659-972c-d4615c2d6c2c','2','$time_stamp','$time_stamp')";
    $query = $con_new->query($sql);
    if ($query) {
        $emailTemplate = "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                <style>
                    @import url('https://fonts.googleapis.com/css?family=Montserrat&display=swap');
                    @import url('https://fonts.googleapis.com/css?family=Merriweather&display=swap');
                    @import url('https://fonts.googleapis.com/css?family=Poppins&display=swap');
            
                    *
                    {
                        margin: 0px;
                        padding: 0px;
                        font-family: 'Merriweather', sans-serif;
                    }
                    
                    html,body
                    {
                        width: 100%;
                        height: 100%;
                    }
            
                    article
                    {
                        margin: 0 auto;
                        width: 100%;
                    }
            
                    #head, #footer
                    {
                        width: 100%;
                        background-color: #292e1e;
                        padding: 1em 0.7em; 
                    }
            
                    #head
                    {
                        box-shadow: 0px 10px 12px 0px rgba(0,0,0,0.05);    
                    }
            
                    #footer
                    {
                        box-shadow: 0px -10px 12px 0px rgba(0,0,0,0.05);    
                    }
                        
                    #head h6
                    {
                        font-size: larger;
                        letter-spacing: 2px;
                        margin: 0px !important;
                        color: #fafafa;
                        font-weight: lighter !important;
                    }
            
                    #footer p
                    {
                        font-family: 'Poppins', sans-serif;
                        font-size: x-small;
                        font-weight: lighter !important;
                        letter-spacing: 1px;
                        color: #fafafa;
                        text-align: center;
                    }
                    
                    #body
                    {
                        width: 100%;
                        padding: 1em;
                        background-color: #fafafa;
                        padding-top: 50px;
                        padding-bottom: 50px;
                    }
            
                    table
                    {
                        border-spacing: 0px;
                    }
            
                    #title h6
                    {
                        font-size: medium;
                        letter-spacing: 1px;
                        margin: 0px !important;
                        color: #555;
                    }
                    
                    #title p
                    {
                        font-family: 'Poppins', sans-serif;
                        font-size: small;
                        font-weight: lighter !important;
                        letter-spacing: 1px;
                        color: #999;
                    }
                    
                    #title, #field
                    {
                        padding: 0.5em;
                    }
            
                    #double
                    {
                        width: 100%;
                    }
            
                    #double #field
                    {
                        width: 50%;
                    }
                    #field h6
                    {
                        font-family: 'Poppins', sans-serif;
                        font-size: smaller;
                        letter-spacing: 1px;
                        margin: 0px !important;
                        color: #555;
                    }
            
                    #field p
                    {
                        font-size: x-small;
                        font-weight: lighter !important;
                        letter-spacing: 1px;
                        color: #999;
                    }

                    #redirect_admin
                    {
                        font-size: smaller;
                        letter-spacing: 1px;
                        margin: 0px !important;
                        color: #fff;
                        background-color: #064668;
                        padding: 0.7em 1em;
                        border-radius: 3px;
                        box-shadow: 0px 10px 10px 0px rgba(0,0,0,0.03);
                    }
            
                    @media screen and (min-width: 575px)
                    {
                        article
                        {
                            margin: 0 auto;
                            width: 550px;
                        }
                    }
            
                </style>
            </head>
            <body>
                <article>
                    <table id='template'>
                        <tbody>
                            <tr>
                                <td>
                                    <table id='head'>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h6>CDC OFFICE</h6>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table id='body'>
                                        <tbody>
                                            <tr>
                                                <td id='title'>
                                                    <h6>We got a new lead From Tawk</h6>
                                                    <p>Details are as mentioned below:</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id='field'>
                                                    <p>Name</p>    
                                                    <h6>" . $name . "</h6>    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id='field'>
                                                    <p>Contact Number</p>    
                                                    <h6>" . $contact . "</h6>    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id='field'>
                                                    <p>Generated From Link</p>    
                                                    <h6>" . $generated_from_link . "</h6>    
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table id='footer'>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p>Copyright 2019 © Centre for Defence Careers | All Rights Reserved</p>
                                                </td>
                                            </tr>
                                        </tbody>    
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </article>
            </body>
        </html>";

        $mail = new PHPMailer(true);

        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'mail.centrefordefencecareers.co.in';     // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'office@centrefordefencecareers.co.in'; // SMTP username
        $mail->Password   = 'Animal@!23';
        $mail->Port = 465;
        $mail->SMTPSecure = "ssl";
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Recipients
        $mail->setFrom('office@centrefordefencecareers.co.in', 'CDC Office');
        $mail->addAddress('singh201033@gmail.com', 'S Singh');             // Add a recipient
        $mail->addAddress('minal_pawar2000@yahoo.co.in', 'Minal Pawar');    // Name is optional
        $mail->addAddress('khushikora@gmail.com', 'Khushi Kora');

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'We got a new lead in CDC from Tawk';
        $mail->Body    = $emailTemplate;
        $mail->AltBody = 'We got a new Lead In Cdc From Tawk';

        $mail->send();
    }
}
