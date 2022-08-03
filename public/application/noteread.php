<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

    if (empty($_GET['userkey'])) {
    
   
}else{
 $type = $_GET["type"];
    $key = $_GET["userkey"];
    
        $sql = "SELECT * FROM spr_note WHERE userkey = '$key' AND type = '$type'";
        $raw = mysqli_query($con,$sql);
        while($res=mysqli_fetch_assoc($raw)){
        $data[]=$res;
    }
   print(json_encode($data));  
}


?>