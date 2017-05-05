<?php 
	//mypage 
	include_once "header.php";
	
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
        
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    //get user post
		
    $getupost = $conn-> prepare("SELECT name,loginname,password,hometown,post FROM USER WHERE loginname = ? ");
    $getupost->bind_param("s",$_SESSION["loginname"]);
    $getupost->execute();
    $resultu = $getupost->get_result();
    if($resultu){
        $rowu = mysqli_fetch_array($resultu,MYSQLI_BOTH); 
        $upost = $rowu['post'];
        $name = $rowu['name'];
        $loginname = $rowu['loginname'];
        $hometown = $rowu['hometown'];
		$password = $rowu['password'];
    }
    
	$getpledge = $conn-> prepare("SELECT * FROM PLEDGE WHERE loginname = ? ORDER BY createtime DESC "); 
    $getpledge->bind_param("s",$loginname); 
    $getpledge->execute();
    $pledge = $getpledge->get_result();
	
	$getcredcn = $conn-> prepare("SELECT * FROM CCN WHERE loginname = ? ORDER BY edate DESC "); 
    $getcredcn->bind_param("s",$loginname); 
    $getcredcn->execute();
    $credcn = $getcredcn->get_result();
		
    if(isset($loginname)){
	
		//get project create list
        $getcreatep = $conn-> prepare("SELECT * FROM PROJECT WHERE owner = ? ORDER BY endcampaign DESC");
        $getcreatep->bind_param("s",$loginname);
        $getcreatep->execute();
        $peocreate = $getcreatep->get_result();
		
		//get pledged project list
        $getproject1 = $conn-> prepare("SELECT pid FROM PLEDGE WHERE loginname = ? ORDER BY updatetime DESC");
        $getproject1->bind_param("s",$loginname);
        $getproject1->execute();
        $projectlist1 = $getproject1->get_result();
		
		//get liked project list
        $getproject2 = $conn-> prepare("SELECT pid FROM LIKERELATION WHERE loginname = ? ORDER BY updatetime DESC");
        $getproject2->bind_param("s",$loginname);
        $getproject2->execute();
        $projectlist2 = $getproject2->get_result();

        //get followed people list
        $getpeople = $conn-> prepare("SELECT following FROM FOLLOW WHERE loginname = ? ORDER BY updatetime DESC");
        $getpeople->bind_param("s",$loginname);
        $getpeople->execute();
        $peopleresult = $getpeople->get_result();
        
    }else{
        
    }

?>
<script type="text/javascript">
function unfollow(followto)
        {
            document.querySelector("#unfollowing").value = followto;
            document.querySelector("#unloginname").value = "<?php echo $loginname?>";
            document.getElementById("unfollow").submit();
        }
function peopledetail(ploginname)
        {
            document.querySelector("#ploginname").value = ploginname;
            document.getElementById("peopledetail").submit();
        }
function tagproject(tag)
        {
            document.querySelector("#htag").value = tag;
            document.getElementById("tag").submit();
        }
</script>


