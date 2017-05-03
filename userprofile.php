<?php
    session_start();    
    require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
        
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
        //get user post
    $getupost = $conn-> prepare("SELECT name,loginname,hometown,post FROM USER 
            WHERE loginname = ? ");
    $getupost->bind_param("s",$_SESSION["loginname"]);
    $getupost->execute();
    $resultu = $getupost->get_result();
    if($resultu){
        $rowu = mysqli_fetch_array($resultu,MYSQLI_BOTH); 
        $upost = $rowu['post'];
        $name = $rowu['name'];
        $loginname = $rowu['loginname'];
        $hometown = $rowu['hometown'];
    }
    $getpro = $conn-> prepare("SELECT * FROM PROJECT 
            WHERE post is not null");
    $getpro->execute();
    $resultp = $getpro->get_result();


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>UserProfile</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/full-width-pics.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        function success()
        {
            $('#success').modal('show')
        }
    </script>
</head>

<body onload="success()">

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
                <a class="navbar-brand" href="#">GreatFund</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">Find Project</a>
                    </li>
                    <li>
                        <a href="#">Find People</a>
                    </li>
                    <li>
                        <a href="#">My Page</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Full Width Image Header with Logo -->
    <!-- Image backgrounds are set within the full-width-pics.css file. -->
    <header class="image-bg-fluid-height">
        <img class="img-responsive img-center img-circle" src="img/<?php echo $upost;?>" height="200px" width="200px" alt="">
    </header>

    <!-- Content Section -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="section-heading">Welcome Back <?php echo $name;?></h1>
                    <p class="lead section-lead">Your user detail:</p>
                    <p class="section-paragraph">Loginname: <?php echo $loginname;?></p>
                    <p class="section-paragraph">Name: <?php echo $name;?></p>
                    <p class="section-paragraph">Hometown: <?php echo $hometown;?></p>
                </div>
            </div>
        </div>
    </section>
    <!-- Content Section -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="section-heading">Projects you might be interested<img src="img/observe.gif"/></h1>
                    <?php
                    while($rowp = mysqli_fetch_array($resultp,MYSQLI_BOTH)){
                        echo " 
                        <p class=\"lead section-lead\">".$rowp['pname']."</p>
                        <p class=\"lead section-lead\"><img src=\"img/".$rowp['post']."\" height=\"250px\" width=\"600px\"/></p>
                        <p class=\"section-paragraph\">owner: ".$rowp['owner']." <span style=\"margin-left:100px\"></span> createtime: ".$rowp['createtime']."</p>
                        <p class=\"section-paragraph\">Minimum:".$rowp['min']." <span style=\"margin-left:100px\"></span> Maximum:".$rowp['max']." </p>";
                        if($rowp['status'] == 'Completed')
                        {
                            echo"<p class=\"section-paragraph\">Status: <button type=\"button\" class=\"btn btn-success\">Completed</button> </p>";
                        }
                        else if ($rowp['status'] == 'Cancelled')
                        {
                            echo"<p class=\"section-paragraph\">Status: <button type=\"button\" class=\"btn btn-danger\">Cancelled</button> </p>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; DB Project - Jiwei Yu & Yue Jing</p>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </footer>

<div class="modal fade" id="success" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span   aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Welcome back <?php echo $name;?></h4>
        </div>
        <div class="modal-body">
            <p>What a lovely day! You should drink some hot water!</p>
            <img src="img/hotwater.gif"/>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
