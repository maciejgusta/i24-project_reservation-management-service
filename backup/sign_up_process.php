<?php
session_start();

//Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// If necessary, modify the path in the require statement below to refer to the
// location of your Composer autoload.php file.
require 'vendor/autoload.php';



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

    if ($db->query('select email from users where email="'.$email.'";')->num_rows > 0){
        $_SESSION['error'] = 'This email has already been used for another account!';
        header("Location: sign_up.php");
        exit();
    }

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

    $secret_key = 'f93b3f017f51628c260f7abf7a18d25fdf7fc1ed0ce71c8185a1f7af9d8561fe';
    $token = generateEmailVerificationToken($username, $secret_key);
    $verification_link = 'https://retro-ciecie.pl/email_verification.php?token='.$token.'';

    $sql = "insert into users (username, password, first_name, last_name, email, token, verified) values (\"$username\", \"$password\", \"$first_name\", \"$last_name\", \"$email\", \"$token\", false);";
    $db->query($sql);

    // Replace sender@example.com with your "From" address.
    // This address must be verified with Amazon SES.
    $sender = 'contact@retro-ciecie.pl';
    $senderName = 'Contact';

    // Replace recipient@example.com with a "To" address. If your account
    // is still in the sandbox, this address must be verified.
    $recipient = $email;

    // Replace smtp_username with your Amazon SES SMTP user name.
    $usernameSmtp = 'AKIASIVGKZNY6WKAHY4Y';
    $passwordSmtp = 'BHMZ0k3J8j8Kj5VyferxHj3r63UEITl7g+zWc5370wu+';

    // Specify a configuration set. If you do not want to use a configuration
    // set, comment or remove the next line.
    //$configurationSet = 'ConfigSet';

    // If you're using Amazon SES in a region other than US West (Oregon),
    // replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
    // endpoint in the appropriate region.
    $host = 'email-smtp.eu-central-1.amazonaws.com';
    $port = 587;

    // The subject line of the email
    $subject = 'Email verification for '.$username.'.';

    // The plain-text body of the email
    $bodyText = 'Verify Your Email Address
    Thank you for signing up! Please click the button below to verify your email address.
    '.$verification_link.' Verify Email
    If you didn\'t request this email, you can safely ignore it.';

    // The HTML-formatted body of the email
    $bodyHtml = '<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Email Verification</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .email-container {
                width: 100%;
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            h1 {
                color: #333333;
                font-size: 24px;
                margin-bottom: 10px;
            }
            p {
                font-size: 16px;
                color: #666666;
                margin: 0 20px;
            }
            .verify-button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #28a745;
                color: #ffffff;
                text-decoration: none;
                border-radius: 5px;
                font-size: 18px;
                margin: 20px 0;
            }
            .verify-button:hover {
                background-color: #218838;
            }
            .footer {
                font-size: 14px;
                color: #999999;
                margin-top: 20px;
            }
            @media screen and (max-width: 600px) {
                h1 {
                    font-size: 20px;
                }
                p {
                    font-size: 14px;
                }
                .verify-button {
                    font-size: 16px;
                    padding: 8px 16px;
                }
            }
        </style>
    </head>
    <body>
        <table width="100%" bgcolor="#f4f4f4" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center" style="padding: 20px 0;">
                    <table class="email-container" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                        <tr>
                            <td style="padding: 20px;">
                                <h1>Verify Your Email Address</h1>
                                <p>Thank you for signing up! Please click the button below to verify your email address.</p>
                                <a href="'.$verification_link.'" class="verify-button">Verify Email</a>
                                <p class="footer">If you didn\'t request this email, you can safely ignore it.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
';

    $mail = new PHPMailer(true);

    // Specify the SMTP settings.
    $mail->isSMTP();
    $mail->setFrom($sender, $senderName);
    $mail->Username   = $usernameSmtp;
    $mail->Password   = $passwordSmtp;
    $mail->Host       = $host;
    $mail->Port       = $port;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = 'tls';
    //$mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);

    // Specify the message recipients.
    $mail->addAddress($recipient);
    // You can also add CC, BCC, and additional To recipients here.

    // Specify the content of the message.
    $mail->isHTML(true);
    $mail->Subject    = $subject;
    $mail->Body       = $bodyHtml;
    $mail->AltBody    = $bodyText;
    $mail->Send();

    header('Location: index.php');
    $_SESSION['error'] = "Account needs to be verified via email!";
    exit();
}
?>