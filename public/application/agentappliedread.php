<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

    if (empty($_GET['agentkey'])) {
    $userkey = $_GET["userkey"];
    $psid = $_GET["psid"];
    
        $sql = "SELECT * FROM spr_apply WHERE userkey = '$userkey' and psid = '$psid'";
        $raw = mysqli_query($con,$sql);
        while($res=mysqli_fetch_assoc($raw)){
        $data[]=$res;
    }
   print(json_encode($data));  
   
}else{
 $agentkey = $_GET["agentkey"];
    $psid = $_GET["psid"];
    
        $sql = "SELECT * FROM spr_apply WHERE agentkey = '$agentkey' and psid = '$psid'";
        $raw = mysqli_query($con,$sql);
        while($res=mysqli_fetch_assoc($raw)){
        $data[]=$res;
    }
   print(json_encode($data));  
   
}


?>