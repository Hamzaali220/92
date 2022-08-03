<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

  $msg = $_POST['msg'];
     $doc = $_POST['doc'];
     $title1 = rand(); 
     $location = "images/$title1.jpg";
     $image = $_POST['image'];
     $pdf = $_POST['pdf'];
     $type = $_POST['type'];
     $agentname = $_POST['agentname'];
     $username = $_POST['username'];
     $agentkey = $_POST['agentkey'];
     $userkey = $_POST['userkey'];
     $senderdevice = $_POST['senderdevice'];
     

$sql = "INSERT INTO spr_chat values (NULL,'$msg','$doc','$location','$pdf','$type','$agentname','$username','$agentkey','$userkey','$senderdevice')";
    
  if(mysqli_query($con,$sql)){
  file_put_contents($location,base64_decode($image));
      echo 'data updated successfully';
    }
    else{
      echo 'failure';
    }
    mysqli_close($con);

?>