<?php
session_start(); // Start the session to access session variables




$username = isset($_SESSION['username']) ? $_SESSION['username'] : "none";
if (isset($_SESSION['date'])){
    unset($_SESSION['date']);
}

// Check if there is an error in the session and store it in a local variable
$error = isset($_SESSION['error']) ? $_SESSION['error'] : false; // Default to false if not set
$verified = isset($_SESSION['verified']) ? $_SESSION['verified'] : false;
unset($_SESSION['verified']);
unset($_SESSION['error']); // Clear the session error after reading it
?>
 
<!DOCTYPE html>
<html id="dark-mode" lang="en">
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
    <title>Log in</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<script>
    function toggleDarkMode() {
        const html = document.documentElement; // <html> element
        html.classList.toggle('dark-mode');
        // Zapisz wybór motywu do localStorage, aby zapamiętać go po odświeżeniu strony
        if (html.classList.contains('dark-mode')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    }

    // Ustaw motyw na podstawie zapisanych preferencji
    window.onload = function() {
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark-mode');
        }
    }
</script>
	<div id="log_in_block">
        <form id="log_in_form" action="login.php" method="post">
            <label class="label" for="username">Username:</label>
            <input class="input" type="text" name="username" required>
            <label class="label" for="password">Password:</label>
            <input class="input" type="password" name="password" required>
            
            <div id="credentials_block">
            <?php
                if ($error){
                    echo '<div id="credentials_div">'.$error.'</div>';
                } else if ($verified){
                    echo '<div id="verification_div">Account has been verified!</div>';
                }
            ?>
            </div>
            
            <button id="log_in_button" type="submit" name="login">Log in</button>
        </form>
        <form id="sign_up_form" style="margin-top: 10px" action="sign_up.php" method="post">
            <button id="sign_up_button" type="submit" name="sign_up">Sign up</button>
        </form>
        <form id="forgot_possword_form"  action="forgot_password.php" method="post">
            <div id="forgot_password_link" onclick="window.location.href=\'forgot_password.php\'">Forgot password?</div>
        </form>
    </div>
    <?php
        if (isset($_SESSION['account_delete'])) {
            echo "<script>alert('" . $_SESSION['account_delete'] . "');</script>";
            // Opcjonalnie wyczyść zmienną sesji po wyświetleniu alertu
            unset($_SESSION['account_delete']);
        }
    ?>
</body>
</html>
