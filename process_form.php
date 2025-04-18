<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set content type to JSON
header('Content-Type: application/json');

// Get form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// Debug information
$debug = [
    'post_data' => $_POST,
    'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
    'php_version' => PHP_VERSION,
    'mail_function' => function_exists('mail') ? 'Available' : 'Not available',
    'sendmail_path' => ini_get('sendmail_path') ?: 'Not set'
];

// Validate inputs
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please fill in all fields',
        'debug' => $debug
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address',
        'debug' => $debug
    ]);
    exit;
}

// Email settings
$to = "bourhimsouhail@gmail.com"; // Your email address
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

// Email content
$email_content = "
<html>
<head>
    <title>New Contact Form Submission</title>
</head>
<body>
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> $name</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Subject:</strong> $subject</p>
    <p><strong>Message:</strong></p>
    <p>" . nl2br(htmlspecialchars($message)) . "</p>
</body>
</html>
";

// Try to send email
$mail_sent = mail($to, "Portfolio Contact: $subject", $email_content, $headers);

// Add mail result to debug info
$debug['mail_sent'] = $mail_sent;
$debug['mail_error'] = error_get_last();

// Log the attempt
$log_message = date('Y-m-d H:i:s') . " - Attempt to send email:\n";
$log_message .= "To: $to\n";
$log_message .= "From: $email\n";
$log_message .= "Subject: $subject\n";
$log_message .= "Result: " . ($mail_sent ? "Success" : "Failed") . "\n\n";

// Try to write to log file
$log_file = __DIR__ . '/email_log.txt';
$can_write = @file_put_contents($log_file, $log_message, FILE_APPEND);

// Prepare response
$response = [
    'success' => $mail_sent,
    'message' => $mail_sent 
        ? 'Thank you for your message! I will get back to you soon.' 
        : 'Sorry, there was an error sending your message. Please try again later.',
    'debug' => $debug
];

// Ensure proper JSON encoding
$json_response = json_encode($response);
if ($json_response === false) {
    // If JSON encoding fails, create a simpler response
    $json_response = json_encode([
        'success' => $mail_sent,
        'message' => $mail_sent 
            ? 'Thank you for your message! I will get back to you soon.' 
            : 'Sorry, there was an error sending your message. Please try again later.'
    ]);
}

// Output the response
echo $json_response;
?> 