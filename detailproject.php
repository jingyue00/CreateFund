<?php 
	//Show the detail of project
    //session_start();
    include_once "header.php";
    
    //require "class.connect.php";
    //$connect = new connect();
    //$conn = $connect->getConnect("dbproject");
    //if(!$conn) { echo "failed to connect!";}
        
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);

    //<!-- get pid --> 
    if(isset($_GET["pid"])){
        $pid = $_GET["pid"];
        $_SESSION['pid'] = $_GET["pid"];
    } elseif (isset($_SESSION['pid'])){
        $pid = $_SESSION["pid"];
    }
    
    if(isset($_SESSION["loginname"])){
        $loginname = $_SESSION["loginname"];
    }
    //else{
    //$pid = $_SESSION["pid"];
    //$pid = '10113106771384991868';
    //}

    //<!-- get loginname --> 
    //$loginname = 'jane1234';

    //if like btn clicked
    if(isset($_POST['likeme'])){ 

        //check if already liked
        $ugetlike = $conn-> prepare("SELECT COUNT(*) AS count FROM LIKERELATION
                WHERE pid = ? AND loginname = ? ");
        $ugetlike->bind_param("ss",$pid,$loginname);
        $ugetlike->execute();
        $uresultl = $ugetlike->get_result();
        if($uresultl){
            $urowl = mysqli_fetch_array($uresultl,MYSQLI_BOTH); 
            $ulikeamt = $urowl['count'];
        }

        if($ulikeamt == 1){
            //already like
            $liketodo = $conn-> prepare("DELETE FROM LIKERELATION
                WHERE pid = ? AND loginname = ? ");
        } else if ($ulikeamt == 0){
            //not like yet
            $liketodo = $conn-> prepare("INSERT INTO LIKERELATION (`pid`, `loginname`) VALUES (?, ?) ");
        }
        $liketodo->bind_param("ss",$pid,$loginname);
        $liketodo->execute();

    } 

    //save the comment
    if(isset($_POST['submitcomment'])){ //check if form was submitted
        $inputc = $_POST['comment']; 

        //save comment into rich_content
        $newcomment = $conn-> prepare("INSERT RICH_CONTENT SET 
            content = ? , createtime = ?
            ");
        $now = new DateTime(null, new DateTimeZone('America/New_York'));
        $nowb = $now->format('Y-m-d H:i:s'); 
        $newcomment->bind_param("ss",$inputc,$nowb);
        $newcomment->execute();

        //get rid
        $getrid = $conn->prepare("SELECT rid FROM RICH_CONTENT WHERE content = ? ORDER BY createtime DESC LIMIT 1");
        $getrid->bind_param("s",$inputc);
        $getrid->execute();
        $result = $getrid->get_result();
        if($result){
            $row = mysqli_fetch_array($result,MYSQLI_BOTH);    
            $rid = $row['rid'];
        }

        //save into comment table
        $newcomment = $conn-> prepare("INSERT COMMENT SET 
            loginname = ?,
            comment = ?,
            pid = ?,
            updatetime = ?
            ");
        $now = new DateTime(null, new DateTimeZone('America/New_York'));
        $nowb = $now->format('Y-m-d H:i:s');
        $newcomment->bind_param("ssss", $loginname, $rid, $pid,$nowb);
        $newcomment->execute();
        $result = $getrid->get_result();
        if($result){
            echo "good comment";
        }
    }

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
            WHERE pid = ? ORDER BY updatetime DESC");
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

    $getlike = $conn-> prepare("SELECT COUNT(*) AS count FROM LIKERELATION
            WHERE pid = ? ");
    $getlike->bind_param("s",$pid);
    $getlike->execute();
    $resultl = $getlike->get_result();
    if($resultl){
        $rowl = mysqli_fetch_array($resultl,MYSQLI_BOTH); 
        $likeamt = $rowl['count'];
    }

    //get user post
    $getupost = $conn-> prepare("SELECT post FROM USER 
            WHERE loginname = ? ");
    $getupost->bind_param("s",$owner);
    $getupost->execute();
    $resultu = $getupost->get_result();
    if($resultu){
        $rowu = mysqli_fetch_array($resultu,MYSQLI_BOTH); 
        $upost = $rowu['post'];
    }

    //get average star from pledge table
    $getrate = $conn-> prepare("SELECT AVG(rate) as a, COUNT(loginname) as b FROM PLEDGE 
            WHERE pid = ? ");
    $getrate->bind_param("s",$pid);
    $getrate->execute();
    $resultr = $getrate->get_result();
    if($resultr){
        $rowr = mysqli_fetch_array($resultr,MYSQLI_BOTH); 
        $avgr = $rowr['a'];
        $pcount = $rowr['b'];
    }

?>
<script>
function update()
        {
            document.querySelector("#hpid").value = "<?php echo $pid?>";
            document.querySelector("#hloginame").value = "<?php echo $loginname?>";
            document.getElementById("pledgeform").submit();
        }
</script>

 <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            
            <div class="col-md-3">
                <!-- Owner Name -->
                <p class="lead"><?php echo "$owner"; ?></p>
                <!-- PUT OWNER IMAGE AND INFO HERE -->
                <img src="img/<?php echo "$upost";?>" class="img-circle" alt="Cinque Terre" width="250" height="250">

            </div>
        
        <!-- /.Project Detail -->
        <div class="col-md-9">
        
            <div class="thumbnail">

                    <img class="img-responsive" src="img/<?php echo "$post";?>" alt="">

                    <div class="caption-full">
                        <!-- <h4 class="pull-right">$<?php echo "$currentamt"; ?> raised, $<?php echo "$min"; ?> goal </h4> -->
                        <h3><?php echo "$pname"; ?></h3>
                        <div class="text-right">
                            <button name = "pledgeme" class="btn btn-warning" onClick="update()">Pledge Me!</button>
                        </div>
                        <div class="detail-list">
                            <p class="pull-right">
                                <form class="pull-right" role="form" id="likes" method="post" action="detailproject.php" enctype="multipart/form-data">
                                    <input type="hidden" name="like"/>
                                    <span class="glyphicon glyphicon-heart"></span><a> <?php echo "$likeamt";?> likes</a>
                                    <button class="btn btn-warning" name = "likeme">Like Me!</button>
                                </form>
                            </p>
                            <p>
                                <span class="glyphicon glyphicon-time"></span><a> <?php echo "$endcampaignformat";?></a><br/>
                                <span class="glyphicon glyphicon-map-marker"></span><a> User Location</a><br/>
                                <?php
                                $gettag = $conn-> prepare("SELECT tag FROM TAG_PROJECT 
                                        WHERE pid = ? ");
                                $gettag->bind_param("s",$pid);
                                $gettag->execute();
                                $tresult = $gettag->get_result();
                                if($tresult){
                                    while ($row = mysqli_fetch_array($tresult, MYSQLI_BOTH)) {
                                         $rows[] = $row;
                                    }
                                }
                       
                                foreach($rows as $row)
                                {
                                    $a = stripslashes($row['tag']);
                                    echo "<button type='button' class='btn btn-default btn-xs btn-success'>".$a."</button>
                                          <a> </a>
                                    ";
                                }

                                ?>

                            </p>
                        </div>

                        <p><?php echo "$rt";?></p>
                    </div>
                    <div class="ratings">
                        <p class="pull-right"><?php echo "$reviewamt";?> reviews</p>
                        <p>
                            <?php 
                            for ($i = 0; $i < $avgr; $i++){
                                echo "<span class='glyphicon glyphicon-star'></span>";
                            }
                            $rest = 5 - $avgr;
                            for ($i = 0; $i < $rest; $i++){
                                echo "<span class='glyphicon glyphicon-star-empty'></span>";
                            }

                            ?>
                
                            <?php echo "$avgr";?> stars from <?php echo "$pcount";?> sponsers
                        </p>
                    </div>

                    <!--  Progress Bar -->
                    <div class="caption-full">
                        <h4 class="pull-right">$<?php echo "$currentamt"; ?> raised, $<?php echo "$min"; ?> goal </h4>
                        <h4>Current Fund Progress: <?php echo "$progress";?>% completed</h4>
                        <div class="progress">
                          <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo "$progress";?>%">
                            <span class="sr-only"><?php echo "$progress";?>% Complete</span>
                          </div>
                        </div>
                    </div>
            </div>

            <div class="well">

                    <div class="text-right comment">
                        <a class="btn btn-success commentbtn">Leave a Review</a>
                        <div class="commentarea">
                            <!-- comment Code -->
                            <form role="form" id="comment" method="post" action="detailproject.php" enctype="multipart/form-data">
                            <input class="form-control" rows="5" name="comment" id="comment" type="text" class="form-control" placeholder="Any comment" aria-describedby="basic-addon1">
                            </input>
                            <button class="btn btn-default" name="submitcomment" type="submit">Submit</button>
                            </form>
                          </div>
                    </div>

                    <script>
                    $(document).ready(function(){
                      $(function(){
                        var comments = $('.comment'),
                            state = false;
                            comments.each(function(){
                          var videocon = $(this),
                              btn = videocon.find('.commentbtn'),
                              area = videocon.find('.commentarea');
                              btn.on('click', function() {
                            if ( state == false ) {
                              area.slideDown('slow', function() { state = true; btn.html('Leave a Review'); });
                            } else {
                              area.slideUp('fast', function() { state = false; btn.html('Leave a Review'); });
                            }
                          });
                        });
                      });
                    });
                    </script>

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
<form role="form" id="pledgeform" method="post" action="transactionform.php">
        <input type="hidden" id="hpid" name="hpid"/>
        <input type="hidden" id="hloginame" name="hloginname"/>
</form>

<?php 

include_once "footer.php";

?>
