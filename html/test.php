<?php
require 'vendor/autoload.php';

use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

// Create an SES client
$SesClient = new SesClient([
    'version' => 'latest',
    'region'  => 'us-center-1', // Set your desired region
    'credentials' => [
        'key'    => 'AKIASIVGKZNY4HYSPCEP',
        'secret' => 'BNz7fP1/JgWK1ygIKq9gZeO8aqx7QaV9+rZM3dstqh07',
    ]
]);

print_r($SesClient);

// $sender_email = 'your_verified_email@example.com'; // Replace with your verified email address
// $recipient_emails = ['recipient@example.com']; // Replace with recipient's email
// $subject = 'Test Email from Amazon SES';
// $body_text = 'This is a test email sent using Amazon SES via the AWS SDK for PHP!';
// $body_html = '<h1>Amazon SES Test</h1><p>This email was sent using Amazon SES!</p>';

// try {
//     $result = $SesClient->sendEmail([
//         'Destination' => [
//             'ToAddresses' => $recipient_emails,
//         ],
//         'ReplyToAddresses' => [$sender_email],
//         'Source' => $sender_email,
//         'Message' => [
//             'Body' => [
//                 'Html' => [
//                     'Charset' => 'UTF-8',
//                     'Data' => $body_html,
//                 ],
//                 'Text' => [
//                     'Charset' => 'UTF-8',
//                     'Data' => $body_text,
//                 ],
//             ],
//             'Subject' => [
//                 'Charset' => 'UTF-8',
//                 'Data' => $subject,
//             ],
//         ],
//     ]);

//     // Output the message ID
//     echo "Email sent! Message ID: " . $result['MessageId'] . "\n";
// } catch (AwsException $e) {
//     // output error message if fails
//     echo $e->getMessage();
//     echo "\n";
// }
