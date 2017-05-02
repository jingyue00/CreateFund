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

    $hamount = $_POST["hamount"];
	$hccn = $_POST["hccn"];
    $hccv = $_POST["hccv"];

	//<!-- get pid --> 
    if(isset($_SESSION["pid"])){
        $pid = $_SESSION["pid"];
    }

    echo "$pid";
    echo "$loginname";

    //else{
    //$pid = $_SESSION["pid"];
    //$pid = '10113106771384991868';
    //}

    //<!-- get loginname --> 
    //$loginname = 'jane1234';

    //check if already exit pledge
    $ifpledge = $conn->prepare("SELECT plid FROM PLEDGE WHERE 
        pid = ? AND loginname = ? 
        ");
    $ifpledge->bind_param("ss",$pid,$loginname);
    $ifpledge->execute();
    $result = $ifpledge->get_result();
    $rowCount = mysqli_num_rows($result);
    if($rowCount > 0){
            $row = mysqli_fetch_array($result,MYSQLI_BOTH);        
            $plid = $row['plid']; 
            echo "aaa";
            echo $plid;
    }  
    else{
        $newpledge = $conn->prepare("
                INSERT PLEDGE SET loginname = ?, pid = ?
            ");
            $newpledge->bind_param("ss",$loginname,$pid);
            $newpledge->execute();

            $getplid = $conn->prepare("SELECT plid FROM PLEDGE WHERE 
                pid = ? AND loginname = ? 
                ");
            $getplid->bind_param("ss",$pid,$loginname);
            $getplid->execute();

            $result = $getplid->get_result();
            if($result){
                    $row = mysqli_fetch_array($result,MYSQLI_BOTH);        
                    $plid = $row['plid']; 
            } 
            echo "bbb";
            echo $plid;
    }

    //insert new transaction
    $newtrans = $conn->prepare("
                INSERT TRANSACTION SET plid = ?, amount = ?, ccn = ?, ccv = ?, loginname = ?
            ");
    $newtrans->bind_param("sssss",$plid, $hamount,$hccn,$hccv,$loginname);
	$newtrans->execute();

    header("Location:transactionlist.php");
    exit;


?>


<?php 

include_once "footer.php";

?>