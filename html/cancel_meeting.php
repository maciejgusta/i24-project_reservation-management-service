<?php 
    session_start();

    if (!(isset($_SESSION['username']) && isset($_SESSION['id_user']))) {
        header("Location: index.php");
        exit();
    } 

    $id_visit = isset($_GET['id_visit']) ? $_GET['id_visit'] : "none";
    unset($_GET['id_visit']);

    $db_servername = "localhost";
    $db_username = "admin";
    $db_password = "admin";
    $db_name = "jadzia";
    
    $db = new mysqli($db_servername, $db_username, $db_password, $db_name);
    
    $db->query('delete from visits where id_visit="'.$id_visit.'";');
    $_SESSION['alert'] = 'The meeting has been cancelled!';
    header("Location: meetings.php");
    exit();
?>