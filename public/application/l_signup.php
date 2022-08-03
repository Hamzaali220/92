<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

 $name =$_POST["name"];
   $email = $_POST["email"];
$password =$_POST["password"];
   $type = $_POST["type"];
$que1 =$_POST["que1"];
   $answer1 = $_POST["answer1"];
$que2 =$_POST["que2"];
   $answer2 = $_POST["answer2"];
 
$sql = "insert into spr_userlogin values (NULL,'$name','$email','$password','$type','')";
    
if(mysqli_query($con,$sql)){
$sql1 = "insert into spr_securityquestion values ('$email','$que1','$answer1','$que2','$answer2')";
    
if(mysqli_query($con,$sql1)){
    echo 'success';
    }
    else{
      echo 'failure';
    }
   
    }
    else{
      echo 'failure';
    }
    mysqli_close($con);


?>