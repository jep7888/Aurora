<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Style Gallery - Aurora Bags</title>
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

        /* === GALLERY PAGE STYLES === */
        .gallery-header {
            text-align: center;
            padding: 4rem 5vw 2rem;
            background-color: var(--color-secondary);
        }

        .gallery-header h1 {
            font-family: var(--font-serif);
            font-size: 3.5rem;
            font-weight: normal;
            color: var(--color-primary);
            margin-bottom: 1rem;
        }

        .gallery-header p {
            max-width: 800px;
            margin: 0 auto;
            font-size: 1.1rem;
            color: var(--color-light-text);
        }

        .gallery-grid {
            padding: 4rem 5vw;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            background-color: var(--color-secondary);
        }

        .gallery-image-placeholder {
            width: 100%;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: var(--font-serif);
            color: var(--color-text);
            font-size: 1.2rem;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover .gallery-image-placeholder {
            transform: scale(1.05);
        }

        .gallery-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 1rem;
            text-align: center;
            transform: translateY(100%);
            transition: transform 0.4s ease;
        }

        .gallery-item:hover .gallery-caption {
            transform: translateY(0);
        }

        .gallery-caption h3 {
            font-size: 1.1rem;
            font-weight: bold;
            color: var(--color-primary);
        }

        .gallery-caption p {
            font-size: 0.9rem;
            color: var(--color-light-text);
        }

        /* === MOBILE RESPONSIVENESS === */
        @media (max-width: 900px) {
            /* Mobile Nav styles from index.html (omitted for brevity) */
            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .gallery-image-placeholder {
                height: 300px;
            }

            .gallery-caption {
                /* Keep caption always visible on small screens for better accessibility */
                transform: translateY(0);
                position: relative;
                padding: 1rem 0;
                background-color: transparent;
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
                if (link.href.includes('gallery.html')) {
                    link.closest('li').classList.add('active');
                }
            });
            
            // Simple gallery hover/focus effects can be enhanced here if needed
            const galleryItems = document.querySelectorAll('.gallery-item');
            galleryItems.forEach(item => {
                item.addEventListener('click', () => {
                    // Placeholder for a lightbox or product link
                    const caption = item.querySelector('.gallery-caption h3').textContent;
                    alert(`Showing style details for: ${caption}`);
                });
            });
        });
    </script>
</head>
<body>

    <header class="header">
        <div class="logo">Aurora</div>
        <nav>
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.php">Home</a></li>
                <li class="nav-item"><a href="products.php">Products</a></li>
                <li class="nav-item active"><a href="gallery.php">Gallery</a></li>
                <li class="nav-item"><a href="about.php">About Us</a></li>
                <li class="nav-item"><a href="contact.php">Contact Us</a></li>
                <li class="nav-item"><a href="login.php">Login/Signup</a></li>
                <li class="nav-item"><a href="cart.php">Cart</a></li>
            </ul>
        </nav>
        <div class="mobile-menu-toggle">☰</div>
    </header>

    <main>
        <section class="gallery-header">
            <h1>Style Gallery: Aurora Muse</h1>
            <p>A curated feed of luxury street style and editorial looks featuring the Aurora collection. Get inspired by how others style elegance.</p>
        </section>

        <section class="gallery-grid">
            <div class="gallery-item">
                <div class="gallery-image-placeholder">The Venus Crossbody in Beige</div>
                <div class="gallery-caption">
                    <h3>City Chic</h3>
                    <p>Featuring The Venus Crossbody</p>
                </div>
            </div>
            <div class="gallery-item">
                <div class="gallery-image-placeholder">The Luna Tote - Office Look</div>
                <div class="gallery-caption">
                    <h3>Boardroom Ready</h3>
                    <p>Featuring The Luna Tote</p>
                </div>
            </div>
            <div class="gallery-item">
                <div class="gallery-image-placeholder">The Stella Clutch - Evening</div>
                <div class="gallery-caption">
                    <h3>Evening Grace</h3>
                    <p>Featuring The Stella Clutch</p>
                </div>
            </div>
            <div class="gallery-item">
                <div class="gallery-image-placeholder">The Sol Satchel - Day Out</div>
                <div class="gallery-caption">
                    <h3>Weekend Refinement</h3>
                    <p>Featuring The Sol Satchel</p>
                </div>
            </div>
            <div class="gallery-item">
                <div class="gallery-image-placeholder">Monochromatic Style</div>
                <div class="gallery-caption">
                    <h3>Minimalist Depth</h3>
                    <p>Featuring The Nova Backpack</p>
                </div>
            </div>
            <div class="gallery-item">
                <div class="gallery-image-placeholder">Close-up of Hardware</div>
                <div class="gallery-caption">
                    <h3>Detail Focus</h3>
                    <p>Rose Gold Accents</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section"><h4>Aurora Bags</h4><p>Luxury defined by simplicity...</p></div>
            <div class="footer-section footer-links"><h4>Quick Links</h4><ul><li><a href="products.html">Shop All</a></li><li><a href="about.html">Our Story</a></li><li><a href="contact.html">Customer Care</a></li><li><a href="gallery.html">Style Guide</a></li></ul></div>
            <div class="footer-section"><h4>Contact Us</h4><p>Email: <a href="mailto:info@aurorabags.com">info@aurorabags.com</a></p><p>Phone: (555) 123-4567</p><p>Address: 101 Ethereal St, City, State 01234</p></div>
            <div class="footer-section"><h4>Follow Us</h4><div class="social-icons"><a href="#" aria-label="Instagram">IG</a><a href="#" aria-label="Facebook">FB</a><a href="#" aria-label="Pinterest">P</a></div></div>
        </div>
        <div class="footer-bottom">&copy; 2025 Aurora Bags. All Rights Reserved.</div>
    </footer>

</body>
</html>