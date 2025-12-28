<?php
require_once('header.php');
require_once('nav.php');
?>
<!-- main change -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h2>Add News</h2>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <form name="News" id="add_ne" action="#" method="POST" enctype="multipart/form-data">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td><label class="form-label">News Title:</label></td>
                                    <td><input class="form-control" id="title" type="text" name="news_title"></td>
                                </tr>
                                <tr>
                                    <td><label>News Date:</label></td>
                                    <td><input class="form-control" id="date" type="datetime-local" name="news_date">
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>News Text:</label></td>
                                    <td><textarea name="news_text" id="editor"></textarea name="">
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
                                    <td><select name="news_type" id="type">
                                            <option>Choose the type of news</option>
                                            <option value="World">World</option>
                                            <option value="World">Political</option>
                                            <option value="Economic">Economic</option>
                                            <option value="Sport">Sport</option>
                                            <option value="History">History</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>Uplode News Image:</td>
                                    <td><label id="format"><input class="form-control" type="file" name="news_uplode">
                                        The allowed formats here are (jpg,png,svg)</label></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                    <input class="btn btn-success" type="submit" value="Add" name="add_news">
                                    <a href="./news.php" class="btn btn-danger">Cancel</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                    <?php
                    if(isset($_POST['add_news'])){
                        require_once('../config.php');
                            $title = $_POST['news_title'];
                            $date = $_POST['news_date'];
                            $text = $_POST['news_text'];
                            $textr = str_replace("'", "''", "$text");
                            $type = $_POST['news_type'];
                            $folder ="./news_uplode/";
                            $img = $_FILES['news_uplode']['name'];
                            $tmp = $_FILES['news_uplode']['tmp_name'];
                            $sql = "INSERT INTO news (news_title, news_date, news_text,news_type,news_img)
                            VALUES ('$title', '$date', '$textr', '$type', '$img')";
                            $exe = mysqli_query($conn,$sql);
                            if(!$exe){
                                echo "Insert Error" . mysqli_error($conn);
                            }
                            move_uploaded_file($tmp,$folder.$img);
                        mysqli_close($conn);
                    }
                    ?>
                </div>
            </div> 
        </div>
    </div>  
</main>
<!-- end main  -->
<?php
require_once('footer.php');
?>