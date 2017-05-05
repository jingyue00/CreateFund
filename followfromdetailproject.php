
<?php
    session_start();
    //include_once "header.php";

    require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
        
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    //<!-- get loginname -->
    if(isset($_SESSION["loginname"])){
        $loginname = $_SESSION["loginname"];
    }

    if($_SESSION['notloginyet']=="silent"){
            $_SESSION['notloginyet'] = "nologin";
    } else { 

        $hloginname = $_POST["hloginname"];
    	$hfollowing = $_POST["hfollowing"];

        //check if already follow
        $iffollow = $conn->prepare("SELECT COUNT(*) as c FROM FOLLOW WHERE 
            following = ? AND loginname = ? 
            ");
        $iffollow->bind_param("ss",$hfollowing,$hloginname);
        $iffollow->execute();
        $result = $iffollow->get_result();
        $row = mysqli_fetch_array($result,MYSQLI_BOTH);  
        if($row['c'] > 0){
                //already following
                $_SESSION['follow'] = "already";
                $_SESSION['following'] = $hfollowing;
        }  
        else{
                $newfollow = $conn->prepare("
                    INSERT FOLLOW SET loginname = ?, following = ?
                ");
                $newfollow->bind_param("ss",$hloginname,$hfollowing);
                $newfollow->execute();
                //insert a new following
                $_SESSION['follow'] = "new";
                $_SESSION['following'] = $hfollowing;

                //add userlog
                $now = new DateTime(null, new DateTimeZone('America/New_York'));
                $nowb = $now->format('Y-m-d H:i:s'); 
                $ltype = "follow";
                $newlog = $conn->prepare("
                            INSERT USERLOG SET loginname = ?, ltype = ?, targetid = ?, ltime = ?
                        ");
                $newlog->bind_param("ssss",$loginname,$ltype,$hfollowing,$nowb);
                $newlog->execute();
                 
        }
        $_SESSION["ploginname"] = $_POST["hfollowing"];

    }
    header("Location:detailproject.php");
    exit;

?>