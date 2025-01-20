<?php
    $siteRoot = $siteRoot ?? '../';  // use siteRoot as defined in the .php file that includes this one; if it's not define then use the root from here
    require_once $siteRoot . 'config.php';
    
    require '../PHPMailer/PHPMailer.php';
    require '../PHPMailer/SMTP.php';
    require '../PHPMailer/Exception.php';
    
    use PHPMailer\module9\PHPMailer\PHPMailer;

    function send_mail(string $subject, string $msg): array|bool
    {
        global $gmailUsername, $gmailPassword;
        if (!isset($gmailUsername) || !isset($gmailPassword)) {
            return ["success" => false, "error" => "couldn't retrieve gmail credentials"];
        }
        
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0; // 4
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = $gmailUsername;
        $mail->Password = $gmailPassword;
        $mail->setFrom($gmailUsername);
        $mail->addAddress($gmailUsername);
        $mail->Subject = $subject;
        $mail->Body = $msg;

        //send the message, check for errors
        if (!$mail->send()) {
            return ["success" => false, "error" => $mail->ErrorInfo];
        } else {
            return ["success" => true];
        }
    }

?>