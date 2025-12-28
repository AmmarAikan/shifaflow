<?php
require_once('header.php');
require_once('nav.php');
?>
        <!-- main  -->
        <div class="row">
            <div class="containar">
                <div style="margin-top:20px;margin-bottom:20px;" class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- list group  -->
                                <?php
                                require_once('list.php');
                                ?>
                            </div>
                        </div>
                        <div style="margin-top:20px;" class="row">
                            <div class="col-md-12">
                                <!-- Search -->
                                <?php
                                require_once('search.php');
                                ?>
                            </div>
                        </div>
                        <div style="margin-top:20px;" class="row">
                            <div class="col-md-12">
                                <!-- FaceBook  -->
                            <?php
                                require_once('face.php');
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <?php
                                    require_once('config.php');
                                    $sql="select * from news order by news_date desc";
                                    $exe=mysqli_query($conn,$sql);
                                    if(!$exe){
                                        echo "Error" . mysqli_error($conn);
                                    }
                                    while($row=mysqli_fetch_assoc($exe)){
                                    $id = $row['nwes_id'];
                                    $title=$row['news_title'];
                                    $type=$row['news_type'];
                                    $date=$row['news_date'];
                                    $text=substr($row['news_text'],0,250)."    <a href='read_more.php?newsId=$id' class='stretched-link'>Continue reading</a>";
                                    $img=$row['news_img'];
                                    echo "
                                    <div
                                    class='row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative'>
                                    <div class='col p-4 d-flex flex-column position-static'>
                                        <strong class='d-inline-block mb-2 text-primary'>$type</strong>
                                        <h3 class='mb-0'>$title</h3>
                                        <div class='mb-1 text-muted'>$date</div>
                                        <p class='card-text mb-auto'>$text</p>
                                    </div>
                                    <div class='col-auto d-none d-lg-block'>
                                    <img src='./dashboard/news_uplode/$img' alt='' srcset='' width='270' height='250'>
                                    </div>
                                </div>
                                    ";
                                    }
                                    mysqli_close($conn);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
require_once('footer.php');
?>