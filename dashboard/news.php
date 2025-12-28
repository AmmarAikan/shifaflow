<?php
require_once('header.php');
require_once('nav.php');
?>
<!-- main change -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">News</h1>
        <a href="./add_news.php" class="btn btn-primary">Add News</a>
    </div>
    <h2>Mange Nwes</h2>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">News Title</th>
                    <th scope="col">Date</th>
                    <th scope="col">News Text</th>
                    <th scope="col">Type</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once('../config.php');
                $sql = "SELECT * FROM news ORDER BY news_date DESC";
                $exe = mysqli_query($conn, $sql);
                if (!$exe) {
                    die("Selected Erorr" .mysqli_error($conn));
                }
                while ($row = mysqli_fetch_assoc($exe)) {
                    $id = $row['nwes_id'];
                    $title = $row['news_title'];
                    $date = $row['news_date'];
                    $text = substr($row['news_text'],0,150) ;
                    $type = $row['news_type'];
                    echo "
                    <tr>
                    <td>$id</td>
                    <td>$title</td>
                    <td>$date</td>
                    <td>$text</td>
                    <td>$type</td>
                    <td><a href='./edit_news.php?val=$id' class='btn btn-info'>Edit</a></td>
                    <td><a href='./del_news.php?val=$id' class='btn btn-danger'>Del</a></td>
                    </tr>
                    ";
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
</main>
<!-- end main  -->
<?php
require_once('footer.php');
?>