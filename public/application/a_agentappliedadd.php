<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

   $psid = $_POST["psid"];
 $applier = $_POST["applier"];
 $agentkey = $_POST["agentkey"];
 $userkey = $_POST["userkey"];
 

        $sql = "SELECT * FROM spr_agentbio WHERE userkey = '$agentkey'";
        $raw = mysqli_query($con,$sql);
        while($res=mysqli_fetch_assoc($raw)){
$abid = $res['abid'];
     $agentname = $res['agentname'];
     $offaddress = $res['offaddress'];
     $state = $res['state'];
     $city = $res['city'];
     $zipcode = $res['zipcode'];
     $licenceno = $res['licenceno'];
     $franchise = $res['franchise'];
     $experience = $res['experience'];
     $companyname = $res['companyname'];
     $fax = $res['fax'];
     $brokername = $res['brokername'];
     $mlspublic = $res['mlspublic'];
     $mlsoffice = $res['mlsoffice'];
    }
  $sql1 = "insert into spr_apply  values (NULL,'$abid','$agentname','$offaddress','$state','$city','$zipcode','$licenceno','$franchise','$experience','$companyname','$fax','$brokername','$mlspublic','$mlsoffice','$psid','$agentkey','$userkey')";
       
if(mysqli_query($con,$sql1)){
$sql2 = "update spr_sellerpost set applier = '$applier' WHERE psid= '$psid'";
  if(mysqli_query($con,$sql2)){
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