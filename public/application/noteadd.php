<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);
    
     $title = $_POST['title'];
     $note = $_POST['note'];
     $type = $_POST['type'];
     $userkey = $_POST['userkey'];

$sql = "INSERT INTO spr_note values (NULL,'$title','$note','$type','$userkey')";
    
  if(mysqli_query($con,$sql)){
      echo 'data updated successfully';
    }
    else{
      echo 'failure';
    }
    mysqli_close($con);

?>