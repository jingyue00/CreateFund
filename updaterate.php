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
    
	$loginname = $_SESSION['loginname'];
	$pid = $_POST["projectid"];
	$rate = $_POST["rate"];
		
	$updatepur = $conn->prepare("UPDATE PLEDGE Set rate=? WHERE loginname= ? and pid = ?");        
	$updatepur->bind_param("sss", $rate, $loginname, $pid);
	$updatepur->execute();
	$updaterowu = mysqli_fetch_array($updatepur->get_result(),MYSQLI_BOTH);
	
	if (!$updaterowu )
	{
		header("Location:mypage.php");
		exit;
	}
?>
