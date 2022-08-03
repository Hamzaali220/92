<?php
      
   $email = $_POST["email"];
   $otp =$_POST["otp"];
 $to = $_POST["email"];
$subject = "Otp for 92Agent";
$txt = $_POST["otp"];
$headers = "From: admin@example.com" . "\r\n" .
"CC: admin@example.com";

mail($to,$subject,$txt,$headers);

?>