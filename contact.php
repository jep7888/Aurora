<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
require "db_connect.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    if ($name && $email && $message) {

        $stmt = $conn->prepare(
            "INSERT INTO contact_messages (name, email, subject, message)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'aurora.official00000@gmail.com'; 
                $mail->Password = 'jgqhobzuqjpmbbow'; 
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom($email, $name);
                $mail->addAddress('aurora.official00000@gmail.com');

                $mail->isHTML(true);
                $mail->Subject = "New Contact Message: " . ($subject ?: "No Subject");
                $mail->Body = '
                        <!DOCTYPE html>
                        <html>
                        <head>
                        <meta charset="UTF-8">
                        <title>New Contact Message</title>
                        </head>
                        <body style="margin:0;padding:0;background-color:#F6F4F1;font-family:Arial,Helvetica,sans-serif;color:#333333;">

                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#F6F4F1;padding:40px 0;">
                        <tr>
                        <td align="center">

                        <table width="600" cellpadding="0" cellspacing="0" style="background:#FFFFFF;border-radius:6px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.08);">

                        <tr>
                        <td style="background-color:#B5838D;padding:24px;text-align:center;">
                            <h1 style="margin:0;font-family:Georgia,serif;font-size:26px;color:#FFFFFF;letter-spacing:2px;">
                                Aurora Bags
                            </h1>
                            <p style="margin:6px 0 0;color:#F6F4F1;font-size:14px;">
                                New Contact Message
                            </p>
                        </td>
                        </tr>

                        <tr>
                        <td style="padding:30px;">

                        <p style="font-size:15px;color:#777777;margin-bottom:20px;">
                        You have received a new message from the contact form.
                        </p>

                        <table width="100%" cellpadding="0" cellspacing="0">

                        <tr>
                        <td style="padding:10px 0;">
                            <strong style="color:#B5838D;">Name:</strong><br>
                            <span style="color:#333333;">' . htmlspecialchars($name) . '</span>
                        </td>
                        </tr>

                        <tr>
                        <td style="padding:10px 0;">
                            <strong style="color:#B5838D;">Email:</strong><br>
                            <span style="color:#333333;">' . htmlspecialchars($email) . '</span>
                        </td>
                        </tr>

                        <tr>
                        <td style="padding:10px 0;">
                            <strong style="color:#B5838D;">Subject:</strong><br>
                            <span style="color:#333333;">' . htmlspecialchars($subject ?: "No Subject") . '</span>
                        </td>
                        </tr>

                        <tr>
                        <td style="padding:10px 0;">
                            <strong style="color:#B5838D;">Message:</strong><br>
                            <div style="margin-top:8px;padding:15px;background:#F6F4F1;border-left:4px solid #E5C3A6;color:#333333;">
                                ' . nl2br(htmlspecialchars($message)) . '
                            </div>
                        </td>
                        </tr>

                        </table>

                        </td>
                        </tr>

                        <tr>
                        <td style="background-color:#F6F4F1;padding:20px;text-align:center;font-size:12px;color:#777777;">
                            © ' . date("Y") . ' Aurora Bags · Contact Notification
                        </td>
                        </tr>

                        </table>

                        </td>
                        </tr>
                        </table>

                        </body>
                        </html>
                        ';


                $mail->send();
                $success = "Thank you! Your message has been sent.";

            } catch (Exception $e) {
                $success = "Message saved, but email failed to send.";
            }

        } else {
            $error = "Database error. Please try again.";
        }

    } else {
        $error = "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Aurora Bags</title>
    <style>
        /* Shared Global and Nav/Footer Styles from index.html (omitted for brevity, assume they are present) */
        :root {
            --color-primary: #B5838D;
            --color-secondary: #F6F4F1;
            --color-accent: #E5C3A6;
            --color-text: #333333;
            --color-light-text: #777777;
            --font-serif: 'Georgia', serif;
            --font-sans: 'Helvetica Neue', sans-serif;
            --transition-speed: 0.3s;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-sans);
            color: var(--color-text);
            background-color: #FFFFFF;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: var(--color-text);
            transition: color var(--transition-speed);
        }

        a:hover {
            color: var(--color-primary);
        }

        /* === NAVIGATION BAR === */
        .header {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 1.5rem 5vw;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.05);
        }

        .logo {
            font-family: var(--font-serif);
            font-size: 1.8rem;
            font-weight: bold;
            letter-spacing: 2px;
            color: var(--color-primary);
        }

        .nav-menu {
            list-style: none;
            display: flex;
            gap: 2rem;
        }

        .nav-menu a {
            font-family: var(--font-serif);
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-bottom: 5px;
            position: relative;
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0;
            height: 1px;
            background-color: var(--color-primary);
            transition: width var(--transition-speed) ease-in-out;
        }

        .nav-menu a:hover::after,
        .nav-menu .active a::after {
            width: 100%;
        }

        .mobile-menu-toggle {
            display: none; 
            cursor: pointer;
            font-size: 1.5rem;
            line-height: 1; 
            z-index: 1001; 
            color: var(--color-primary);
        }

        @media (max-width: 900px) {
            .mobile-menu-toggle {
                display: block; 
            }

            .nav-menu {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background-color: white;
                box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
                padding: 1rem 5vw;
                gap: 0.5rem;
            }

            .nav-menu.active {
                display: flex;
            }

            .nav-menu a {
                padding: 0.5rem 0;
            }

            .hero-text h1 {
                font-size: 3rem;
            }
            
        }

        .footer {
            background-color: var(--color-text);
            color: white;
            padding: 4rem 5vw;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 3rem;
        }

        .footer-section {
            flex: 1;
            min-width: 200px;
        }

        .footer-section h4 {
            font-family: var(--font-serif);
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            color: var(--color-accent);
            font-weight: normal;
        }

        .footer-section p, .footer-section a {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.8;
        }

        .footer-section a:hover {
            color: var(--color-primary);
        }

        .footer-links ul {
            list-style: none;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            font-size: 1.5rem;
        }

        .social-icons a {
            color: white;
            transition: color var(--transition-speed);
        }

        .social-icons a:hover {
            color: var(--color-primary);
        }

        .footer-bottom {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
        }

        /* === CONTACT PAGE STYLES === */
        .contact-section {
            padding: 6rem 5vw;
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .contact-info h1 {
            font-family: var(--font-serif);
            font-size: 3rem;
            font-weight: normal;
            color: var(--color-primary);
            margin-bottom: 2rem;
        }

        .contact-info p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .details-list {
            list-style: none;
        }

        .details-list li {
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .details-list strong {
            display: block;
            font-family: var(--font-serif);
            font-size: 1.2rem;
            color: var(--color-accent);
            margin-bottom: 0.3rem;
        }

        .contact-form form {
            background-color: var(--color-secondary);
            padding: 2.5rem;
            border: 1px solid rgba(181, 131, 141, 0.2);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: var(--color-primary);
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 1px solid #ddd;
            font-family: inherit;
            font-size: 1rem;
            transition: border-color var(--transition-speed);
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--color-primary);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 150px;
        }

        .submit-button {
            display: inline-block;
            padding: 1rem 2.5rem;
            background-color: var(--color-primary);
            color: white;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
            font-size: 1rem;
            border: 2px solid var(--color-primary);
            transition: all var(--transition-speed) ease;
            cursor: pointer;
        }

        .submit-button:hover {
            background-color: white;
            color: var(--color-primary);
            box-shadow: 0 5px 15px rgba(181, 131, 141, 0.3);
        }

        /* === MOBILE RESPONSIVENESS === */
        @media (max-width: 900px) {
            /* Mobile Nav styles from index.html (omitted for brevity) */
            .contact-section {
                grid-template-columns: 1fr;
                gap: 3rem;
                padding: 4rem 5vw;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Replicate basic nav functionality from index.html
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            const navMenu = document.querySelector('.nav-menu');
            const navLinks = document.querySelectorAll('.nav-menu a');

            mobileMenuToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                mobileMenuToggle.textContent = navMenu.classList.contains('active') ? '✕' : '☰';
            });

            // Set active link
            navLinks.forEach(link => {
                if (link.href.includes('contact.html')) {
                    link.closest('li').classList.add('active');
                }
            });

            // Contact Form Validation/Submission Logic
            const contactForm = document.getElementById('contact-form');
            contactForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent actual form submission

                const name = document.getElementById('name').value.trim();
                const email = document.getElementById('email').value.trim();
                const message = document.getElementById('message').value.trim();
                
                if (!name || !email || !message) {
                    alert('Please fill out all fields.');
                    return;
                }

                // Simple email regex for client-side check
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    alert('Please enter a valid email address.');
                    return;
                }

                // If validation passes (in a real app, use fetch/XMLHttpRequest here)
                alert('Thank you for your message, ' + name + '! We will be in touch soon. (Form Submission Placeholder)');
                contactForm.reset();
            });
        });
    </script>
