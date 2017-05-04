<?php 
    //session_start();
    include_once "header.php";

    $listcondition = "ALL";
    if(isset($_SESSION["peoplelistcondition"])){
        $listcondition = $_SESSION["peoplelistcondition"];
    }
    unset($_SESSION["peoplelistcondition"]);

    if(strcmp($listcondition,"ALL") == 0){
        //listcondition == all
        $getppl = $conn-> prepare("SELECT * FROM USER");  // specify page size 
    } else {
        //listcondition is not all
        $sqlst = "SELECT * FROM PROJECT ".$listcondition;
        $getppl = $conn-> prepare($sqlst);
    }
    $getppl->execute();
    $peopleresult = $getppl->get_result();

    //add userlog
    $now = new DateTime(null, new DateTimeZone('America/New_York'));
    $nowb = $now->format('Y-m-d H:i:s'); 
    $ltype = "searchpeople";
    $newlog = $conn->prepare("
                INSERT USERLOG SET loginname = ?, ltype = ?, targetid = ?, ltime = ?
            ");
    $newlog->bind_param("ssss",$loginname,$ltype,$listcondition,$nowb);
    $newlog->execute();

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
</script>

 <!-- Page Content -->

<div class="container"> 
        <?php

        if($peopleresult){
            $row = mysqli_fetch_array($peopleresult, MYSQLI_BOTH);
            $rowCount = mysqli_num_rows($peopleresult);
        }
        ?>

        <!-- Page Header -->
        <div class="row">
        	<div class="col-lg-12">
                <h1 class="page-header">People List
                    <small> total: <?php echo "$rowCount";?></small>
                </h1>
            </div>
    	</div>
    	<!-- /.row -->

        <?php
        if(isset($peopleresult) AND $peopleresult){
            $i = 0;
            while($row = mysqli_fetch_array($peopleresult, MYSQLI_BOTH)){
                
                $ppost = $row['post'];
                $pname = $row['name'];
                $phometown = $row['hometown'];
                $ploginname = $row['loginname'];

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
                <button style=\"width: 60px;margin-right:65px;\" class=\"pull-right\"> Detail </button>
                <button type=\"button\" style=\"margin-right: 40px; width: 60px;\" name = \"follow\" onClick=\"$followbtn('$row[1]')\"> ".$followbtn." </button>
                
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
<form role="form" id="follow" method="post" action="follow.php">
        <input type="hidden" id="hloginname" name="hloginname"/>
        <input type="hidden" id="hfollowing" name="hfollowing"/>
</form>
<form role="form" id="unfollow" method="post" action="unfollow.php">
        <input type="hidden" id="unloginname" name="unloginname"/>
        <input type="hidden" id="unfollowing" name="unfollowing"/>
</form>


<?php 

include_once "footer.php";

?>
