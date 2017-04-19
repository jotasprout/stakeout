<?php 

 require_once('class.phpmailer.php');
 
    $mail = new PHPMailer();
    $mail->CharSet =  "utf-8";
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Username = "murlsprout@gmail.com";
    $mail->Password = "Thug4Life$";
    $mail->SMTPSecure = "ssl";  
    $mail->Host = "smtp.gmail.com";
    $mail->Port = "465";
 
    $mail->setFrom('murlsprout@gmail.com', 'Murl Sprout');
    $mail->AddAddress('jotasprout@mail.com', 'Jay the Magnificent');
 
    $mail->Subject  =  'using PHPMailer';
    $mail->IsHTML(true);
    $mail->Body    = 'Hi there ,
                        <br />
                        this mail was sent using PHPMailer...
                        <br />
                        Caio';
  
     if($mail->Send())
     {
        echo "Message was successfully Sent :)";
     }
     else
     {
        echo "Mail Error - >".$mail->ErrorInfo;
     }
  
?>