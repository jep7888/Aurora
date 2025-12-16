<?php
    session_start();
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Products | Aurora Admin</title>
        <style>
            :root {
                --color-primary: #B5838D; 
                --color-secondary: #F6F4F1; 
                --color-accent: #E5C3A6; 
                --color-text: #333333;
                --color-light-text: #777777;
                --font-serif: 'Georgia', serif;
                --font-sans: 'Helvetica Neue', sans-serif;
                --transition-speed: 0.25s; 
            }

            * { box-sizing: border-box; margin: 0; padding: 0; }
            body { 
                font-family: var(--font-sans); color: var(--color-text); background-color: #FFFFFF; 
                line-height: 1.6; display: flex; min-height: 100vh; flex-direction: column; 
                overflow-y: hidden;
            }
            a { text-decoration: none; color: var(--color-text); transition: color var(--transition-speed); }
            a:hover { color: var(--color-primary); }

            .header {
                background-color: rgba(255, 255, 255, 0.95); padding: 1rem 5vw; display: flex;
                justify-content: space-between; align-items: center; width: 100%;
                box-shadow: 0 1px 10px rgba(0, 0, 0, 0.05); flex-shrink: 0;
            }
            .logo { font-family: var(--font-serif); font-size: 1.8rem; font-weight: bold; letter-spacing: 2px; color: var(--color-primary); }
            .header-actions { list-style: none; display: flex; gap: 1.5rem; align-items: center; }
            .header-actions a { font-family: var(--font-sans); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; }
            .menu-toggle { display: none; background: none; border: none; font-size: 1.5rem; color: var(--color-primary); cursor: pointer; }

            .admin-container { display: flex; flex-grow: 1; width: 100%; }

            .sidebar {
                width: 250px; background-color: #FFFFFF; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.03);
                padding: 2rem 0; flex-shrink: 0;
            }

            .sidebar-nav { list-style: none; padding: 0; }
            .sidebar-nav li a {
                display: block; padding: 0.8rem 1.5rem; color: var(--color-text); font-size: 1rem; font-weight: 500;
                border-left: 4px solid transparent; transition: background-color var(--transition-speed), border-color var(--transition-speed);
            }

            .sidebar-nav li a:hover { background-color: var(--color-secondary); color: var(--color-primary); }

            .sidebar-nav li.active a {
                border-left-color: var(--color-primary); 
                background-color: rgba(181, 131, 141, 0.05); 
                color: var(--color-primary);
                font-weight: bold;
            }

            .admin-content {
                flex-grow: 1; background-color: var(--color-secondary); 
                padding: 3rem 5vw; 
            }

            .content-header {
                margin-bottom: 2rem; padding-bottom: 10px; border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                display: flex; justify-content: space-between; align-items: center;
            }

            .content-header h1 {
                font-family: var(--font-serif); font-size: 2.2rem; color: var(--color-text); font-weight: normal;
            }

            .cta-button { 
                display: inline-block; padding: 0.8rem 1.8rem; background-color: var(--color-primary); color: white; text-transform: uppercase; 
                letter-spacing: 1px; font-weight: bold; font-size: 0.9rem; border: 1px solid var(--color-primary); border-radius: 4px; 
                transition: all var(--transition-speed) ease; cursor: pointer;
            }
            .cta-button:hover { background-color: white; color: var(--color-primary); box-shadow: 0 4px 10px rgba(181, 131, 141, 0.3); }
            .btn-secondary { 
                background-color: white; color: var(--color-text); border: 1px solid var(--color-light-text); padding: 0.6rem 1.2rem; 
                font-size: 0.9rem; letter-spacing: 0.5px; border-radius: 4px; transition: all var(--transition-speed); cursor: pointer;
            }
            .btn-secondary:hover { background-color: var(--color-secondary); border-color: var(--color-primary); color: var(--color-primary); }
            .btn-danger {
                background-color: #E74C3C; color: white; border: 1px solid #E74C3C; padding: 0.6rem 1.2rem; font-size: 0.9rem; 
                letter-spacing: 0.5px; border-radius: 4px; transition: all var(--transition-speed); cursor: pointer;
            }
            .btn-danger:hover { background-color: #C0392B; border-color: #C0392B; }

            .product-admin-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2.5rem;
            }
            
            .product-admin-card {
                text-align: left; overflow: hidden; background-color: white;
                box-shadow: 0 1px 5px rgba(0, 0, 0, 0.05); 
                border-radius: 4px;
            }

            .product-admin-card-image {
                background-color: var(--color-secondary);
                height: 250px;
                margin-bottom: 0;
                display: flex; justify-content: center; align-items: center;
                font-family: var(--font-serif); color: var(--color-light-text); font-size: 1.2rem;
                border-bottom: 1px solid #eee;
            }

            .product-admin-card-details { padding: 1rem; }

            .product-admin-card-details h4 {
                font-family: var(--font-serif); font-size: 1.2rem; margin-bottom: 0.5rem; font-weight: normal;
            }

            .product-admin-card-details .price {
                color: var(--color-primary); font-weight: bold; font-size: 1.1rem;
            }
            
            .product-actions {
                display: flex; justify-content: space-between; gap: 0.5rem;
                padding-top: 1rem; border-top: 1px dashed #eee; margin-top: 1rem;
            }

            .badge { padding: 0.3rem 0.7rem; border-radius: 12px; font-size: 0.8rem; font-weight: bold; display: inline-block; letter-spacing: 0.5px;}
            .badge-success { background-color: #4CAF50; color: white; } 
            .badge-warning { background-color: #FFC107; color: var(--color-text); } 
            .badge-danger { background-color: #E74C3C; color: white; }
        
            .footer { background-color: var(--color-text); color: white; padding: 1rem 5vw; text-align: center; font-size: 0.85rem; flex-shrink: 0; }
            .footer-bottom { color: rgba(255, 255, 255, 0.5); }

            @media (max-width: 900px) {
                .menu-toggle { display: block; }
                .sidebar {
                    width: 0; padding: 0; position: fixed; left: 0; top: 66px; height: 100%; overflow-y: auto; z-index: 900; transition: width var(--transition-speed);
                }
                .sidebar.active { width: 200px; padding: 1rem 0; box-shadow: 5px 0 10px rgba(0, 0, 0, 0.1); }
                .admin-content { padding: 2rem 5vw; margin-left: 0; }
                .product-admin-grid { gap: 1.5rem; }
            }

            /* Modal Styles */
            #addProductModal {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.35);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 999;
            }

            #addProductBox {
                background: #fff;
                padding: 2rem;
                width: 420px;
                border-radius: 8px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            }

            #addProductBox h2 {
                font-family: Georgia, serif;
                margin-bottom: 1rem;
            }

            #addProductForm {
                display: grid;
                gap: 0.8rem;
            }

            #addProductForm input,
            #addProductForm textarea,
            #addProductForm select {
                padding: 0.6rem;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            #addProductActions {
                display: flex;
                justify-content: flex-end;
                gap: 0.5rem;
                margin-top: 1rem;
            }

            /* Product Box Display */
            #adminProductList {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }

            .admin-product-box {
                background: #ffffff;
                border-radius: 8px;
                box-shadow: 0 4px 14px rgba(0,0,0,0.06);
                overflow: hidden;
                display: flex;
                flex-direction: column;
            }

            .admin-product-box img {
                width: 100%;
                height: 220px;
                object-fit: cover;
                background: #f2f2f2;
            }

            .admin-product-content {
                padding: 1rem;
            }

            .admin-product-content h3 {
                font-family: var(--font-serif);
                font-size: 1.1rem;
                margin-bottom: 0.3rem;
            }

            .admin-product-content p {
                font-size: 0.85rem;
                color: var(--color-light-text);
                margin-bottom: 0.6rem;
            }

            .admin-product-meta {
                font-size: 0.85rem;
                margin-bottom: 0.5rem;
            }

            .status-instock {
                background: #2ecc71;
                color: white;
            }

            .status-lowstock {
                background: #f1c40f;
                color: #333;
            }

            .status-outofstock {
                background: #e74c3c;
                color: white;
            }

            /* Hover Effect for Product Boxes */
            .admin-product-box {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                cursor: pointer;
            }

            .admin-product-box:hover {
                transform: translateY(-5px) scale(1.02);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            }

            /* Scrollbar Styles */            
            .product-list-wrapper {
                max-height: 65vh; 
                overflow-y: auto;
                padding-right: 5px; 
            }

            .product-list-wrapper::-webkit-scrollbar {
                width: 8px;
            }

            .product-list-wrapper::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 8px;
            }

            .product-list-wrapper::-webkit-scrollbar-thumb {
                background-color: #B5838D; 
                border-radius: 8px;
                border: 2px solid #f1f1f1;
            }

            .product-list-wrapper {
                scrollbar-width: thin;
                scrollbar-color: #B5838D #f1f1f1;
            }

            .product-list-wrapper::-webkit-scrollbar-thumb:hover {
                background-color: #925f6b;
            }

            /* Success Modal Styles */
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

            .checkmark-circle-bg {
                fill: none;
                stroke: var(--color-primary);
                stroke-width: 3;
                stroke-dasharray: 157;
                stroke-dashoffset: 157;
                animation: circleDraw 0.6s ease forwards;
            }

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
            <div class="logo">Aurora Admin</div>
            <div class="header-actions">
                <button class="menu-toggle">☰</button>
                <a href="admin_profile.html">Profile</a>
                <a href="admin_logout.php" style="color: #E74C3C;">Logout</a>
            </div>
        </header>

        <div class="admin-container">
            <aside class="sidebar">
                <ul class="sidebar-nav">
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="admin_products.php">Products</a></li>
                    <li><a href="admin_orders.php">Orders</a></li>
                    <li><a href="admin_accounts.php">Accounts / Users</a></li>
                    <li><a href="admin_sales.php">Sales Analytics</a></li>
                </ul>
            </aside>

            <main class="admin-content">
                <section class="content-header">
                    <h1>Product Catalog</h1>
                    <button class="cta-button" onclick="openAddProductModal()"
                            style="padding: 0.75rem 1.5rem; font-size: 0.9rem;">
                        + Add New Product
                    </button>
                </section>

                <section class="product-filters"
                    style="margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; gap: 1rem; align-items: center;">

                    <input type="text" id="searchInput" placeholder="Search by product name..." 
                        style="padding: 0.5rem 1rem; border-radius: 4px; border: 1px solid #ccc; flex: 1; min-width: 200px;">

                    <select id="statusFilter"
                        style="padding: 0.5rem 1rem; border-radius: 4px; border: 1px solid #ccc; min-width: 180px;">
                        <option value="">All Stock Status</option>
                        <option value="instock">In Stock</option>
                        <option value="lowstock">Low Stock</option>
                        <option value="outofstock">Out of Stock</option>
                    </select>

                    <!--<button class="btn-secondary" onclick="applyFilters()">Filter</button>-->
                    <button class="btn-secondary" onclick="resetFilters()">Reset</button>
                </section>


                <div class="product-list-wrapper">
                    <section id="adminProductList"></section>
                </div>
            </main>


            <div id="addProductModal" style="display:none;">
                <div id="addProductBox">
                    <h2>Add New Product</h2>

                    <form id="addProductForm" enctype="multipart/form-data">
                        <input type="text" name="product_name" placeholder="Product Name" required>

                        <textarea name="description" placeholder="Description"></textarea>

                        <input type="number" step="0.01" name="price" placeholder="Price" required>

                        <input type="number" name="stock_count" placeholder="Stock Count"
                            required oninput="updateStockStatus(this.value)">

                        <input type="file" name="product_image" accept="image/*" required>

                        <select id="productStatus" disabled>
                            <option value="instock">In Stock</option>
                            <option value="lowstock">Low Stock</option>
                            <option value="outofstock">Out of Stock</option>
                        </select>

                        <input type="hidden" name="status" id="hiddenStatus">

                        <div id="addProductActions">
                            <button type="button" class="cta-button" onclick="submitProduct()">Save</button>
                            <button type="button" class="btn-secondary" onclick="closeAddProductModal()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Product Modal -->
            <div id="updateProductModal" style="display:none; position: fixed; inset:0; background: rgba(0,0,0,0.35); align-items: center; justify-content: center; z-index:999;">
                <div style="
                    background: #fff; 
                    padding: 2rem; 
                    width: 420px; 
                    border-radius: 8px; 
                    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
                    display: flex;
                    flex-direction: column;
                    gap: 0.8rem;
                ">
                    <h2 style="font-family: Georgia, serif; margin-bottom: 1rem;">Update Product</h2>

                    <form id="updateProductForm" style="display: grid; gap: 0.8rem;">
                        <input type="hidden" id="updateProductId" name="id">

                        <input type="text" id="updateProductName" name="product_name" placeholder="Product Name" required style="padding: 0.6rem; border:1px solid #ccc; border-radius:4px;" readonly>

                        <textarea id="updateDescription" name="description" placeholder="Description" style="padding: 0.6rem; border:1px solid #ccc; border-radius:4px;" readonly></textarea>

                        <input type="number" step="0.01" id="updatePrice" name="price" placeholder="Price" required style="padding: 0.6rem; border:1px solid #ccc; border-radius:4px;">

                        <input type="number" id="updateStock" name="stock_count" placeholder="Stock Count" required style="padding: 0.6rem; border:1px solid #ccc; border-radius:4px;">

                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem; margin-top: 1rem;">
                            <button type="button" class="cta-button" onclick="submitUpdate()" style="padding: 0.75rem 1.5rem; font-size: 0.9rem;">Save</button>
                            <button type="button" class="btn-secondary" onclick="closeUpdateModal()" style="padding: 0.6rem 1.2rem;">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Success Modal -->
            <div id="successModal" class="success-overlay">
                <div class="success-box">
                    <div class="checkmark-circle">
                        <svg viewBox="0 0 52 52">
                            <circle class="checkmark-circle-bg" cx="26" cy="26" r="25" />
                            <path class="checkmark-check" d="M14 27 L22 35 L38 19" />
                        </svg>
                    </div>
                    <p id="successMessage"></p>
                </div>
            </div>


        </div>

        <footer class="footer">
            <div class="footer-bottom">
                &copy; 2025 Aurora Bags Admin.
            </div>
        </footer>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const menuToggle = document.querySelector('.menu-toggle');
                    const sidebar = document.querySelector('.sidebar');
                    const navLinks = document.querySelectorAll('.sidebar-nav a');

                    if (menuToggle) {
                        menuToggle.addEventListener('click', () => {
                            sidebar.classList.toggle('active');
                        });
                    }

                    const path = window.location.pathname;
                    const page = path.split("/").pop().toLowerCase(); // normalize to lowercase

                    navLinks.forEach(link => {
                        const li = link.closest('li');
                        li.classList.remove('active');

                        const linkPage = link.href.split("/").pop().toLowerCase();
                        if (linkPage === page) {
                            li.classList.add('active');
                        }
                    });

                    fetchProducts();
                });

                // Modal Functions
                function openAddProductModal() {
                    document.getElementById('addProductModal').style.display = 'flex';
                }

                function closeAddProductModal() {
                    document.getElementById('addProductModal').style.display = 'none';
                    document.getElementById('addProductForm').reset();
                }

                function submitProduct() {
                    const form = document.getElementById('addProductForm');
                    const formData = new FormData(form);

                    const xhttp = new XMLHttpRequest();
                    xhttp.open("POST", "add_new_products.php", true);

                    xhttp.onload = function () {
                        const res = JSON.parse(this.responseText);

                        if (res.success) {
                            appendProduct(res.product);
                            closeAddProductModal();
                            showSuccess("Product added successfully");
                        } else {
                            alert(res.message);
                        }
                    };

                    xhttp.send(formData);
                }

                // Append Product to List
                function appendProduct(product) {

                    let statusClass = 'status-outofstock';
                    let statusText = 'Out of Stock';

                    if (product.status === 'instock') {
                        statusClass = 'status-instock';
                        statusText = 'In Stock';
                    } else if (product.status === 'lowstock') {
                        statusClass = 'status-lowstock';
                        statusText = 'Low Stock';
                    }

                    const html = `
                        <div class="admin-product-box" data-id="${product.product_id}">
                            <img src="${product.image_path}" alt="${product.product_name}">

                            <div class="admin-product-content">
                                <h3>${product.product_name}</h3>
                                <p>${product.description || 'No description provided.'}</p>
                                <div class="admin-product-meta">
                                    <strong>₱${product.price}</strong><br>
                                    Stock: ${product.stock_count}
                                </div>
                                <span class="badge ${statusClass}">${statusText}</span>

                                <div class="product-actions" style="margin-top:10px;">
                                    <button class="btn-secondary" onclick="openUpdateModal(${product.product_id})">Update</button>
                                    <button class="btn-danger" onclick="deleteProduct(${product.product_id})">Delete</button>
                                </div>
                            </div>
                        </div>
                    `;

                    document
                        .getElementById('adminProductList')
                        .insertAdjacentHTML('beforeend', html);
                }

                // Stock Status Update
                function updateStockStatus(stock) {
                    const statusSelect = document.getElementById('productStatus');
                    const hiddenStatus = document.getElementById('hiddenStatus');

                    stock = parseInt(stock) || 0;

                    let status = 'outofstock';

                    if (stock === 0) {
                        status = 'outofstock';
                    } else if (stock <= 10) {
                        status = 'lowstock';
                    } else {
                        status = 'instock';
                    }

                    statusSelect.value = status;
                    hiddenStatus.value = status;
                }

                // Fetch Products
                let allProducts = [];

                function fetchProducts() {
                    const xhttp = new XMLHttpRequest();
                    xhttp.open("GET", "fetch_products.php", true);

                    xhttp.onload = function () {
                        if (this.status === 200) {
                            allProducts = JSON.parse(this.responseText); 
                            displayProducts(allProducts);
                        }
                    };

                    xhttp.send();
                }

                function displayProducts(products) {
                    const container = document.getElementById('adminProductList');
                    container.innerHTML = "";
                    products.forEach(product => appendProduct(product));
                }

                document.getElementById('searchInput').addEventListener('input', applyFilters);

                function applyFilters() {
                    const searchQuery = document.getElementById('searchInput').value.toLowerCase();
                    const statusFilter = document.getElementById('statusFilter').value;

                    const filtered = allProducts.filter(product => {
                        const matchesName =
                            product.product_name.toLowerCase().includes(searchQuery);

                        const matchesStatus =
                            statusFilter === "" || product.status === statusFilter;

                        return matchesName && matchesStatus;
                    });

                    displayProducts(filtered);
                }

                function resetFilters() {
                    document.getElementById('searchInput').value = "";
                    document.getElementById('statusFilter').value = "";
                    displayProducts(allProducts);
                }

                document.getElementById('statusFilter')
                    .addEventListener('change', applyFilters);

                // updatge product modal
                function openUpdateModal(productId) {
                    const product = allProducts.find(p => p.product_id == productId);

                    if (!product) return;

                    document.getElementById('updateProductId').value = product.product_id;
                    document.getElementById('updateProductName').value = product.product_name;
                    document.getElementById('updateDescription').value = product.description;
                    document.getElementById('updatePrice').value = product.price;
                    document.getElementById('updateStock').value = product.stock_count;

                    document.getElementById('updateProductModal').style.display = 'flex';
                }

                function submitUpdate() {
                    const form = document.getElementById('updateProductForm');
                    const formData = new FormData(form);

                    const xhttp = new XMLHttpRequest();
                    xhttp.open("POST", "update_product.php", true);

                    xhttp.onload = function () {
                        const res = JSON.parse(this.responseText);
                        if (res.success) {
                            fetchProducts(); 
                            showSuccess("Product updated successfully");
                            closeUpdateModal();
                        } else {
                            alert(res.message);
                        }
                    };

                    xhttp.send(formData);
                }

                function closeUpdateModal() {
                    document.getElementById('updateProductModal').style.display = 'none';
                    document.getElementById('updateProductForm').reset();
                }

                //show success modal
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

                //delete product
                function deleteProduct(productId) {
                    if (!confirm("Are you sure you want to delete this product?")) return;

                    const formData = new FormData();
                    formData.append("id", productId);

                    const xhttp = new XMLHttpRequest();
                    xhttp.open("POST", "delete_product.php", true);

                    xhttp.onload = function () {
                        const res = JSON.parse(this.responseText);

                        if (res.success) {
                            fetchProducts(); 
                            showSuccess("Product deleted successfully");
                        } else {
                            alert(res.message);
                        }
                    };

                    xhttp.send(formData);
                }

            </script>
    </body>
</html>