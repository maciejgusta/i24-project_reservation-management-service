<?php
session_start(); // Start the session to access session variables

if (isset($_SESSION['account_delete'])) {
    echo "<script>alert('" . $_SESSION['account_delete'] . "');</script>";
    // Opcjonalnie wyczyść zmienną sesji po wyświetleniu alertu
    unset($_SESSION['del']);
}


$username = isset($_SESSION['username']) ? $_SESSION['username'] : "none";
if (isset($_SESSION['date'])){
    unset($_SESSION['date']);
}

// Check if there is an error in the session and store it in a local variable
$error = isset($_SESSION['error']) ? $_SESSION['error'] : false; // Default to false if not set
unset($_SESSION['error']); // Clear the session error after reading it
?>
 
<!DOCTYPE html>
<html id="html_form" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
	<div id="log_in_block">
        <form id="log_in_form" action="login.php" method="post">
            <label class="label" for="username">Username:</label>
            <input class="input" type="text" name="username" required>
            <label class="label" for="password">Password:</label>
            <input class="input" type="password" name="password" required>
            
            <div id="credentials_block">
            <?php
                if ($error == true){
                    echo '<div id="credentials_div">Invalid username or password!</div>';
                }
            ?>
            </div>
            
            <button id="log_in_button" type="submit" name="login">Log in</button>
        </form>
        <form id="sign_up_form" style="margin-top: 10px" action="sign_up.php" method="post">
            <button id="sign_up_button" type="submit" name="sign_up">Sign up</button>
        </form>
    </div>
</body>
</html>
