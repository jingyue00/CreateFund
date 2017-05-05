<?php 
	//homepage 
	include_once "header.php";


    if(isset($loginname)){

        //get people list
        $getpeople = $conn-> prepare("SELECT following FROM FOLLOW WHERE loginname = ? ORDER BY updatetime DESC");
        $getpeople->bind_param("s",$loginname);
        $getpeople->execute();
        $peopleresult = $getpeople->get_result();

        //get following people activity about project
        if(isset($peopleresult) AND $peopleresult){

            //following people > 0
            $followingproject = array();
            $followingpeople = array();
            while($row = mysqli_fetch_array($peopleresult, MYSQLI_BOTH)){
                $getfollowingproject = $conn->prepare("SELECT targetid FROM USERLOG WHERE loginname = ?
                AND ltype IN ('createproject','transaction','likeproject','commentproject','viewproject')
                GROUP BY targetid
                ORDER BY ltime DESC");
                $a = $row['following'];
                $getfollowingproject->bind_param("s",$a);
                $getfollowingproject->execute();
                $followingprojectresult = $getfollowingproject->get_result();
                $x = mysqli_num_rows($followingprojectresult);
                if ($x > 0){
                    while($rowtemp = mysqli_fetch_array($followingprojectresult, MYSQLI_BOTH)){
                        $a = $rowtemp['targetid'];
                        array_push($followingproject, $rowtemp['targetid']);
                    }
                }

                $getfollowingpeople = $conn->prepare("SELECT targetid FROM USERLOG WHERE loginname = ?
                AND ltype IN ('follow')
                GROUP BY targetid
                ORDER BY ltime DESC");
                $getfollowingpeople->bind_param("s",$row['following']);
                $getfollowingpeople->execute();
                $followingpeopleresult = $getfollowingpeople->get_result();
                $x = mysqli_num_rows($followingpeopleresult);
                if ($x > 0){
                    while($rowtemp = mysqli_fetch_array($followingpeopleresult, MYSQLI_BOTH)){
                        array_push($followingpeople, $rowtemp['targetid']);
                    }
                }
            }
        }
        $followingprojectsize = count($followingproject);
        $followingpeoplesize = count($followingpeople);
        //my following people dont' have any project log, use user self log 
        if($followingprojectsize==0){
            $getfollowingproject = $conn->prepare("SELECT targetid FROM USERLOG WHERE loginname = ?
            AND ltype IN ('createproject','transaction','likeproject','commentproject','viewproject')
            GROUP BY targetid
            ORDER BY ltime DESC");
            $a = $loginname;
            $getfollowingproject->bind_param("s",$a);
            $getfollowingproject->execute();
            $followingprojectresult = $getfollowingproject->get_result();
            $x = mysqli_num_rows($followingprojectresult);
            if ($x > 0){
                while($rowtemp = mysqli_fetch_array($followingprojectresult, MYSQLI_BOTH)){
                $a = $rowtemp['targetid'];
                array_push($followingproject, $rowtemp['targetid']);
                }
            }
        }
        //my following people dont' have any people log, use user self log
        if($followingpeoplesize==0){
            $getfollowingpeople = $conn->prepare("SELECT targetid FROM USERLOG WHERE loginname = ?
            AND ltype IN ('follow')
            GROUP BY targetid
            ORDER BY ltime DESC");
            $getfollowingpeople->bind_param("s",$loginname);
            $getfollowingpeople->execute();
            $followingpeopleresult = $getfollowingpeople->get_result();
            $x = mysqli_num_rows($followingpeopleresult);
            if ($x > 0){
                while($rowtemp = mysqli_fetch_array($followingpeopleresult, MYSQLI_BOTH)){
                    array_push($followingpeople, $rowtemp['targetid']);
                }
            }
        }
        
    }else{
        //not log in: 
        $followingproject = array();
        $followingpeople = array();

        //get last 3 project in userlog 
        $getfollowingproject = $conn->prepare("SELECT targetid FROM USERLOG WHERE
        ltype IN ('createproject','transaction','likeproject','commentproject','viewproject')
        GROUP BY targetid
        ORDER BY ltime DESC");
        $getfollowingproject->execute();
        $followingprojectresult = $getfollowingproject->get_result();
        $x = mysqli_num_rows($followingprojectresult);
        if ($x > 0){
            while($rowtemp = mysqli_fetch_array($followingprojectresult, MYSQLI_BOTH)){
            $a = $rowtemp['targetid'];
            array_push($followingproject, $rowtemp['targetid']);
            }
        }

        $getfollowingpeople = $conn->prepare("SELECT targetid FROM USERLOG WHERE ltype IN ('follow')
        GROUP BY targetid
        ORDER BY ltime DESC");
        $getfollowingpeople->execute();
        $followingpeopleresult = $getfollowingpeople->get_result();
        $x = mysqli_num_rows($followingpeopleresult);
        if ($x > 0){
            while($rowtemp = mysqli_fetch_array($followingpeopleresult, MYSQLI_BOTH)){
            array_push($followingpeople, $rowtemp['targetid']);
            }
        }
        
    }

    $followingprojectsize = count($followingproject);
    $followingpeoplesize = count($followingpeople);
    if($followingprojectsize == 0){
        //no log from my following people and myself, use global log
        $getfollowingproject = $conn->prepare("SELECT targetid FROM USERLOG WHERE
        ltype IN ('createproject','transaction','likeproject','commentproject','viewproject')
        GROUP BY targetid
        ORDER BY ltime DESC");
        $getfollowingproject->execute();
        $followingprojectresult = $getfollowingproject->get_result();
        $x = mysqli_num_rows($followingprojectresult);
        if ($x > 0){
            while($rowtemp = mysqli_fetch_array($followingprojectresult, MYSQLI_BOTH)){
            $a = $rowtemp['targetid'];
            array_push($followingproject, $rowtemp['targetid']);
            }
        }

    }
    if($followingpeoplesize == 0){
        //no log from my following people and myself, use global log
        $getfollowingpeople = $conn->prepare("SELECT targetid FROM USERLOG WHERE ltype IN ('follow')
        GROUP BY targetid
        ORDER BY ltime DESC");
        $getfollowingpeople->execute();
        $followingpeopleresult = $getfollowingpeople->get_result();
        $x = mysqli_num_rows($followingpeopleresult);
        if ($x > 0){
            while($rowtemp = mysqli_fetch_array($followingpeopleresult, MYSQLI_BOTH)){
            array_push($followingpeople, $rowtemp['targetid']);
            }
        }
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
</script>


<body> 
<link href="css/half-slider.css" rel="stylesheet"> 

<header id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <!-- <li data-target="#myCarousel" data-slide-to="2"></li> -->
        </ol>

        <!-- Wrapper for Slides -->
        <div class="carousel-inner">
            <div class="item active">
                <!-- Set the first background image using inline CSS below. -->
                <div class="fill" style="background-image:url('img/slider4.jpg');"></div>
                <div class="carousel-caption">
                    
                </div>
            </div>
            <div class="item">
                <!-- Set the second background image using inline CSS below. -->
                <div class="fill" style="background-image:url('img/slider1.jpg');"></div>
                <div class="carousel-caption">
                   
                </div>
            </div>
            <!-- <div class="item">
                <!-- Set the third background image using inline CSS below. 
                <div class="fill" style="background-image:url('img/slider3.jpg');"></div>
                <div class="carousel-caption">
                    
                </div>
            </div> 
           -->
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>

    </header>
    <!-- Page Content -->

    <div class="container">
    	 <!-- Team Members Row -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Meet Amazing People
                    <small></small>
                </h1>
            </div>
        </div>
           <!-- people list -->
           <?php
           $i = 0;
           
           foreach($followingpeople as $a){
    
                $getfname = $conn-> prepare("SELECT * FROM USER WHERE loginname = ?");
                $getfname->bind_param("s",$a);
                $getfname->execute();
                $fresult = $getfname->get_result();
                $prow = mysqli_fetch_array($fresult, MYSQLI_BOTH);
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
           

           ?>


        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Find Interesting Project
                    <small></small>
                </h1>
            </div>
        </div>
         <?php
        $i = 0;
           
        foreach($followingproject as $a){

                $getpname = $conn-> prepare("SELECT * FROM PROJECT WHERE pid = ?");
                $getpname->bind_param("s",$a);
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

        ?>
        </div>
    </div>
<form role="form" id="follow" method="post" action="followfromindex.php">
        <input type="hidden" id="hloginname" name="hloginname"/>
        <input type="hidden" id="hfollowing" name="hfollowing"/>
</form>
<form role="form" id="unfollow" method="post" action="unfollowfromindex.php">
        <input type="hidden" id="unloginname" name="unloginname"/>
        <input type="hidden" id="unfollowing" name="unfollowing"/>
</form>
<form role="form" id="peopledetail" method="post" action="usrpage.php">
        <input type="hidden" id="ploginname" name="ploginname"/>
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