<?php
require_once('header.php');
// require_once('nav.php');
require_once('validate_sess.php');
?>






<?php
$E_user_name = "";
$E_password1 = "";
$E_password2 = "";  
$E_eq = "";
$E_email = "";
$E_phone = "";
$E_gender ="";
$E_doctor = "";
        if(isset($_POST['reg'])){
            // require_once('config.php');
            require_once('../config.php');
            // $name = $_POST['user_name'];
            // $password1 = $_POST['user_password1'];
            // $password2 = $_POST['user_password2'];
            // $email = $_POST['user_email'];
            // $phone = $_POST['user_tel'];
            // $gender = $_POST['user_gender'];
            $doctor = $_POST['doctorName'];
            // $address = $_POST['address'];
            $date = $_POST['pationt_brith'];


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
                if (empty($name) ) {

                $E_user_name = "You must enter the name or Enter only ALPHABET characters";
                // echo "<script>alert( 'You must enter the name or Enter only ALPHABET characters' )</script>";
            }
            elseif (empty($password1) || !$uppercase || !$lowercase || !$number
                || !$specialChars || strlen($password1) < 4 ) {
                    $E_password1 = "Password should be at least 4 characters in length and should include at least one upper case letter, one number, and one special character";
                // echo "<script>alert( 'Password should be at least 4 characters in length 
                // and should include at least one upper case letter, one number, and one special character' )</script>";
            } elseif (empty($password2)) {
                $E_password2 = "You must enter the confirming password";
                // echo "<script>alert( 'You must enter the confirming password' )</script>";
            } elseif ($password2 !== $password1) {
                $E_eq = 'Your confirming password is not correct';
                // echo "<script>alert( 'Your confirming password is not correct' )</script>";
            } elseif (empty($email) || (!filter_var($email, FILTER_VALIDATE_EMAIL))
            // (!preg_match("\w+@(gmail|hotmail|yahoo).(com|net|org)$", $email))
            ) {
                $E_email = 'Your email is either empty or Enter only with EMAIL FORMAT';
                // echo "<script>alert( 'Your email is either empty or Enter only with EMAIL FORMAT' )</script>";
            } elseif (empty($phone) || (!(ctype_digit($phone))) || strlen($phone) < 9) {
                $E_phone = 'Your phone is either empty or Enter only NUMERIC data';
                // echo "<script>alert( 'Your phone is either empty or Enter only NUMERIC data' )</script>";
            } elseif (empty($gender)) {
                $E_gender = "You must choease the gender";
                // echo "<script>alert( 'You must choease the gender' )</script>";
            }
            // elseif (strlen($doctor) == 1) {
            //     $E_doctor = "You must choease the doctor";
            //     // echo "<script>alert( 'You must choease the doctor' )</script>";
            // }
            // else if(isset($_FILES['user_uplode']) && empty($_FILES['user_uplode']['tmp_name'])) {
              
               
              
              $doctor_Id=0;
              $sql="select * from regist where R_name='$doctor' ";
              $exe=mysqli_query($conn,$sql);
              // $row=mysqli_fetch_assoc($exe);
              
              while($row = mysqli_fetch_assoc($exe))
                 { $doctor_Id=$row['R_phone'];

              }
              
                
               
               
                                   
                $sic_id=$_SESSION['adminId'];

                // $password2 = md5($_POST['user_password2']);
                $sql = "insert into session(sic_id,doctor_name,doctor_id,session_date)
                values('$sic_id','$doctor','$doctor_Id','$date')";
                $result = mysqli_query($conn,$sql);
                if($result){
                    // header('Location:index.php');
                    echo "<script>alert('تم حجز الجلسة بنجاح');</script>";
                    
                    
                }
                if(!$result){
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
        <h3>إنشاء جلسة جديدة</h3>
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

                <tr>
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
                        </tr>
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
                                    <td><label>تاريخ الجلسة:</label></td>
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
                        <input class="btn btn-primary" type="submit" value="انشاء جلسة " name="reg">
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