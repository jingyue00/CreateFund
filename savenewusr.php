<?PHP
	session_start();
	
	//connect to database
	require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}

	//get product and customer
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $name = $_POST["name"];
	$loginname = $_POST["loginname"];
	$password = $_POST["password"];
	$md5password = md5($password);
	$hometown = $_POST["hometown"];
	$target_path = "/var/www/html/DbProject/img/";
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
	
	
	$usr = $conn->prepare("select * from USER where loginname= ?");
	$usr->bind_param("s", $loginname);
	$usr->execute();
	$prow = mysqli_fetch_array($usr->get_result(), MYSQLI_BOTH);
	
	if ($prow) {
		echo "<script>window.location.href='signup.php'; alert('Login Name already exist!');</script>";
	}
	else {
		$updatepur = $conn->prepare("INSERT USER Set name=?, loginname=?, password=?, hometown=?, post=?");        
		$updatepur->bind_param("sssss", $name, $loginname, $md5password, $hometown, $post);
		$updatepur->execute();
	}
	$updaterowu = mysqli_fetch_array($updatepur->get_result(),MYSQLI_BOTH);

	//$stmt = $conn->prepare('INSERT INTO TAG_USER(tag, loginname) VALUES(:chk, :loginn)');
	//$stmt->bindParam(':loginn', $loginname);
	//$stmt->bindParam(':chk', $chk1);
	//foreach($_GET["tag"] as $chk1) $stmt->execute();
	//foreach($_GET["tag"] as $chk1) {
		//$chk .= $chk1.",";
		//$query = "INSERT INTO TAG_USER(tag, loginname) VALUES('$chk1', '$loginname')";
		//$result = mysqli_query($query, $conn);
	//}
	//$in_ch=mysqli_query($conn,"insert into TAG_USER(loginname, tag) values ('$loginname','$chk')");  
	//if($in_ch==1)  
	//{  
    //  echo'<script>alert("Inserted Successfully")</script>';  
	//}  
	//else  
	//{  
    //  echo'<script>alert("Failed To Insert")</script>';  
	//}  
   
  
	//echo $chk;
	$updatetag = $conn->prepare("INSERT TAG_USER Set loginname=?, tag=?");        
	$updatetag->bind_param("ss", $loginname, $chk);
	//$updatetag->execute();

	//save USER_TAG
	if( isset( $_GET["tag"] )) {

        $updatetag = $conn->prepare("INSERT TAG_USER Set loginname=?, tag=?");        

        foreach($_GET["tag"] as $chk) { 
            $updatetag->bind_param("ss", $loginname, $chk);
            $updatetag->execute();
            //echo "total tag: ".$updatetag->affected_rows;
        }
    }


	//foreach($_POST["tag"] as $chk) $updatetag->execute();
	//$updaterowt = mysqli_fetch_array($updatetag->get_result(),MYSQLI_BOTH);

	
	if (!$updaterowu )
	{
		header("Location:login.php");
		exit;
	}
?>
