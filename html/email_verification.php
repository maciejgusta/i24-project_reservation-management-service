<?php
    session_start();
    if (isset($_GET['token'])){
        $token = $_GET['token'];
        unset($_GET['token']);

        $sql_servername = "localhost";
        $sql_username = "admin";
        $sql_password = "admin";
        $sql_db = "jadzia";

        $db = new mysqli($sql_servername, $sql_username, $sql_password, $sql_db);

        $user = $db->query('select id_user, username from users where token="'.$token.'";');
        if ($user->num_rows > 0){
            $result = $user->fetch_assoc();
            $id_user = $result['id_user'];
            $username = $result['username'];
            $db->query('update users set verified=true where id_user="'.$id_user.'";');
            $_SESSION['verified'] = 'Account has been verified!';
            header("Location: index.php");
        } else {
            $_SESSION['error'] = 'Couldn\'t verify email';
            header("Location: index.php");
        }

    } else {
        session_unset();
        header("Location: index.php");
        exit();
    }

    

?>