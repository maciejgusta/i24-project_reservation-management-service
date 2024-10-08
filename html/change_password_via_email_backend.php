<?php
    session_start();
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : false;
    unset($_SESSION['username']);
    $token = isset($_SESSION['token']) ? $_SESSION['token'] : false;
    unset($_SESSION['token']);

    if (isset($_POST['change_password'])){
        $new_password = $_POST['new_password'];
        $new_password_repeat = $_POST['new_password_repeat'];
        if ($new_password != $new_password_repeat){
            $_SESSION['error'] = "Passwords do not match!";
            header('Location: change_password_via_email.php?token='.$token);
            exit();
        }
        if (strlen($new_password) < 8){
            $_SESSION['error'] = "Password is too short, it must be at least 8 characters long!";
            header('Location: change_password_via_email.php?token='.$token);
            exit();
        }

        $db_servername = "localhost";
        $db_username = "admin";
        $db_password = "admin";
        $db_name = "jadzia";
        $db = new mysqli($db_servername, $db_username, $db_password, $db_name);
        
        $db->query('update users set password="'.$new_password.'" where token="'.$token.'";');
        $_SESSION['verified'] = "New password has been set!";
        header("Location: index.php");
        exit();
    }   
?>