<?php
require_once('header.php');
require_once('nav.php');
?>
<!-- main change -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Patients & Doctors</h1>
        <a href="./add_user.php" class="btn btn-primary">Add Patients &Doctors</a>
    </div>
    <h2>Manage Patient</h2>
      <!-- list group  -->
    <div class="table-responsive">
    <?php
            require_once('list.php');
            ?>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Permission</th>
                    <th scope="col">Address</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php
                require_once('../config.php');
                $sql = "select * from regist order by R_id asc";
                $exe = mysqli_query($conn, $sql);
                if (!$exe) {
                    die("Selected Erorr");
                }
                while ($row = mysqli_fetch_assoc($exe)) {
                    $id = $row['R_id'];
                    $name = $row['R_name'];
                    $email = $row['R_Email'];
                    $phone = $row['R_phone'];
                    $per = $row['R_type'];
                    $address = $row['R_address'];
                    echo "
                    <tr>
                    <td>$id</td>
                    <td>$name</td>
                    <td>$email</td>
                    <td>$phone</td>
                    <td>$per</td>
                    <td>$address</td>
                    <td><a href='./edit_user.php?eu=$id' class='btn btn-info'>Edit</a></td>
                    <td><a href='./del_user.php?du=$id' class='btn btn-danger'>Del</a></td>
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