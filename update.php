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
    $pname = $_GET["product"];
	$cname = $_GET["customer"];
	$putime = date('Y/m/d h:i:s');
	$pending = 'pending';	
	
	$pro = $conn->prepare("select * from product where pname= ?");
	$pro->bind_param("s",$pname);
	$pro->execute();
	$row = mysqli_fetch_array($pro->get_result(),MYSQLI_BOTH);
	$pprice = $row['pprice'];
	
	$pur = $conn->prepare("select * from purchase where cname = ? and pname = ? and status= ?");
	$pur->bind_param("sss", $cname, $pname, $pending);
	$pur->execute();
	$prow = mysqli_fetch_array($pur->get_result(), MYSQLI_BOTH);
	
	if ($prow) {
		$status = $prow['status'];
		$quantity = $prow['quantity'] + 1;
		$puprice = $prow['puprice'] + $pprice;
		$updatepur = $conn->prepare("UPDATE purchase SET quantity = ?, putime = ?, puprice = ? WHERE cname= ? and pname = ? and status = ?");
		$updatepur->bind_param("isssss", $quantity, $putime, $puprice, $cname, $pname, $pending);
		$updatepur->execute();
	}
	else {
		$status = $prow['status'];
		$updatepur = $conn->prepare("INSERT purchase Set cname=?, pname=?, putime=?, quantity=?, puprice=?, status=?");        
		$quantity = "1";
		$updatepur->bind_param("ssssss", $cname, $pname, $putime, $quantity, $pprice, $pending);
		$updatepur->execute();
	}
	$updaterow = mysqli_fetch_array($updatepur->get_result(),MYSQLI_BOTH);
	if (!$updaterow)
	{
		header("Location:CusOrder.php");
		exit;
	}
?>
