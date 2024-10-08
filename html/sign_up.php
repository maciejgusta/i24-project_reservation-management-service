<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : false; // Default to false if not set
unset($_SESSION['error']); // Clear the session error after reading it
?>

<!DOCTYPE html>
<html id="html_form" lang="en">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
        
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="css/sign_up.css">
</head>
<body id="body_form">
<div id="back" onclick="window.location.href='index.php'">Return</div>

    <div id="sign_up_block">
        <form id="sign_up_form" action="sign_up_process.php" method="post">
            <label class="label" for="username">Username:</label>
            <input class="input" type="text" name="username" required>
            <label class="label" for="password">Password:</label>
            <input class="input" type="password" name="password" required>
            <label class="label" for="repeat_password">Repeat password:</label>
            <input class="input" type="password" name="repeat_password" required>
            <label class="label" for="first_name">First name:</label>
            <input class="input" type="text" name="first_name" required>
            <label class="label" for="last_name">Last name:</label>
            <input class="input" type="text" name="last_name" required>
            <label class="label" for="email">E-mail:</label>
            <input class="input" type="text" name="email" required>

            <div id="credentials_block">
            <?php
                if ($error){
                    echo "<div id=\"credentials_div\">$error</div>";
                }  
            ?>
            </div>
            <button id="sign_up_button" type="submit" name="sign_up">Sign up</button>
            
        </form>
    </div>
</body>
</html>