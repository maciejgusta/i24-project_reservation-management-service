<?php

session_start();

if (!(isset($_SESSION['username']) && isset($_SESSION['id_user']))) {
    session_unset();
    header("Location: index.php");
    exit();
} 

$_SESSION['date']->modify("+7 days");
header("Location: home.php");
exit();

?>
