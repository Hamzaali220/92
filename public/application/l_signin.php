<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

        $con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

        
                $key = $_GET["email"];
                 $password = $_GET["password"];
                $sql = "SELECT * FROM spr_userlogin WHERE email = '$key' and password = '$password'";
                $raw = mysqli_query($con,$sql);
                while($res=mysqli_fetch_assoc($raw)){
                    $data[]=$res;
                }
                print(json_encode($data));
           

?>