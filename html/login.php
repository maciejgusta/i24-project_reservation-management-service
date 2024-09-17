<?php

session_start();

if (isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];



    $sql_servername = "localhost";
    $sql_username = "admin";
    $sql_password = "admin";
    $sql_db = "jadzia";

    $db = new mysqli($sql_servername, $sql_username, $sql_password, $sql_db);

    if ($db->connect_error){
        die("Connection failed" . $db->connect_error);
    }

    $sql = "select * from users where username=\"$username\" and password=\"$password\"";
    $result = $db->query($sql);

    if ($result->num_rows > 0){
        $user = $result->fetch_assoc();
        echo "<h1>Logged as: ".$user["first_name"]." ".$user["last_name"]." (".$user["username"].").</h1>";
        $_SESSION['error'] = false;
    } else {
        $_SESSION['error'] = true;
        header('Location: index.php');
        exit();
    }

    $db->close();

    //print_r($result);

}

