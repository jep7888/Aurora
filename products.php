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
    <title>Products - Aurora Bags</title>
    <style>
        /* Shared Global and Nav/Footer Styles from index.html (omitted for brevity, assume they are present) */
        /* === GLOBAL STYLES === */
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
        
        /* === PRODUCTS PAGE STYLES === */
        .products-header {
            text-align: center;
            padding: 4rem 5vw 2rem;
            background-color: var(--color-secondary);
        }

        .products-header h1 {
            font-family: var(--font-serif);
            font-size: 3rem;
            font-weight: normal;
            margin-bottom: 0.5rem;
        }

        .products-header p {
            color: var(--color-light-text);
            font-size: 1.1rem;
        }

        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem 5vw;
            border-bottom: 1px solid #eee;
        }

        .controls label {
            font-weight: bold;
            color: var(--color-primary);
            margin-right: 0.5rem;
        }

        .controls select {
            padding: 0.5rem 1rem;
            border: 1px solid var(--color-accent);
            background-color: white;
            font-family: inherit;
            cursor: pointer;
            transition: border-color var(--transition-speed);
        }

        .controls select:focus {
            outline: none;
            border-color: var(--color-primary);
        }

        .product-list {
            padding: 4rem 5vw;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
        }

        .product-card {
            text-align: left;
            overflow: hidden;
            transition: box-shadow var(--transition-speed);
        }

        .product-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .product-image-placeholder {
            background-color: var(--color-secondary);
            height: 350px;
            margin-bottom: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: var(--font-serif);
            color: var(--color-light-text);
            font-size: 1.2rem;
            cursor: pointer;
            position: relative;
        }
        
        .product-image-placeholder:hover .add-to-cart {
            opacity: 1;
            transform: translateY(0);
        }

        .add-to-cart {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 1rem 0;
            background-color: rgba(181, 131, 141, 0.9); /* Semi-transparent Primary */
            color: white;
            text-align: center;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
            opacity: 0;
            transform: translateY(100%);
            transition: all var(--transition-speed);
            cursor: pointer;
            font-family: var(--font-sans);
            font-weight: bold;
        }

        .product-card h3 {
            font-size: 1.3rem;
            margin-bottom: 0.4rem;
            font-weight: normal;
        }

        .product-card .price {
            color: var(--color-primary);
            font-weight: bold;
            font-size: 1.1rem;
        }

        /* === MOBILE RESPONSIVENESS === */
        @media (max-width: 900px) {
            /* Mobile Nav styles from index.html (omitted for brevity) */
            .controls {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .product-grid {
                gap: 2rem;
            }
        }


        /*new styles can be added below*/
        .product-details {
    padding: 0 0.2rem 1rem;
}

.product-details p {
    font-size: 0.9rem;
    color: var(--color-light-text);
    margin-bottom: 0.6rem;
}

.quantity-control {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin: 0.8rem 0;
}

.quantity-control button {
    width: 30px;
    height: 30px;
    border: 1px solid var(--color-primary);
    background: white;
    color: var(--color-primary);
    cursor: pointer;
    font-weight: bold;
}

.quantity-control span {
    min-width: 24px;
    text-align: center;
}

.add-cart-btn {
    width: 100%;
    padding: 0.7rem;
    background: var(--color-primary);
    color: white;
    border: none;
    text-transform: uppercase;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.add-cart-btn:hover {
    background: #9c6b75;
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
                <li class="nav-item"><a href="user_home.php">Home</a></li>
                <li class="nav-item active"><a href="products.php">Products</a></li>
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
        <section class="products-header">
            <h1>All Handbags</h1>
            <p>Explore our curated collection of essential luxury pieces.</p>
        </section>

        <section class="filters">

        </section>

<section class="product-list">
    <div class="product-grid" id="productGrid"></div>
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
        document.addEventListener("DOMContentLoaded", fetchProducts);

function fetchProducts() {
    fetch("fetch_displayed_products.php")
        .then(res => res.json())
        .then(products => renderProducts(products))
        .catch(err => console.error(err));
}

function renderProducts(products) {
    const grid = document.getElementById("productGrid");
    grid.innerHTML = "";

    products.forEach(product => {
        grid.innerHTML += `
            <div class="product-card">
                <div class="product-image-placeholder">
                    <img src="${product.image_path}" alt="${product.product_name}" style="width:100%; height:100%; object-fit:cover;">
                </div>

                <div class="product-details">
                    <h3>${product.product_name}</h3>
                    <p>${product.description}</p>
                    <p class="price">₱ ${parseFloat(product.price).toLocaleString()}</p>

                    <div class="quantity-control">
                        <button onclick="changeQty(${product.product_id}, -1)">−</button>
                        <span id="qty-${product.product_id}">1</span>
                        <button onclick="changeQty(${product.product_id}, 1)">+</button>
                    </div>

                    <button class="add-cart-btn" onclick="addToCart(${product.product_id})">
                        Add to Cart
                    </button>
                </div>
            </div>
        `;
    });
}

function changeQty(productId, delta) {
    const qtySpan = document.getElementById(`qty-${productId}`);
    let qty = parseInt(qtySpan.innerText);
    qty = Math.max(1, qty + delta);
    qtySpan.innerText = qty;
}

function addToCart(productId) {
    const qty = parseInt(document.getElementById(`qty-${productId}`).innerText);


    fetch("add_to_cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            product_id: productId,
            quantity: qty
        })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message || "Added to cart!");
    });
}

    </script>

</body>
</html>