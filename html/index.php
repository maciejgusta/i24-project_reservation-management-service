<?php
session_start(); // Start the session to access session variables

// Check if there is an error in the session and store it in a local variable
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
<p>test</p>
	<div id="login_container">
        <form id="login_form" action="login.php" method="post">
            <label for="username">Username:</label>
            <input id="login_input1" type="text" name="username" required>
            <label for="password">Password:</label>
            <input id="login_input2" type="password" name="password" required><br>
            <?php
                if ($error == true){
                    echo "<p id=\"invalid_credentials\">Invalid username or password!</p>";
                }
            ?>
            <button type="submit" name="login">Log in</button>
        </form>
        <form id="sign_up_form" style="margin-top: 10px" action="sign_up.php" method="post">
            <button type="submit" name="sign_up">Sign up</button>
        </form>
    </div>
</body>
</html>
