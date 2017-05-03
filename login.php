<?php
	session_start();
?>
<html>
	<head>
		<title>User Login</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
		<script src="plugins/jquery/js/jquery.min.js"></script>
		<script src="plugins/bootstrap/js/bootstrap.js"></script>
		<script src="plugins/angular/angular.min.js"></script>
		<link rel="stylesheet" href="css/login.css">
	</head>

	<body>
	<div class="jumbotron vertical-center container-fluid text-center">
		<div class=" panel panel-default panel-style">
			<div class="panel-heading  text-center">
				<h2>User Login</h2>
			</div>

			<div class="panel-body">
				<form class="form-horizontal" role="form" method="post" action="authorize.php">
					<div class="form-group col-md-12">
						<!-- Username input -->
						<div class="input-group col-md-offset-1">
							<span class="input-group-addon"> 
								<i class="glyphicon glyphicon-user"></i>
							</span> 
							<input class="form-control" name="loginname" id="loginname"
								type="text" placeholder="Enter Login Name" >
						</div>
					</div>
					
					<div class="form-group col-md-12">
						<!-- Password input -->
						<div class="input-group col-md-offset-1">
							<span class="input-group-addon">
								<i class="glyphicon glyphicon-lock"></i>
							</span> 
							<input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" >
						</div>
					</div>

					<div class="form-group col-md-12">
						<!-- captcha input -->
						<div class="input-group col-md-offset-1">
							<span class="input-group-addon">
								<!-- <i class="glyphicon glyphicon-lock"></i> -->
								<img src="create_code.php">
							</span> 

							<input type="text" style="height: 50px" class="form-control" id="code" name="code" placeholder="Enter captcha" >
						</div>
					</div>

					<div class="form-group ">			
						<button type="submit"
							class="btn btn-info col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1">Submit</button>
					</div>
				</form>
				<h6 class="text-danger" style="text-align: right">
					No account?<a href="signup.php"><i> Sign up</i></a>
				</h6>
			</div>
		</div>
	</div>
</body>
</html>