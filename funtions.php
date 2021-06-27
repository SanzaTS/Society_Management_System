<?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        
        require 'vendor/autoload.php';
function sendMail($sendTo,$subject,$message)
{

        
        $mail = new PHPMailer(true);
        
        try {
 

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'your username';
            $mail->Password = 'your password';
        
            $mail->setFrom('noreply@gmail.com', 'society');           
            $mail->addAddress($sendTo);
            //$mail->addAddress('receiver2@gfg.com', 'Name');
            
            $mail->isHTML(true);                                  
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = 'Body in plain text for non-HTML mail clients';
            if($mail->send())
            {
                return "Mail has been sent successfully";
            }
            //echo "Mail has been sent successfully!";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

}



?>