<?php
    $db_name = "dev92agents";
    $mysql_user="dev92agents";
    $mysql_pass="DEYiITasMllcgmBF";
    $server_name="localhost";

$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);
   
    if (empty($_GET['agentname'])) {
           if(empty($_GET['state'])){
               if(empty($_GET['city'])){
                   if(empty($_GET['zipcode'])){
                     
                       $sql = "SELECT * FROM spr_agentbio";
                       $raw = mysqli_query($con,$sql);
                       while($res=mysqli_fetch_assoc($raw)){
                           $data[]=$res;
                       }
                       print(json_encode($data));
                   }
                   else{
                       
                       $zipcode = $_GET["zipcode"];
                       $sql = "SELECT * FROM spr_agentbio WHERE zipcode LIKE '%$zipcode%'";
                       $raw = mysqli_query($con,$sql);
                       while($res=mysqli_fetch_assoc($raw)){
                           $data[]=$res;
                       }
                       print(json_encode($data));
                   }
               }
               else{
                   if(empty($_GET['zipcode'])){
                     
                       $city = $_GET["city"];
                    
                       $sql = "SELECT * FROM spr_agentbio WHERE city LIKE '%$city%'";
                       $raw = mysqli_query($con,$sql);
                       while($res=mysqli_fetch_assoc($raw)){
                           $data[]=$res;
                       }
                       print(json_encode($data));
                   }
                   else{
                       $city = $_GET["city"];
                       $zipcode = $_GET["zipcode"];
                       $sql = "SELECT * FROM spr_agentbio WHERE city LIKE '%$city%' AND zipcode LIKE '%$zipcode%'";
                       $raw = mysqli_query($con,$sql);
                       while($res=mysqli_fetch_assoc($raw)){
                           $data[]=$res;
                       }
                       print(json_encode($data));
                   }
               }
           }
else{
               if(empty($_GET['city'])){
                   if(empty($_GET['zipcode'])){

                      
                       $state = $_GET["state"];
                    
                       $sql = "SELECT * FROM spr_agentbio WHERE state LIKE '%$state%'";
                       $raw = mysqli_query($con,$sql);
                       while($res=mysqli_fetch_assoc($raw)){
                           $data[]=$res;
                       }
                       print(json_encode($data));
                   }
                   else{

                       $state = $_GET["state"];
                   
                       $zipcode = $_GET["zipcode"];
                       $sql = "SELECT * FROM spr_agentbio WHERE state LIKE '%$state%' AND zipcode LIKE '%$zipcode%'";
                       $raw = mysqli_query($con,$sql);
                       while($res=mysqli_fetch_assoc($raw)){
                           $data[]=$res;
                       }
                       print(json_encode($data));
                   }
               }
               else{
                   if(empty($_GET['zipcode'])){

                       $state = $_GET["state"];
                       $city = $_GET["city"];
                      
                       $sql = "SELECT * FROM spr_agentbio WHERE state LIKE '%$state%' AND city LIKE '%$city%'";
                       $raw = mysqli_query($con,$sql);
                       while($res=mysqli_fetch_assoc($raw)){
                           $data[]=$res;
                       }
                       print(json_encode($data));
                   }
                   else{

                    
                       $state = $_GET["state"];
                       $city = $_GET["city"];
                       $zipcode = $_GET["zipcode"];
                       $sql = "SELECT * FROM spr_agentbio WHERE state LIKE '%$state%' AND city LIKE '%$city%' AND zipcode LIKE '%$zipcode%'";
                       $raw = mysqli_query($con,$sql);
                       while($res=mysqli_fetch_assoc($raw)){
                           $data[]=$res;
                       }
                       print(json_encode($data));
                   }
               }
           }

        }else{
            if(empty($_GET['state'])){
                if(empty($_GET['city'])){
                    if(empty($_GET['zipcode'])){
                        $agentname = $_GET["agentname"];
                       
                        $sql = "SELECT * FROM spr_agentbio WHERE agentname LIKE '%$agentname%'";
                        $raw = mysqli_query($con,$sql);
                        while($res=mysqli_fetch_assoc($raw)){
                            $data[]=$res;
                        }
                        print(json_encode($data));
                    }
                    else{

                        $agentname = $_GET["agentname"];
                       
                        $zipcode = $_GET["zipcode"];
                        $sql = "SELECT * FROM spr_agentbio WHERE agentname LIKE '%$agentname%' AND zipcode LIKE '%$zipcode%'";
                        $raw = mysqli_query($con,$sql);
                        while($res=mysqli_fetch_assoc($raw)){
                            $data[]=$res;
                        }
                        print(json_encode($data));
                    }
                }
                else{
                    if(empty($_GET['zipcode'])){

                        $agentname = $_GET["agentname"];
                      
                        $city = $_GET["city"];
                    
                        $sql = "SELECT * FROM spr_agentbio WHERE agentname LIKE '%$agentname%' AND city LIKE '%$city%'";
                        $raw = mysqli_query($con,$sql);
                        while($res=mysqli_fetch_assoc($raw)){
                            $data[]=$res;
                        }
                        print(json_encode($data));
                    }
                    else{
                        $agentname = $_GET["agentname"];
                     
                        $city = $_GET["city"];
                        $zipcode = $_GET["zipcode"];
                        $sql = "SELECT * FROM spr_agentbio WHERE agentname LIKE '%$agentname%' AND city LIKE '%$city%' AND zipcode LIKE '%$zipcode%'";
                        $raw = mysqli_query($con,$sql);
                        while($res=mysqli_fetch_assoc($raw)){
                            $data[]=$res;
                        }
                        print(json_encode($data));
                    }
                }
            }
            else{
                if(empty($_GET['city'])){
                    if(empty($_GET['zipcode'])){

                        $agentname = $_GET["agentname"];
                        $state = $_GET["state"];
                        $sql = "SELECT * FROM spr_agentbio WHERE agentname LIKE '%$agentname%' AND state LIKE '%$state%'";
                        $raw = mysqli_query($con,$sql);
                        while($res=mysqli_fetch_assoc($raw)){
                            $data[]=$res;
                        }
                        print(json_encode($data));
                    }
                    else{
                        $agentname = $_GET["agentname"];
                        $state = $_GET["state"];
                  
                        $zipcode = $_GET["zipcode"];
                        $sql = "SELECT * FROM spr_agentbio WHERE agentname LIKE '%$agentname%' AND state LIKE '%$state%' AND zipcode LIKE '%$zipcode%'";
                        $raw = mysqli_query($con,$sql);
                        while($res=mysqli_fetch_assoc($raw)){
                            $data[]=$res;
                        }
                        print(json_encode($data));
                    }
                }
                else{
                    if(empty($_GET['zipcode'])){

                        $agentname = $_GET["agentname"];
                        $state = $_GET["state"];
                        $city = $_GET["city"];                    
                        $sql = "SELECT * FROM spr_agentbio WHERE agentname LIKE '%$agentname%' AND state LIKE '%$state%' AND city LIKE '%$city%'";
                        $raw = mysqli_query($con,$sql);
                        while($res=mysqli_fetch_assoc($raw)){
                            $data[]=$res;
                        }
                        print(json_encode($data));
                    }
                    else{
                        $agentname = $_GET["agentname"];
                        $state = $_GET["state"];
                        $city = $_GET["city"];
                        $zipcode = $_GET["zipcode"];
                        $sql = "SELECT * FROM spr_agentbio WHERE agentname LIKE '%$agentname%' AND state LIKE '%$state%' AND city LIKE '%$city%' AND zipcode LIKE '%$zipcode%'";
                        $raw = mysqli_query($con,$sql);
                        while($res=mysqli_fetch_assoc($raw)){
                            $data[]=$res;
                        }
                        print(json_encode($data));
                    }
                }
            }
        }


 if(mysqli_query($con,$sql)){
   
      echo 'data updated successfully';
    }
    else{
      echo 'failure';
    }
    mysqli_close($con);

?>
