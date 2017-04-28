<?php
    session_start();
	require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
		
	//get cname and keyword
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $hamount = $_POST["hamount"];
	$hccn = $_POST["hccn"];
    $hccv = $_POST["hccv"];

	//<!-- get pid --> 
    if(isset($_GET["pid"])){
        $pid = $_GET["pid"];
    }
    else{
    //$pid = $_SESSION["pid"];
    $pid = '10113106771384991868';
    }

    //<!-- get loginname --> 
    $loginname = 'jane1234';


    //check if already exit pledge
    $ifpledge = $conn->prepare("SELECT plid FROM PLEDGE WHERE 
        pid = ? AND loginname = ? 
        ");
    $ifpledge->bind_param("ss",$pid,$loginname);
    $ifpledge->execute();
    $result = $ifpledge->get_result();
    if($result){
            $row = mysqli_fetch_array($result,MYSQLI_BOTH);        
            $plid = $row['plid']; 
            echo "aaa";
            echo $plid;
    }  
    else{
        $newpledge = $conn->prepare("
                INSERT PLEDGE SET plid = ?, loginname = ?, pid = ?
            ");
            $newpledge->bind_param("sss",'',$loginname,$pid);
            $newpledge->execute();
            $result = $newpledge->get_result();
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

include_once "header.php";

?>


<?php 

include_once "footer.php";

?>