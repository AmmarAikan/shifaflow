<!-- <?php
// session_start();
// // $_SESSION['phone'] == null;
// // $_SESSION['phone'] == null;

// if($_SESSION['adminName'] == null && $_SESSION['adminId'] == null)
// {
// 		// echo '<meta http-equiv="refresh" content="0;url=sign_in.php">';
// 		// exit();
// // Session timeout functionality
// $sessionTimeout = 30; 

// // Check if the session has expired
// if (isset($_SESSION['start_time'])) {
//     $elapsedTime = time() - $_SESSION['start_time']; 
//     if ($elapsedTime > $sessionTimeout) {
//         session_unset(); // Clear session data
//         session_destroy(); // Destroy the session
// 		echo '<meta http-equiv="refresh" content="0;url=sign_in.php">';
//        // header('Location: sign_in.php'); // Redirect to login page
//         exit();
//     }
// } else {
//     // If no session start time is set, redirect to login page
//   //  header('Location: sign_in.php');
//     echo '<meta http-equiv="refresh" content="0;url=sign_in.php">';
//     exit();
// }
	
// }
?> -->
<?php
session_start();

// Ensure session variables exist before checking them
if (!isset($_SESSION['adminName']) || !isset($_SESSION['adminId'])) {
    // Set session timeout in seconds
    $sessionTimeout = 30; 

    // Check if session start time exists
    if (isset($_SESSION['start_time'])) {
        $elapsedTime = time() - $_SESSION['start_time']; 
        if ($elapsedTime > $sessionTimeout) {
            session_unset(); // Clear session data
            session_destroy(); // Destroy the session
            echo '<meta http-equiv="refresh" content="0;url=sign_in.php">'; // Redirect to login page
            exit();
        }
    } else {
        // If session start time is not set, set it now
        $_SESSION['start_time'] = time();
        echo '<meta http-equiv="refresh" content="0;url=sign_in.php">';
        exit();
    }
}
?>
