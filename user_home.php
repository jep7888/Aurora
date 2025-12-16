<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aurora Bags - Luxury Women's Handbags</title>
    <style>
        /* === GLOBAL STYLES === */
        :root {
            --color-primary: #B5838D; /* Blush Pink */
            --color-secondary: #F6F4F1; /* Soft Beige/Off-White */
            --color-accent: #E5C3A6; /* Soft Rose Gold/Copper */
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

        /* === NAVIGATION BAR (UPDATED FOR RESPONSIVENESS) === */
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

        /* === HERO SECTION (index.html) === */
        .hero {
            height: 80vh;
            background-color: var(--color-secondary);
            display: flex;
            align-items: center;
            padding: 0 5vw;
            overflow: hidden;
            position: relative;
        }

        .hero-text {
            max-width: 45%;
            padding-right: 5rem;
            z-index: 10;
        }

        .hero-text h1 {
            font-family: var(--font-serif);
            font-size: 4rem;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            font-weight: normal;
        }

        .hero-text p {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            color: var(--color-light-text);
        }

        .cta-button {
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
        }

        .cta-button:hover {
            background-color: white;
            color: var(--color-primary);
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(181, 131, 141, 0.3);
        }

        .hero-image-placeholder {
            position: absolute;
            right: 0;
            top: 0;
            width: 60%;
            height: 100%;
            background-color: var(--color-accent);
            clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: var(--font-serif);
            font-size: 1.5rem;
            color: white;
            opacity: 0.8;
        }
        /* Image Placeholder for hero section: Woman with a stylish bag */
        

        /* === FEATURED SECTION === */
        .featured {
            padding: 5rem 5vw;
            text-align: center;
        }

        .featured h2 {
            font-family: var(--font-serif);
            font-size: 2.5rem;
            margin-bottom: 3rem;
            font-weight: normal;
            position: relative;
        }

        .featured h2::after {
            content: '';
            display: block;
            width: 50px;
            height: 2px;
            background-color: var(--color-accent);
            margin: 10px auto 0;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2.5rem;
        }

        .product-card {
            text-align: left;
            overflow: hidden;
        }

        .product-image{
            background-color: var(--color-secondary);
            height: 350px;
            margin-bottom: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: var(--font-serif);
            color: var(--color-light-text);
            font-size: 1.2rem;
            transition: transform var(--transition-speed) ease;
            cursor: pointer;
        }

        .product-image:hover {
            transform: scale(1.03);
            background-color: var(--color-accent);
            color: white;
        }

        .product-card h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            font-weight: normal;
        }

        .product-card .price {
            color: var(--color-primary);
            font-weight: bold;
            font-size: 1.1rem;
        }

        /* === FOOTER === */
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


        /* === MOBILE RESPONSIVENESS (UPDATED) === */
        @media (max-width: 900px) {
            .hero {
                height: auto;
                flex-direction: column;
                padding: 5rem 5vw;
            }

            .hero-text {
                max-width: 100%;
                padding-right: 0;
                text-align: center;
                margin-bottom: 3rem;
            }

            .hero-text h1 {
                font-size: 3rem;
            }

            .hero-image-placeholder {
                position: relative;
                width: 100%;
                height: 400px;
                clip-path: none;
            }
            
            /* **THE NAVIGATION FIX** */
            .mobile-menu-toggle {
                display: block; 
            }

            .nav-menu {
                display: none; /* Hidden by default on mobile */
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
                display: flex; /* Shown when toggled */
            }

            .nav-menu a {
                padding: 0.5rem 0;
            }
            /* End of Navigation Fix */

            .footer-content {
                flex-direction: column;
                gap: 2rem;
            }
        }

        /* NEW */
        .product-image {
            width: 100%;
            height: 350px; 
            background-color: #f5f2ef; 
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
    </style>
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
                <li class="nav-item active"><a href="user_home.php">Home</a></li>
                <li class="nav-item"><a href="products.php">Products</a></li>
                <!-- <li class="nav-item"><a href="gallery.php">Gallery</a></li> -->
                <li class="nav-item"><a href="about.php">About Us</a></li>
                <li class="nav-item"><a href="contact.php">Contact Us</a></li>
                <li class="nav-item"><a href="cart.php">Cart</a></li>
                <a href="admin_logout.php" style="color: #E74C3C;">Logout</a>
            </ul>
        </nav>
        <div class="mobile-menu-toggle">☰</div>
    </header>

    <main>
        <section class="hero">
            <div class="hero-text">
                <h1>Elegance Reimagined. Discover the Aurora Collection.</h1>
                <p>Curated luxury, minimalist design. Find the perfect accessory that complements your unique style.</p>
                <a href="products.php" class="cta-button">Shop Now</a>
            </div>
            <div class="hero-image-placeholder">
                <img src="IMG2.jpg">
            </div>
        </section>

        <section class="featured">
            <h2>Featured Styles</h2>
            <div class="product-grid">
                <div class="product-card">
                    <div class="product-image"> <img src="Bag1.jpg" alt="The Luna Tote"> </div>
                    <h3>The Luna Tote</h3>
                </div>
                <div class="product-card">
                    <div class="product-image"> <img src="Bag2.jpg" alt="The Venus Crossbody"> </div>
                    <h3>The Venus Crossbody</h3>
                </div>
                <div class="product-card">
                    <div class="product-image"> <img src="Bag3.jpg" alt="The Stella Clutch"> </div>
                    <h3>The Stella Clutch</h3>
                </div>
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

        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            const navMenu = document.querySelector('.nav-menu');
            const navLinks = document.querySelectorAll('.nav-menu a');

            // Mobile menu toggle functionality
            mobileMenuToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
                // Change icon from '☰' to '✕' and vice-versa
                mobileMenuToggle.textContent = navMenu.classList.contains('active') ? '✕' : '☰';
            });

            // Active link highlighting
            const path = window.location.pathname;
            const page = path.split("/").pop();
            
            navLinks.forEach(link => {
                // Logic to set 'active' class based on the current page
                if (link.href.includes(page) && (page === 'index.html' || page === '')) {
                    link.closest('li').classList.add('active');
                }
            });
        });
    </script>
</body>
</html>