<body> 
	<link href="css/half-slider.css" rel="stylesheet"> 
	<div class="col-lg-12">		
		<!-- Trigger the modal with a button -->
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">My profile</button>
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#mypledgeModal">Pledge History</button>
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#mycardModal">Credit Card Information</button>
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#mynewcardModal">Add New Credit Card</button>
		<button type="button" class="btn btn-info btn-lg"><a href="createproject.php">Create New Project</a></button>
		
		<?php	echo"My Tags:";
                                $gettag = $conn-> prepare("SELECT tag FROM TAG_USER 
                                        WHERE loginname = ? ");
                                $gettag->bind_param("s",$loginname);
                                $gettag->execute();
                                $tresult = $gettag->get_result();
                                $tcount = mysqli_num_rows($tresult);
                                if($tresult){
                                    while ($row = mysqli_fetch_array($tresult, MYSQLI_BOTH)) {
                                         $rows[] = $row;
                                    }
                                }
                                if($tcount > 0){
                                    foreach($rows as $row)
                                    {
                                        $a = stripslashes($row['tag']);
                                        echo "<button type=\"button\" class=\"btn btn-default btn-xs btn-success\" onClick=\"tagproject('$a')\">".$a."</button>
                                              <a> </a>
                                        ";
                                    }
                                }

                                ?>
		
		<!-- My Profile Modal -->			
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"> Edit My Profile </h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="mypedituser.php">
							<div class="form-group col-md-12">
								<!-- Login Name input -->
								<div class="input-group col-md-offset-1">
									<span class="input-group-addon"></span> 
										<input class="form-control" name="loginname" id="loginname" disabled value = "<?php echo $loginname;?>"
											type="text" placeholder="Enter Login Name" onKeyUp="chInput('loginname')" onKeyDown="chInput('loginname')">
								</div>
							</div>
							<div class="form-group col-md-12">
								<!-- Username input -->
								<div class="input-group col-md-offset-1">
									<span class="input-group-addon"></span> 
										<input class="form-control" name="usrname" id="usrname" value = "<?php echo $name;?>"
											type="text" placeholder="Enter User Name" onKeyUp="chInput('usrname')" onKeyDown="chInput('usrname')">
								</div>
							</div>			
							<div class="form-group col-md-12">
								<!-- Password input -->
								<div class="input-group col-md-offset-1">
									<span class="input-group-addon"></span> 
										<input type="password" class="form-control" id="password" name="password" placeholder="Enter new Password">
								</div>
							</div>
					
							<div class="form-group col-md-12">
								<!-- Home town input -->
								<div class="input-group col-md-offset-1">
									<span class="input-group-addon"></span> 
										<input class="form-control" name="hometown" id="hometown" value = " <?php echo $hometown;?>"
											type="text" placeholder="Enter Home Town" onKeyUp="chInput('hometown')" onKeyDown="chInput('hometown')">
								</div>
							</div>

							<!-- user post -->
							<div class="form-group col-md-12">
								<!-- User Post input -->
								<h4>Please select your new post, now your post is <?php echo "$upost";?></h4>
								<div class="input-group col-md-offset-1 pull-left">
									<input type="hidden" name="size" value="1000000" />
									<input id="post" type="file" name="post"/> 
								</div>
							</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-default ">Edit My Profile</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>					
				</form>		
				</div>
			</div>
		</div>
		
		<!-- Pledge History Modal -->
		<div id="mypledgeModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"> My Pledge History </h4>
					</div>
					<div class="modal-body">
						<div class="container">
						<form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="updaterate.php">
							<!-- Page Header -->
							<div class="row">
								<div class="col-md-6 center-block"> 
									<h1 class="page-header">My Pledge History
										<small>Detail Information</small>
									</h1>
								</div>
							</div>
							<div class="row">
								<div class="row">  
									<div class="col-md-6 center-block"> 
										<table class="table table-striped table-hover ">
											<thead>
												<tr class="info">
													<th>Project</th><th>Amount</th><th>Project Status</th><th>Pledge Status</th><th>Rate</th>
												</tr>
											</thead>
											<tbody>
												
												<?php							
													if($pledge){
														while($row = mysqli_fetch_array($pledge, MYSQLI_BOTH)){
															$plid = $row['plid'];
															$amount = $row['totalamount'];
															$pledgestatus = $row['status'];
															$rate = $row['rate'];
															$projectid = $row['pid'];

															$getpname = $conn->prepare("SELECT pname FROM
																PLEDGE a, PROJECT b
																WHERE a.pid = b.pid
																AND plid = ?");
															$getpname->bind_param("s",$plid);
															$getpname->execute();
															$presult= $getpname->get_result();
															if($presult){
																$rowp= mysqli_fetch_array($presult,MYSQLI_BOTH);    
																$pname = $rowp['pname'];
															}
															$getstatus = $conn->prepare("SELECT p.status FROM
																PROJECT p, PLEDGE pl
																WHERE p.pid = pl.pid AND plid = ?
															");
															$getstatus -> bind_param("s",$plid);
															$getstatus ->execute();
															$prestat = $getstatus->get_result();
															if($prestat){
																$rows= mysqli_fetch_array($prestat,MYSQLI_BOTH);    
																$status = $rows['status'];
															}
															
															if ($status == "Completed" and $rate == NULL){
															echo"
															<input name='projectid' id='projectid' value = $projectid type = 'hidden'>
															<tr>
															  <td>".$pname."</td>
															  <td>$".$amount."</td>
															  <td>".$status."</td>
															  <td>".$projectstatus."</td>
															  <td> 
																
															    <select id='rate' name ='rate' >
																<option>1</option>
																<option>2</option>
																<option>3</option>
																<option>4</option>
																<option>5</option>
																</select>	
															   </td>
															  
															</tr>";
															}
															else {
																echo "
																 <tr>
																  <td>".$pname."</td>
																  <td>$".$amount."</td>
																  <td>".$status."</td>
																  <td>".$projectstatus."</td>
																  <td>".$rate."</td>
																</tr>
																";
															}
														}
													}
												?>
											</tbody>
										</table>   
									</div>
								</div>
							</div>								
						</div>
					</div>	
					<div class='modal-footer'>	
						<?php
						if ($status == "Completed" and $rate == NULL){
							echo "<button type='submit' class='btn btn-default '>Submit</button>";
						}?>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
					</div>
					</form>
				</div>
			</div>
		</div>
		
		<!-- Add New Credit Card Modal -->			
		<div id="mynewcardModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"> Add New Credit Card </h4>
					</div>
					<form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="mynewcredit.php">
						<div class="modal-body">
							<div class="form-group col-md-12">
								<!-- Credit Card Number input -->
								<div class="input-group col-md-offset-1">
									<span class="input-group-addon"></span> 
										<input class="form-control" name="credcn" id="credcn" type="text" placeholder="Enter Credit Card Number" onKeyUp="chInput('credcn')" onKeyDown="chInput('credcn')">
								</div>
							</div>
							<div class="form-group col-md-12">
								<!-- Expiration Date input -->
								<div class="input-group col-md-offset-1">
									<span class="input-group-addon"></span> 
										<div class="input-group date">
											<input name="edate" id="edate" type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th" onKeyUp="chInput('edate')" onKeyDown="chInput('edate')"></i></span>
										</div>
								</div>
							</div>		
							<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
							<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
							<script>
								$('#edate').datepicker({
									format: 'yyyy/mm/dd',
									todayHighlight: true,
									autoclose: true,
									
								});
							</script>
							<div class="form-group col-md-12">
								<!-- Password input -->
								<div class="input-group col-md-offset-1">						
									<label for="credname">Choose Your Card Type:</label>
									<select class="form-control" id="credname" name ="credname" >
										<option></option>
										<option>Visa</option>
										<option>Master</option>
									  </select>								  					
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit"
							class="btn btn-default">Submit</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>					
					</form>		
				</div>
			</div>
		</div>
		
		<!-- Credit Card Information -->
		<div id="mycardModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"> Credit Card Information </h4>
					</div>
					<div class="modal-body">
						<div class="container">
							<!-- Page Header -->
							<div class="row">
								<div class="col-md-6 center-block"> 
									<h1 class="page-header">My Credit Card
										<small>Detail Information</small>
									</h1>
								</div>
							</div>
							<div class="row">
								<div class="row">  
									<div class="col-md-6 center-block"> 
										<table class="table table-striped table-hover ">
											<thead>
												<tr class="info">
													<th>Card Name</th><th>Card Number</th><th>Expatriation date</th>
												</tr>
											</thead>
											<tbody>
												<?php
													if($credcn){
														while($row = mysqli_fetch_array($credcn, MYSQLI_BOTH)){
															$cname = $row['cname'];
															$ccn = $row['ccn'];
															$b = stripslashes($row['edate']);
															$phpdate = strtotime( $b );
															$mysqldate = date( 'Y-m-d', $phpdate );
															echo "
															 <tr>
															  <td>".$cname."</td>
															  <td>".$ccn."</td>
															  <td>" .$mysqldate."</td>
															</tr>
															"; 
														}
													}
												?>
											</tbody>
										</table>   
									</div>
								</div>
							</div>								
						</div>
					</div>												
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>					
				</div>
			</div>
		</div>
		
		
	
	</div>
	
    <!-- Page Content -->
    <div class="container">
    	<!-- Team Members Row -->
		<div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Project you Created</h1>
            </div>
        </div> 
		<?php
			if($peocreate) 
			{	
				if (mysqli_num_rows($peocreate)== 0){
						echo " 
							<p>No Created Project Yet!</p>;
							<img src='img/pu.gif'/>
							";
				} 
				else {
					$i = 0;
					while($row = mysqli_fetch_array($peocreate, MYSQLI_BOTH)){	
						$pid = $row['pid'];
						$pname = $row['pname'];?>
								<div id="statusModal<?php echo $row['pname'];?><?php echo $row['pid'];?>" class="modal fade" role="dialog">
										<div class="modal-dialog">
											<!-- Modal content-->
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">  <?php echo $pname?>
												</div>
												<form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="updatestatus.php">
													<div class="modal-body">
														<div class="form-group col-md-12">
															<!-- Password input -->
															<div class="input-group col-md-offset-1">	
																<input name='projectid' id='projectid' value = <?php echo $row['pid'];?> type = 'hidden'>
																<label for="credname">Choose My Project status:</label>
																<select class="form-control" id="projstatus" name ="projstatus" >
																	<option>Completed</option>
																	<option>Failed</option>
																  </select>								  					
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="submit"
														class="btn btn-default">Submit</button>
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													</div>					
												</form>		
											</div>
										</div>
									</div>
								
						<?php
						$post = $row['post'];
						$min = $row['min'];
                        $status = $row['status'];
						$currentamt = $row['currentamt'];
						$endcampaign = $row['endcampaign'];
						$endcampaignformat = new DateTime($endcampaign, new DateTimeZone('America/New_York'));
						$endcampaignformat = $endcampaignformat->format('Y-m-d');  
						$pdesc = $row['pdesc'];
						$getrichtext = $conn->prepare("SELECT content FROM RICH_CONTENT WHERE rid = ?");
						$getrichtext->bind_param("s",$pdesc);
						$getrichtext->execute();
						$resultc = $getrichtext->get_result();
						if($resultc){
							$rowc= mysqli_fetch_array($resultc,MYSQLI_BOTH);    
							$rtc = $rowc['content'];
							$rtc = substr($rtc, 0, 90);
						}
						//three projects each row
						if($i%3 == 0){
							echo "<div class='row'>";
						}
						echo 
						//<button type='button' style='width: 100px;' class='pull-right' onClick='updateproject(".$pid.")'>change status</button>
						"
							<div class='col-md-4 portfolio-item' style='padding-bottom: 20px;'>
							<a href='detailproject.php?pid=".$pid."'>
							<img class='img-responsive' src='img/".$post."' alt='' width='380' height='142'>
							</a>
							<h3>
								<a href='detailproject.php?pid=".$pid."'>".$pname."</a>
							</h3>
							<div>
							<a class='pull-right'>$".$currentamt." raised, $".$min." goal </a>
							<span class='glyphicon glyphicon-time'></span><a> ".$endcampaignformat."</a><br/>
							</div>
							<p class='text-info'>".$rtc."</p>
                            <div>";
								if ($status == 'PledgeClosed' or $status == 'Delay'){ ?>
									<button type='button' class='btn  btn-sm pull-right' data-toggle='modal' data-target='#statusModal<?php echo $row['pname'];?><?php echo $row['pid'];?>' >Change Status</button>
									
									
								<?php	
								}
								else {
									echo "<button type='button' class='btn  btn-sm pull-right' disabled >Change Status</button>";
								}
								echo"<a >".$status."</a>
                            </div>
                            </div>
							
                            ";
						
						//end of row
						if($i%3 == 2){
							echo "</div><hr>";
						}
						$i++;
					}
				}									
			} 
		?>
		
		<div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Project you pledge
                    <small></small>
                </h1>
            </div>
        </div> 
		<?php		
			if($projectlist1) 
			{		
				if (mysqli_num_rows($projectlist1) == 0){
					echo "
						<p>No Pledged Project Yet!</p>;
						<img src='img/pu.gif'/>
						";
				}
				else{
					$i = 0;
					while($row = mysqli_fetch_array($projectlist1, MYSQLI_BOTH)){
						$getpname = $conn-> prepare("SELECT * FROM PROJECT WHERE pid = ?");
						$getpname->bind_param("s",$row['pid']);
						$getpname->execute();
						$presult = $getpname->get_result();
						$prrow = mysqli_fetch_array($presult, MYSQLI_BOTH);
						$pid = $prrow['pid'];
						$pname = $prrow['pname'];
						$post = $prrow['post'];
						$min = $prrow['min'];
						$currentamt = $prrow['currentamt'];
						$endcampaign = $prrow['endcampaign'];
						$endcampaignformat = new DateTime($endcampaign, new DateTimeZone('America/New_York'));
						$endcampaignformat = $endcampaignformat->format('Y-m-d');  
						$pdesc = $prrow['pdesc'];
						$getrichtext = $conn->prepare("SELECT content FROM RICH_CONTENT WHERE rid = ?");
						$getrichtext->bind_param("s",$pdesc);
						$getrichtext->execute();
						$resultc = $getrichtext->get_result();
						if($resultc){
							$rowc= mysqli_fetch_array($resultc,MYSQLI_BOTH);    
							$rtc = $rowc['content'];
							$rtc = substr($rtc, 0, 90);
						}

						//new row
						if($i%3 == 0){
							echo "<div class='row'>";
						}

						echo "
							<div class='col-md-4 portfolio-item'>
							<a href='detailproject.php?pid=".$pid."'>
							<img class='img-responsive' src='img/".$post."' alt='' width='380' height='142'>
							</a>
							<h3>
								<a href='detailproject.php?pid=".$pid."'>".$pname."</a>
							</h3>
							<div>
							<a class='pull-right'>$".$currentamt." raised, $".$min." goal </a>
							<span class='glyphicon glyphicon-time'></span><a> ".$endcampaignformat."</a><br/>
							</div>
							<p class='text-info'>".$rtc."</p>
							</div>
						";
						//end of row
						if($i%3 == 2){
							echo "</div><hr>";
						}
						$i++;	
					}
				}
			} 			
		?>
		
		<div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Project you liked
                    <small></small>
                </h1>
            </div>
        </div>		 
		<?php
			if($projectlist2){			
				if (mysqli_num_rows($projectlist2) == 0){
					echo "
						<p>No Liked Project Yet!</p>;
						<img src='img/pu.gif'/>
						";
				} 
				else {
					$i = 0;
					while($row = mysqli_fetch_array($projectlist2, MYSQLI_BOTH)){				
						$getpname = $conn-> prepare("SELECT * FROM PROJECT WHERE pid = ?");
						$getpname->bind_param("s",$row['pid']);
						$getpname->execute();
						$presult = $getpname->get_result();
						$prrow = mysqli_fetch_array($presult, MYSQLI_BOTH);		
						$pid = $prrow['pid'];
						$pname = $prrow['pname'];
						$post = $prrow['post'];
						$min = $prrow['min'];
						$currentamt = $prrow['currentamt'];
						$endcampaign = $prrow['endcampaign'];
						$endcampaignformat = new DateTime($endcampaign, new DateTimeZone('America/New_York'));
						$endcampaignformat = $endcampaignformat->format('Y-m-d');  
						$pdesc = $prrow['pdesc'];
						$getrichtext = $conn->prepare("SELECT content FROM RICH_CONTENT WHERE rid = ?");
						$getrichtext->bind_param("s",$pdesc);
						$getrichtext->execute();
						$resultc = $getrichtext->get_result();
						if($resultc){
							$rowc= mysqli_fetch_array($resultc,MYSQLI_BOTH);    
							$rtc = $rowc['content'];
							$rtc = substr($rtc, 0, 90);
						}
						//new row
						if($i%3 == 0){
							echo "<div class='row'>";
						}
						echo "
							<div class='col-md-4 portfolio-item'>
							<a href='detailproject.php?pid=".$pid."'>
								<img class='img-responsive' src='img/".$post."' alt='' width='380' height='142'>
							</a>
							<h3>
								<a href='detailproject.php?pid=".$pid."'>".$pname."</a>
							</h3>
							<div>
							<a class='pull-right'>$".$currentamt." raised, $".$min." goal </a>
							<span class='glyphicon glyphicon-time'></span><a> ".$endcampaignformat."</a><br/>
							</div>
							<p class='text-info'>".$rtc."</p>
							</div>
						";

						//end of row
						if($i%3 == 2){
							echo "</div><hr>";
						}
						$i++;	  
					}
				}
            }
		?> 
		 
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">People you followed
                    <small></small>
                </h1>
            </div>
        </div>
        <!-- people list -->
        <?php
		if(isset($peopleresult) AND $peopleresult){
			if (mysqli_num_rows($peopleresult) == 0){
				echo "
					<p>No Liked Project Yet!</p>;
					<img src='img/pu.gif'/>
					";
				} 
			else {
				$i = 0;
				while($row = mysqli_fetch_array($peopleresult, MYSQLI_BOTH)){
					$getfname = $conn-> prepare("SELECT * FROM USER WHERE loginname = ?");
					$getfname->bind_param("s",$row['following']);
					$getfname->execute();
					$fresult = $getfname->get_result();
					$prow = mysqli_fetch_array($fresult, MYSQLI_BOTH);
					if (count($prow) == 0){
						echo "
							<p>No People Followed Yet!</p>;
							<img src='img/pu.gif'/>
							";
					}
					else {
						$ppost = $prow['post'];
						$pname = $prow['name'];
                        $ploginname = $prow['loginname'];
						$phometown = $prow['hometown'];
						
						//new row
						if($i%3 == 0){
							echo "<div class='row'>";
						}
						echo "<div class='col-md-4 text-center'>
						<img class='img-circle' style='width: 65%' height='230' src='img/".$ppost."'>
						<h3>".$pname."
							<small>from ".$phometown."</small>
						</h3>
                        <button type=\"button\" style=\"width: 60px;margin-right:65px;\" class=\"pull-right\" onClick=\"peopledetail('$ploginname')\"> Detail </button>
						<button type=\"button\" style=\" width: 60px;\" name = \"follow\" onClick=\"unfollow('$prow[1]')\"> unfollow </button>
						</div>
						";

						//end of row
						if($i%3 == 2){
							echo "</div><hr>";
						}
						$i++;
					}
				}
            }
		} 

        ?>


            <!-- <div class="col-lg-4 col-sm-6 text-center mb-4">
                <img class="rounded-circle img-fluid d-block mx-auto img-circle" src="http://placehold.it/200x200" alt="">
                <h3>John Smith
                    <small>Job Title</small>
                </h3>
                <p>We are a group of seasoned engineers and we want bring you a whole new experience of controlling smart things.</p>
            </div>
            <!-- people list-->

          

      
            
        </div>
	</body>
<form role="form" id="unfollow" method="post" action="unfollowfrommypage.php">
        <input type="hidden" id="unloginname" name="unloginname"/>
        <input type="hidden" id="unfollowing" name="unfollowing"/>
</form>
<form role="form" id="peopledetail" method="post" action="usrpage.php">
        <input type="hidden" id="ploginname" name="ploginname"/>
</form>
<form role="form" id="tag" method="post" action="tag.php">
        <input type="hidden" id="htag" name="htag"/>
</form>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>





<?php 

include_once "footer.php";

?>