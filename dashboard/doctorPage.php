<?php
// require_once('header.php');
require_once('validate_sess.php');

// require_once('nav.php');
?>

<?php
require_once('validate_sess.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!--My Css -->
    <link rel="stylesheet" href="./css/mystyle.css">
    
</head>

<body >

    <!-- navigator -->
    <nav class=" navbar navbar-expand-lg bg-body-tertiary"
        style="background-color: #091629 ; direction: rtl;z-index: 1000;">
        <div class="container-fluid">
            <a class="navbar-brand " href="#" style="color: white;">
                <h2>دار الشفاء</h2>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class=" nav-link active " aria-current="page" href="index.php"
                            style="color: white;">الرئيسية</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="featuers_us.php" style="color: white;">مميزاتنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact_us.php" style="color: white;">التواصل</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="about_us.php" style="color: white;">عن العيادة</a>
                    </li>
                    <!-- <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true"style="color: white;">Disabled</a>
          </li> -->
                </ul>
            </div>

           
          
        <div class="navbar-nav">
        <!-- <a class="nav-link px-3" href="./patientPage.php" style="color:white;">صفحتي </a> -->
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="./sign_out.php" style="color:white;">خروج </a>
                
            </div>
            
        </div>
    </nav>
    <!-- navigator -->

<!-- main change -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style='direction: rtl;width:100%;'>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <!-- <h1 class="h2">News</h1> -->
        <?php
            if($_SESSION['adminName'])
            {
                $name = $_SESSION['adminName'];
                echo "<span class='navbar-brand col-md-3 col-lg-3 me-0 px-2 ' style='font-weight:bold;font-size: 30px;'>      مرحبا دكتور/ة  :  $name</span>";
            }
        ?>
        <div style="margin-top:20px;" class="row">
                            <div class="col-md-12">
                                <!-- Search -->
                                <?php
                                require_once('search.php');
                                // echo "<span class='navbar-brand col-md-3 col-lg-3 me-0 px-2 ' style='font-weight:bold;font-size: 30px;'>      مرحبا دكتور/ة  :  $name</span>";

                                ?>
                            </div>
                        </div>
        <!-- <a href="./newSession.php" class="btn btn-primary">إنشاء جلسة جديدة</a> -->
    </div>
    <div style="padding:4px;margin:10px; background-color:green;"><h2>تفاصيل الجلسات</h2></div>
    <div class="table-responsive" >
        <table class="table table-striped table-sm" >
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">اسم الدكتور </th>
                    <th scope="col">رقم المريض </th>
                    <!-- <th scope="col">رقم الدك</th> -->
                    <th scope="col">تاريخ الجلسة </th>
                    <th scope="col">تاريخ العودة</th>
                    <th scope="col">علاج الجلسة من الدكتور</th>
                    <!-- <th scope="col">طلب اللغاء</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $tim =  date("Y-m-d");
                require_once('../config.php');
                $phon = $_SESSION['adminId'];
                $sql = "SELECT * FROM session where doctor_id='$phon' ORDER BY session_id DESC";
                $exe = mysqli_query($conn, $sql);
                if (!$exe) {
                    die("Selected Erorr" .mysqli_error($conn));
                }
                while ($row = mysqli_fetch_assoc($exe)) {
                    $id = $row['session_id'];
                    $doctorName = $row['doctor_name'];
                    // $doctorId = $row['doctor_id'];
                    $session_date = $row['session_date'] ;
                    $session_return_date = $row['session_return_date'];
                    $session_treatment = $row['session_treatment'];;
                    $seDate = explode(" ",$session_date);
                    $sicId = $row['sic_id'];

                     //reorder date
                    //  $orderdate="";
                    //  $splitdate = explode("-",$seDate[0]);
                    //  for($i=2; $i>=0 ; $i=$i-1){
                    //     $orderdate =$orderdate. "-". $splitdate[$i];
                    //  }   
                    
                    // $seDate = strrev($seDate );
                    $finished = strnatcmp($tim,$seDate[0])>0;
                    echo "
                    <tr>
                    <td>$id</td>
                    <td>$doctorName</td>
                    <td>$sicId</td>

                  
                    <td>$session_date</td>
                    <td>$session_return_date</td>
                    <td>$session_treatment</td>";
                    
                    
                    if(!$finished){
                    //    echo " <td><a href='./del_news.php?val=$id' class='btn btn-danger'>$seDate[0] / $tim اللغاء الجلسة</a></td>";
                       echo " <td><a href='./medical_advice.php?val=$id & Dn=$doctorName & PatId=$phon & SDate=$session_date' class='btn btn-success'>  الارشاد الطبي</a></td>";
                      
                    }else{
                       echo " <td><a href='' class='btn btn-danger'> انتهت</a></td>";
                        }

                    echo "</tr>";
                    
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</main>
<!-- end main  -->
<?php
require_once('footer.php');
?>