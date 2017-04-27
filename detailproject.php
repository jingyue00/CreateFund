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
    //$pid = $_SESSION["pid"];
    $pid = '10113106771384991864';

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
                        <h4 class="pull-right">$<?php echo "$currentamt"; ?> raised | $<?php echo "$min"; ?> goal </h4>
                        <h4><?php echo "$pname"; ?></h4>
                        <div class="text-right">
                            <a class="btn btn-warning">Pledge Me!</a>
                        </div>
                        <div class="detail-list">
                                <span class="glyphicon glyphicon-time"></span><a><?php echo "$endcampaignformat";?></a><br/>
                                <span class="glyphicon glyphicon-map-marker"></span><a>User Location</a> <br/>
                                <button type="button" class="btn btn-default btn-xs btn-danger">Tag1</button>
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

                </div>



        </div>
    </div>

<?php 

include_once "footer.php";

?>
