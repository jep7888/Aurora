<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Signup - Aurora Bags</title>
    <style>
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

        /* === LOGIN/SIGNUP PAGE STYLES === */
        .auth-container {
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--color-secondary);
            padding: 4rem 5vw;
        }

        .auth-box {
            background-color: white;
            padding: 3rem 4rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            max-width: 450px;
            width: 100%;
            text-align: center;
        }

        .tab-buttons {
            display: flex;
            margin-bottom: 2rem;
        }

        .tab-button {
            flex: 1;
            padding: 1rem 0;
            background: none;
            border: none;
            border-bottom: 2px solid #ddd;
            font-family: var(--font-serif);
            font-size: 1.2rem;
            color: var(--color-light-text);
            cursor: pointer;
            transition: all var(--transition-speed);
        }

        .tab-button.active {
            border-bottom: 2px solid var(--color-primary);
            color: var(--color-primary);
            font-weight: bold;
        }

        .auth-form {
            display: none;
        }

        .auth-form.active {
            display: block;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            font-weight: bold;
            color: var(--color-text);
        }

        .form-group input {
            width: 100%;
            padding: 1rem;
            border: 1px solid #eee;
            background-color: var(--color-secondary);
            font-family: inherit;
            font-size: 1rem;
            transition: border-color var(--transition-speed);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--color-primary);
            background-color: white;
        }

        .submit-button {
            width: 100%;
            padding: 1rem;
            margin-top: 1rem;
            background-color: var(--color-primary);
            color: white;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: background-color var(--transition-speed), box-shadow var(--transition-speed);
        }

        .submit-button:hover {
            background-color: #A3737C;
            box-shadow: 0 5px 15px rgba(181, 131, 141, 0.4);
        }

        .auth-box p {
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .auth-box a {
            color: var(--color-primary);
            font-weight: bold;
        }

        @media (max-width: 600px) {
            .auth-box {
                padding: 2rem;
            }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* === MODAL ANIMATIONS === */
        @keyframes drawCheck {
            to { stroke-dashoffset: 0; }
        }
        @keyframes popIn {
            0% { transform: scale(0.6); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        @keyframes modalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>

<body>

    <header class="header">
        <div class="logo">Aurora</div>
    </header>

    <main>
        <section class="auth-container">
            <div class="auth-box">
                <div class="tab-buttons">
                    <button id="login-tab-btn" class="tab-button active">Login</button>
                    <button id="signup-tab-btn" class="tab-button">Signup</button>
                </div>

                <form id="login-form" class="auth-form active" method="POST" action="login_function.php">
                    <div class="form-group">
                        <label for="login-email">Email Address</label>
                        <input type="email" id="login-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" id="login-password" name="password" required>
                    </div>
                    <button type="submit" class="submit-button">Sign In</button>
                    <p><a href="forgot_password.php">Forgot Password?</a></p>
                </form>

                <form id="signup-form" class="auth-form">
                    <div class="form-group">
                        <label for="signup-name">Full Name</label>
                        <input type="text" id="signup-name" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-email">Email Address</label>
                        <input type="email" id="signup-email" required>
                    </div>

                    <div class="form-group" style="position: relative;">
                        <label for="signup-password">Password</label>
                        <input type="password" id="signup-password" required style="padding-right: 35px;">
                        <span class="toggle-password" style="position:absolute; top:50px; right:10px; cursor:pointer; width:20px; height:20px;">
                            <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20" style="display:none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88a3 3 0 104.24 4.24"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-1.768 0-3.44-.502-4.884-1.36"/>
                            </svg>
                        </span>
                    </div>

                    <div class="form-group" style="position: relative;">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" required style="padding-right: 35px;">
                        <span class="toggle-password" style="position:absolute; top:50px; right:10px; cursor:pointer; width:20px; height:20px;">
                            <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20" style="display:none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88a3 3 0 104.24 4.24"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-1.768 0-3.44-.502-4.884-1.36"/>
                            </svg>
                        </span>
                    </div>

                    <button type="submit" class="submit-button" id="signupBtn">
                        <span id="signupBtnText">Create Account</span>
                        <span id="signupLoader"
                            style="display:none;
                                    margin-left:10px;
                                    width:16px;
                                    height:16px;
                                    border:2px solid rgba(255,255,255,0.4);
                                    border-top:2px solid #fff;
                                    border-radius:50%;
                                    animation: spin 0.8s linear infinite;
                                    vertical-align:middle;">
                        </span>
                    </button>
                    <!-- <p>By signing up, you agree to our <a href="#">Terms & Privacy</a>.</p> -->
                </form>
            </div>
        </section>
    </main>


    <!-- SUCCESS MODAL -->
    <div id="successModal" style="
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 2000;
    ">

        <div style="
            background: #ffffff;
            width: 360px;
            padding: 42px 36px;
            border-radius: 22px;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0,0,0,0.2);
            animation: modalFadeIn 0.4s ease;
            font-family: Helvetica Neue, Arial, sans-serif;
        ">

            <div style="
                width: 96px;
                height: 96px;
                border-radius: 50%;
                background: #B5838D;
                margin: 0 auto 28px;
                display: flex;
                align-items: center;
                justify-content: center;
                animation: popIn 0.5s ease forwards;
            ">

                <svg width="48" height="36" viewBox="0 0 52 40" style="display:block;">
                    <path
                        d="M2 22 L20 38 L50 2"
                        fill="none"
                        stroke="#ffffff"
                        stroke-width="6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-dasharray="80"
                        stroke-dashoffset="80"
                        style="animation: drawCheck 0.6s ease forwards 0.4s;"
                    />
                </svg>

            </div>

            <h2 style="
                font-family: Georgia, serif;
                font-size: 22px;
                font-weight: 500;
                color: #333333;
                margin-bottom: 12px;
            ">
                Account Created
            </h2>

            <p style="
                font-size: 14px;
                color: #777777;
                line-height: 1.7;
                margin: 0;
            ">
                Welcome to <strong>Aurora</strong>.  
                Your account has been successfully created.
            </p>

        </div>
    </div>

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

        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loginBtn = document.getElementById('login-tab-btn');
            const signupBtn = document.getElementById('signup-tab-btn');
            const loginForm = document.getElementById('login-form');
            const signupForm = document.getElementById('signup-form');
            const signupPassword = document.getElementById('signup-password');
            const confirmPassword = document.getElementById('confirm-password');

            function switchTab(target) {
                if (target === 'login') {
                    loginBtn.classList.add('active');
                    signupBtn.classList.remove('active');
                    loginForm.classList.add('active');
                    signupForm.classList.remove('active');
                } else {
                    signupBtn.classList.add('active');
                    loginBtn.classList.remove('active');
                    signupForm.classList.add('active');
                    loginForm.classList.remove('active');
                }
            }

            loginBtn.addEventListener('click', () => switchTab('login'));
            signupBtn.addEventListener('click', () => switchTab('signup'));

            switchTab('login');

            const btn = document.getElementById('signupBtn');
            const btnText = document.getElementById('signupBtnText');
            const loader = document.getElementById('signupLoader');

            signupForm.addEventListener('submit', async (e) => {
                e.preventDefault();

                const name = document.getElementById('signup-name').value.trim();
                const email = document.getElementById('signup-email').value.trim();
                const password = document.getElementById('signup-password').value;
                const confirmPassword = document.getElementById('confirm-password').value;

                if (password !== confirmPassword) {
                    alert('Passwords do not match.');
                    return;
                }

                btn.disabled = true;
                btnText.textContent = 'Creating';
                loader.style.display = 'inline-block';

                const formData = new FormData();
                formData.append('name', name);
                formData.append('email', email);
                formData.append('password', password);

                try {
                    const response = await fetch("Signup.php", { method: "POST", body: formData });
                    const result = await response.json();

                    if (result.success) {
                        signupForm.reset();
                        showSuccessModal();
                    } else {
                        alert("Error: " + result.message);
                    }

                } catch (error) {
                    alert("Failed to connect to server.");
                } finally {
                    btn.disabled = false;
                    btnText.textContent = 'Create Account';
                    loader.style.display = 'none';
                }
            });

            // Toggle password visibility
            document.querySelectorAll('.toggle-password').forEach((container, idx) => {
                const eyeOpen = container.querySelector('.eye-open');
                const eyeClosed = container.querySelector('.eye-closed');
                const input = idx === 0 ? signupPassword : confirmPassword;

                container.addEventListener('click', () => {
                    if (input.type === 'password') {
                        input.type = 'text';
                        eyeOpen.style.display = 'none';
                        eyeClosed.style.display = 'block';
                    } else {
                        input.type = 'password';
                        eyeOpen.style.display = 'block';
                        eyeClosed.style.display = 'none';
                    }
                });
            });

            // Real-time password mismatch check
            confirmPassword.addEventListener('input', () => {
                if (signupPassword.value !== confirmPassword.value) {
                    signupPassword.style.borderColor = '#e74c3c';
                    confirmPassword.style.borderColor = '#e74c3c';
                } else {
                    signupPassword.style.borderColor = '';
                    confirmPassword.style.borderColor = '';
                }
            });

            // modal function
            function showSuccessModal() {
                const modal = document.getElementById('successModal');
                modal.style.display = 'flex';
                setTimeout(() => { modal.style.display = 'none'; }, 2000);
            }
        });
    </script>

</body>
</html>