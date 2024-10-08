<?php
    session_start();

    $error = (isset($_SESSION['error']) ? $_SESSION['error'] : false);
    unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
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
    <title>Forgot password</title>
    <link rel="stylesheet" href="css/forgot_password.css">
</head>
<body>
    
    <div id="back" onclick="window.location.href='index.php'">Return</div>
    <div id="title">Forgot password</div>
	<div id="forgot_password_block">
        <form id="forgot_password_form" action="forgot_password_backend.php" method="post">
            <label class="label" for="email">
                <?php
                    echo 'Enter your email:';
                ?>
                </label>
            <input class="input" type="email" name="email" required>
            
            <div id="credentials_block">
            <?php
                if ($error == true){
                    echo '<div id="credentials_div">No account uses this email!</div>';
                }
            ?>
            </div>
            
            <button id="forgot_password_button" type="submit" name="change" method="post">Reset password via email</button>
        </form>
    </div>
</body>
</html>