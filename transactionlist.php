<?php 
    
    include_once "header.php";

    if(isset($_SESSION["loginname"])){
        $loginname = $_SESSION["loginname"];
    }

    $gettrans = $conn-> prepare("SELECT * FROM TRANSACTION WHERE loginname = ? ORDER BY createtime DESC "); 
    $gettrans->bind_param("s",$loginname); 
    $gettrans->execute();
    $transaction = $gettrans->get_result();

?>

<div class="container">
    <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Your Transaction
                    <small>Detail Information</small>
                </h1>
            </div>
        </div>


    <div class="row">
        <div class="row">  
             <div class="col-md-3">

            </div>

        <div class="col-md-6 center-block"> 
          
        <table class="table table-striped table-hover ">
          <thead>
            <tr class="info">
              <th>Date</th>
              <th>Project</th>
              <th>Amount</th>
              <th>Payment</th>
            </tr>
          </thead>
          <tbody>
          <?php
            if($transaction){
            while($row = mysqli_fetch_array($transaction, MYSQLI_BOTH)){
                $tdate = $row['createtime'];
                $plid = $row['plid'];
                $ccn = $row['ccn'];
                $amount = $row['amount'];

                $getpname = $conn->prepare("SELECT pname FROM
                    PLEDGE a, PROJECT b
                    WHERE a.pid = b.pid
                    AND plid = ?");
                $getpname->bind_param("s",$plid);
                $getpname->execute();
                $presult= $getpname->get_result();
                if($presult){
                    $rowp= mysqli_fetch_array($presult,MYSQLI_BOTH);    
                    $pname = $rowp['pname'];
                }

                $getcardname = $conn->prepare("SELECT cname FROM CCN WHERE ccn = ?");
                $getcardname->bind_param("s",$ccn);
                $getcardname->execute();
                $cresult= $getcardname->get_result();
                if($cresult){
                    $rowc= mysqli_fetch_array($cresult,MYSQLI_BOTH);    
                    $cname = $rowc['cname'];
                }

                echo "
                 <tr>
                  <td>".$tdate."</td>
                  <td>".$pname."</td>
                  <td>$".$amount."</td>
                  <td>".$cname." - ".$ccn."</td>
                </tr>
                ";
               
                }
           }

          ?>

          </tbody>
        </table> 
        
        </div>
    </div>
</div>


 
<?php 

include_once "footer.php";

?>