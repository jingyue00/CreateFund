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
    $name = $_GET["name"];
	$loginname = $_GET["loginname"];
	$password = $_GET["password"];
	$md5password = md5($password);
	$hometown = $_GET["hometown"];	
	
	
	$usr = $conn->prepare("select * from USER where loginname= ?");
	$usr->bind_param("s", $loginname);
	$usr->execute();
	$prow = mysqli_fetch_array($usr->get_result(), MYSQLI_BOTH);
	
	if ($prow) {
		echo "<script>window.location.href='signup.php'; alert('Login Name already exist!');</script>";
	}
	else {
		$updatepur = $conn->prepare("INSERT USER Set name=?, loginname=?, password=?, hometown=?");        
		$updatepur->bind_param("ssss", $name, $loginname, $md5password, $hometown);
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
	foreach($_GET["tag"] as $chk) $updatetag->execute();
	$updaterowt = mysqli_fetch_array($updatetag->get_result(),MYSQLI_BOTH);
	
	if (!$updaterowu )
	{
		header("Location:login.php");
		exit;
	}
?>
