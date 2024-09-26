<?php
session_start();

if (isset($_POST['change_password'])){

    $username = $_SESSION['username'];
    $new_password = $_POST['new_password'];
    $new_password_repeat = $_POST['new_password_repeat'];
    $old_password = $_POST['old_password'];
    $id_user = $_SESSION['id_user'];

    $sql_servername = "localhost";
    $sql_username = "admin";
    $sql_password = "admin";
    $sql_db = "jadzia";

    $db = new mysqli($sql_servername, $sql_username, $sql_password, $sql_db);

    if ($db->connect_error){
        die("Connection failed" . $db->connect_error);
    }

    $sql = "select * from users where id_user=\"$id_user\" and username=\"$username\" and password=\"$old_password\";";

    $result = $db->query($sql);

    if($result->num_rows > 0)
    {
        if ($new_password != $new_password_repeat){
            $_SESSION['error'] = "Passwords do not match!";
            header("Location: change_password.php");
            exit();
        }
        if ($old_password == $new_password){
            $_SESSION['error'] = "Enter new password!";
            header("Location: change_password.php");
            exit();
        }
        if (strlen($new_password) < 8){
            $_SESSION['error'] = "Password is too short, it must be at least 8 characters long!";
            header("Location: change_password.php");
            exit();
        }
        $change = "update users set password=\"$new_password\" where id_user=\"$id_user\" and username=\"$username\" and password=\"$old_password\";";
        $db->query($change);
        header("Location: change_password.php");
        exit();
    }

}
header("Location: change_password.php");
exit();
    
?>
