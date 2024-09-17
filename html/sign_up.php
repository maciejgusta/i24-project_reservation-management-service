<?php
    session_start();
    $username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
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
    <div id="sign_up_container" action="sign_up.php" method="post">
        <form id="sign_up_form">
            <label for="username">Username:</label>
            <input type="text" name="username">
            <label for="password">Password:</label>
            <input type="password" name="password">
            <label for="repeat_password">Repeat password:</label>
            <input type="password" name="repeat_password">
            <label for="first_name">First name:</label>
            <input type="text" name="first_name">
            <label for="last_name">Last name:</label>
            <input type="text" name="lastname">
            <label for="phone_number">Phone number:</label>
            <input type="text" name="phone_number">
            <button type="submit">Sign up</button>
        </form>
        <?php
            echo "$username";
        ?>
    </div>
</body>
</html>