<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Customers Product</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/customer.css">
	<script>
		function update(pname,cname){
			document.querySelector("#product").value = pname;
			document.querySelector("#customer").value = cname;
			document.getElementById("getpname").submit();
		}
	</script>
</head>
<body>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" >Customers Product</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="start.php"><span class="glyphicon glyphicon-log-in"></span> Back to search page</a></li>
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

	<?PHP
		//get cname 
		session_start();
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $cname = $_SESSION["cname"];
		$keyword = $_SESSION["keyword"];
		require "class.connect.php";
        $connect = new connect();
        $conn = $connect->getConnect("marketplace");
        if(!$conn) { echo "failed to connect!";}
	?>
	<button type="button" class='nav navbar-nav  btn-info  col-md-20'><a href = "cusorder.php?cname=<?php $cname//?>">Customer: <?php echo "$cname"; ?> View Orders</a></button>
	<?php			
		echo"
				<div class=\"panel panel-default\">				             						
                <table class='table table-hover'> 
					<thead>
						<tr>
						<th>Product Name</th>
						<th>Product Description</th>
						<th>Product Price</th>
						<th>Product Status</th>
						<th>shopping cart</th>
						</tr>
                </thead> 			
            ";
		
		//if keyword is null, display all products
        if($keyword == "")
        {
            $products = $conn->prepare("select * from product");
            $products -> execute();      
            $result = $products->get_result();
            if ($result){
                while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
                    $pname   = $row['pname'];
                    $pdesc = $row['pdescription'];
                    $pprice = $row['pprice'];
                    $pstatus = $row['pstatus'];
                    echo "<tr><td>".$pname."</td><td>".$pdesc."</td><td>".$pprice."</td><td>".$pstatus."</td>";
					if ($row[3] == 'available') {
						echo "<td><button type=\"button\" class = \"buttong btn-sm\" onClick=\"update('$row[0]','$cname')\" data-target=\"#myModal\">Buy</button></td></tr>";
					} else {
						echo "<td></td></tr>";
					}						
                }
            }
            echo"</tbody></table>";
			if(isset($_POST['sAcc']) && intval($_POST['sAcc'])){
				$sql = "Insert Into purchase (cname,pname,putime, quantity, puprice, status) Values
					($cnane, $pname, date('Y/m/d'),1,pprice,pstatus)";
			} 
        }
		else {
			$query = "select * from product where "."pdescription".' regexp "'.$keyword.'";';
            $result = $conn->query($query);
				    
			if ($result){	
				while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
					$pname   = $row['pname'];
					$pdesc = $row['pdescription'];
					$pprice = $row['pprice'];
					$pstatus = $row['pstatus'];
					echo "<tr><td>".$pname."</td><td>".$pdesc."</td><td>".$pprice."</td><td>".$pstatus."</td>";
					if ($row[3] == 'available') {
						echo "<td><button type=\"button\" class = \"buttong btn-sm\" onClick=\"update('$row[0]','$cname')\" data-target=\"#myModal\">Buy</button></td></tr>";
					} else {
						echo "<td></td></tr>";
					}					
				}
				echo"</tbody></table>";
			}
		}
	?>
	<form role = "form" id = "getpname" method = "get" action = "update.php">
		<input type = "hidden" id = "product" name = "product" >;
		<input type = "hidden" id = "customer" name = "customer" >;
	</form>
	<script src="app.js"></script>
</body>
</html>