<?php

session_start();

$_SESSION['date']->modify("-7 days");
header("Location: home.php");
exit();

?>
