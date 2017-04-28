<?php 
    session_start();
    include_once "header.php";

    require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
        
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

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


?>


<?php 

include_once "footer.php";

?>