<?php 
session_start();
include_once "header.php";

require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
		
	//get cname and keyword
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $loginname = $_SESSION["loginname"];

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
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for Slides -->
        <div class="carousel-inner">
            <div class="item active">
                <!-- Set the first background image using inline CSS below. -->
                <div class="fill" style="background-image:url('img/slider4.jpg');"></div>
                <div class="carousel-caption">
                    <h2>Caption 1</h2>
                </div>
            </div>
            <div class="item">
                <!-- Set the second background image using inline CSS below. -->
                <div class="fill" style="background-image:url('img/slider1.jpg');"></div>
                <div class="carousel-caption">
                    <h2>Caption 2</h2>
                </div>
            </div>
            <div class="item">
                <!-- Set the third background image using inline CSS below. -->
                <div class="fill" style="background-image:url('img/slider3.jpg');"></div>
                <div class="carousel-caption">
                    <h2>Caption 3</h2>
                </div>
            </div>
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
           <!-- about user -->
            <div class="col-lg-4 col-sm-6 text-center mb-4">
                <img class="rounded-circle img-fluid d-block mx-auto img-circle" src="http://placehold.it/200x200" alt="">
                <h3>John Smith
                    <small>Job Title</small>
                </h3>
                <p>What does this team member to? Keep it short! This is also a great spot for social links!</p>
            </div>
            <!-- about user-->
            
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Find Interesting Project
                    <small></small>
                </h1>
            </div>
           <!-- about user -->
            <div class="col-lg-4 col-sm-6 text-center mb-4">
                <img class="rounded-circle img-fluid d-block mx-auto" src="http://placehold.it/200x200" alt="">
                <h3>John Smith
                    <small>Job Title</small>
                </h3>
                <p>What does this team member to? Keep it short! This is also a great spot for social links!</p>
            </div>
            <!-- about user-->
            
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