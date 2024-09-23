<?php   
    session_start();
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : "none";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="home_container">
        <div class="home_menu" onclick="window.location.href='schedule.php'">Schedule</div>
        <div class="home_menu" onclick="window.location.href='meeting.php'">fix a meeting</div>
        <div class="home_menu" onclick="window.location.href='settings.php'">settings</div>
    </div>
</body> 
</html>
