<?php
include "connection.php";
include "SMTP.php";
include "PHPMailer.php";
include "Exception.php";
include "signupProcess.php";

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_GET["e"])){
    $email = $_GET["e"];

    $rs = Database::search("SELECT * FROM `user` WHERE `email` = '".$email."'");
    $n = $rs->num_rows;

    if($n == 1){
        
        $code = uniqid();
        Database:: iud("UPDATE `user` SET `verification_code` ='".$code."' WHERE `email`='".$email."'");

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'champika.delima@gmail.com';
        $mail->Password = 'oayolnjmqpdlsuht';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('champika.delima@gmail.com','Reset Password');
        $mail->addReplyTo('champika.delima@gmail.com','Reset Password');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'eshop forgot password verification code ';
        $bodyContent = '<h1 style= "color:green;">Your verification code is '.$code.'</h1>';
        $mail->Body   = $bodyContent;

        if(!$mail->send()){
            echo 'verification code sending failed.';
        }else{
            echo 'success'; 
        }

    }else{
        echo("Invalid Email Address.");
    }

}else{
    echo("Please enter your Email address in Email Field.");
}

?>