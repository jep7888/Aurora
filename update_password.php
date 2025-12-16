<?php
require "db_connect.php";

$token = $_POST['token'] ?? '';
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$token_safe = $conn->real_escape_string($token);
$password_safe = $conn->real_escape_string($password);

$result = $conn->query("SELECT email FROM password_resets WHERE token = '$token_safe'");
$data = $result->fetch_assoc();

if (!$data) die("Invalid token.");

$user_email = $data['email'];
$user_email_safe = $conn->real_escape_string($user_email);

$conn->query("
    UPDATE user_accounts
    SET password = '$password_safe'
    WHERE email = '$user_email_safe'
");

$conn->query("
    DELETE FROM password_resets
    WHERE email = '$user_email_safe'
");

echo "Password updated. You can now login.";
?>
