<?php
require_once('header.php');
?>
<!-- main change -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h2>Edit News</h2>
    <hr>
    <?php
        if(isset($_GET['val'])){
        $news_id = $_GET['val'];
        require_once('../config.php');
        $sql = "select * from news where nwes_id = $news_id";
        $exe = mysqli_query($conn, $sql);
        if (!$exe) {
        die("Selected Erorr" . mysqli_error($conn));
        }
        $row = mysqli_fetch_assoc($exe);
    if(isset($_POST['edit_news']))
    {
        if (isset($_FILES['news_uplode']) && !empty($_FILES['news_uplode']['tmp_name'])) {
            $folder ="./news_uplode/";
            $img = $_FILES['news_uplode']['name'];
            $tmp = $_FILES['news_uplode']['tmp_name'];
            $title = $_POST['news_title'];
            $date = $_POST['news_date'];
            $text = $_POST['news_text'];
            $text_r=str_replace("'","''","$text");
            $type = $_POST['news_type'];
            $sql = "UPDATE `news` SET `news_title` = '$title', `news_date` = '$date', 
                `news_text` = '$text_r', `news_type` = '$type' , `news_img` = '$img' WHERE `news`.`nwes_id` = $news_id";
            $exe = mysqli_query($conn,$sql);
            if(!$exe){
                echo "U Error" . mysqli_error($conn);
            }
            else{
                move_uploaded_file($tmp,$folder.$img);
                header('location:news.php');
            }    
        }
            else {
                $title = $_POST['news_title'];
                $date = $_POST['news_date'];
                $text = $_POST['news_text'];
                $text_r=str_replace("'","''","$text");
                $type = $_POST['news_type'];
                $sql = "UPDATE `news` SET `news_title` = '$title', `news_date` = '$date', 
                `news_text` = '$text_r', `news_type` = '$type' WHERE `news`.`nwes_id` = $news_id";
                $exe = mysqli_query($conn,$sql);
                if(!$exe){
                    echo "Update Error" . mysqli_error($conn);
                }
                else {
                    header('location:news.php');
                }
            }
    }}
    mysqli_close($conn);
    ?>
    <form name="News" id="add_ne" action="" method="POST" enctype="multipart/form-data">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <td><label class="form-label">News Title:</label></td>
                    <td><input class="form-control" id="title" type="text" 
                    name="news_title" value="<?php echo $row['news_title']; ?>"></td>
                </tr>
                <tr>
                    <td><label>News Date:</label></td>
                    <td><input class="form-control" id="date" type="datetime-local"
                    name="news_date" value="<?php echo $row['news_date']; ?>"></td>
                </tr>
                <tr>
                    <td><label>News Text:</label></td>
                    <td><textarea name="news_text" id="editor"><?php echo $row['news_text']; ?></textarea>
                        <script>
                            ClassicEditor
                                .create(document.querySelector('#editor'))
                                .then(editor => {
                                    console.log(editor);
                                    })
                                .catch(error => {
                                    console.error(error);
                                    });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td><label>News Type:</label></td>
                    <td id="ff">
                        <input type="text" class="form-control" value="<?php echo $row['news_type'];  ?>" onclick="noned();">
                    </td>
                    <td id="f">
                        <select name="news_type" id="type">
                        <option value="<?php echo $row['news_type'];  ?>"></option>
                        <option value="World">World</option>
                        <option value="Political">Political</option>
                        <option value="Economic">Economic</option>
                        <option value="Sport">Sport</option>
                        <option value="History">History</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Uplode News Image:</td>
                    <td><img class="w-50 h-50 my-2" src="./news_uplode/<?php echo $row['news_img']; ?>"  height="230px">
                        <label id="format"><input class="form-control" type="file" name="news_uplode">
                        The allowed formats here are (jpg,png,svg)</label></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                    <input class="btn btn-success" type="submit" value="Update" name="edit_news">
                    <a href="./news.php" class="btn btn-danger">Cancel</a>
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