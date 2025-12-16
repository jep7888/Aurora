<?php
require "db_connect.php";

$token = $_GET['token'] ?? '';
$token_safe = $conn->real_escape_string($token);

$result = $conn->query("SELECT email FROM password_resets WHERE token = '$token_safe'");
if ($result->num_rows === 0) {
    die("Invalid or expired reset link.");
}

$user = $result->fetch_assoc();
$user_email = $user['email'];
$user_email_safe = $conn->real_escape_string($user_email);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $password_safe = $conn->real_escape_string($password_hashed);

        if (!$conn->query("UPDATE user_accounts SET password = '$password_safe' WHERE email = '$user_email_safe'")) {
            $error = "Database error: " . $conn->error;
        } else {
            $conn->query("DELETE FROM password_resets WHERE email = '$user_email_safe'");
            $success = true;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body { background:#F6F4F1; font-family: Helvetica, Arial, sans-serif; }
        .box { max-width:400px; margin:100px auto; background:#fff; padding:30px; text-align:center; box-shadow:0 10px 30px rgba(0,0,0,.1); }
        h2 { font-family: Georgia, serif; color:#B5838D; }
        input { width:92%; padding:12px; margin-top:15px; border:1px solid #ddd; }
        button { width:100%; margin-top:20px; padding:12px; background:#B5838D; color:#fff; border:none; cursor:pointer; }
        .modal { display:none; position:fixed; z-index:1; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.4); }
        .modal-content { max-width:400px; margin:100px auto; background:#fff; padding:30px; text-align:center; box-shadow:0 10px 30px rgba(0,0,0,.1); border-radius:0; }
        .close { color:#aaa; float:right; font-size:28px; font-weight:bold; cursor:pointer; }
    </style>
</head>
<body>

<div class="box">
    <h2>Reset Password</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="password" name="password" placeholder="New password" required>
        <input type="password" name="confirm_password" placeholder="Confirm new password" required>
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <button type="submit">Change Password</button>
    </form>
</div>

<div id="successModal" class="modal" style="<?php if (isset($success)) echo 'display:block;'; ?>">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Password Changed</h2>
        <p>Your password has been updated successfully. You can now login.</p>
        <button onclick="redirectToIndex()">OK</button>
    </div>
</div>

<script>
function closeModal() {
    document.getElementById('successModal').style.display = 'none';
}

function redirectToIndex() {
    window.location.href = 'index.php';
}
</script>

</body>
</html>
