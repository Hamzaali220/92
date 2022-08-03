<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

     $too = $_POST['too'];
     $fromm = $_POST['fromm'];
     $question = $_POST['question'];
     $reply = $_POST['reply'];
     $receiverkey = $_POST['receiverkey'];
     $senderkey = $_POST['senderkey'];

$sql = "INSERT INTO spr_question values (NULL,'$too','$fromm','$question','$reply','$receiverkey','$senderkey')";
    
  if(mysqli_query($con,$sql)){
      echo 'data updated successfully';
    }
    else{
      echo 'failure';
    }
    mysqli_close($con);

?>