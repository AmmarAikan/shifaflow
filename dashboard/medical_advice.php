<?php
// require_once('header.php');
// require_once('nav.php');
// require_once('validate_sess.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دار الشفاء</title>
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
        <a class="nav-link px-3" href="./patientPage.php" style="color:white;">صفحتي </a>
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="./sign_out.php" style="color:white;">خروج </a>
                
            </div>
            
        </div>
    </nav>
    <!-- navigator -->





<?php
$E_user_name = "";
$E_password1 = "";
$E_password2 = "";  
$E_eq = "";
$E_email = "";
$E_phone = "";
$E_gender ="";
$E_doctor = "";
$date = "00:00:00 0000-00-00";
$text="";
echo "<script>console.log( $date);</script>";

        if(isset($_POST['reg'])){
            // require_once('config.php');
            require_once('../config.php');
            // $name = $_POST['user_name'];
            // $password1 = $_POST['user_password1'];
            // $password2 = $_POST['user_password2'];
            // $email = $_POST['user_email'];
            // $phone = $_POST['user_tel'];
            // $gender = $_POST['user_gender'];
            // $doctor = $_POST['doctorName'];
            // $address = $_POST['address'];
            // if($_POST['pationt_brith']){
                $date = $_POST['pationt_brith'];
            // }
            // if($_POST['message']){
                $text=$_POST['message'];
            // }


        //    print "<script>console.log( $date);</script>";

            
            $type = "patient";
            // $type = "Admin";
            // $type = "doctor";

            // password Strong
            // $uppercase = preg_match('@[A-Z]@', $password1);
            // $lowercase = preg_match('@[a-z]@', $password1);
            // $number    = preg_match('@[0-9]@', $password1);
            // $specialChars = preg_match('@[^\w]@', $password1);
            ////////////////////
            // if (empty($name) || (!(ctype_alpha($name)))) {
                // if (empty($name) ) {

                // $E_user_name = "You must enter the name or Enter only ALPHABET characters";
                // echo "<script>alert( 'You must enter the name or Enter only ALPHABET characters' )</script>";
            // }
            // elseif (empty($password1) || !$uppercase || !$lowercase || !$number
                // || !$specialChars || strlen($password1) < 4 ) {
                    // $E_password1 = "Password should be at least 4 characters in length and should include at least one upper case letter, one number, and one special character";
                // echo "<script>alert( 'Password should be at least 4 characters in length 
                // and should include at least one upper case letter, one number, and one special character' )</script>";
            // } elseif (empty($password2)) {
                // $E_password2 = "You must enter the confirming password";
                // echo "<script>alert( 'You must enter the confirming password' )</script>";
            // } elseif ($password2 !== $password1) {
                // $E_eq = 'Your confirming password is not correct';
                // echo "<script>alert( 'Your confirming password is not correct' )</script>";
            // } elseif (empty($email) || (!filter_var($email, FILTER_VALIDATE_EMAIL))
            // (!preg_match("\w+@(gmail|hotmail|yahoo).(com|net|org)$", $email))
            // ) {
                // $E_email = 'Your email is either empty or Enter only with EMAIL FORMAT';
                // echo "<script>alert( 'Your email is either empty or Enter only with EMAIL FORMAT' )</script>";
            // } elseif (empty($phone) || (!(ctype_digit($phone))) || strlen($phone) < 9) {
                // $E_phone = 'Your phone is either empty or Enter only NUMERIC data';
                // echo "<script>alert( 'Your phone is either empty or Enter only NUMERIC data' )</script>";
            // } elseif (empty($gender)) {
                // $E_gender = "You must choease the gender";
                // echo "<script>alert( 'You must choease the gender' )</script>";
            // }
            // elseif (strlen($doctor) == 1) {
            //     $E_doctor = "You must choease the doctor";
            //     // echo "<script>alert( 'You must choease the doctor' )</script>";
            // }
            // else if(isset($_FILES['user_uplode']) && empty($_FILES['user_uplode']['tmp_name'])) {
              
               
              
            //   $doctor_Id=0;
            //   $sql="select * from regist where R_name='$doctor' ";
            //   $exe=mysqli_query($conn,$sql);
            //   // $row=mysqli_fetch_assoc($exe);
              
            //   while($row = mysqli_fetch_assoc($exe))
            //      { $doctor_Id=$row['R_phone'];

            //   }
              
                
               
               
                                   
                $sic_id=$_SESSION['adminId'];
                $n=$_GET['val'];
                // if($date==""){
                //     $date="0000-00-00";
                //     $date = strtotime($date);
                //     $date = date("Y-m-d", $date);
                // }
                // $password2 = md5($_POST['user_password2']);
                if($date==""){
                    $sql = "update session set session_treatment='$text'  where  session_id='$n' ";
                }
               
                if(!$date==""){
                    $sql = "update session set session_treatment='$text' , session_return_date='$date'  where  session_id='$n' ";
                }
                $result = mysqli_query($conn,$sql);
                if($result){
                    
                    echo "<script>alert('تم اضافةالارشاد  بنجاح');</script>";
                    header('Location:doctorPage.php');
                    
                    
                   exit();
                    
                }
                if(!$result){
                    echo "<script>alert('   $date');</script>";
                    echo "Insert Error" . mysqli_error($conn);
                }
                mysqli_close($conn);
            // }
            // else {
            //     $folder ="./Uplode/";
            //     $img = $_FILES['user_uplode']['name'];
            //     $tmp = $_FILES['user_uplode']['tmp_name'];
            //     $password2 = md5($_POST['user_password2']);
            //     $sql = "insert into user(user_name,user_password,user_email,phone,user_gender,user_doctor,user_img,user_type)
            //     values('$name','$password2','$email','$phone','$gender','$doctor','$img','$type')";
            //     $result = mysqli_query($conn,$sql);
            //     if(!$result){
            //         echo "Insert Error" . mysqli_error($conn);
            //     }
            //     move_uploaded_file($tmp,$folder.$img);
            //     mysqli_close($conn);
            // }
        }
        ?>
