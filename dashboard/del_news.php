<?php
require('../config.php');
$n=$_GET['val'];
$exe=mysqli_query($conn,"delete from news where nwes_id = $n");
if(!$exe)
{
    echo "error" . mysqli_error($conn);
}
header("location:news.php");
mysqli_close($conn);
?>