<?php
    session_start();    
    
    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use Dotenv\Dotenv;

    // If necessary, modify the path in the require statement below to refer to the
    // location of your Composer autoload.php file.
    require 'vendor/autoload.php';
    
    if (isset($_POST['change'])){   
        $email = $_POST['email'];

        $db_servername = "localhost";
        $db_username = "admin";
        $db_password = "admin";
        $db_name = "jadzia";
        $db = new mysqli($db_servername, $db_username, $db_password, $db_name);

        $result = $db->query('select * from users where email="'.$email.'";');

        if ($result->num_rows>0){
            $result = $result->fetch_assoc();
            $token = $result['token'];
            $username = $result['username'];
            $link = 'https://retro-ciecie.pl/change_password_via_email.php?token='.$token.'';


            // Replace sender@example.com with your "From" address.
            // This address must be verified with Amazon SES.
            $sender = 'contact@retro-ciecie.pl';
            $senderName = 'Contact';

            // Replace recipient@example.com with a "To" address. If your account
            // is still in the sandbox, this address must be verified.
            $recipient = $email;

            $dotenv = Dotenv::createImmutable(__DIR__);
            $dotenv->load();

            // Replace smtp_username with your Amazon SES SMTP user name.
            $usmtp = $_ENV['AWS_SES_SMTP_USERNAME'];
            $psmtp = $_ENV['AWS_SES_SMTP_PASSWORD'];

            // Specify a configuration set. If you do not want to use a configuration
            // set, comment or remove the next line.
            //$configurationSet = 'ConfigSet';

            // If you're using Amazon SES in a region other than US West (Oregon),
            // replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
            // endpoint in the appropriate region.
            $host = 'email-smtp.eu-central-1.amazonaws.com';
            $port = 587;

            // The subject line of the email
            $subject = 'Password reset for '.$username.'.';

            // The plain-text body of the email
            $bodyText = 'Reset Your Password
        We received a request to reset your password. Click the button below to choose a new password.
        Reset Password
        If you didn\'t request this, you can safely ignore this email.';

            // The HTML-formatted body of the email
            $bodyHtml = '
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; width: 100%;">
    <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f4f4;">
        <tr>
            <td align="center" valign="middle">
                <table cellpadding="0" cellspacing="0" border="0" width="600" style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: center;">
                    <tr>
                        <td style="padding: 20px;">
                            <h1 style="color: #333333; font-size: 24px; margin-bottom: 20px;">Reset Your Password</h1>
                            <p style="font-size: 16px; color: #666666; margin-bottom: 30px;">We received a request to reset your password. Click the button below to choose a new password.</p>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>
                                    <td align="center">
                                        <a href="'.$link.'" style="display: inline-block; padding: 12px 25px; background-color: #28a745; color: #ffffff; text-decoration: none; border-radius: 5px; font-size: 16px;">Reset Password</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="font-size: 12px; color: #999999; margin-top: 30px;">If you didn\'t request this, you can safely ignore this email.</p>
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

            //Specify the SMTP settings.
            $mail->isSMTP();
            $mail->setFrom($sender, $senderName);
            $mail->Username   = $usmtp;
            $mail->Password   = $psmtp;
            $mail->Host       = $host;
            $mail->Port       = $port;
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = 'tls';
            $mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);

            // Specify the message recipients.
            $mail->addAddress($recipient);
            // You can also add CC, BCC, and additional To recipients here.

            // Specify the content of the message.
            $mail->isHTML(true);
            $mail->Subject    = $subject;
            $mail->Body       = $bodyHtml;
            $mail->AltBody    = $bodyText;
            $mail->Send();

            header("Location: index.php");
            $_SESSION['verified'] = "Reset your password via email which has been sent to you!";
            exit();

        } else {
            $_SESSION['error'] = true;
            header("Location: forgot_password.php");
            exit();
        }
    
    } else {
        $_SESSION['error'] = true;
        header("Location: forgot_password.php");
        exit();
    }
?>