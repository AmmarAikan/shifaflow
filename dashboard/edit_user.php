<?php
require_once('header.php');
?>
<!-- main change -->
<main class="col-md-9 ms-sm-auto col-lg-11 px-md-4">
    <h2>Edit Patient</h2>
    <hr>
    <?php
    if (isset($_GET['eu'])) {
    $id = $_GET['eu'];
    require_once('../config.php');
    $sql = "select * from regist where R_id = '$id'";
    $exe = mysqli_query($conn,$sql);
    if (!$exe) {
        echo("Selected Erorr" . mysqli_close($conn));
    }
    $row = mysqli_fetch_assoc($exe);
    $id = $row['R_id'];
    $name = $row['R_name'];
    $email = $row['R_Email'];
    $phone = $row['R_phone'];
    $password = $row['R_password'];
    $address = $row['R_address'];
    $brithday = $row['R_brith'];
    $gender = $row['R_gender'];
    $type = $row['R_type'];
        if(isset($_POST['save_edit'])){
                    $id = $_POST['myid'];
                    $name = $_POST['user_name'];
                    $email = $_POST['user_email'];
                    $phone = $_POST['user_tel'];
                    $password = md5($_POST['user_password2']);
                    $address = $_POST['user_address'];
                    $brithday = $_POST['pationt_brith'];
                    $gender = $_POST['user_gender'];
                    $type = $_POST['user_per'];
                    $sql = "update regist set R_name = '$name', R_Email = '$email', R_phone = '$phone',
                    R_password = '$password', R_address = '$address', R_brith = '$brithday', R_gender = '$gender' , 
                    R_type = '$type'  WHERE R_id = $id";
                    $exe = mysqli_query($conn,$sql);
                    if(!$exe){
                        echo "Update Error" . mysqli_error($conn);
                    }
                    else {
                        echo '<meta http-equiv="refresh" content="0;url=users.php">';
                        exit();
                    }
                    }
                // else {
                //     $id = $_POST['myid'];
                //     $name = $_POST['user_name'];
                //     $password = md5($_POST['user_password2']);
                //     $email = $_POST['user_email'];
                //     $phone = $_POST['user_tel'];
                //     $gender = $_POST['user_gender'];
                //     $country = $_POST['user_country'];
                //     $type = $_POST['user_per'];
                //     $sql = "update user set user_name = '$name', user_password = '$password', user_email = '$email',
                //     phone = '$phone', user_gender = '$gender', user_country = '$country', user_type = '$type' , 
                //     user_img = '$img'  WHERE user_id = $id";
                //     $exe = mysqli_query($conn,$sql);
                //     if(!$exe){
                //         echo "Update Error" . mysqli_error($conn);
                //     }
                //     else {
                //         header('location:users.php');
                //     }
                // }      
            
    }
    mysqli_close($conn);
    ?>
    <form name="User" id="edit_user" action="" method="POST" enctype="multipart/form-data">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <td><label class="form-label">Name:</label></td>
                    <td><input class="form-control" id="name" type="text" value="<?php echo $name; ?>" name="user_name" placeholder="FristName MiddlelName LastName"></td>
                </tr>
                <tr>
                    <td><label>Email:</label></td>
                    <td><input class="form-control" id="email" type="email" value="<?php echo $email; ?>" name="user_email"></td>
                </tr>
                <tr>
                    <td><label>Phone Number:</label></td>
                    <td><input class="form-control" id="tel" type="tel" value="<?php echo $phone; ?>" name="user_tel" placeholder="Must consist of 9 numbers"></td>
                </tr>
                    <td><label>Password:</label></td>
                    <td><input class="form-control" id="pass" type="text" value=" <?php echo $password; ?>" name="user_password1" placeholder="Must be at least 4 characters in uppercase, lowercase, number, symbol">
                    </td>
                </tr>
                <tr>
                    <td><label>Confirm Password:</label></td>
                    <td><input class="form-control" id="pass1" type="password" value="<?php echo $password; ?>" name="user_password2"></td>
                </tr>
                <tr>
                    <td><label>Address:</label></td>
                    <td><input class="form-control" id="add" type="add" value="<?php echo $address;?>" name="user_address" placeholder="Address"></td>
                </tr>
                <tr>
                    <td><label> date of brith:</label></td>
                    <td><input class="form-control" id="date" type="datetime-local" value = "<?php echo $brithday; ?>" name="pationt_brith">
                    </td>
                    <td>
                <pre> *</pre>
                </td>
                <tr>
                    <td><label>Gender:</label></td>
                    <td>
                        <input type="text" class="form-control" value="<?php echo $gender; ?>" disabled>
                        <input type="text" hidden class="form-control" name="user_gender" value="<?php echo $gender; ?>">
                        <input class="form-check-input" id="gender" type="radio" name="user_gender" value="Male">Male
                        <input class="form-check-input" id="gender" type="radio" name="user_gender" value="Female">Female
                    </td>
                </tr>
                <tr>
                    <td><label>Permission:</label></td>
                    <td><select name="user_per" id="per">
                            <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
                            <option value="Admin">Admin</option>
                            <option value="patient">patient</option>
                            <option value="doctor">doctor</option>
                        </select></td>
                </tr>
                    <td><input type="text" hidden name="myid" value = "<?php echo $id; ?>"></td>
                    <td>
                        <input class="btn btn-success" type="submit" value="Update User" name="save_edit">
                        <a href="./users.php" class="btn btn-danger">Cancel</a>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</main>
<!-- end main  -->
<?php
require_once('footer.php');
?>