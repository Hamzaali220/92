<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

    if (empty($_GET['senderkey'])) {
    
} else{
$key = $_GET["senderkey"];
        $sql = "SELECT * FROM spr_question WHERE senderkey = '$key'";
        $raw = mysqli_query($con,$sql);
        while($res=mysqli_fetch_assoc($raw)){
        $data[]=$res;
    }
   print(json_encode($data));  
}


?>