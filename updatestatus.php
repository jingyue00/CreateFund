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
    
	$owner = $_SESSION['loginname'];
	$projectid = $_POST["projectid"];
	$projstatus = $_POST["projstatus"];
	date_default_timezone_set("America/New_York");
	$time = date("Y-m-d h:i:sa");
		
	echo $projstatus;
	echo $owner;
	echo $projectid;
	echo $time;
	$updatepur = $conn->prepare("UPDATE PROJECT Set status=?, ctime=? WHERE owner=? and pid =?");        
	$updatepur->bind_param("ssss", $projstatus, $time, $owner, $projectid);
	$updatepur->execute();
	$updaterowu = mysqli_fetch_array($updatepur->get_result(),MYSQLI_BOTH);
	
	if (!$updaterowu )
	{
		header("Location:mypage.php");
		exit;
	}
?>
