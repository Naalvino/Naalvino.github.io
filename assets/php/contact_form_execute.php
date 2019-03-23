<?php
    $name= $_POST['name'];
    $email= $_POST['email'];
    $subject= $_POST['subject'];
    $message= $_POST['message'];

    $myemail= 'alvinon@kean.edu';
    $body= "User Name: $name.\n".
           "User Email: $email.\n".
           "User Message: $message.\n"; 

    $headers= "From: $email \r\n";
    $headers.="Reply-To: $email \r\n";

    mail($myemail, $subject, $body, $headers);
    header("Location: index.html");