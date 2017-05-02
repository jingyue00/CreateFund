<html>
	<head>
		<title>User SignUp</title>
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
				<h2>User SignUp</h2>
			</div>

			<div class="panel-body">
				<form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="savenewusr.php">
					<div class="form-group col-md-12">
						<!-- Username input -->
						<div class="input-group col-md-offset-1">
							<span class="input-group-addon"></span> 
							<input class="form-control" name="name" id="name"
								type="text" placeholder="Enter User Name" onKeyUp="chInput('name')" onKeyDown="chInput('name')">
						</div>
					</div>
					
					<div class="form-group col-md-12">
						<!-- Login Name input -->
						<div class="input-group col-md-offset-1">
							<span class="input-group-addon"></span> 
							<input class="form-control" name="loginname" id="loginname"
								type="text" placeholder="Enter Login Name" onKeyUp="chInput('loginname')" onKeyDown="chInput('loginname')">
						</div>
					</div>
					
					<div class="form-group col-md-12">
						<!-- Password input -->
						<div class="input-group col-md-offset-1">
							<span class="input-group-addon"></span> 
							<input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" >
						</div>
					</div>
					
					<div class="form-group col-md-12">
						<!-- Home town input -->
						<div class="input-group col-md-offset-1">
							<span class="input-group-addon"></span> 
							<input class="form-control" name="hometown" id="hometown"
								type="text" placeholder="Enter Home Town" onKeyUp="chInput('hometown')" onKeyDown="chInput('hometown')">
						</div>
					</div>

					<!-- user post -->
					<div class="form-group col-md-12">
						<!-- User Post input -->
						<h4>Please select your post</h4>
						<div class="input-group col-md-offset-1 pull-left">
							<input type="hidden" name="size" value="1000000" />
				            <input id="post" type="file" name="post"/> 
						</div>
					</div>
					
					<div class="form-group col-md-12">
						<!-- Tags Selected -->
						<h4>Please select your interests</h4>
						<div class="input-group col-md-offset-1">					
							<input type="checkbox" name="tag[]" value="jazz">Jazz
							<input type="checkbox" name="tag[]" value="blue">Blue
							<input type="checkbox" name="tag[]" value="modern">Modern
							<input type="checkbox" name="tag[]" value="art">Art
							<input type="checkbox" name="tag[]" value="beauty">Beauty
							<br /> 
							<input type="checkbox" name="tag[]" value="fashion">Fashion						
							<input type="checkbox" name="tag[]" value="food">Food
							<input type="checkbox" name="tag[]" value="it">IT
							<input type="checkbox" name="tag[]" value="makeup">Make up
							<input type="checkbox" name="tag[]" value="music">Music
							<br /> 
							<input type="checkbox" name="tag[]" value="painting">Painting
							<input type="checkbox" name="tag[]" value="rap">Rap
							<input type="checkbox" name="tag[]" value="social">Social
							<input type="checkbox" name="tag[]" value="tech">Technology
							<input type="checkbox" name="tag[]" value="travel">Travel
						</div>
					</div>
					
					<div class="form-group ">			
						<button type="submit"
							class="btn btn-info col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1">Sign Up</button>
					</div>
				</form>
				<h6 class="text-danger" style="text-align: right">
					Have account Already?<a href="login.php"><i> Log In</i></a>
				</h6>
			</div>
		</div>
	</div>
</body>
</html>