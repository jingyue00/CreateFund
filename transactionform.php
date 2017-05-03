<?php 

    include_once "header.php";

    $_SESSION['loginname'] = $_POST['hloginname'];
    $_SESSION['pid'] = $_POST['hpid'];

?>
<script>
function update()
        {
            document.querySelector("#hccn").value = document.querySelector('input[name="ccnradio"]:checked').value;
            document.querySelector("#hamount").value = document.querySelector('input[name="pledgeamt"]').value;
            document.querySelector("#hccv").value = document.querySelector('input[name="ccv"]').value;
            document.getElementById("pform").submit();
        }

</script>
<div class="container">
    <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Your Pledge
                    <small>Detail Information</small>
                </h1>
            </div>
        </div>


    <div class="row">
        <div class="row">  
             <div class="col-md-3">

            </div>

        <div class="col-md-6 center-block"> 
          <div class="form-group">
            <label for="exampleInputEmail1">Enter Your Amount</label>
            <input type="amount" class="form-control" name="pledgeamt" placeholder="$">
          </div>
          <?php
            $getccn = $conn-> prepare("SELECT * FROM CCN 
                WHERE loginname = ? ");
            $getccn->bind_param("s",$loginname);
            $getccn->execute();
            $cresult = $getccn->get_result();
            if($cresult){
                while ($row = mysqli_fetch_array($cresult, MYSQLI_BOTH)) {
                $rows[] = $row;
                }
            }
                       
            foreach($rows as $row)
            {
                $a = stripslashes($row['ccn']);
                $b = stripslashes($row['edate']);
                $phpdate = strtotime( $b );
                $mysqldate = date( 'Y-m-d', $phpdate );
                $c = stripslashes($row['cname']);
                echo "
                <div class='radio'>
                  <label><input type='radio' name='ccnradio' value=".$a.">Card Type: ".$c.", Card Number: ".$a.", Expire Date: ".$mysqldate."</label>
                </div>
                ";
            }
         ?>
          <div class="form-group">
            <label for="exampleInputEmail1">Enter Card CCV</label>
            <input type="ccv" class="form-control" name="ccv" placeholder="3 Digital Number">
          </div>
          
          <button type="button" class="btn btn-default" onClick="update()">Submit</button>
        
        
        </div>
    </div>
</div>


<form role="form" id="pform" method="post" action="inserttrans.php">
        <input type="hidden" id="hamount" name="hamount"/>
        <input type="hidden" id="hccn" name="hccn"/>
        <input type="hidden" id="hccv" name="hccv"/>
</form>
 
<?php 

include_once "footer.php";

?>
