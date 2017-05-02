<?php 
	//homepage 
	include_once "header.php";

	//require "class.connect.php";
    //$iconnect = new connect();
    //$conn = $iconnect->getConnect("dbproject");
    //if(!$conn) { echo "failed to connect!";}
		
	//get cname and keyword
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);

    //<!-- get pid --> 
    if(isset($_GET["pid"])){
        $pid = $_GET["pid"];
    }
    else{
    //$pid = $_SESSION["pid"];
    $pid = '10113106771384991868';
    }

    if(isset($loginname)){

        //get people list
        $getpeople = $conn-> prepare("SELECT following FROM FOLLOW WHERE loginname = ? ORDER BY updatetime DESC");
        $getpeople->bind_param("s",$loginname);
        $getpeople->execute();
        $peopleresult = $getpeople->get_result();

        //get project list
        $getproject1 = $conn-> prepare("SELECT pid FROM LIKERELATION WHERE loginname = ? ORDER BY updatetime DESC");
        $getproject1->bind_param("s",$loginname);
        $getproject1->execute();
        $projectlist1 = $getproject1->get_result();
        
        $getproject2 = $conn-> prepare("SELECT pid FROM PLEDGE WHERE loginname = ? ORDER BY updatetime DESC");
        $getproject2->bind_param("s",$loginname);
        $getproject2->execute();
        $projectlist2 = $getproject2->get_result();
        
    }else{
        
        //get people list
        //$people = [
        //'following'=>'jane1234',
        //'following'=>'ivy1234',
        //'following'=>'lily1234'];

        //get project list
        $getproject1 = $conn-> prepare("SELECT pid FROM LIKERELATION ORDER BY updatetime DESC LIMIT 3");
        $getproject1->execute();
        $projectlist1 = $getproject1->get_result();
    
        $getproject2 = $conn-> prepare("SELECT pid FROM PLEDGE ORDER BY updatetime DESC LIMIT 3");
        $getproject2->execute();
        $projectlist2 = $getproject2->get_result();

        //get project list
    }

?>
<!--
<!DOCTYPE html>
<html lang="en">
<script src="js/jquery.mb.YTPlayer.js"></script>
<link href="css/bootstrap.css" rel="stylesheet"> 
-->

    <!-- /page loader -->

	<!-- Section: home video 
    <section id="intro" class="home-video text-light">
		<div class="home-video-wrapper">

		<div class="homevideo-container">
           <div id="P1" class="bg-player" style="display:block; margin: auto; background: rgba(0,0,0,0.5)" data-property="{videoURL:'https://www.youtube.com/watch?v=mroiVdC7H10',containment:'.homevideo-container', quality: 'hd720', showControls: false, autoPlay:true, mute:true, startAt:0, opacity:1}"></div>
		</div>
		<div class="overlay">
			<div class="text-center video-caption">
				<div class="wow bounceInDown" data-wow-offset="0" data-wow-delay="0.8s">
					<h1 class="big-heading font-light"><span id="js-rotating">We are GreateFund, Awesome Funding Website, Get better Fund, Craft from GreateFund </span></h1>
				</div>
				<div class="wow bounceInUp" data-wow-offset="0" data-wow-delay="1s">
					<div class="margintop-30">
						<a href="#about" class="btn btn-skin" id="btn-scroll">Start here</a>
					</div>
				</div>
			</div>
		</div>
		</div>
    </section>
	<!-- /Section: intro -->

<!--Video Section
<section class="content-section video-section">
  <div class="pattern-overlay">
  <a id="bgndVideo" class="player" data-property="{videoURL:'https://www.youtube.com/watch?v=fdJc1_IBKJA',containment:'.video-section', quality:'large', autoPlay:true, mute:true, opacity:1}">bg</a>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
        <h1>Full Width Video</h1>  
        <h3>Enjoy Adding Full Screen Videos to your Page Sections</h3>
	   </div>
      </div>
    </div>
  </div>
</section>
<!--Video Section Ends Here-->

<!--
<script>
$(document).ready(function () {

    $(".player").mb_YTPlayer();

});
</script>
-->
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
           if(isset($peopleresult) AND $peopleresult){
            $i = 0;
            while($row = mysqli_fetch_array($peopleresult, MYSQLI_BOTH)){
                $getfname = $conn-> prepare("SELECT * FROM USER WHERE loginname = ?");
                $getfname->bind_param("s",$row['following']);
                $getfname->execute();
                $fresult = $getfname->get_result();
                $prow = mysqli_fetch_array($fresult, MYSQLI_BOTH);
                $ppost = $prow['post'];
                $pname = $prow['name'];
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
                <p>We are a group of seasoned engineers and we want bring you a whole new experience of controlling smart things.</p>
                </div>
                ";

                //end of row
                if($i%3 == 2){
                    echo "</div><hr>";
                }
                $i++;
            }
           } else {
            echo"
            <div class='row'>
                <div class='col-md-4 text-center'>
                <img class='img-circle' style='width: 65%' height='230' src='img/user2.jpg'>
                <h3>Ivy Yu
                    <small>from NY</small>
                </h3>
                <p>Database is the best course in Tanadon</p>
                </div>

                <div class='col-md-4 text-center'>
                <img class='img-circle' style='width: 65%'' height='230' src='img/user9.jpg'>
                <h3>Jane Jing
                    <small>from NY</small>
                </h3>
                <p>Database is the best course in Tanadon</p>
                </div>

                <div class='col-md-4 text-center'>
                <img class='img-circle' style='width: 65%'' height='230' src='img/user4.jpg'>
                <h3>Mary
                    <small>from NY</small>
                </h3>
                <p>Database is the best course in Tanadon</p>
                </div>

            </div><hr>
            ";

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

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Find Interesting Project
                    <small></small>
                </h1>
            </div>
        </div>
         <?php

        //while($row = $allProject){
         if(($projectlist1!=FALSE) or($projectlist2!=FALSE)){
            if($projectlist1){

                $i = 0;
                while($row = mysqli_fetch_array($projectlist1, MYSQLI_BOTH)){

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

            if($projectlist2){
                while($row = mysqli_fetch_array($projectlist2, MYSQLI_BOTH)){
            
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
            }
        }
    }
        ?>

           <!-- project list 
            <div class="col-lg-4 col-sm-6 text-center mb-4">
                <img class="rounded-circle img-fluid d-block mx-auto" src="http://placehold.it/200x200" alt="">
                <h3>John Smith
                    <small>Job Title</small>
                </h3>
                <p>What does this team member to? Keep it short! This is also a great spot for social links!</p>
            </div>
            <!-- project list-->
            
        </div>


        

    </div>
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