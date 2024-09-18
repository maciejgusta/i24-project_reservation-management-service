<?php
session_start();

// Enable error reporting for debugging
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


if (isset($_POST['sign_up'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];

    $sql_servername = "localhost";
    $sql_username = "admin";
    $sql_password = "admin";
    $sql_db = "jadzia";

    $db = new mysqli($sql_servername, $sql_username, $sql_password, $sql_db);

    if ($db->connect_error){
        die("Connection failed".$db->connect_error);
    }

    $sql = "select * from users where username=\"$username\"";
    $result = $db->query($sql);
    if ($result->num_rows > 0){
        $_SESSION['error'] = "Username is taken, please choose another one!";
        header("Location: sign_up.php");
        exit();
        // error displaying
    }
    if (strlen($password) < 8){
        $_SESSION['error'] = "Password too short, it must be at least 8 characters long!";
        header("Location: sign_up.php");
        exit();
    }
    if ($password != $repeat_password){
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: sign_up.php");
        exit();
    }
    if (strlen((string)$phone_number) != 9){
        $_SESSION['error'] = "The phone number must consit of 9 digits!";
        header("Location: sign_up.php");
        exit();
    }
    $sql = "insert into users values (\"$username\", \"$password\", \"$first_name\", \"$last_name\", \"$phone_number\")";
    $db->query($sql);
}
?>