<!-- main  -->
<div style="margin-top:20px;margin-bottom:20px;" class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8" style="direction: rtl;">
        <h3>الارشاد الطبي للمريض</h3>
        <form name="Register" id="reg"  method="post" enctype="multipart/form-data">
            <table class="table">

                <!-- <tr>
                    <td><label class="form-label">الاسم:</label></td>
                    <td><input class="form-control" id="name" type="text" name="user_name" placeholder="ادخل اسمك الثلاثي"></td>
                    <td>
                        <pre> * </pre>
                    </td>
                    <td style="color: red;">
                        <?php echo $E_user_name;?>
                    </td>
                </tr> -->
                
                <!-- <tr>
                    <td><label>الاييميل:</label></td>
                    <td><input class="form-control" id="email" type="email" name="user_email"></td>
                    <td>
                        <pre> *</pre>
                    </td>
                    <td style="color: red;">
                        <?php echo $E_email;?>
                    </td>
                </tr> -->
                <!-- <tr>
                    <td><label>رقم الهاتف:</label></td>
                    <td><input class="form-control" id="tel" type="tel" name="user_tel" placeholder="Must consist of 9 numbers"></td>
                    <td>
                        <pre> *</pre>
                    </td>
                    <tr>
                    <td><label>كلمة السر:</label></td>
                    <td><input class="form-control" id="pass" type="password" name="user_password1" placeholder="Must be at least 4 characters in uppercase, lowercase, number, symbol"></td>
                    <td>
                        <pre> * </pre>
                    </td>
                    <td style="color: red;">
                        <?php echo $E_password1;?>
                    </td>
                </tr> -->
                <!-- <tr>
                    <td><label>تاكيد كلمة السر:</label></td>
                    <td><input class="form-control" id="pass1" type="password" name="user_password2"></td>
                    <td>
                        <pre> *</pre>
                    </td>
                    <td style="color: red;">
                        <?php echo $E_password2; echo $E_eq;?>
                    </td>
                </tr>


                    <td style="color: red;">
                        <?php echo $E_phone;?>
                    </td>
                </tr> -->

                <!-- <tr>
                <td><label>اسم الدكتور:</label></td>
                <td><select name="doctorName" id="maritalStatu">
                <option>اختر اسم الدكتور  </option>
                
                <?php
                    require_once('../config.php');
                    $sql="select * from regist where R_type='doctor' order by R_id ASC";
                    $exe=mysqli_query($conn,$sql);
                    // $row=mysqli_fetch_assoc($exe);
                    while($row = mysqli_fetch_assoc($exe)){
                        // echo "<option". "value=".'$row["R_name"]' ">". $row["R_name"] . "</option>";
                        printf ("<option value='%s'>  %s </option>",$row["R_name"],$row["R_name"]);


                    }
                    
                    
                    mysqli_close($conn);
                                        ?>
                                        
                                </select></td>
                            <td>
                                <pre> *</pre>
                            </td>
                        </tr> -->
<!-- 
                <tr>
                    <td><label class="form-label">العنوان:</label></td>
                    <td><input class="form-control" id="name" type="text" name="address" placeholder="العنوان"></td>
                    <td>
                        <pre> * </pre>
                    </td> -->
                    <!-- <td style="color: red;">
                        <?php echo $E_user_name;?>
                    </td> -->
                <!-- </tr> -->


                <tr>
                
                    
                        <textarea name="message" rows="10" class="form-control" id="mess_s"></textarea>
                   
                
                </td>

                <tr>
                                    <td><label>تاريخ العودة:</label></td>
                                    <td><input class="form-control" id="date" type="datetime-local" name="pationt_brith">
                                    </td>
                                    <td>
                        <pre> *</pre>
                    </td>
                                </tr>
                                


                <!-- <tr>
                    <td><label>الجنس:</label></td>
                    <td>
                        <input class="form-check-input" id="gender" type="radio" name="user_gender" value="Male">ذكر
                        <input class="form-check-input" id="gender" type="radio" name="user_gender" value="Female">انثى
                    </td>
                    <td>
                        <pre> *</pre>
                    </td>
                    <td style="color: red;">
                        <?php echo $E_gender;?>
                    </td>
                </tr> -->
                <!-- <tr>
                    <td><label>:</label></td>
                    <td><select name="user_doctor" id="doctor">
                            <option value="w">Choose your doctor</option>
                            <option value="Yemen">Yemen</option>
                            <option value="China">China</option>
                            <option value="KSA">KSA</option>
                        </select></td>
                    <td>
                        <pre> *</pre>
                    </td>
                    <td style="color: red;">
                        <?php echo $E_doctor;?>
                    </td>
                </tr> -->
                <!-- <tr>
                    <td>Uplode Image:</td>
                    <td><label id="format"><input class="form-control" type="file" id="user_img" name="user_uplode" onchange="checkImg();">
                            The allowed formats here are (jpg,png,svg,jpeg)</label></td>
                </tr> -->
                <!-- <tr>
                    <td><label class="form-check-label">موافق:</label> </td>
                    <td><input class="form-check-input" type="checkbox" name="agree" onclick="theChecker();">
                    </td>
                </tr> -->
                <tr>
                    <td></td>
                    <td>
                        <input class="btn btn-primary" type="submit" value="موافق " name="reg" style="margin-right:250px; width:150px">
                    </td>
                </tr>
            </table>
        </form>
        
    </div>
    <div class="col-md-2"></div>
</div>
<?php
require_once('footer.php');
?>