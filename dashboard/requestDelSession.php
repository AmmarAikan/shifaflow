<?php
require('../config.php');

$sic_id=$_GET['PatId'];
$SessionDate=$_GET['SDate'];
$n=$_GET['val'];
$Dn=$_GET['Dn'];
$sql = "insert into requests(sic_id,doctor_name,session_id,reuest_statue,dateSession)
                values('$sic_id','$Dn','$n','waiting','$SessionDate')";
$exe=mysqli_query($conn,$sql);
if($exe)
{
echo "<script>alert('   تم ارسال الطلب');</script>";
   header("location:patientPage.php");
}
else{
     echo "error" . mysqli_error($conn);
}


mysqli_close($conn);
?>