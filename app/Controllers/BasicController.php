<?php
namespace App\Controllers;
/**
 * Created by PhpStorm.
 * User: gaolin
 * Date: 2/19/17
 * Time: 3:26 AM
 */
class BasicController
{

    function GotoUrl($msg, $url, $time=5){
        header( "refresh:$time;url=$url" );
        echo "<font color=red>$msg</font> <br>";
        echo "You'll be redirected in about {$time} secs. If not, click <a href=\"$url\">here</a>.";

    }

    function notifyAllStudent($subject,$msg,$emailArr){
        require  dirname(dirname(__FILE__))."/Models/mail/PHPMailerAutoload.php";

        $mail = new \PHPMailer;

        //$mail->SMTPDebug = 3;                               // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'mavappointmail@gmail.com';                 // SMTP username
        $mail->Password = 'mavpassword';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        $mail->setFrom('MavAppoint', 'Mailer');

//        $mail->addAddress('lin.gao@mavs.uta.edu', 'Lin Gao');     // Add a recipient
//        $mail->addAddress('ellen@example.com');               // Name is optional
//        $mail->addReplyTo('info@example.com', 'Information');
//        $mail->addCC('cc@example.com');
//        $mail->addBCC('bcc@example.com');

//        $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
//        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body =$msg;
//        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        foreach ($emailArr as $email){
            $mail->clearAddresses();
            $mail->addAddress($email);     // Add a recipient
            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
        }


    }







}