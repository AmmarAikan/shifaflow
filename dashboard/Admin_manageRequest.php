<?php
require_once('header.php');
require_once('validate_sess.php');
require_once('nav.php');

// require_once('nav.php');
?>

<!-- main change -->
  <div class="row">
        <div class="col-md-2">
            </div>
        <div class="col-md-10">
            <div class="row">
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style='direction: rtl;width:100%;'>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <!-- <h1 class="h2">News</h1> -->
        <!-- <?php
            if($_SESSION['adminName'])
            {
                $name = $_SESSION['adminName'];
                echo "<span class='navbar-brand col-md-3 col-lg-3 me-0 px-2 ' style='font-weight:bold;font-size: 30px;'>   مرحبا : $name</span>";
            }
        ?> -->
        <a href="./allrequest2.php" class="btn btn-primary" style="margin-right: 1180px;">الطلبات السابقة</a>
    </div>
    <div style="padding:4px;margin:10px; background-color:rgb(94, 162, 240);"><h2>ادارة الجلسات</h2></div>
    <div class="table-responsive" >
        <table class="table table-striped table-sm" >
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"> رقم الجلسة </th>
                    <!-- <th scope="col">رقم الدك</th> -->
                    <th scope="col"> رقم المريض </th>
                    <th scope="col"> تاريخ الجلسة</th>
                    <th scope="col"> اسم الدكتور</th>
                    
                </tr>
                </div>
            </thead>
            <tbody>
                <?php
                $tim =  date("Y-m-d");
                require_once('../config.php');
                $phon = $_SESSION['adminId'];
                $sql = "SELECT * FROM requests where reuest_statue='waiting' ORDER BY session_id DESC";
                $exe = mysqli_query($conn, $sql);
                if (!$exe) {
                    die("Selected Erorr" .mysqli_error($conn));
                }
                while ($row = mysqli_fetch_assoc($exe)) {
                    $id = $row['requests_id'];
                    $doctorName = $row['doctor_name'];
                    $patient_id = $row['sic_id'];
                    $session_id = $row['session_id'] ;
                    $session_date = $row['dateSession'];
                    // $session_treatment = $tim;
                    // $seDate = explode(" ",$session_date);

                     //reorder date
                    //  $orderdate="";
                    //  $splitdate = explode("-",$seDate[0]);
                    //  for($i=2; $i>=0 ; $i=$i-1){
                    //     $orderdate =$orderdate. "-". $splitdate[$i];
                    //  }   
                    
                    // $seDate = strrev($seDate );
                    // $finished = strnatcmp($tim,$seDate[0])>0;
                    echo "
                    <tr>
                    <td>$id</td>
                    <td>$session_id</td>
                    <td>$patient_id</td>
                    
                    <td>$session_date</td>
                    <td>$doctorName</td>
                   
                    ";
                    $accept=1;
                    $refuse=0;
                    
                    
                       echo " <td><a href='./editReqest.php?val=$session_id & st=$refuse' class='btn btn-danger'>رفض الطلب </a></td>";
                       echo " <td><a href='./editReqest.php?val=$session_id & st=$accept' class='btn btn-success'> موافقة على الطلب</a></td>";
                      
                   

                    echo "</tr>";
              
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
    </div>
</main>
<!-- end main  -->
<?php
require_once('footer.php');
?>