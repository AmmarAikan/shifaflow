<?php
require('../config.php');

$reply=$_GET['st'];
// $sic_id=$_GET['PatId'];
// $SessionDate=$_GET['SDate'];
$n=$_GET['val'];
// $Dn=$_GET['Dn'];
$accept='accept';
$refuse='refuse';
echo "<script>console.log( $accept);</script>";

if($reply==='1'){
  
  $sql = "update requests set reuest_statue='$accept' where  session_id='$n' ";
$exe=mysqli_query($conn,$sql);
if($exe)
{
 $exe=mysqli_query($conn,"delete from session where session_id = $n");

echo "<script>alert('   تم ارسال الطلب');</script>";
   header("location:Admin_manageRequest.php");
}
else{
     echo "error" . mysqli_error($conn);
}


mysqli_close($conn);  
}


if($reply==='0'){
    $sql = "update requests set reuest_statue='$refuse' where  session_id='$n' ";
    $exe=mysqli_query($conn,$sql);
    if($exe)
    {
     
    
    echo "<script>alert('   تم ارسال الطلب');</script>";
       header("location:Admin_manageRequest.php");
    }
    else{
         echo "error" . mysqli_error($conn);
    }
    
    
    mysqli_close($conn); 

}

?>