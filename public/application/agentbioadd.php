<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";


$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

     $agentemail = $_POST['agentemail'];
     $agentname = $_POST['agentname'];
     $offaddress = $_POST['offaddress'];
     $state = $_POST['state'];
     $city = $_POST['city'];
     $zipcode = $_POST['zipcode'];
     $licenceno = $_POST['licenceno'];
     $franchise = $_POST['franchise'];
     $experience = $_POST['experience'];
     $companyname = $_POST['companyname'];
     $fax = $_POST['fax'];
     $brokername = $_POST['brokername'];
     $mlspublic = $_POST['mlspublic'];
     $mlsoffice = $_POST['mlsoffice'];
      $pdf = $_POST['pdf'];
     $status = $_POST['status'];
     $userkey = $_POST['userkey'];
     $location = "images/pending/user_$userkey.pdf";

$sql = "INSERT INTO spr_agentbio values (NULL,'$agentname','$offaddress','$state','$city','$zipcode','$licenceno','$franchise','$experience','$companyname','$fax','$brokername','$mlspublic','$mlsoffice','$status','$userkey')";
    
  if(mysqli_query($con,$sql)){
   file_put_contents($location,base64_decode($pdf));
      echo 'data updated successfully';
$sql1 = "update spr_userlogin set status = '$status' WHERE email= '$agentemail'";
    
  if(mysqli_query($con,$sql1)){
      echo 'data updated successfully';
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