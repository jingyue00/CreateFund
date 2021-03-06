

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

    if($_SESSION['notloginyet']=="silent"){
            $_SESSION['notloginyet'] = "nologin";
    } else { 
        $hamount = $_POST["hamount"];
    	$hccn = $_POST["hccn"];
        $hccv = $_POST["hccv"];

    	//<!-- get pid --> 
        if(isset($_SESSION["pid"])){
            $pid = $_SESSION["pid"];
        }

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
                    INSERT PLEDGE SET loginname = ?, pid = ?, status = ?
                ");
                $status = 'waiting';
                $newpledge->bind_param("sss",$loginname,$pid,$status);
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

        //update project currentamt
        $getcurrentamt = $conn->prepare("SELECT * FROM PROJECT WHERE pid = ?");
        $getcurrentamt->bind_param("s",$pid);
        $getcurrentamt->execute();
        $amtr = $getcurrentamt->get_result();
        $rowr = mysqli_fetch_array($amtr,MYSQLI_BOTH); 
        $currentamt = $rowr['currentamt'];
        $min = $rowr['min'];
        $max = $rowr['max'];

        $newamt = $currentamt + $hamount;
        
        if($newamt < $max){
            $updateamt = $conn->prepare("UPDATE PROJECT SET currentamt = ? WHERE pid = ?");
            $updateamt->bind_param("ss",$newamt, $pid);
            $updateamt->execute();
        }else{
            $updateamt = $conn->prepare("UPDATE PROJECT SET currentamt = ?, status = ? WHERE pid = ?");
            $closestatus = "PledgeClosed";
            $updateamt->bind_param("sss",$newamt, $closestatus, $pid);
            $updateamt->execute();

            //change pledge status to confirmed
            $updatepl = $conn->prepare("UPDATE PLEDGE SET status = ? WHERE pid = ?");
            $confirmstatus = "confirmed";
            $updatepl->bind_param("ss", $confirmstatus, $pid);
            $updatepl->execute();
        }

        

        $now = new DateTime(null, new DateTimeZone('America/New_York'));
        $nowb = $now->format('Y-m-d H:i:s'); 
        $ltype = "transaction";
        $newlog = $conn->prepare("
                INSERT USERLOG SET loginname = ?, ltype = ?, targetid = ?, ltime = ?
                ");
        $newlog->bind_param("ssss",$loginname,$ltype,$pid,$nowb);
        $newlog->execute();

        header("Location:transactionlist.php");
        exit;
    }    


?>


<?php 

include_once "footer.php";

?>