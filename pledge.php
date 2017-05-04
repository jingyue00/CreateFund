
<?php
    session_start();
    //include_once "header.php";

    require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
        
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $_SESSION['cannotpledge'] = "cannotpledge"; 

    header("Location:detailproject.php");
    exit;

?>