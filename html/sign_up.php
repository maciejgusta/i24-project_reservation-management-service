<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : false; // Default to false if not set
unset($_SESSION['error']); // Clear the session error after reading it
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="sign_up_container">
        <form id="sign_up_form" action="sign_up_process.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <label for="repeat_password">Repeat password:</label>
            <input type="password" name="repeat_password" required>
            <label for="first_name">First name:</label>
            <input type="text" name="first_name" required>
            <label for="last_name">Last name:</label>
            <input type="text" name="last_name" required>
            <label for="phone_number">Phone number:</label>
            <input type="number" name="phone_number" required>
            <button type="submit" name="sign_up">Sign up</button>
            <?php
                echo "<p id=\"invalid_credentials\">$error</p>";
            ?>
        </form>
    </div>
</body>
</html>