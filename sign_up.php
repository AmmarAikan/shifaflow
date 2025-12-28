<?php
require_once('header.php');
//require_once('nav.php');

?>
<?php
$E_user_name = "";
$E_password1 = "";
$E_password2 = "";
$E_eq = "";
$E_email = "";
$E_phone = "";
$E_gender ="";
$E_country = "";
        if(isset($_POST['ok'])){
            require_once('config.php');
            $name = $_POST['user_name'];
            $password1 = $_POST['user_password1'];
            $password2 = $_POST['user_password2'];
            $email = $_POST['user_email'];
            $phone = $_POST['user_tel'];
            $gender = $_POST['user_gender'];
            // $country = $_POST['user_country'];
            $address = $_POST['address'];
            $brithday = $_POST['pationt_brith'];


            $type = "patient";
            // $type = "Admin";
            // $type = "doctor";

            // password Strong
            $uppercase = preg_match('@[A-Z]@', $password1);
            $lowercase = preg_match('@[a-z]@', $password1);
            $number    = preg_match('@[0-9]@', $password1);
            $specialChars = preg_match('@[^\w]@', $password1);
            ////////////////////
            // if (empty($name) || (!(ctype_alpha($name)))) {
                if (empty($name) ) {

                $E_user_name = "يجب ان يحتوي فقط على حروف";
                // echo "<script>alert( 'You must enter the name or Enter only ALPHABET characters' )</script>";
            }
            elseif (empty($password1) || !$uppercase || !$lowercase || !$number
                || !$specialChars || strlen($password1) < 5 ) {
                    $E_password1 = "يجب الا تقل كلمة السر عن خمسة احرف تحتوي على احرف كبيرة وصغيرة ورموز وارقام";
                // echo "<script>alert( 'Password should be at least 4 characters in length 
                // and should include at least one upper case letter, one number, and one special character' )</script>";
            } elseif (empty($password2)) {
                $E_password2 = "يجب تاكيد كلمة السر";
          
            } elseif ($password2 !== $password1) {
                $E_eq = 'لا تتطابق كلمة السر';
            
            } elseif (empty($email) || (!filter_var($email, FILTER_VALIDATE_EMAIL))
   
            ) {
                $E_email = 'يجب كتابة الايميل و بشكل صحيح';
               
            } elseif (empty($phone) || (!(ctype_digit($phone))) || strlen($phone) < 9) {
                $E_phone = 'ادخال رقم الهاتف ولا يقل عن تسعة ارقام';
              
            } elseif (empty($gender)) {
                $E_gender = "يجب اختيار الجنس";
             
            }
        
                $password2 = md5($_POST['user_password2']);
                $sql = "insert into regist(R_name,R_Email,R_phone,R_password,R_address,R_brith,R_gender,R_type)
                values('$name','$email','$phone','$password2','$address','$brithday','$gender','$type')";
                $result = mysqli_query($conn,$sql);
                if($result){
                    header('location:dashboard/sign_in.php');
                    exit;
                }
                if(!$result){
                    echo "Insert Error" . mysqli_error($conn);
                }
                mysqli_close($conn);
          
        }
        ?>
<!-- main  -->
<div style="margin-top:20px;margin-bottom:20px;" class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8" style="direction: rtl;">
        <h3>Register on the site</h3>
        <form name="Register" id="reg" action="sign_up.php" method="post" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <td><label class="form-label">الاسم:</label></td>
                    <td><input class="form-control" id="name" type="text" name="user_name" placeholder="ادخل اسمك الثلاثي"></td>
                    <td>
                        <pre> * </pre>
                    </td>
                    <td style="color: red;">
                        <?php echo $E_user_name;?>
                    </td>
                </tr>
                
                <tr>
                    <td><label>الاييميل:</label></td>
                    <td><input class="form-control" id="email" type="email" name="user_email"></td>
                    <td>
                        <pre> *</pre>
                    </td>
                    <td style="color: red;">
                        <?php echo $E_email;?>
                    </td>
                </tr>
                <tr>
                    <td><label>رقم الهاتف:</label></td>
                    <td><input class="form-control" id="tel" type="tel" name="user_tel" placeholder="يحتوي على تسعة ارقام"></td>
                    <td>
                        <pre> *</pre>
                    </td>
                    <tr>
                    <td><label>كلمة السر:</label></td>
                    <td><input class="form-control" id="pass" type="password" name="user_password1" placeholder="يجب الا تقل كلمة السر عن خمسة احرف تحتوي على احرف كبيرة وصغيرة ورموز وارقام"></td>
                    <td>
                        <pre> * </pre>
                    </td>
                    <td style="color: red;">
                        <?php echo $E_password1;?>
                    </td>
                </tr>
                <tr>
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
                </tr>

                <tr>
                    <td><label class="form-label">العنوان:</label></td>
                    <td><input class="form-control" id="name" type="text" name="address" placeholder="العنوان"></td>
                    <td>
                        <pre> * </pre>
                    </td>
                    <!-- <td style="color: red;">
                        <?php echo $E_user_name;?>
                    </td> -->
                </tr>

                <tr>
                                    <td><label>تاريخ الميلاد:</label></td>
                                    <td><input class="form-control" id="date" type="datetime-local" name="pationt_brith">
                                    </td>
                                    <td>
                        <pre> *</pre>
                    </td>
                                </tr>
                                


                <tr>
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
                </tr>
                <!-- <tr>
                    <td><label>:</label></td>
                    <td><select name="user_country" id="country">
                            <option value="w">Choose your country</option>
                            <option value="Yemen">Yemen</option>
                            <option value="China">China</option>
                            <option value="KSA">KSA</option>
                        </select></td>
                    <td>
                        <pre> *</pre>
                    </td>
                    <td style="color: red;">
                        <?php echo $E_country;?>
                    </td>
                </tr> -->
                <!-- <tr>
                    <td>Uplode Image:</td>
                    <td><label id="format"><input class="form-control" type="file" id="user_img" name="user_uplode" onchange="checkImg();">
                            The allowed formats here are (jpg,png,svg,jpeg)</label></td>
                </tr> -->
                <tr>
                    <td><label class="form-check-label">موافق:</label> </td>
                    <td><input class="form-check-input" type="checkbox" name="agree" onclick="theChecker();">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input class="btn btn-primary"  type="submit" value="انشاء حساب" name="ok">
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

