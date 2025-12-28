<?php require_once('header.php'); require_once('validate_sess.php'); ?>

<div class="wrapper">
    <?php require_once('nav.php'); ?>  

    <!-- Main content -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style='direction: rtl; width: 100%;'>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div style="padding:4px;margin:10px; background-color:rgb(94, 162, 240);">
                <h2> جميع الطلبات</h2>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"> رقم الجلسة </th>
                        <th scope="col"> رقم المريض </th>
                        <th scope="col"> تاريخ الجلسة</th>
                        <th scope="col"> اسم الدكتور</th>
                        <th scope="col">حالة الطلب</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once('../config.php');
                    $sql = "SELECT * FROM requests ORDER BY requests_id DESC";
                    $exe = mysqli_query($conn, $sql);
                    if (!$exe) {
                        die("Selected Error: " . mysqli_error($conn));
                    }
                    while ($row = mysqli_fetch_assoc($exe)) {
                        echo "<tr>
                            <td>{$row['requests_id']}</td>
                            <td>{$row['session_id']}</td>
                            <td>{$row['sic_id']}</td>
                            <td>{$row['dateSession']}</td>
                            <td>{$row['doctor_name']}</td>
                            <td>{$row['reuest_statue']}</td>
                        </tr>";
                    }
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php require_once('footer.php'); ?>
