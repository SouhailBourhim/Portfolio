<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Email configuration
$to = "bourhimsouhail@gmail.com";
$subject = "Test Email from Portfolio";
$message = "This is a test email to verify that the mail function is working on your server.";
$headers = "From: test@yourdomain.com\r\n";
$headers .= "Reply-To: test@yourdomain.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Try to send email
$mail_sent = mail($to, $subject, $message, $headers);

// Display results
echo "<h1>Email Test Results</h1>";

if ($mail_sent) {
    echo "<p style='color: green;'>Email was sent successfully!</p>";
    echo "<p>Check your inbox (and spam folder) for the test email.</p>";
} else {
    echo "<p style='color: red;'>Failed to send email.</p>";
    echo "<p>This could be due to several reasons:</p>";
    echo "<ul>";
    echo "<li>The mail() function is not properly configured on your server</li>";
    echo "<li>Your hosting provider blocks outgoing emails</li>";
    echo "<li>There are issues with the email headers</li>";
    echo "</ul>";
    echo "<p>Consider using an alternative method like PHPMailer with SMTP.</p>";
}

// Display server information
echo "<h2>Server Information</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Server Name: " . $_SERVER['SERVER_NAME'] . "</p>";

// Check if mail function exists
echo "<p>mail() function exists: " . (function_exists('mail') ? 'Yes' : 'No') . "</p>";

// Check mail configuration
$mail_config = ini_get('sendmail_path');
echo "<p>sendmail_path: " . ($mail_config ? $mail_config : 'Not set') . "</p>";

// Check if we can write to the log file
$log_file = 'email_log.txt';
$log_write = file_put_contents($log_file, date('Y-m-d H:i:s') . " - Test script run\n", FILE_APPEND);
echo "<p>Can write to log file: " . ($log_write !== false ? 'Yes' : 'No') . "</p>";
?> 