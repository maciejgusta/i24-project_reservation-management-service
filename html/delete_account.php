<?php
    session_start();

    if (!(isset($_SESSION['username']) && isset($_SESSION['id_user']))) {
        header("Location: index.php");
        exit();
    } 

    $id_user = (isset($_SESSION['id_user']) ? $_SESSION['id_user'] : "none");
    $error = (isset($_SESSION['error']) ? $_SESSION['error'] : false);
    $db_servername = "localhost";
    $db_username = "admin";
    $db_password = "admin";
    $db_name = "jadzia";
    $db = new mysqli($db_servername, $db_username, $db_password, $db_name);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete my account</title>
    <link rel="stylesheet" href="css/delete_account.css">
</head>
<body>
    
    <div id="back" onclick="window.location.href='settings.php'">Return</div>
    <div id="title">Account Delete</div>
	<div id="del_acc_block">
        <form id="del_acc_form" action="delete_acc.php" method="post">
            <label class="label" for="password">
                <?php
                    echo 'Enter ' . $_SESSION['username'] . '\'s password:';
                ?>
                </label>
            <input class="input" type="password" name="password" required>
            
            <div id="credentials_block">
            <?php
                if ($error == true){
                    echo '<div id="credentials_div">Invalid password!</div>';
                }
            ?>
            </div>
            
            <button id="del_acc_button" type="submit" name="delete" method="post">Delete</button>
        </form>
    </div>
</body>
</html>