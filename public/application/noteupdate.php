<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

     $nid = $_POST['nid'];  
     $title = $_POST['title'];
     $note = $_POST['note'];

$sql = "update spr_note set title = '$title', note = '$note' WHERE nid= '$nid'";
    
  if(mysqli_query($con,$sql)){
      echo 'data updated successfully';
    }
    else{
      echo 'failure';
    }
    mysqli_close($con);

?>