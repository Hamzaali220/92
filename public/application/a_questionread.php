<?php
$db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

    if (empty($_GET['receiverkey'])) {
    
} else{
$key = $_GET["receiverkey"];
        $sql = "SELECT * FROM spr_question WHERE receiverkey = '$key'";
        $raw = mysqli_query($con,$sql);
        while($res=mysqli_fetch_assoc($raw)){
        $data[]=$res;
    }
   print(json_encode($data));  
}


?>