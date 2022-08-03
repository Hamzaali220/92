<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

        $con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

        
                $key = $_POST["email"];
$password = $_POST["password"];
                $sql = "update spr_userlogin set password = '$password'  WHERE email= '$key'";
                
 if(mysqli_query($con,$sql)){
      echo 'data updated successfully';
    }
    else{
      echo 'failure';
    }


mysqli_close($con);
?>