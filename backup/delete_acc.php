<?php

session_start();

if (isset($_POST['delete'])){
    $username = $_SESSION['username'];
    $password = $_POST['password'];
    $id_user = $_SESSION['id_user'];



    $sql_servername = "localhost";
    $sql_username = "admin";
    $sql_password = "admin";
    $sql_db = "jadzia";

    $db = new mysqli($sql_servername, $sql_username, $sql_password, $sql_db);

    if ($db->connect_error){
        die("Connection failed" . $db->connect_error);
    }

    $sql = "select * from users where username=\"$username\" and password=\"$password\";";
    $result = $db->query($sql);
    
        if ($result->num_rows > 0){
        $del = "delete from users where id_user=\"$id_user\" and username=\"$username\" and password=\"$password\";";
        $db->query($del);
    if (isset($_SESSION['date'])){
        unset($_SESSION['date']);
    }
    if (isset($_SESSION['error'])){
        unset($_SESSION['error']);
    }
    
    $_SESSION['account_delete'] = "Konto zostało usunięte";
    header("Location: index.php");
    exit();
    } 
    else {
        $_SESSION['error'] = true;
        header('Location: delete_account.php');
        exit();
    }

    $db->close();

    //print_r($result);

}

?>