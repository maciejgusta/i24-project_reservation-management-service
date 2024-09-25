<?php
    session_start();
    $id_user = (isset($_SESSION['id_user']) ? $_SESSION['id_user'] : "none");
    $error = (isset($_SESSION['error']) ? $_SESSION['error'] : "none");
    $db_servername = "localhost";
    $db_username = "admin";
    $db_password = "admin";
    $db_name = "jadzia";
    $db = new mysqli($db_servername, $db_username, $db_password, $db_name);
?>
 
<!DOCTYPE html>
<html id="html_form" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/change_password.css">
</head>
<body>
    <div id="back" onclick="window.location.href='settings.php'">Return</div>
    <div id="title">Change Password</div>

    <div id="change_password_block">
        <form id="change_password_form" action="change_password_script.php" method="post">
            <label class="label" for="password">
                <?php
                    echo 'Enter ' . $_SESSION['username'] . '\'s password:';
                ?>
                </label>
            <input class="input" type="password" name="password" required>

            <label class="label" for="password">
                <?php
                    echo 'Enter new ' . $_SESSION['username'] . '\'s password:';
                ?>
                </label>
            <input class="input" type="password" name="new_password" required>

            <label class="label" for="password">
                <?php
                    echo 'Confirm new ' . $_SESSION['username'] . '\'s password:';
                ?>
                </label>
            <input class="input" type="password" name="new_password_repeat" required>
            
            <div id="credentials_block">
            <?php
                if ($error == true){
                    echo '<div id="credentials_div">Invalid password!</div>';
                }
            ?>
            </div>
            
            <button id="change_password_button" type="submit" name="change" method="post">Change Password</button>
        </form>
    </div>

	
</body>
</html>
