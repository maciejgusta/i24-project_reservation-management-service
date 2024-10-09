<?php
    session_start();
    $error = (isset($_SESSION['error']) ? $_SESSION['error'] : false);
    unset($_SESSION['error']);

    if (isset($_GET['token'])){
        $token = $_GET['token'];

        $db_servername = "localhost";
        $db_username = "admin";
        $db_password = "admin";
        $db_name = "jadzia";
        $db = new mysqli($db_servername, $db_username, $db_password, $db_name);

        $result = $db->query('select * from users where token="'.$token.'";')->fetch_assoc();
        $id_user = $result['id_user'];
        $username = $result['username'];
        $_SESSION['username'] = $username;
        $_SESSION['token'] = $token;
    }
?>

<?php

?>

<!DOCTYPE html>
<html id="html_form" lang="en" id="dark-mode">
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
    <title>Change Password</title>
    <link rel="stylesheet" href="css/change_password_via_email.css">
</head>
<body>
    <div id="back" onclick="window.location.href='index.php'">Return</div>
    <div id="title"> 
        <?php
            echo 'Change ' . $username . '\'s password:';
        ?>
    </div>

    <div id="change_password_block">
        <form id="change_password_form" action="change_password_via_email_backend.php" method="post">
            <label class="label" for="password">
                <?php
                    echo 'Enter new password:';
                ?>
                </label>
            <input class="input" type="password" name="new_password" required>

            <label class="label" for="password">
                <?php
                    echo 'Confirm new password:';
                ?>
                </label>
            <input class="input" type="password" name="new_password_repeat" required>
            
            <div id="credentials_block">
            <?php
                if ($error){
                    echo "<div id=\"credentials_div\">$error</div>";
                }  
            ?>
            </div>
            
            <button id="change_password_button" type="submit" name="change_password" method="post">Change Password</button>
        </form>
    </div>

	
</body>
</html>
