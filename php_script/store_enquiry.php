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

if (isset($_POST['user_name']) && isset($_POST['contact_number']) && isset($_POST['preferred_time_from']) && isset($_POST['preferred_time_to']) && isset($_POST['preferred_language']) && isset($_POST['entry_id']) && isset($_POST['dob']) && isset($_POST['gender']) && isset($_POST['caste']) && isset($_POST['qualification'])) {
    $user_name = $_POST['user_name'];
    $contact_number = $_POST['contact_number'];
    $preferred_time_from = $_POST['preferred_time_from'];
    $preferred_time_to = $_POST['preferred_time_to'];
    $preferred_language = $_POST['preferred_language'];
    $entry_id = $_POST['entry_id'];
    $msg = $_POST['message'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $caste = $_POST['caste'];
    $qualification = $_POST['qualification'];

    if (isset($_POST['stream'])) {
        $stream = $_POST['stream'];
    } else {
        $stream = null;
    }


    date_default_timezone_set('Asia/Kolkata');

    $time_stamp = date("Y-m-d H:i:s");


    $preferred_time = $preferred_time_from . ' - ' . $preferred_time_to;

    $sql_entry = "SELECT entry_category_id,category,entries FROM entries WHERE id='$entry_id'";
    $query_entry = $con_new->query($sql_entry);
    if (mysqli_num_rows($query_entry) > 0) {
        while ($row = mysqli_fetch_array($query_entry, MYSQLI_ASSOC)) {
            $entry_category = $row['entry_category'];
            $entry_category_id = $row['entry_category_id'];
            $entry_name = $row['entries'];
        }
    } else {
        $entry_category_id = '';
    }

    $email_entry_name = $entry_name . " (" . $entry_category . ")";

    $sql_contact_check = "SELECT * FROM leads WHERE contact_number='$contact_number'";
    $query_contact_check = $con_new->query($sql_contact_check);
    if (mysqli_num_rows($query_contact_check) > 0) {
        while ($data = mysqli_fetch_array($query_contact_check, MYSQLI_ASSOC)) {
            $lead_id = $data['id'];
            $stored_entry_id = json_decode($data['entry_id']);
            $stored_entry_category_id = json_decode($data['entry_category_id']);


            if (in_array($entry_id, $stored_entry_id) != 1) {
                array_push($stored_entry_id, $entry_id);

                $new_entry_id = json_encode($stored_entry_id);
            } else {
                $new_entry_id = json_encode($stored_entry_id);
            }

            if (in_array($entry_category_id, $stored_entry_category_id) != 1) {
                array_push($stored_entry_category_id, strval($entry_category_id));

                $new_entry_category_id = json_encode($stored_entry_category_id); //$data['entry_category'].','.$entry_category;
            } else {
                $new_entry_category_id = json_encode($stored_entry_category_id);
            }

            $sql_update = "UPDATE tb_user_leads SET entry_id='$new_entry_id', entry_category='$new_entry_category_id' WHERE lead_id='$lead_id'";
            $query_update = $con->query($sql_update);
            if ($query_update) {
                $response = array(
                    'error' => false,
                    'message' => '<p>We have received your details.</p><p>Our Counsellor will contact you within 24 hours</p>'
                );
            } else {
                $response = array(
                    'error' => true,
                    'query' => $sql,
                    'message' => '<p>We are currently unable to send the details.</p><p>You can call us at <a href="telephone:9320704957">9320704957</a> for further enquiry</p>'
                );
            }
        }
    } else {

        if ($entry_id == "") {
            $entry_id = json_encode([]);
        } else {
            $entry_id = json_encode(array($entry_id));
        }

        if ($entry_category_id == "") {
            $entry_category_id = json_encode([]);
        } else {
            $entry_category_id = json_encode(array(strval($entry_category_id)));
        }

        $id = gen_uuid();

        $cste = '1';

        if ($caste == 'OBC') {
            $cste = '2';
        } elseif ($caste == 'SC/ST') {
            $cste = '3';
        }

        $qualificatn = null;

        switch ($qualification) {
            case "Graduation":
                $qualificatn = '1';
                break;
            case "Graduation (Appearing)":
                $qualificatn = '2';
                break;
            case "Diploma":
                $qualificatn = '3';
                break;
            case "Diploma (Appearing)":
                $qualificatn = '4';
                break;
            case "12th":
                $qualificatn = '5';
                break;
            case "12th (Appearing)":
                $qualificatn = '6';
                break;
            case "11th":
                $qualificatn = '7';
                break;
            case "11th (Appearing)":
                $qualificatn = '8';
                break;
            case "10th":
                $qualificatn = '9';
                break;
            case "10th (Appearing)":
                $qualificatn = '10';
                break;
        }


        $sql = "INSERT INTO leads(id,entry_id,entry_category,name,contact_number,message,dob,gender,caste,qualification,stream,preferred_time,preferred_language,generated_by,lead_type,lead_status,created_at,updated_at) VALUES('$id','$entry_id','$entry_category_id','$user_name','$contact_number','$msg','$dob','$gender','$cste','$qualificatn','$stream','$preferred_time','$preferred_language','eligibility_check','1','1','$time_stamp','$time_stamp')";
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
                                                        <h6>We got a new lead</h6>
                                                        <p>Details are as mentioned below:</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td id='field'>
                                                        <p>Name</p>    
                                                        <h6>" . $user_name . "</h6>    
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td id='field'>
                                                        <p>Contact Number</p>    
                                                        <h6>" . $contact_number . "</h6>    
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <table id='double'>
                                                        <tbody>
                                                            <tr>
                                                                <td id='field'>
                                                                    <p>Preferred Time</p>    
                                                                    <h6>" . $preferred_time . "</h6>    
                                                                </td>
                                                                <td id='field'>
                                                                    <p>Entry</p>    
                                                                    <h6>" . $email_entry_name . "<h6>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table id='double'>
                                                            <tbody>
                                                                <tr>
                                                                    <td id='field'>
                                                                        <p>Date Of Birth</p>    
                                                                        <h6>" . $dob . "</h6>    
                                                                    </td>
                                                                    <td id='field'>
                                                                        <p>Gender</p>    
                                                                        <h6>" . $gender . "</h6>    
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table id='double'>
                                                            <tbody>
                                                                <tr>
                                                                    <td id='field'>
                                                                        <p>Caste</p>    
                                                                        <h6>" . $caste . "</h6>    
                                                                    </td>
                                                                    <td id='field'>
                                                                        <p>Qualification</p>    
                                                                        <h6>" . $qualification . "</h6>    
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table id='double'>
                                                            <tbody>
                                                                <tr>
                                                                    <td id='field'>
                                                                        <p>Preferred_language</p>    
                                                                        <h6>" . $preferred_language . "</h6>    
                                                                    </td>
                                                                    <td id='field'>
                                                                        <p>Applied On</p>    
                                                                        <h6>" . $time_stamp . "</h6>    
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>    
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td id='field'>
                                                        <p>Message</p>    
                                                        <h6>" . $msg . "</h6>    
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
            // $mail->addAddress('sankpalabhijeet3@gmail.com','Abhijeet Sankpal');

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'We got a new lead in CDC';
            $mail->Body    = $emailTemplate;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();

            $response = array(
                'error' => false,
                'message' => '<p>We have received your details.</p><p>Our Counsellor will contact you within 24 hours</p>'
            );
        } else {
            $response = array(
                'error' => true,
                'query' => $sql,
                'message' => '<p>We are currently unable to send the details.</p><p>You can call us at <a href="telephone:9320704957">9320704957</a> for further enquiry</p>'
            );
        }
    }
} else {
    $response = array(
        'error' => true,
        'Message' => '<p>We are currently unable to send the enquiry</p><p>You can call us at <a href="telephone:9320704957">9320704957</a> for further assistance</p>'
    );
}

echo json_encode($response);
