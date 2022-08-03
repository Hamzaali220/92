<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";
$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

     $pdf = $_POST['title'];
      $title1 = rand(); 
     $location = "images/$title1.doc";
     $name = $_POST['name'];
     $userkey = $_POST['userkey'];

$sql = "INSERT INTO spr_document values (NULL,'$location','$name','$userkey')";
    
  if(mysqli_query($con,$sql)){
     file_put_contents($location,base64_decode($pdf));

      echo 'data updated successfully';
    }
    else{
      echo 'failure';
    }
    mysqli_close($con);


?>