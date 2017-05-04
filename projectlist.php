<?php 
    //session_start();
    include_once "header.php";

    //require "class.connect.php";
    //$connect = new connect();
    //$conn = $connect->getConnect("dbproject");
    //if(!$conn) { echo "failed to connect!";}
        
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);

    //from search input form the keyword is set
    if(isset($_POST["keyword"])){
        $getpro = $conn-> prepare("SELECT * FROM PROJECT where pname like ? ORDER BY createtime DESC ");  // specify page size 
        $keyword = "%".$_POST["keyword"]."%";
        $getpro->bind_param("s",$keyword);
    }
    else{
        $getpro = $conn-> prepare("SELECT * FROM PROJECT ORDER BY createtime DESC ");  // specify page size 
    }
    $getpro->execute();
    $listresult = $getpro->get_result();

    //add userlog
    $now = new DateTime(null, new DateTimeZone('America/New_York'));
    $nowb = $now->format('Y-m-d H:i:s'); 
    $ltype = "searchproject";
    $newlog = $conn->prepare("
                INSERT USERLOG SET loginname = ?, ltype = ?, targetid = ?, ltime = ?
            ");
    $newlog->bind_param("ssss",$loginname,$ltype,$listcondition,$nowb);
    $newlog->execute();

?>

 <!-- Page Content -->
    <div class="container">
        <?php
        if($listresult){
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

        ?>


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
