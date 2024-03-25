<?php 



use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';


function sendMail($usermail, $otp, $no=null){

    $mail = new PHPMailer(true);


    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = '';              //SMTP username
    $mail->Password   = '';                     //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;  

    $mail->setFrom('@gmail.com', 'Simple Form');
    $mail->addAddress($usermail, 'Dear');                  //Add a recipient
    
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = "Hey your Sakebook passwrod reset otp!!";
    $mail->Body    = "Your otp is ". $otp;


    $mail->send();
}

?>
