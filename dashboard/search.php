<form method="GET">
    <input style="margin-bottom:10px;" name="find" placeholder=" " class="form-control" type="text">
    <input type="submit" name="sub_find" class="form-control btn btn-success" value="كلمات وصفات علاجية">
</form>
<?php
ob_start(); 
if(isset($_GET['sub_find'])){
    $f=$_GET['find'];
    // $header = ["find => '$f'"];
    header("location:result.php?find=$f");
    // header('location:doctorPage.php');
    // $ch = curl_init("");
    // curl_setopt($ch,CURLOPT_URL,"result.php");
    // curl_setopt($ch,CURLOPT_POST,true);
    // curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($header));
    // curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);


    // curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    // curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

    // curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
    // $resposnse = curl_exec($ch);
    // curl_close($ch);     

    // echo $resposnse;
 
    exit();
}
ob_end_flush();
?>
