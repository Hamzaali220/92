<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

        $con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

        
                $key = $_GET["email"];
$oldp = $_GET["oldp"];
$newp = $_GET["newp"];
                $sql = "SELECT * FROM spr_userlogin WHERE email = '$key' and password = '$oldp'";
                

   $raw = mysqli_query($con,$sql);

if(mysqli_num_rows($raw) > 0){
$error="ok";
echo json_encode(array("response"=>$error));
$sql1 = "update spr_userlogin set password = '$newp'  WHERE email= '$key'";
    
  if(mysqli_query($con,$sql1)){
      echo 'data updated successfully';
    }
    else{
      echo 'failure';
    }
}
else{
$error="failed";
echo json_encode(array("response"=>$error));
}
          

mysqli_close($con);
?>