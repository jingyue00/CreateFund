<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Customers Order</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/customer.css">
</head>
<body>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" >Customers Order</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="CusProduct.php"><span class="glyphicon glyphicon-log-in"></span> Back to Customer Product Page</a></li>
				</ul>
			</div>
		</div>
	</nav>
    <script src="plugins/jquery/js/jquery.min.js"></script>
	<script src="plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="plugins/angular/angular.min.js"></script>
    <script src="js/app.js" type="text/javascript"></script>
	<script src="js/customerController.js" type="text/javascript"></script>
	<script src="js/service.js" type="text/javascript"></script>
	
	<?php
		//get cname 
		session_start();
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $cname = $_SESSION["cname"];
       //connect to database
		require "class.connect.php";
        $connect = new connect();
        $conn = $connect->getConnect("marketplace");
        if(!$conn) { echo "failed to connect!";}
		echo"
				<div class=\"panel panel-default\">			 
                <table class='table table-hover'> 
					<thead>
						<tr>
						<th>Customer Name </th>
						<th>Product Name</th>
						<th>Purchase Time</th>
						<th>Quantity</th>
						<th>Purchase Time</th>
						<th>Status</th>
						</tr>
                </thead> 
        ";		     
		$query = "select * from purchase where "."cname".' regexp "'.$cname.'";';
        $result = $conn->query($query);
		if ($result){	
			while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
				$cname   = $row['cname'];
				$pname = $row['pname'];
				$putime = $row['putime'];
				$quantity = $row['quantity'];
				$puprice = $row['puprice'];
				$status = $row['status'];
				echo "<tr><td>".$cname."</td><td>".$pname."</td><td>".$putime."</td><td>".$quantity."</td><td>".$puprice."</td><td>".$status."</td></tr>";
			}
			echo"</tbody></table>";
		}
	?>
</body>
</html>