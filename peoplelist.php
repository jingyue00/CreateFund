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

?>
<script type="text/javascript">
function follow(followto)
        {
            document.querySelector("#hfollowing").value = followto;
            document.querySelector("#hloginname").value = "<?php echo $loginname?>";
            document.getElementById("follow").submit();
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
                <button type=\"button\" style=\"margin-right: 40px; width: 60px;\" name = \"follow\" onClick=\"follow('$row[1]')\"> Follow </button>
                
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


<?php 

include_once "footer.php";

?>
