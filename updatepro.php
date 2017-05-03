<?php
    session_start();
	require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
		
	//get cname and keyword
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $pname = $_POST["pname"];
	$pdesc = $_POST["pdesc"];
	
	$min = $_POST["min"];
	$max = $_POST["max"];
	$endcampaign = $_POST["end"];
    $endcampaign = $endcampaign." 23:59:59";
	$edate = $_POST["edate"];
    $edate = $edate." 23:59:59";
    $richtext = $_POST["content"];

	$l = $_SESSION["loginname"];

    //echo "Upload: " . $_FILES["post"]["name"] . "<br />";
    //echo "Type: " . $_FILES["post"]["type"] . "<br />";
    //echo "Size: " . ($_FILES["post"]["size"] / 1024) . " Kb<br />";
    //echo "Stored in: " . $_FILES["post"]["tmp_name"];

    $target_path = "/Library/WebServer/Documents/git/img/";
    $target_path = $target_path . basename( $_FILES['post']['name']); 

    //echo "<br>";
    //echo $target_path;
    //echo "<br>";
    if(move_uploaded_file($_FILES["post"]["tmp_name"], $target_path))
    {
       //echo "upload complete";
    }
    else
    {
       //echo "move_uploaded_file failed";
       exit();
    }

    //echo "<img src='img/".$_FILES["post"]["name"]."'>";

    $post = $_FILES["post"]["name"];

    $newcontent = $conn->prepare("INSERT RICH_CONTENT SET
        rid = '',
        content = ?,
        createtime = NOW()
        ");
    $newcontent->bind_param("s",$pdesc);
    $newcontent->execute();
    $result = $newcontent->get_result();
    // not work: $a = $conn->insert_id;

    $getrid = $conn-> prepare("SELECT rid FROM RICH_CONTENT 
            WHERE content = ? ORDER BY createtime DESC LIMIT 1");
    $getrid->bind_param("s",$pdesc);
    $getrid->execute();
    $result = $getrid->get_result();
    while($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
        $_SESSION['rid'] = $row['rid'];
    };

	$newpro = $conn->prepare("INSERT PROJECT SET
            pid = '',
            pname = ?,
            pdesc = ?,
            createtime = NOW(),
            owner = ?,
            min = ?,
            max = ?,
            endcampaign = ?,
            etime = ?,
            status = 'PledgeStarted',
            currentamt = '0',
            post = ?
    ");
	$newpro->bind_param("ssssssss",$pname,$_SESSION['rid'],$l,$min,$max,$endcampaign,$edate,$post);
	$newpro->execute();

    if( isset( $_POST["tag"] )) {
        $getpid = $conn-> prepare("SELECT pid FROM PROJECT 
            WHERE pname = ? ORDER BY createtime DESC LIMIT 1");
        $getpid->bind_param("s",$pname);
        $getpid->execute();
        $result = $getpid->get_result();
        if($result){
            $row = mysqli_fetch_array($result,MYSQLI_BOTH);        
            $_SESSION['pid'] = $row['pid'];  
        } 

        $updatetag = $conn->prepare("INSERT TAG_PROJECT Set pid=?, tag=?");        

        foreach($_POST["tag"] as $chk) { 
            $updatetag->bind_param("ss", $_SESSION['pid'], $chk);
            $updatetag->execute();
            //echo "total tag: ".$updatetag->affected_rows;
        }
    }

    header("Location:detailproject.php");
    exit;

?>