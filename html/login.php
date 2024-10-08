<?php

session_start();

if (isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];



    $sql_servername = "localhost";
    $sql_username = "admin";
    $sql_password = "admin";
    $sql_db = "jadzia";

    $db = new mysqli($sql_servername, $sql_username, $sql_password, $sql_db);

    if ($db->connect_error){
        die("Connection failed" . $db->connect_error);
    }

    $sql = "select * from users where username=\"$username\" and password=\"$password\";";
    $result = $db->query($sql);

    if ($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if ($user['verified']){
            $_SESSION['username'] = $username;
            $_SESSION['id_user'] = $db->query("select id_user from users where username=\"$username\" and password=\"$password\";")->fetch_assoc()['id_user'];
            header("Location: home.php");
            exit();
        } else {
            $_SESSION['error'] = 'Account not verified, please check your email: '.$user['email'].'!';
            $secret_key = 'f93b3f017f51628c260f7abf7a18d25fdf7fc1ed0ce71c8185a1f7af9d8561fe';
            $token = generateEmailVerificationToken($username, $secret_key);
            $verification_link = 'https://retro-ciecie.pl/email_verification.php?token='.$token.'';
            
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
            $bodyText = ''.$verification_link.'';

            // The HTML-formatted body of the email
            $bodyHtml = '<h1>Email verification</h1>
                <p><a href="'.$verification_link.'">Verification link</a></p>';

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
            exit();
        }
    } else {
        $_SESSION['error'] = 'Invalid username or password!';
        header('Location: index.php');
        exit();
    }

    $db->close();

    //print_r($result);

}

