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

$name     = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!$name || !$email || !$password) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit();
}

$check = $conn->prepare("SELECT id FROM user_accounts WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Email already exists."]);
    exit();
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("
    INSERT INTO user_accounts (name, email, password, role, status)
    VALUES (?, ?, ?, 'user', 'active')
");
$stmt->bind_param("sss", $name, $email, $hashed);

if (!$stmt->execute()) {
    echo json_encode(["success" => false, "message" => "Failed to create account."]);
    exit();
}

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
    $mail->Subject = "Welcome to Aurora ";

$mail->Body = "
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>Welcome to Aurora</title>
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
                Welcome, $name
            </h2>

            <p style='font-size:15px; line-height:1.8; margin:0 0 18px;'>
                Thank you for joining <strong>Aurora</strong>.  
                We design bags for women who appreciate refined details,
                modern silhouettes, and effortless elegance.
            </p>

            <p style='font-size:15px; line-height:1.8; margin:0 0 24px;'>
                Your account has been successfully created using the email below.
            </p>

            <!-- Email Card -->
            <div style='background:#F6F4F1;
                        border:1px solid #E5C3A6;
                        padding:18px 20px;
                        border-radius:12px;
                        margin-bottom:28px;'>
                <p style='margin:0; font-size:14px; color:#333333;'>
                    <span style='color:#777777; letter-spacing:0.5px;'>EMAIL</span><br>
                    <strong>$email</strong>
                </p>
            </div>

            <p style='font-size:14px; line-height:1.7; color:#777777; margin:0 0 34px;'>
                Discover curated collections, save your favorites,
                and enjoy exclusive offers created just for you.
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
        "message" => "Account created successfully! Welcome email sent."
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => true,
        "message" => "Account created, but email could not be sent."
    ]);
}

$conn->close();
?>
