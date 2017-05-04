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
    $credcn = $_POST["credcn"];
	$loginname = $_SESSION['loginname'];
	$edate = $_POST["edate"];
	$credname = $_POST["credname"];
	
	$usr = $conn->prepare("select * from CCN where loginname= ?");
	$usr->bind_param("s", $loginname);
	$usr->execute();
	$prow = mysqli_fetch_array($usr->get_result(), MYSQLI_BOTH);
	
	if ($prow) {
		$updatepur = $conn->prepare("INSERT CCN Set ccn=?, loginname=?, edate=?, cname=?");        
		$updatepur->bind_param("ssss", $credcn, $loginname, $edate, $credname);
		$updatepur->execute();
		$updaterowu = mysqli_fetch_array($updatepur->get_result(),MYSQLI_BOTH);
	}

	if (!$updaterowu )
	{
		header("Location:mypage.php");
		exit;
	}
?>
