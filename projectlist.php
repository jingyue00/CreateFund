<?php 
    session_start();
    include_once "header.php";

    require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
        
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $listcondition = "ALL";
    if(isset($_SESSION["projectlistcondition"])){
        $listcondition = $_SESSION["projectlistcondition"];
    }

    if(strcmp($listcondition,"ALL") == 0){
        $getpro = $conn-> prepare("SELECT * FROM PROJECT ORDER BY createtime DESC ");  // specify page size 
    } else {
        $sqlst = "SELECT * FROM PROJECT ".$listcondition;
        $getpro = $conn-> prepare($sqlst);
    }
    $getpro->execute();
    $listresult = $getpro->get_result();

?>

 <!-- Page Content -->
    <div class="container">
        <?php
        if($listresult){
            $row = mysqli_fetch_array($listresult, MYSQLI_BOTH);
            $rowCount = mysqli_num_rows($listresult);
        }
        ?>

        <!-- Page Header -->
        <div class="row">
        	<div class="col-lg-12">
                <h1 class="page-header">Project List
                    <small> total: <?php echo "$rowCount";?></small>
                </h1>
            </div>
    	</div>
    	<!-- /.row -->

        <?php
        if($listresult){
            $i = 0;
            while($row = mysqli_fetch_array($listresult, MYSQLI_BOTH)){
                $pname = $row['pname'];
                $post = $row['post'];
                $min = $row['min'];
                $endcampaign = $row['endcampaign'];
                $pdesc = $row['pdesc'];
                $getrichtext = $conn->prepare("SELECT content FROM RICH_CONTENT WHERE rid = ?");
                $getrichtext->bind_param("s",$pdesc);
                $getrichtext->execute();
                $resultc = $getrichtext->get_result();
                if($resultc){
                    $rowc= mysqli_fetch_array($resultc,MYSQLI_BOTH);    
                    $rtc = $rowc['content'];
                }

                //new row
                if($i%3 == 0){
                    echo "<div class='row'>";
                }

                echo "
                <div class='col-md-4 portfolio-item'>
                <a>
                    <img class='img-responsive' src='img/".$post."' alt='' width='380' height='142'>
                </a>
                <h3>
                    <a>".$pname."</a>
                </h3>
                <p>".$pdesc."</p>
                </div>
                ";

                //end of row
                if($i%3 == 2){
                    echo "</div><hr>";
                }

                $i++;
            }
        }

        ?>


    	<!-- Projects Row -->
        <div class="row">
       <!-- project Start --> 
            <div class="col-md-4 portfolio-item">
                <a href="#">
                    <img class="img-responsive" src="img/coco1.png" alt="" width="380" height="142">
                </a>
                <h3>
                    <a href="#">Project Name</a>
                </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
            </div>
        <!-- project End --> 


            <div class="col-md-4 portfolio-item">
                <a href="#">
                    <img class="img-responsive" src="img/resize1.png" alt="" width="380" height="142">
                </a>
                <h3>
                    <a href="#">Project Name</a>
                </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
            </div>

            <div class="col-md-4 portfolio-item">
                <a href="#">
                    <img class="img-responsive" src="img/resize2.png" alt="" width="380" height="142">
                </a>
                <h3>
                    <a href="#">Project Name</a>
                </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
            </div>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Pagination -->
        <div class="row text-center">
            <div class="col-lg-12">
                <ul class="pagination">
                    <li>
                        <a href="#">&laquo;</a>
                    </li>
                    <li class="active">
                        <a href="#">1</a>
                    </li>
                    <li>
                        <a href="#">2</a>
                    </li>
                    <li>
                        <a href="#">3</a>
                    </li>
                    <li>
                        <a href="#">4</a>
                    </li>
                    <li>
                        <a href="#">5</a>
                    </li>
                    <li>
                        <a href="#">&raquo;</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /.row -->

        <hr>

    </div>


<?php 

include_once "footer.php";

?>
