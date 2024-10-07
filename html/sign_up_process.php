<?php
session_start();

//Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['sign_up'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];

    $sql_servername = "localhost";
    $sql_username = "admin";
    $sql_password = "admin";
    $sql_db = "jadzia";

    $db = new mysqli($sql_servername, $sql_username, $sql_password, $sql_db);

    if ($db->connect_error){
        die("Connection failed".$db->connect_error);
    }

    $sql = "select * from users where username=\"$username\"";
    $result = $db->query($sql);
    if ($result->num_rows > 0){
        $_SESSION['error'] = "Username is taken, please choose another one!";
        header("Location: sign_up.php");
        exit();
        // error displaying
    }
    if (strlen($password) < 8){
        $_SESSION['error'] = "Password is too short, it must be at least 8 characters long!";
        header("Location: sign_up.php");
        exit();
    }
    if ($password != $repeat_password){
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: sign_up.php");
        exit();
    }
    // if (strlen((string)$phone_number) != 9){
    //     $_SESSION['error'] = "The phone number must consit of 9 digits!";
    //     header("Location: sign_up.php");
    //     exit();
    // }
    $sql = "insert into users (username, password, first_name, last_name, email) values (\"$username\", \"$password\", \"$first_name\", \"$last_name\", \"$email\");";
    $db->query($sql);

    function generateEmailVerificationToken($id_user, $secret_key) {
        // Step 1: Combine id_user with a unique value (timestamp in this case)
        $data = $id_user . ':' . time();
        
        // Step 2: Generate a hash using HMAC-SHA256 and the secret key
        $hash = hash_hmac('sha256', $data, $secret_key, true);
        
        // Step 3: Base64 encode the hash to make it URL-safe
        $token = base64_encode($hash);
        
        // Make the token URL-safe by replacing +, /, and = with -, _, and empty string
        $url_safe_token = strtr($token, '+/', '-_');
        $url_safe_token = rtrim($url_safe_token, '=');
        
        return $url_safe_token;
    }

    $id_user = $db->query('select id_user from users where username="'.$username.'";')->fetch_assoc()['id_user'];
    $secret_key = 'f93b3f017f51628c260f7abf7a18d25fdf7fc1ed0ce71c8185a1f7af9d8561fe';
    $token = generateEmailVerificationToken($id_user, $secret_key);

    $db->query('update users set token="'.$token.'" where id_user="'.$id_user.'";');

    header("Location: index.php");
    exit();
}
?>