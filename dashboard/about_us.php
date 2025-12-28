<?php
require_once('header.php');
require_once('nav.php');
?>
<!-- main change -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h2>About Us</h2>
    <hr>
    <div class="row">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <form name="about_us" id="add_about_us" action="#" method="post">
                        <h5>About Us Text:</h5>
                        <textarea name="about_text" id="editor" style="width:500px; height:300px;"></textarea>
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
                            <br>
                            <input class="btn btn-success" type="submit" value="Add" name="add_about">
                    </form>       
                </div>
                    <?php
                    if(isset($_POST['add_about'])){
                        require_once('../config.php');
                        $text = $_POST['about_text'];
                        $textr = str_replace("'", "''", "$text");
                        $sql = "insert into about_us(about_text)values('$textr')";
                        $exe = mysqli_query($conn,$sql);
                        if(!$exe){
                            echo "Inserted Error" . mysqli_error($conn);
                        }
                        else {
                            echo "<script>alert('Success')</script>";
                        }
                        mysqli_close($conn);
                    }
                    ?>
            </div>
        </div> 
    </div> 
</main>
<!-- end main  -->
<?php
require_once('footer.php');
?>