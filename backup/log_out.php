<?php
    session_start();
    if (isset($_SESSION['date'])){
        unset($_SESSION['date']);
    }
    if (isset($_SESSION['error'])){
        unset($_SESSION['error']);
    }
    header("Location: index.php");
    exit();
?>