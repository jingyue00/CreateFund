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

    //<!-- get pid --> 
    $pid = $_SESSION["pid"];
    //$pid = '10113106771384991864';

    $getpro = $conn-> prepare("SELECT * FROM PROJECT 
            WHERE pid = ? ");
    $getpro->bind_param("s",$pid);
    $getpro->execute();
    $result = $getpro->get_result();
    if($result){
        $row = mysqli_fetch_array($result,MYSQLI_BOTH);        
        $pname = $row['pname'];  
        $pdesc = $row['pdesc']; 
        $createtime = $row['createtime']; 
        $currentamt = $row['currentamt'];
        $owner = $row['owner'];
        $min = $row['min'];
        $max = $row['max'];
        $endcampaign = $row['endcampaign'];
        $etime = $row['etime'];
        $ctime = $row['ctime'];
        $status = $row['status'];
        $post = $row['post'];
    } 

    $getrichtext = $conn->prepare("SELECT content FROM RICH_CONTENT WHERE rid = ?");
    $getrichtext->bind_param("s",$pdesc);
    $getrichtext->execute();
    $result = $getrichtext->get_result();
    if($result){
        $row = mysqli_fetch_array($result,MYSQLI_BOTH);    
        $rt = $row['content'];
    }

    $getreview = $conn-> prepare("SELECT COUNT(*) AS count FROM COMMENT 
            WHERE pid = ? ");
    $getreview->bind_param("s",$pid);
    $getreview->execute();
    $result = $getreview->get_result();
    if($result){
        $row = mysqli_fetch_array($result,MYSQLI_BOTH); 
        $reviewamt = $row['count'];
    }

    $getreviewdetail = $conn-> prepare("SELECT * FROM COMMENT 
            WHERE pid = ? ");
    $getreviewdetail->bind_param("s",$pid);
    $getreviewdetail->execute();
    $commentresult = $getreviewdetail->get_result();

    $now = new DateTime(null, new DateTimeZone('America/New_York'));
    $nowb = $now->format('Y-m-d H:i:s');  
    $a = strlen($endcampaign);
    $b = strlen($nowb);
    $restcampaign = strtotime($a)-strtotime($b);

    if ($status='PledgeStarted'){
        $progress = round(($currentamt/$min)*100);
    }

    $endcampaignformat = new DateTime($endcampaign, new DateTimeZone('America/New_York'));
    $endcampaignformat = $endcampaignformat->format('Y-m-d');  

    $getlike = $conn-> prepare("SELECT COUNT(*) AS count FROM dbproject.LIKE
            WHERE pid = ? ");
    $getlike->bind_param("s",$pid);
    $getlike->execute();
    $resultl = $getlike->get_result();
    if($resultl){
        $rowl = mysqli_fetch_array($resultl,MYSQLI_BOTH); 
        $likeamt = $rowl['count'];
    }

?>

 <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            
            <div class="col-md-3">
                <!-- Owner Name -->
                <p class="lead"><?php echo "$owner"; ?></p>
                <!-- PUT OWNER IMAGE AND INFO HERE -->
                <img src="img/coco.png" class="img-circle" alt="Cinque Terre" width="250" height="250">

            </div>
        
        <!-- /.Project Detail -->
        <div class="col-md-9">
        
            <div class="thumbnail">

                    <img class="img-responsive" src="img/coco1.png" alt="">

                    <div class="caption-full">
                        <h4 class="pull-right">$<?php echo "$currentamt"; ?> raised, $<?php echo "$min"; ?> goal </h4>
                        <h3><?php echo "$pname"; ?></h3>
                        <div class="text-right">
                            <a class="btn btn-warning">Pledge Me!</a>
                        </div>
                        <div class="detail-list">
                            <p class="pull-right">
                                <span class="glyphicon glyphicon-heart"></span><a> <?php echo "$likeamt";?> likes</a>
                                <button class="btn btn-warning">Like Me!</button>
                            </p>
                            <p>
                                <span class="glyphicon glyphicon-time"></span><a> <?php echo "$endcampaignformat";?></a><br/>
                                <span class="glyphicon glyphicon-map-marker"></span><a> User Location</a><br/>
                                <button type="button" class="btn btn-default btn-xs btn-success"> Tag1</button>
                                <button type="button" class="btn btn-default btn-xs btn-success"> Tag2</button>
                                <button type="button" class="btn btn-default btn-xs btn-success"> Tag3</button>
                            </p>
                        </div>

                        <p><?php echo "$rt";?></p>
                    </div>
                    <div class="ratings">
                        <p class="pull-right"><?php echo "$reviewamt";?> reviews</p>
                        <p>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            4.0 stars
                        </p>
                    </div>

                    <!--  Progress Bar -->
                    <div class="caption-full">
                        <h4>Current Progress: <?php echo "$progress";?>% completed</h4>
                        <div class="progress">
                          <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo "$progress";?>%">
                            <span class="sr-only"><?php echo "$progress";?>% Complete</span>
                          </div>
                        </div>
                    </div>
            </div>

            <div class="well">

                    <div class="text-right">
                        <a class="btn btn-success">Leave a Review</a>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            Anonymous
                            <span class="pull-right">10 days ago</span>
                            <p>This product was great in terms of quality. I would definitely buy another!</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            Anonymous
                            <span class="pull-right">12 days ago</span>
                            <p>I've alredy ordered another one!</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            Anonymous
                            <span class="pull-right">15 days ago</span>
                            <p>I've seen some better than this, but not at this price. I definitely recommend this item.</p>
                        </div>
                    </div>
                    <hr>

                    <?php
                    if($commentresult){
                        while ($row = mysqli_fetch_array($commentresult, MYSQLI_BOTH)){
                            $reviewcontent = $row['comment'];
                            $reviewuser = $row['loginname'];
                            $reviewtime = $row['updatetime'];
                            $getrichtext = $conn->prepare("SELECT content FROM RICH_CONTENT WHERE rid = ?");
                            $getrichtext->bind_param("s",$reviewcontent);
                            $getrichtext->execute();
                            $resultc = $getrichtext->get_result();
                            if($resultc){
                                $rowc= mysqli_fetch_array($resultc,MYSQLI_BOTH);    
                                $rtc = $rowc['content'];
                            }

                            echo "
                            <div class='row'>
                                <div class='col-md-12'>".$reviewuser."
                                <span class='pull-right'>".$reviewtime."</span>
                                <p>".$rtc."</p></div></div> 
                                <hr>
                            ";

                        }
                    }

                    ?>

                </div>



        </div>
    </div>

<?php 

include_once "footer.php";

?>
