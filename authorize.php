<?php
	//Connect login page and homepage
    session_start();
	//connect to database
	require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
		
	//get cname and keyword
	session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $code = $_POST["code"];
    if($code != $_SESSION["code"])
    {
         echo "<script>window.location.href='login.php'; alert('Incorrect Captcha. Please re-enter!');</script>";
    }
    $loginname = $_POST["loginname"];
	$password = $_POST["password"];
	$md5password = md5($password);
	$checkCname = $conn->prepare("select * from USER where loginname = ? and password = ?");
    $checkCname->bind_param("ss",$loginname, $md5password);
    $checkCname->execute();
    $row = mysqli_fetch_array($checkCname -> get_result(),MYSQLI_BOTH);
    if(!$row)
    {
        echo "<script>window.location.href='login.php'; alert('Incorrect Login Name or Password. Please re-enter!');</script>";
		$conn->close();
	}
    else
    {
        $_SESSION['loginname'] = $loginname;
		$conn->close();
		echo "<script>window.location.href='index.php';</script>";
	}
?>