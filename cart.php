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
    <title>Shopping Cart - Aurora Bags</title>
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

        /* === CART PAGE STYLES === */
        .cart-container {
            padding: 4rem 5vw;
            max-width: 1200px;
            margin: 0 auto;
        }

        .cart-container h1 {
            font-family: var(--font-serif);
            font-size: 3rem;
            font-weight: normal;
            color: var(--color-primary);
            margin-bottom: 3rem;
            text-align: center;
        }

        .cart-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 4rem;
        }

        .cart-items {
            border-top: 2px solid var(--color-primary);
        }

        .cart-item {
            display: flex;
            padding: 2rem 0;
            border-bottom: 1px solid #eee;
            align-items: center;
        }

        .item-image-placeholder {
            width: 100px;
            height: 100px;
            background-color: var(--color-secondary);
            margin-right: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 0.8rem;
        }

        .item-details {
            flex-grow: 1;
        }

        .item-details h3 {
            font-size: 1.2rem;
            font-weight: normal;
            margin-bottom: 0.5rem;
        }

        .item-details p {
            font-size: 0.9rem;
            color: var(--color-light-text);
            margin-bottom: 0.5rem;
        }

        .item-quantity-control {
            display: flex;
            align-items: center;
            margin-right: 2rem;
        }

        .item-quantity-control input {
            width: 50px;
            text-align: center;
            padding: 0.5rem;
            border: 1px solid #ddd;
            margin: 0 5px;
            font-family: inherit;
        }

        .quantity-button {
            padding: 0.5rem 0.8rem;
            background: none;
            border: 1px solid var(--color-primary);
            color: var(--color-primary);
            cursor: pointer;
            transition: background-color var(--transition-speed);
        }

        .quantity-button:hover {
            background-color: var(--color-secondary);
        }

        .item-subtotal {
            font-weight: bold;
            font-size: 1.1rem;
            color: var(--color-primary);
            width: 100px;
            text-align: right;
        }

        .remove-item {
            cursor: pointer;
            color: var(--color-light-text);
            margin-left: 2rem;
            font-size: 1.2rem;
            transition: color var(--transition-speed);
        }

        .remove-item:hover {
            color: #CC0000;
        }

        .cart-summary {
            background-color: var(--color-secondary);
            padding: 2rem;
            height: fit-content;
        }

        .cart-summary h2 {
            font-family: var(--font-serif);
            font-size: 2rem;
            font-weight: normal;
            margin-bottom: 2rem;
            color: var(--color-text);
        }

        .summary-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .summary-line.total {
            border-top: 1px solid #ddd;
            padding-top: 1rem;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .checkout-button {
            width: 100%;
            display: block;
            padding: 1rem;
            margin-top: 2rem;
            background-color: var(--color-primary);
            color: white;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: background-color var(--transition-speed);
        }

        .checkout-button:hover {
            background-color: #A3737C;
        }

        .empty-cart {
            text-align: center;
            padding: 5rem 0;
            font-size: 1.2rem;
            color: var(--color-light-text);
        }

        @media (max-width: 900px) {
            .cart-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .cart-item {
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .item-image-placeholder, .item-details {
                margin-bottom: 1rem;
            }

            .item-image-placeholder {
                width: 80px;
                height: 80px;
            }

            .item-quantity-control, .item-subtotal {
                margin: 0;
            }
        }

        .cart-check {
    margin-right: 1rem;
    transform: scale(1.2);
    accent-color: var(--color-primary);
}
.summary-item {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    color: var(--color-text);
}

#selected-items-summary {
    margin-bottom: 1.5rem;
}

.summary-item img {
    border: 1px solid #ddd;
}
.success-overlay {
    position: fixed;
    inset: 0;
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 2000;
}

.success-box {
    background: var(--color-secondary);
    padding: 2.8rem 3.2rem;
    border-radius: 14px;
    text-align: center;
    box-shadow: 0 25px 45px rgba(0,0,0,0.18);
    animation: popIn 0.35s ease;
    border: 1px solid rgba(181, 131, 141, 0.25);
}

@keyframes popIn {
    0% {
        transform: scale(0.75);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.checkmark-circle {
    width: 82px;
    height: 82px;
    margin: 0 auto 1.2rem;
}

.checkmark-circle svg {
    width: 100%;
    height: 100%;
}

/* Circle stroke */
.checkmark-circle-bg {
    fill: none;
    stroke: var(--color-primary);
    stroke-width: 3;
    stroke-dasharray: 157;
    stroke-dashoffset: 157;
    animation: circleDraw 0.6s ease forwards;
}

/* Check stroke */
.checkmark-check {
    fill: none;
    stroke: var(--color-primary);
    stroke-width: 4;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: checkDraw 0.35s ease forwards 0.6s;
}

@keyframes circleDraw {
    to { stroke-dashoffset: 0; }
}

@keyframes checkDraw {
    to { stroke-dashoffset: 0; }
}

#successMessage {
    font-family: var(--font-sans);
    font-size: 0.95rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    color: var(--color-text);
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
                <li class="nav-item"><a href="products.php">Products</a></li>
                <!-- <li class="nav-item"><a href="gallery.php">Gallery</a></li> -->
                <li class="nav-item"><a href="about.php">About Us</a></li>
                <li class="nav-item"><a href="contact.php">Contact Us</a></li>
                <li class="nav-item active"><a href="cart.php">Cart</a></li>
                <a href="admin_logout.php" style="color: #E74C3C;">Logout</a>
            </ul>
        </nav>
        <div class="mobile-menu-toggle">☰</div>
    </header>

    <main>
        <section class="cart-container">
            <h1>Your Shopping Bag</h1>
            
            <div class="cart-content" id="cart-content">
                <div class="cart-items" id="cart-items-container">
                    </div>

                <div class="cart-summary">
                   

<h2>Summary</h2>

<div id="selected-items-summary"></div>

<div class="summary-line total">
    <span>Total</span>
    <span id="selected-total">₱ 0</span>
</div>

<button class="checkout-button" onclick="checkoutSelected()">
    Proceed to Checkout
</button>

<p style="text-align:center;margin-top:1rem;font-size:0.9rem;color:var(--color-light-text);">
    Shipping is FREE for all orders.
</p>



            </div>
        </section>
    </main>


    <!-- Success Modal -->
<div id="successModal" class="success-overlay">
    <div class="success-box">
        <div class="checkmark-circle">
            <svg viewBox="0 0 52 52">
                <circle class="checkmark-circle-bg" cx="26" cy="26" r="25" />
                <path class="checkmark-check" d="M14 27 L22 35 L38 19" />
            </svg>
        </div>
        <p id="successMessage">Success</p>
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
        document.addEventListener("DOMContentLoaded", loadCart);

function loadCart() {
    fetch("fetch_cart.php")
        .then(res => res.json())
        .then(items => renderCart(items));
}

function renderCart(items) {
    const container = document.getElementById("cart-items-container");
    container.innerHTML = "";

    if (items.length === 0) {
        container.innerHTML = `<p class="empty-cart">Your cart is empty.</p>`;
        return;
    }

    let total = 0;

    items.forEach(item => {
        const subtotal = item.price * item.quantity;
        total += subtotal;

        container.innerHTML += `
<div class="cart-item">
    <input
    type="checkbox"
    class="cart-check"
    value="${item.cart_id}"
    data-name="${item.product_name}"
    data-price="${item.price}"
    data-qty="${item.quantity}"
    data-image="${item.image_path}"
    checked
    onchange="updateSummary()"
>


    <div class="item-image-placeholder">
        <img src="${item.image_path}" style="width:100%;height:100%;object-fit:cover;">
    </div>

    <div class="item-details">
        <h3>${item.product_name}</h3>
        <p>₱ ${item.price.toLocaleString()}</p>
    </div>

    <div class="item-quantity-control">
        <button class="quantity-button" onclick="updateQty(${item.cart_id}, -1)">−</button>
        <input id="qty-${item.cart_id}" value="${item.quantity}">
        <button class="quantity-button" onclick="updateQty(${item.cart_id}, 1)">+</button>
    </div>

    <div class="item-subtotal">
        ₱ ${subtotal.toLocaleString()}
    </div>
</div>

        `;
    });

    updateSummary();

}

function updateQty(cartId, delta) {
    const input = document.getElementById(`qty-${cartId}`);
    let qty = parseInt(input.value) + delta;
    if (qty < 1) qty = 1;
    input.value = qty;

    // ✅ Update checkbox dataset so summary updates correctly
    const checkbox = document.querySelector(`.cart-check[value="${cartId}"]`);
    if (checkbox) {
        checkbox.dataset.qty = qty;
    }

    // ✅ Update summary immediately (no waiting)
    updateSummary();

    // ✅ Save to database
    fetch("update_cart_qty.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({ cart_id: cartId, quantity: qty })
    });
}


function checkoutSelected() {
    const selected = [...document.querySelectorAll(".cart-check:checked")]
        .map(cb => cb.value);

    if (selected.length === 0) {
        alert("Please select at least one item to checkout.");
        return;
    }

    fetch("checkout.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ cart_ids: selected })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
    showSuccess("Checkout successful!");

    setTimeout(() => {
        window.location.reload();
    }, 1600); 
}
 else {
            alert(data.error || "Checkout failed.");
        }
    });
}
function updateSummary() {
    const summary = document.getElementById("selected-items-summary");
    const totalEl = document.getElementById("selected-total");

    summary.innerHTML = "";
    let total = 0;

    document.querySelectorAll(".cart-check:checked").forEach(cb => {
        const name = cb.dataset.name;
        const price = parseFloat(cb.dataset.price);
        const qty = parseInt(cb.dataset.qty);
        const image = cb.dataset.image;

        const subtotal = price * qty;
        total += subtotal;

        summary.innerHTML += `
            <div class="summary-item" style="display:flex; gap:10px; margin-bottom:12px;">
                <img src="${image}" style="width:50px;height:50px;object-fit:cover;border-radius:4px;">
                <div style="flex:1;">
                    <div style="font-size:0.9rem;">${name}</div>
                    <div style="font-size:0.8rem;color:#777;">
                        ₱ ${price.toLocaleString()} × ${qty}
                    </div>
                </div>
                <div style="font-weight:bold;">
                    ₱ ${subtotal.toLocaleString()}
                </div>
            </div>
        `;
    });

    totalEl.innerText = `₱ ${total.toLocaleString()}`;
}


// Auto-run on page load
document.addEventListener("DOMContentLoaded", updateSummary);


    function showSuccess(message = "Success") {
        const modal = document.getElementById('successModal');
        const text = document.getElementById('successMessage');

        text.textContent = message;
        modal.style.display = 'flex';

        modal.querySelectorAll('circle, path').forEach(el => {
            el.style.animation = 'none';
            el.offsetHeight;
            el.style.animation = '';
        });

        setTimeout(() => {
            modal.style.display = 'none';
        }, 1500);
    }

    </script>

</body>
</html>