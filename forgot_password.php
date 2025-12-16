<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        body { background:#F6F4F1; font-family: Helvetica, Arial, sans-serif; }
        .box { max-width:400px; margin:100px auto; background:#fff; padding:30px; text-align:center; box-shadow:0 10px 30px rgba(0,0,0,.1); }
        h2 { font-family: Georgia, serif; color:#B5838D; }
        input { width:92%; padding:12px; margin-top:15px; border:1px solid #ddd; }
        button { width:100%; margin-top:20px; padding:12px; background:#B5838D; color:#fff; border:none; cursor:pointer; }
        .modal { display:none; position:fixed; z-index:1; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.4); }
        .modal-content { background-color:#fefefe; margin:15% auto; padding:20px; border:1px solid #888; width:80%; max-width:400px; text-align:center; }
        .close { color:#aaa; float:right; font-size:28px; font-weight:bold; cursor:pointer; }
    </style>
</head>
<body>

<div class="box">
    <h2>Forgot Password</h2>
    <p>Enter your email to receive a reset link.</p>

    <form id="forgotForm">
        <input type="email" name="email" id="email" required placeholder="Email address">
        <button type="submit">Send Reset Link</button>
    </form>
</div>

<div id="successModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Reset Link Sent</h2>
        <p>If the email exists, a reset link has been sent. Check your inbox.</p>
        <button onclick="redirectToIndex()">OK</button>
    </div>
</div>

<script>
document.getElementById('forgotForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('email').value;
    
    fetch('send_reset_email.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'email=' + encodeURIComponent(email)
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('successModal').style.display = 'block';
    })
    .catch(error => {
        alert('Error sending email. Please try again.');
    });
});

function closeModal() {
    document.getElementById('successModal').style.display = 'none';
}

function redirectToIndex() {
    window.location.href = 'index.php';
}
</script>

</body>
</html>
