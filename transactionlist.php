<?php 
    session_start();
    include_once "header.php";

    require "class.connect.php";
    $connect = new connect();
    $conn = $connect->getConnect("dbproject");
    if(!$conn) { echo "failed to connect!";}
        
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    //<!-- get pid --> 
    if(isset($_GET["pid"])){
        $pid = $_GET["pid"];
    }
    else{
    //$pid = $_SESSION["pid"];
    $pid = '10113106771384991868';
    }

    //<!-- get loginname --> 
    $loginname = 'jane1234';


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
              <th>Amount</th>
              <th>Payment</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>2017 May 1</td>
              <td>$20</td>
              <td>VISA - 6200999988887777</td>
            </tr>
            <tr>
              <td>Column content</td>
              <td>Column content</td>
              <td>Column content</td>
            </tr>
            
          </tbody>
        </table> 
        
        </div>
    </div>
</div>


 
<?php 

include_once "footer.php";

?>