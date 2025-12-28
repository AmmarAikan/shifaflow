<?php
require_once('header.php');
// require_once('nav.php');
?>
        <!-- main  -->
 <!-- Background Video-->
             
        <div class="row aboutt" >
                <div class="col-2"></div>
                <div class="col-8">
                <h1>About Us</h1>
                <?php
                        require_once('config.php');
                        $sql="select * from about_us order by about_id desc";
                        $exe=mysqli_query($conn,$sql);
                        $row=mysqli_fetch_assoc($exe);
                        $text=$row['about_text'];
                        echo "<p>$text</p>";
                        mysqli_close($conn);
                ?>
                </div>
                <div class="col-2"></div>
        </div>
        <!-- <div class="video-background">
 <video class="bg-video" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop"><source src="assets/mp4/background.mp4" type="video/mp4" /></video> -->

</div>
        <!-- <div style="height: 450px;"> -->

</div>
        <?php
require_once('footer.php');
?>