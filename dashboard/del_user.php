<?php
$user_id = $_GET['du'];
require_once('../config.php');
$sql = "delete from regist where R_id = $user_id ";
$exe = mysqli_query($conn,$sql);
if(!$exe) {
    echo "Error delete" .mysqli_error($conn);
}
header('location:users.php');
mysqli_close($conn);
?>