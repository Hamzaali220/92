<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

     $psid = $_POST['psid'];
$username = $_POST['username'];
     $title = $_POST['title'];
     $details = $_POST['details'];
     $line1 = $_POST['line1'];
     $line2 = $_POST['line2'];
     $state = $_POST['state'];
     $city = $_POST['city'];
     $zipcode = $_POST['zipcode'];
     $feature = $_POST['feature'];
     $date = $_POST['date'];
     $type = $_POST['type'];
     $nego = $_POST['nego'];
     $shortsale = $_POST['shortsale'];
     $startdate = $_POST['startdate'];
     $clodate = $_POST['clodate'];
     $applier = $_POST['applier'];
     $userkey = $_POST['userkey'];
 $usertype = $_POST['usertype'];
     $agentkey = $_POST['agentkey'];
$agentame = $_POST['agentname'];

$sql = "update spr_sellerpost set username = '$username', title = '$title', details = '$details', line1 = '$line1', line2= '$line2', state = '$state', city = '$city', zipcode = '$zipcode', feature = '$feature', type = '$type', nego = '$nego', shortsale = '$shortsale', startdate = '$startdate', clodate = '$clodate', applier = '$applier', userkey = '$userkey',usertype = '$usertype', agentkey = '$agentkey',agentname = '$agentname'  WHERE psid= '$psid'";
    
  if(mysqli_query($con,$sql)){
      echo 'data updated successfully';
    }
    else{
      echo 'failure';
    }
    mysqli_close($con);

?>