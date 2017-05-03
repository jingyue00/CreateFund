
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

    $hloginname = $_POST["hloginname"];
	$hfollowing = $_POST["hfollowing"];

    //check if already exit pledge
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
             
    }

    header("Location:peoplelist.php");
    exit;

?>