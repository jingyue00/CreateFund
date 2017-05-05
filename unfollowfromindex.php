
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

    $loginname = $_POST["unloginname"];
	$following = $_POST["unfollowing"];

    //check if already exit pledge
    $iffollow = $conn->prepare("SELECT COUNT(*) as c FROM FOLLOW WHERE 
        following = ? AND loginname = ? 
        ");
    $iffollow->bind_param("ss",$following,$loginname);
    $iffollow->execute();
    $result = $iffollow->get_result();
    $row = mysqli_fetch_array($result,MYSQLI_BOTH);  
    if($row['c'] > 0){
            //already following
            $rmfollow = $conn->prepare("DELETE FROM FOLLOW
                WHERE loginname = ? AND following = ? ");
            $rmfollow->bind_param("ss", $loginname, $following);
            $rmfollow->execute();

            $_SESSION['rmfollow'] = "done";
            $_SESSION['following'] = $following;
    }  
    else{    
            // not following
            $_SESSION['rmfollow'] = "fail";
             
    }
    
    header("Location:index.php");
    exit;

?>
