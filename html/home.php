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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="home_container">
        <div class="home_menu">Schedule</div>
        <div class="home_menu">fix a meeting</div>
        <div class="home_menu">setting</div>
    </div>
</body> 
</html>