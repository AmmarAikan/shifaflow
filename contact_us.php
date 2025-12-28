<?php
require_once('header.php');
//require_once('nav.php');
?>
        <!-- main  -->
        <div style="margin-top:20px;margin-bottom:20px;direction: rtl;" class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <h3>تواصل معنا</h3>
                <form id="contact" action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <input placeholder="ادخل اسمك " name="name_sender" id="name_s" class="form-control" type="text" onchange="checkC();">
                    </div>
                </div>
                <div style="margin-top:20px;margin-bottom:20px;" class="row">
                    <div class="col-md-12">
                        <input placeholder="ادخل الايميل" name="email_sender" id="email_s" class="form-control" type="email" onchange="checkC();">
                    </div>
                </div>
                <div style="margin-top:20px;margin-bottom:20px;" class="row">
                    <div class="col-md-12">
                        <textarea name="message" rows="10" class="form-control" id="mess_s" onchange="checkC();"></textarea>
                    </div>
                </div>
                <div style="margin-top:20px;margin-bottom:20px;" class="row">
                <div class="col-md-12">
                    <!-- <td>Uplode Image:</td> -->
                    <label id="format"><input class="form-control" type="file" id="user_img" name="user_uplode" onchange="checkImg();">
                            The allowed formats here are (jpg,png,svg,jpeg)</label>
                    </div>
                </div>
                <div style="margin-top:20px;margin-bottom:20px;direction:ltr;" class="row">
                    <div class="col-md-12">
                        <input type="submit" value="ارسال" class="btn btn-success" id="send_c" name="send" >
                    </div>
                </div>
                </form>
                <?php
        if(isset($_POST['send'])){
            require_once('config.php');
            $name=$_POST['name_sender'];
            $email=$_POST['email_sender'];
            $text=$_POST['message'];
            $n_text=str_replace("'","\'","$text");
            if(isset($_FILES['user_uplode']) && empty($_FILES['user_uplode']['tmp_name'])) {
                $sql="insert into contact_us(cont_user_name,cont_user_email,cont_user_text)
                values('$name','$email','$n_text')";
                $exe = mysqli_query($conn,$sql);
                if(!$exe){
                    echo "Insert Error" . mysqli_error($conn);
                }
                mysqli_close($conn);
            }
            else {
                $folder ="./uplode/";
                $img = $_FILES['user_uplode']['name'];
                $tmp = $_FILES['user_uplode']['tmp_name'];
                $sql="insert into contact_us(cont_user_name,cont_user_email,cont_user_text,cont_user_img)
                values('$name','$email','$n_text','$img')";
                $exe = mysqli_query($conn,$sql);
                if(!$exe){
                    echo "Insert Error" . mysqli_error($conn);
                }
                move_uploaded_file($tmp,$folder.$img);
                }
            mysqli_close($conn);
        }
        ?>
            </div>
            <div class="col-md-3"></div>
        </div>
<?php
require_once('footer.php');
?>