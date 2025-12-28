<?php
require_once('header.php');
require_once('nav.php');
?>
<?php
$id = $_GET['newsId'];
require_once('./config.php');
$sql = "select * from news where nwes_id = $id";
$exe = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($exe)){
    $title = $row['news_title'];
    $date = $row['news_date'];
    $text = $row['news_text'];
    $type = $row['news_type'];
    $img = $row['news_img'];
    echo "
    <div class='row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative'>
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
require_once('footer.php');
?>