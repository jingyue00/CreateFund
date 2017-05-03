

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
      $pid = $_POST["pid"];
      $updatemessage = $_POST["updatemessage"];


    //store the update message into richcontent 
      $newupdate = $conn-> prepare("INSERT RICH_CONTENT SET 
            content = ? , createtime = ?
            ");
        $now = new DateTime(null, new DateTimeZone('America/New_York'));
        $nowb = $now->format('Y-m-d H:i:s'); 
        $newupdate->bind_param("ss",$updatemessage,$nowb);
        $newupdate->execute();

        //get rid
        $getrid = $conn->prepare("SELECT rid FROM RICH_CONTENT WHERE content = ? ORDER BY createtime DESC LIMIT 1");
        $getrid->bind_param("s",$updatemessage);
        $getrid->execute();
        $result = $getrid->get_result();
        if($result){
            $row = mysqli_fetch_array($result,MYSQLI_BOTH);    
            $rid = $row['rid'];
        }

        //save into comment table
        $newupdate = $conn-> prepare("INSERT PROJECT_UPDATE SET 
            pid = ?,
            rid = ?,
            updatetime = ?
            ");
        $now = new DateTime(null, new DateTimeZone('America/New_York'));
        $nowb = $now->format('Y-m-d H:i:s');
        $newupdate->bind_param("sss", $pid, $rid, $nowb);
        $newupdate->execute();
        $result = $getrid->get_result();
        if($result){
            echo "good comment";
        }

        //get uid
        $getuid = $conn->prepare("SELECT uid FROM PROJECT_UPDATE WHERE pid = ? ORDER BY updatetime DESC LIMIT 1");
        $getuid->bind_param("s",$pid);
        $getuid->execute();
        $result = $getuid->get_result();
        if($result){
            $row = mysqli_fetch_array($result,MYSQLI_BOTH);    
            $uid = $row['uid'];
        }


    //store update image
    $a  = $_FILES["updateimage"]["name"];
    if(strcmp($a,"") != 0){
      $imgname = $_FILES["updateimage"]["name"];

      $now = new DateTime(null, new DateTimeZone('America/New_York'));
      $nowb = $now->format('Y-m-d H:i:s');
      $imgtype = "image";

      $newimage = $conn->prepare("
                    INSERT MEDIA SET 
                    uid = ?,
                    type = ?,
                    filename = ?,
                    updatetime = ?
                    ");
      $newimage->bind_param("ssss",$uid,$imgtype,$_FILES["updateimage"]["name"],$nowb);
      $newimage->execute();

    }

    //store update video 
    $a  = $_FILES["updatevideo"]["name"];
    if(strcmp($a,"") != 0 ){
      $imgname = $_FILES["updatevideo"]["name"];

      $now = new DateTime(null, new DateTimeZone('America/New_York'));
      $nowb = $now->format('Y-m-d H:i:s');
      $imgtype = "video";

      $newimage = $conn->prepare("
                    INSERT MEDIA SET 
                    uid = ?,
                    type = ?,
                    filename = ?,
                    updatetime = ?
                    ");
      $newimage->bind_param("ssss",$uid,$imgtype,$_FILES["updatevideo"]["name"],$nowb);
      $newimage->execute();

    }

$target_path = "/var/www/html/DbProject/img/";
$target_path = $target_path . basename( $_FILES['updateimage']['name']); 

if(move_uploaded_file($_FILES["updateimage"]["tmp_name"], $target_path))
{
   echo "upload complete";
}
else
{
   echo "move_uploaded_file failed";
   exit();
}


$target_path = "/var/www/html/DbProject/img/";
$target_path = $target_path . basename( $_FILES['updatevideo']['name']);

if(move_uploaded_file($_FILES["updatevideo"]["tmp_name"], $target_path))
{
   echo "upload complete";
}
else
{
   echo "move_uploaded_file failed";
   exit();
}

header("Location:detailproject.php");
exit;

?>