</head>
<body>

    <header class="header">
        <div class="logo">
            Aurora
            <?php if (isset($_SESSION['user_name'])): ?>
                <span style="font-size:14px; font-weight:normal;">
                    — Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>
                </span>
            <?php endif; ?>
        </div>
        <nav>
            <ul class="nav-menu">
                <li class="nav-item"><a href="user_home.php">Home</a></li>
                <li class="nav-item"><a href="products.php">Products</a></li>
                <li class="nav-item "><a href="about.php">About Us</a></li>
                <li class="nav-item active"><a href="contact.php">Contact Us</a></li>
                <li class="nav-item"><a href="cart.php">Cart</a></li>
                <a href="admin_logout.php" style="color: #E74C3C;">Logout</a>
            </ul>
        </nav>
        <div class="mobile-menu-toggle">☰</div>
    </header>

    <main>
        <section class="contact-section">
            <div class="contact-info">
                <h1>Get In Touch</h1>
                <p>Whether you have a question about our collection, need styling advice, or require customer support, we are here to assist you with a personal touch.</p>

                <ul class="details-list">
                    <li>
                        <strong>Customer Care</strong>
                        <a href="mailto:support@aurorabags.com">support@aurorabags.com</a>
                    </li>
                    <li>
                        <strong>Press & Collaborations</strong>
                        <a href="mailto:press@aurorabags.com">press@aurorabags.com</a>
                    </li>
                    <li>
                        <strong>Visit Our Boutique (Appointment Only)</strong>
                        <p>101 Ethereal St, Suite 500<br>Luxury City, State 01234</p>
                    </li>
                </ul>
            </div>

            <div class="contact-form">
                <?php if ($success): ?>
                    <p style="color:green;font-weight:bold;margin-bottom:1rem;">
                        <?= $success ?>
                    </p>
                <?php endif; ?>

                <?php if ($error): ?>
                    <p style="color:red;font-weight:bold;margin-bottom:1rem;">
                        <?= $error ?>
                    </p>
                <?php endif; ?>

               <form method="POST" action="contact.php">
                <div class="form-group">
                    <label>Your Name</label>
                    <input type="text" name="name" required>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" name="subject">
                </div>

                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" required></textarea>
                </div>

                <button type="submit" class="submit-button">Send Message</button>
            </form>

            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>Aurora Bags</h4>
                <p>Luxury defined by simplicity. Crafting exceptional handbags for the modern woman who values elegance and quality.</p>
            </div>

            <div class="footer-section">
                <h4>Contact Us</h4>
                <p>Email: aurora.official00000@gmail.com</p>
                <p>Phone:  09655075875</p>
                <p>Address: Balas Mexico Pampanga</p>
            </div>
            <div class="footer-section">
                <h4>Follow Us</h4>
                <div class="social-icons">
                    <p>FB: Gel Tobias </p>
                    <p>IG: @mm_softgellyy</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2025 Aurora Bags. All Rights Reserved.
        </div>
    </footer>

</body>
</html>