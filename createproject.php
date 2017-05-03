<?php 
	//Create new project
	
	include_once "header.php";

    $loginname = $_SESSION["loginname"];

?>

 <!-- Page Content -->
 	<h1> Current User: <?php   echo "$loginname"; ?></h1>
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

        <div class="col-md-6 center-block"> 
        	<div class=" center-block">
	 			<form role="form" id="project" method="post" action="updatepro.php" enctype="multipart/form-data">
		            
		            <label>Project Name:</label>
		            <input name="pname" id="pname" type="text" class="form-control" placeholder="Project Name" aria-describedby="basic-addon1" onKeyUp="chInput('pname')" onKeyDown="chInput('pname')">
		            <br />
		            <label>Project Description:</label> 
		            <textarea name="pdesc" id="pdesc" class="form-control" placeholder="Project Description" rows="5"></textarea>
		           
		            <input type="hidden" name="size" value="1000000" />
		            <label>Select Post Image:</label>
		            <input id="post" type="file" name="post"/> 
		            
		            <div>
		            <label>Minimum Amount $ </label>
		            <input  name="min" id="min" type="number" placeholder="0.00" required name="price" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
		this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'" onKeyUp="chInput('min')" onKeyDown="chInput('min')">
		            </div>
		            <div>
		            <label>Maximum Amount $</label>
		            <input name="max" id="max" type="number" placeholder="0.00" required name="price" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onblur="
		this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'" onKeyUp="chInput('max')" onKeyDown="chInput('max')">
					</div>
		            
		            <label>End Campaign Date</label>
		            <div class="input-group date">
		            <input name="end" id="end" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th" onKeyUp="chInput('end')" onKeyDown="chInput('end')"></i></span>
			        </div>

			    
			        <label>Estimated Project End Date</label> 
			        <div class="input-group date">
			            <input name="edate" id="edate" type="text" class="form-control" onKeyUp="chInput('edate')" onKeyDown="chInput('edate')"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
			        </div>

				    <!--<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
					<!-- Include Date Range Picker -->
					<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
					<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

				    <script>
				    $('#end').datepicker({
						format: 'yyyy/mm/dd',
						todayHighlight: true,
						autoclose: true,
					    
				    });
				    
				    $('#edate').datepicker({
					    format: 'yyyy/mm/dd',
						todayHighlight: true,
						autoclose: true,
					    
				    });
				    </script>

				    <fieldset>
				        <legend>Make Post</legend>
				        <p class="container">
				          <textarea class="input-block-level" id="summernote" name="content" rows="18">
				          </textarea>
				        </p>
				    </fieldset>
					<script type="text/javascript">
						$(document).ready(function() {
						  $('#summernote').summernote({
						    height: "500px"
						  });
						});
					    var postForm = function() {
						  var content = $('textarea[name="content"]').html($('#summernote').code());
						}
                    </script>
		             <div class="form-group col-md-12">
						<!-- Tags Selected -->
						<h4>Please tag your project</h4>
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

		            <div class="form-group"> <!-- Submit button -->
		            <button class="btn btn-primary " name="submit" type="submit">Submit</button>
		            </div>

	    </form>
     </div>
     </div>


<?php 

include_once "footer.php";

?>
