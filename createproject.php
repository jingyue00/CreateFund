<?php 

include_once "header.php";

require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
		
	//get cname and keyword
	session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $loginname = $_SESSION["loginname"];

?>

 <!-- Page Content -->
 	<h1> <?php   echo "$loginname"; ?></h1>
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Create Your Project
                    <small>make dream come true</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Projects Row -->
        <div class="row">  
        	 <div class="col-md-3">


            </div>

        <div class="col-md-9 center-block"> 
        	<div class="thumbnail center-block">
	 			<form role="form" id="project" method="post" action="updatepro.php" enctype="multipart/form-data">
		            
		            <label>Project Name:</label>
		            <input name="pname" id="pname" type="text" class="form-control" placeholder="Project Name" aria-describedby="basic-addon1">
		            <br />
		            <label>Project Description:</label> 
		            <textarea name="pdesc" id="pdesc" class="form-control" placeholder="Project Description" rows="5" id="comment"></textarea>
		            <br />
		            <input type="hidden" name="size" value="1000000" />
		            <label>Select Post Image:</label>
		            <input id="post" type="file" name="post"/> 
		            <br />
		            <div>
		            <label>Minimum Amount $ </label> <br/>
		            <input  name="min" id="min" type="number" placeholder="0.00" required name="price" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
		this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'">
		            </div>
		            <div>
		            <label>Maximum Amount $</label> <br/>
		            <input name="max" id="max" type="number" placeholder="0.00" required name="price" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
		this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'">
					</div>
		            <br />
		            <label>End Campaign Date</label> <br/>
		            <div class="input-group date">
		            <input name="end" id="end" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
			        </div>

			        <br />
			        <label>Estimated Project End Date</label> <br/>
			        <div class="input-group date">
			            <input name="edate" id="edate" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
			        </div>

				    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
				    <link href="css/bootstrap.min.css" rel="stylesheet">
				    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
				    <script>
				    $('.input-group.date').datepicker({
					    format: "yyyy/mm/dd",
					    startDate: "2017-04-01",
					    endDate: "2020-01-01",
					    todayBtn: "linked",
					    autoclose: true,
					    todayHighlight: true
					    
				    });
				    </script>


		            <div class="bootstrap-iso" id="summernote"><p>Hello Summernote</p></div>

		            <div class="form-group"> <!-- Submit button -->
		            <button class="btn btn-primary " name="submit" type="submit">Submit</button>
		          </div>

		          <!--  summernote --> 
		            <script>
		            $(document).ready(function() {
		                $('#summernote').summernote();
		            });
		          </script>	  


	    </form>
     </div>
     </div>


<?php 

include_once "footer.php";

?>
