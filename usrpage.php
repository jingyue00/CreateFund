<?php 
	//mypage 
	include_once "header.php";
	
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
    
    if(isset($_POST["ploginname"])){
		$ploginname = $_POST["ploginname"];
		$_SESSION["ploginname"] = $ploginname;
	}else{
		$ploginname = $_SESSION["ploginname"];
	}

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    //get user post
		
    $getupost = $conn-> prepare("SELECT name,loginname,password,hometown,post FROM USER WHERE loginname = ? ");
    $getupost->bind_param("s",$ploginname);
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
function follow(followto)
        {
            document.querySelector("#hfollowing").value = followto;
            document.querySelector("#hloginname").value = "<?php echo $loginname?>";
            document.getElementById("follow").submit();
        }
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
		<div class="row">
            <div class="col-lg-12">
                <h2 class="page-header"><?php echo $loginname?> 's tag:  <?php	
                    $gettag = $conn-> prepare("SELECT tag FROM TAG_USER WHERE loginname = ? ");
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
				</h2>
			</div>
		</div>
	</div> 
    <!-- Page Content -->
    <div class="container">
    	<!-- Team Members Row -->
		<div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Project <?php echo $loginname?> Created</h1>
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
						$pname = $row['pname'];
						$post = $row['post'];
						$min = $row['min'];
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
                <h1 class="page-header">Project <?php echo $loginname?> pledge
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
                <h1 class="page-header">Project <?php echo $loginname?> liked
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
                <h1 class="page-header">People <?php echo $loginname?> followed
                    <small></small>
                </h1>
            </div>
        </div>
        <!-- people list -->
        <?php
		if(isset($peopleresult) AND $peopleresult){
			if (mysqli_num_rows($peopleresult) == 0){
				echo "
					<p>No Followed People Yet!</p>;
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
							<p>No Liked Project Yet!</p>;
							<img src='img/pu.gif'/>
							";
					}
					else {
						$ppost = $prow['post'];
						$pname = $prow['name'];
						$phometown = $prow['hometown'];
						$ploginname = $prow['loginname'];

						 //check if follow
		                $iffollow = $conn->prepare("SELECT COUNT(*) as c FROM FOLLOW WHERE 
		                    following = ? AND loginname = ? 
		                    ");
		                $iffollow->bind_param("ss",$ploginname,$loginname);
		                $iffollow->execute();
		                $result = $iffollow->get_result();
		                $rowf = mysqli_fetch_array($result,MYSQLI_BOTH);  
		                if($rowf['c'] > 0){ 
		                     $followbtn = "unfollow";
		                } else {
		                     $followbtn = "follow";
		                }
						
						//new row
						if($i%3 == 0){
							echo "<div class='row'>";
						}
						echo "<div class=\"col-md-4 text-center\">
		                <img class=\"img-circle\" style=\"width: 65%\" height=\"230\" src='img/".$ppost."'>
		                <h3>".$pname."
		                    <small>from ".$phometown."</small>
		                </h3>
		                <button type=\"button\" style=\"width: 60px;margin-right:65px;\" class=\"pull-right\" onClick=\"peopledetail('$ploginname')\"> Detail </button>
		                <button type=\"button\" style=\"margin-right: 40px; width: 60px;\" name = \"follow\" onClick=\"$followbtn('$ploginname')\"> ".$followbtn." </button>
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
            
        </div>
	</body>
<form role="form" id="follow" method="post" action="followfromusrpage.php">
        <input type="hidden" id="hloginname" name="hloginname"/>
        <input type="hidden" id="hfollowing" name="hfollowing"/>
</form>
<form role="form" id="unfollow" method="post" action="unfollowfromusrpage.php">
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