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
    <div id="schedule_container">Schedule</div>
    <div id="fix a meeting">fix a meeting</div>
    <div id="settings">setting</div>
</body> 
</html>