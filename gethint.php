<?php 
session_start();
date_default_timezone_set('America/New_York');
//include_once "header.php";

require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
        
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

$keyword = "%".$_GET["q"]."%";
$getq = $conn-> prepare("SELECT * FROM PROJECT where pname like ?");
$getq->bind_param("s", $keyword);
$getq->execute();
$result = $getq->get_result();
                            
echo "<datalist id=\"hint\">";
while($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
    echo "<option value=\"".$row["pname"]."\">";
}
echo "</datalist>";


?>