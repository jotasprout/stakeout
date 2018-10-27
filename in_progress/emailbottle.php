<?php
    $to = "jotasprout@gmail.com";
    $subject = "Nonsensical Latin";

    // compose headers
    $headers = "From: stakeout@roxorsoxor.com\r\n";
    $headers .= "Reply-To: stakeout@roxorsoxor.com\r\n";
    $headers .= "X-Mailer: PHP/".phpversion();

    // compose message
    $message = "Humper-didder-doo!";
    $message = wordwrap($message, 70);

    // send email
    mail($to, $subject, $message, $headers);
?>