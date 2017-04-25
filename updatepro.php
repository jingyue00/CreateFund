<?php
	require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
		
	//get cname and keyword
	session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $pname = $_POST["pname"];
	$pdesc = $_POST["pdesc"];
	
	$min = $_POST["min"];
	$max = $_POST["max"];
	$endcampaign = $_POST["end"];
	$etime = $_POST["edate"];

	$l = $_SESSION["loginname"];

    echo "Upload: " . $_FILES["post"]["name"] . "<br />";
    echo "Type: " . $_FILES["post"]["type"] . "<br />";
    echo "Size: " . ($_FILES["post"]["size"] / 1024) . " Kb<br />";
    echo "Stored in: " . $_FILES["post"]["tmp_name"];

    $target_path = "/Library/WebServer/Documents/new/img/";
    $target_path = $target_path . basename( $_FILES['post']['name']); 

    echo "<br>";
    echo $target_path;
    echo "<br>";
    if(move_uploaded_file($_FILES["post"]["tmp_name"], $target_path))
    {
       echo "upload complete";
    }
    else
    {
       echo "move_uploaded_file failed";
       exit();
    }

    echo "<img src='img/".$_FILES["post"]["name"]."'>";

    $post = $_FILES["post"]["name"];

    ?>
    <html>
    <h1><?php   echo "$l"; ?></h1>
    <h1><?php   echo "$pname"; ?></h1>
    <h1><?php   echo "$pdesc"; ?></h1>
    <h1><?php   echo "$post"; ?></h1>
    <h1><?php   echo "$min"; ?></h1>
    <h1><?php   echo "$max"; ?></h1>
    <h1><?php   echo "$end"; ?></h1>
    <h1><?php   echo "$edate"; ?></h1>
    </html>
    <?php

	


	//$newpro = $conn->prepare("INSERT INTO PROJECT() VALUE ()");
	//$newpro->bind_param("ss",$, $);
	//$newpro->execute();

	//$row = mysqli_fetch_array($newpro->get_result();,MYSQLI_BOTH);
    //if(!$row)
    //{
    //    echo "<script>window.location.href='login.php'; alert('Incorrect Login Name or Password. Please re-enter!');</script>";
	//	$conn->close();
	//}
    //else
    //{
    //    $_SESSION['loginname'] = $loginname;
	//	$conn->close();
	//	header('Location:createproject.php');
	//}


?>