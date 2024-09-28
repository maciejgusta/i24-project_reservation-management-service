<?php

session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['id_user']))) {
    session_unset();
    header("Location: index.php");
    exit();
} 

 if (isset($_SESSION['password_change'])) {
    echo "<script>alert('" . $_SESSION['password_change'] . "');</script>";
    // Opcjonalnie wyczyść zmienną sesji po wyświetleniu alertu
    unset($_SESSION['password_change']);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="css/settings.css">
</head>
<body>
    <div id="back" onclick="window.location.href='home.php'">Return</div>

    <div id="title">Settings</div>
    <div class="main_container">
        <div class="box" onclick="window.location.href='change_password.php'">Change Password</div>
        <div class="box" onclick="window.location.href='delete_account.php'">Delete Account</div>  
    </div>

    
    
</body>
</html>