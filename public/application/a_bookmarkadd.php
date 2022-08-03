<?php
$db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

   $psid = $_POST["psid"];
   $agentkey =$_POST["agentkey"];
   $agentname = $_POST["agentname"];
 

        $sql = "SELECT * FROM spr_sellerpost WHERE psid = '$psid'";
        $raw = mysqli_query($con,$sql);
        while($res=mysqli_fetch_assoc($raw)){
     $username = $res['username'];
     $title = $res['title'];
     $details = $res['details'];
     $line1 = $res['line1'];
     $line2 = $res['line2'];
     $state = $res['state'];
     $city = $res['city'];
     $zipcode = $res['zipcode'];
     $feature = $res['feature'];
     $date = $res['date'];
     $type = $res['type'];
     $nego = $res['nego'];
     $shortsale = $res['shortsale'];
     $startdate = $res['startdate'];
     $clodate = $res['clodate'];
     $applier = $res['applier'];
     $userkey = $res['userkey'];
     $usertype = $res['usertype'];
    }
  $sql1 =  "INSERT INTO spr_agentbookmark values (NULL,'$psid','$username','$title','$details','$line1','$line2','$state','$city','$zipcode','$feature','$date','$type','$nego','$shortsale','$startdate','$clodate','$applier','$userkey','$usertype','$agentkey','$agentname')";
       
if(mysqli_query($con,$sql1)){
    echo 'success';
    }
    else{
      echo 'failure';
    }
    mysqli_close($con);


?>