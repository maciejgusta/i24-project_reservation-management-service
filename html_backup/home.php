<?php   
    session_start();
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : "none";
    unset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <?php
        echo $username;
    ?>
</body>
</html>