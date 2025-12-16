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
    <title>About Us - Aurora Bags</title>
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

        /* === ABOUT PAGE STYLES === */
        .about-hero {
            background-color: var(--color-secondary);
            text-align: center;
            padding: 6rem 5vw;
        }

        .about-hero h1 {
            font-family: var(--font-serif);
            font-size: 3.5rem;
            font-weight: normal;
            color: var(--color-primary);
            margin-bottom: 1rem;
        }

        .about-hero p {
            max-width: 800px;
            margin: 0 auto;
            font-size: 1.2rem;
            color: var(--color-light-text);
        }

        .story-section {
            padding: 6rem 10vw;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }

        .story-image-placeholder {
            background-color: var(--color-accent);
            height: 500px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: var(--font-serif);
            color: white;
            font-size: 1.5rem;
            opacity: 0.8;
            padding: 2rem;
        }
        /* Image Placeholder for story section: Handbag being carefully crafted */
        


        .story-text h2 {
            font-family: var(--font-serif);
            font-size: 2.5rem;
            font-weight: normal;
            color: var(--color-primary);
            margin-bottom: 2rem;
        }

        .story-text p {
            margin-bottom: 1.5rem;
            color: var(--color-text);
        }

        .story-text p:last-child {
            margin-bottom: 0;
        }

        .mission-vision {
            background-color: var(--color-secondary);
            padding: 6rem 5vw;
            text-align: center;
        }

        .mission-vision h2 {
            font-family: var(--font-serif);
            font-size: 2.5rem;
            font-weight: normal;
            color: var(--color-primary);
            margin-bottom: 3rem;
        }

        .cards-container {
            display: flex;
            justify-content: center;
            gap: 3rem;
        }

        .card {
            max-width: 350px;
            padding: 2rem;
            background-color: white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            text-align: left;
            border-top: 5px solid var(--color-accent);
        }

        .card h3 {
            font-family: var(--font-serif);
            font-size: 1.5rem;
            color: var(--color-text);
            margin-bottom: 1rem;
        }

        /* === MOBILE RESPONSIVENESS === */
        @media (max-width: 900px) {
            /* Mobile Nav styles from index.html (omitted for brevity) */
            .story-section {
                grid-template-columns: 1fr;
                gap: 3rem;
                padding: 4rem 5vw;
            }

            .story-image-placeholder {
                height: 300px;
                order: -1;
            }

            .cards-container {
                flex-direction: column;
                align-items: center;
                gap: 2rem;
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
                if (link.href.includes('about.html')) {
                    link.closest('li').classList.add('active');
                }
            });
        });
    </script>
</head>
<body>

    <header class="header">
        <div class="logo">Aurora</div>
        <nav>
            <!-- <ul class="nav-menu">
                <li class="nav-item"><a href="index.php">Home</a></li>
                <li class="nav-item"><a href="products.php">Products</a></li>
                <li class="nav-item"><a href="gallery.php">Gallery</a></li>
                <li class="nav-item active"><a href="about.php">About Us</a></li>
                <li class="nav-item"><a href="contact.php">Contact Us</a></li>
                <li class="nav-item"><a href="login.php">Login/Signup</a></li>
                <li class="nav-item"><a href="cart.php">Cart</a></li>
                <a href="admin_logout.php" style="color: #E74C3C;">Logout</a>
            </ul> -->
            <ul class="nav-menu">
                <li class="nav-item"><a href="user_home.php">Home</a></li>
                <li class="nav-item"><a href="products.php">Products</a></li>
                <li class="nav-item active"><a href="about.php">About Us</a></li>
                <li class="nav-item"><a href="contact.php">Contact Us</a></li>
                <li class="nav-item"><a href="cart.php">Cart</a></li>
                <a href="admin_logout.php" style="color: #E74C3C;">Logout</a>
            </ul>

        </nav>
        <div class="mobile-menu-toggle">☰</div>
    </header>

    <main>
        <section class="about-hero">
            <h1>Our Story: Where Simplicity Meets Luxury</h1>
            <p>Aurora was founded on the principle that true elegance is found in the minimalist design and unparalleled quality of materials.</p>
        </section>

        <section class="story-section">
            <div class="story-image-placeholder">
                <img src="craft.jpg" alt="Handbag being carefully crafted" style="max-width:100%; max-height:100%;">
            </div>
            <div class="story-text">
                <h2>The Art of the Handbag</h2>
                <p>Born from a desire to create accessories that transcend trends, every Aurora bag is a testament to meticulous craftsmanship. We believe a bag is not merely a carryall, but a subtle statement of sophistication.</p>
                <p>We source the finest materials, focusing on sustainable practices and ethical production. Our small, dedicated team of artisans ensures that every stitch and seam meets the highest standard of luxury. It is a process rooted in tradition, yet designed for the modern woman.</p>
            </div>
        </section>

        <section class="mission-vision">
            <h2>Our Core Values</h2>
            <div class="cards-container">
                <div class="card">
                    <h3>Purity of Design</h3>
                    <p>We embrace a minimalist aesthetic, stripping away the superfluous to highlight the intrinsic beauty of shape and texture.</p>
                </div>
                <div class="card">
                    <h3>Uncompromising Quality</h3>
                    <p>From the leather to the lining, every component is selected for durability, feel, and its ability to age gracefully.</p>
                </div>
                <div class="card">
                    <h3>Feminine Strength</h3>
                    <p>Our designs are for the woman who is both elegant and powerful, offering refined pieces that support her dynamic life.</p>
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

</body>
</html>