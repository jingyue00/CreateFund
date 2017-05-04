<?php 
	//homepage 
	include_once "header.php";

	$tag = $_POST["htag"];
	//search people 
	if(isset($tag)){
        //get people list
        $getpeople = $conn-> prepare("SELECT loginname FROM TAG_USER WHERE tag = ?");
        $getpeople->bind_param("s",$tag);
        $getpeople->execute();
        $peopleresult = $getpeople->get_result();
        $perowCount = mysqli_num_rows($peopleresult);

        //get project list
        $getproject = $conn-> prepare("SELECT pid FROM TAG_PROJECT WHERE tag = ?");
        $getproject->bind_param("s",$tag);
        $getproject->execute();
        $projectresult = $getproject->get_result();
        $prrowCount = mysqli_num_rows($projectresult);
    }

//add userlog
    $now = new DateTime(null, new DateTimeZone('America/New_York'));
    $nowb = $now->format('Y-m-d H:i:s'); 
    $ltype = "searchtag";
    $newlog = $conn->prepare("
                INSERT USERLOG SET loginname = ?, ltype = ?, targetid = ?, ltime = ?
            ");
    $newlog->bind_param("ssss",$loginname,$ltype,$tag,$nowb);
    $newlog->execute();

	//search project
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
</script>

<div class="container">
    	 <!-- Team Members Row -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> People with tag: <?php echo "$tag";?>
                    <small></small>
                </h1>
            </div>
        </div>
           <!-- people list -->
           <?php
           if($perowCount > 0){
            $i = 0;
            while($row = mysqli_fetch_array($peopleresult, MYSQLI_BOTH)){
                $getfname = $conn-> prepare("SELECT * FROM USER WHERE loginname = ?");
                $getfname->bind_param("s",$row['loginname']);
                $getfname->execute();
                $fresult = $getfname->get_result();
                $prow = mysqli_fetch_array($fresult, MYSQLI_BOTH);
                $ppost = $prow['post'];
                $pname = $prow['name'];
                $phometown = $prow['hometown'];
                $ploginname = $row['loginname'];

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

                echo "<div class='col-md-4 text-center'>
                <img class='img-circle' style='width: 65%' height='230' src='img/".$ppost."'>
                <h3>".$pname."
                    <small>from ".$phometown."</small>
                </h3>
                <button type=\"button\" style=\"margin-right: 40px; width: 60px;\" name = \"follow\" onClick=\"$followbtn('$prow[1]')\"> ".$followbtn." </button>
                </div>
                ";

                //end of row
                if($i%3 == 2){
                    echo "</div><hr>";
                }
                $i++;
            }
           }else {
           	echo "
        	<h3>
                    <a> No people with this tag</a>
            </h3>";
        }
           ?>
            <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Project with tag: <?php echo "$tag";?>
                    <small></small>
                </h1>
            </div>
        </div>
        <?php
        if($prrowCount > 0){
            $i = 0;
            while($row = mysqli_fetch_array($projectresult, MYSQLI_BOTH)){

                $getpname = $conn-> prepare("SELECT * FROM PROJECT WHERE pid = ?");
                $getpname->bind_param("s",$row['pid']);
                $getpname->execute();
                $presult = $getpname->get_result();
                $row = mysqli_fetch_array($presult, MYSQLI_BOTH);
            
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
        } else {
        	echo "
        	<h3>
                    <a> No project with this tag</a>
                </h3>";
        }
    
    ?>

    </div>

<form role="form" id="follow" method="post" action="follow.php">
        <input type="hidden" id="hloginname" name="hloginname"/>
        <input type="hidden" id="hfollowing" name="hfollowing"/>
</form>
<form role="form" id="unfollow" method="post" action="unfollow.php">
        <input type="hidden" id="unloginname" name="unloginname"/>
        <input type="hidden" id="unfollowing" name="unfollowing"/>
</form>
        

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

<?php 

include_once "footer.php";

?>