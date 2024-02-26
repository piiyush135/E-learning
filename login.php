<?php

require('connection.php');

if(isset($_POST['login'])) {
   $email_username = $_POST['email_username'];
   // Using prepared statement to prevent SQL injection
   $query = "SELECT * FROM registered_user WHERE email=? OR username=?";
   $stmt = mysqli_prepare($con, $query);
   mysqli_stmt_bind_param($stmt, "ss", $email_username, $email_username);
   mysqli_stmt_execute($stmt);
   $result = mysqli_stmt_get_result($stmt);

   if($result) {
     if(mysqli_num_rows($result) == 1) {
       $result_fetch = mysqli_fetch_assoc($result);
       // Perform further authentication checks here
       // Assuming authentication is successful, redirect to main.html
       header("Location: main.html");
       exit(); // Ensure that no further code is executed after redirection
     } else {
       showErrorAlert("Email or Username Not Registered");
     }
   } else {
      showErrorAlert("Cannot Run Query");
   }
}

// Define the showErrorAlert function
function showErrorAlert($message) {
    echo "<script>alert('$message'); window.location.href='login.html';</script>";
    exit();
}

?>