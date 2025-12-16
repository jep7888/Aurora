<?php
header("Content-Type: application/json");
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php-error.log');

require "db_connect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

$emailUser = "aurora.official00000@gmail.com"; 
$emailPass = "ynrzlkjwhfofxele"; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit();
}

$email = trim($_POST['email'] ?? '');
if (!$email) {
    echo json_encode(["success" => false, "message" => "Email is required."]);
    exit();
}

// Check if email exists
$result = $conn->query("SELECT id, name FROM user_accounts WHERE email = '".$conn->real_escape_string($email)."'");
if ($result->num_rows === 0) {
    // Show generic message
    echo json_encode(["success" => true, "message" => "If the email exists, a reset link has been sent."]);
    exit();
}

$user = $result->fetch_assoc();
$name = $user['name'];

// Generate token
$token = bin2hex(random_bytes(32));

// Remove old tokens and insert new one
$conn->query("DELETE FROM password_resets WHERE email = '".$conn->real_escape_string($email)."'");
$conn->query("INSERT INTO password_resets (email, token) VALUES ('".$conn->real_escape_string($email)."', '$token')");

// Reset link
$link = "http://localhost/Ecommerce/reset_password.php?token=$token";

// Send email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = "smtp.gmail.com";
    $mail->SMTPAuth   = true;
    $mail->Username   = $emailUser;
    $mail->Password   = $emailPass;
    $mail->SMTPSecure = "ssl";  
    $mail->Port       = 465;   

    $mail->setFrom($emailUser, "Aurora");
    $mail->addAddress($email, $name);
    $mail->isHTML(true);
    $mail->Subject = "Reset Your Aurora Password";

    $mail->Body = "
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Reset Password - Aurora</title>
</head>

<body style='margin:0; padding:0; background:#F6F4F1; 
             font-family: Helvetica Neue, Arial, sans-serif; color:#333333;'>

<table align='center' width='100%' cellpadding='0' cellspacing='0'
       style='max-width:620px; margin:40px auto; background:#ffffff;
              border-radius:18px; overflow:hidden;
              box-shadow:0 18px 40px rgba(0,0,0,0.08);'>

    <!-- Header -->
    <tr>
        <td style='background:#B5838D; padding:36px 30px; text-align:center;'>
            <h1 style='margin:0; font-family: Georgia, serif;
                       font-size:30px; font-weight:500;
                       color:#ffffff; letter-spacing:1.5px;'>
                Aurora
            </h1>
            <p style='margin:10px 0 0; font-size:13px;
                      letter-spacing:1px; text-transform:uppercase;
                      color:#F6F4F1;'>
                Modern · Elegant · Timeless
            </p>
        </td>
    </tr>

    <!-- Content -->
    <tr>
        <td style='padding:42px 40px;'>
            <h2 style='margin:0 0 18px; font-family: Georgia, serif;
                       font-size:22px; font-weight:500;
                       color:#B5838D;'>
                Hello, $name
            </h2>

            <p style='font-size:15px; line-height:1.8; margin:0 0 18px;'>
                We received a request to reset your Aurora account password.
            </p>

            <p style='font-size:15px; line-height:1.8; margin:0 0 24px;'>
                Click the button below to set a new password. This link will expire in 1 hour.
            </p>

            <!-- Reset Button -->
            <a href='$link'
               style='display:inline-block;margin-top:20px;
                      background:#B5838D;color:#fff;
                      padding:12px 22px;text-decoration:none;
                      border-radius:4px;'>
               Reset Password
            </a>

            <p style='margin-top:20px;color:#777'>
                If you did not request a password reset, you can safely ignore this email.
            </p>
        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style='background:#F6F4F1; padding:22px; text-align:center;'>
            <p style='margin:0; font-size:12px;
                      letter-spacing:0.5px;
                      color:#777777;'>
                © " . date("Y") . " Aurora — Crafted with elegance
            </p>
        </td>
    </tr>

</table>

</body>
</html>
";

    $mail->send();

    echo json_encode([
        "success" => true,
        "message" => "If the email exists, a reset link has been sent."
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Could not send email: " . $mail->ErrorInfo
    ]);
}

$conn->close();
?>
