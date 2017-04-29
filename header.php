<?php 
session_start();
include_once "header.php";

require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
        
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    //<!-- get loginname --> 
    if(isset($_SESSION["loginname"])){
        $loginname = $_SESSION["loginname"];
    }else{
        $loginname = 'jane1234';
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Find Me, Fund Me</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet"> 

    <!-- Custom CSS -->
    <link href="css/shop-item.css" rel="stylesheet"> 

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


        <!--  jQuery -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.js"></script>

        <!-- Isolated Version of Bootstrap, not needed if your site already uses Bootstrap 
        <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
        <link href="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> 
        <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css"> -->

        <!-- Bootstrap Date-Picker Plugin -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>  

        <!-- Summernote 
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet"> -->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script> 

        <script src="js/bootstrap.js"></script>  
        
        <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.3/summernote.css" rel="stylesheet"> 

        <link href="css/bootstrap-iso.css" rel="stylesheet"> 
        <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.3/summernote.js"></script> 
        <link href="css/summernote.css" / rel="stylesheet">
        <script src="css/summernote.min.js"></script>

        <!-- icon -->
        <link href="css/iconmoon.css" rel="stylesheet">
        <link href="css/flexslider.css" rel="stylesheet">
        <link href="css/language-selector-remove-able-css.css" rel="stylesheet">
        <link href="css/menu.css" rel="stylesheet">
        <link href="css/responsive.css" rel="stylesheet">
        <link href="css/color.css" rel="stylesheet">
        <link href="css/iconmoon.css" rel="stylesheet">
        <link href="css/themetypo.css" rel="stylesheet">
        <link href="css/widget.css" rel="stylesheet">
        <link href="css/sumoselect.css" rel="stylesheet">

        <!-- css from bootwatch
        <link href="http://bootswatch.com/cerulean/bootstrap.css" rel="stylesheet" type="text/css"> -->
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">GreateFund</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="projectlist.php">Project</a>
                    </li>
                    <li>
                        <a href="#">People</a>
                    </li>
                    <li>
                        <a href="userprofile.php">My Page</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    



<?php 



?>
