<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory | Aurora Admin</title>
    <style>
        /* === GLOBAL STYLES (Copied from index.php) === */
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
        }
        a { text-decoration: none; color: var(--color-text); transition: color var(--transition-speed); }
        a:hover { color: var(--color-primary); }

        /* === HEADER (Top Bar - Matches index.php) === */
        .header {
            background-color: rgba(255, 255, 255, 0.95); padding: 1rem 5vw; display: flex;
            justify-content: space-between; align-items: center; width: 100%;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.05); flex-shrink: 0;
        }
        .logo { font-family: var(--font-serif); font-size: 1.8rem; font-weight: bold; letter-spacing: 2px; color: var(--color-primary); }
        .header-actions { list-style: none; display: flex; gap: 1.5rem; align-items: center; }
        .header-actions a { font-family: var(--font-sans); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; }
        .menu-toggle { display: none; background: none; border: none; font-size: 1.5rem; color: var(--color-primary); cursor: pointer; }

        /* === MAIN LAYOUT: SIDEBAR + CONTENT === */
        .admin-container { display: flex; flex-grow: 1; width: 100%; }

        /* SIDEBAR */
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

        /* MAIN CONTENT AREA */
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

        /* === BUTTONS & FORMS (Professional Enhancements) === */
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
        
        /* Forms */
        .filter-bar { margin-bottom: 1.5rem; display: flex; gap: 1rem; }
        .filter-bar input, .filter-bar select {
            padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px; font-family: var(--font-sans); flex-grow: 1;
            transition: border-color var(--transition-speed), box-shadow var(--transition-speed);
        }
        .filter-bar input:focus, .filter-bar select:focus { border-color: var(--color-primary); box-shadow: 0 0 0 1px rgba(181, 131, 141, 0.5); outline: none; }
        .filter-bar select { flex-grow: 0; min-width: 150px; }
        
        /* === CARDS & TABLES === */
        .data-table-container { background-color: #FFFFFF; border-radius: 6px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th, .data-table td { padding: 1rem 1.2rem; text-align: left; border-bottom: 1px solid #eee; }
        .data-table th { background-color: #f9f9f9; font-weight: 600; text-transform: uppercase; font-size: 0.8rem; color: var(--color-light-text); }
        .data-table tr:hover { background-color: #fafafa; }

        /* Status Badges */
        .badge { padding: 0.3rem 0.7rem; border-radius: 12px; font-size: 0.8rem; font-weight: bold; display: inline-block; letter-spacing: 0.5px;}
        .badge-success { background-color: #4CAF50; color: white; } 
        .badge-warning { background-color: #FFC107; color: var(--color-text); } 
        .badge-danger { background-color: #E74C3C; color: white; }
        
        /* === FOOTER (Matches index.php) === */
        .footer { background-color: var(--color-text); color: white; padding: 1rem 5vw; text-align: center; font-size: 0.85rem; flex-shrink: 0; }
        .footer-bottom { color: rgba(255, 255, 255, 0.5); }

        /* === MOBILE RESPONSIVENESS === */
        @media (max-width: 900px) {
            .menu-toggle { display: block; }
            .sidebar {
                width: 0; padding: 0; position: fixed; left: 0; top: 66px; height: 100%; overflow-y: auto; z-index: 900; transition: width var(--transition-speed);
            }
            .sidebar.active { width: 200px; padding: 1rem 0; box-shadow: 5px 0 10px rgba(0, 0, 0, 0.1); }
            .admin-content { padding: 2rem 5vw; margin-left: 0; }
            .filter-bar { flex-direction: column; }
            .filter-bar select { min-width: 100%; }

            /* Mobile Table Stack */
            .data-table, .data-table thead, .data-table tbody, .data-table th, .data-table td, .data-table tr { display: block; }
            .data-table thead tr { position: absolute; top: -9999px; left: -9999px; }
            .data-table tr { border: 1px solid #ccc; margin-bottom: 1rem; }
            .data-table td { border: none; border-bottom: 1px solid #eee; position: relative; padding-left: 50%; text-align: right; }
            .data-table td:before { 
                position: absolute; top: 1rem; left: 6px; width: 45%; padding-right: 10px; white-space: nowrap; 
                text-align: left; font-weight: bold; color: var(--color-light-text);
            }
            /* Specific column labels for Inventory */
            td:nth-of-type(1):before { content: "Product"; }
            td:nth-of-type(2):before { content: "SKU"; }
            td:nth-of-type(3):before { content: "Warehouse"; }
            td:nth-of-type(4):before { content: "Qty"; }
            td:nth-of-type(5):before { content: "Status"; }
            td:nth-of-type(6):before { content: "Last Update"; }
            td:nth-of-type(7):before { content: "Actions"; }
        }
    </style>
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
            const page = path.split("/").pop();
            
            navLinks.forEach(link => {
                link.closest('li').classList.remove('active');
                if (link.href.includes(page)) {
                    link.closest('li').classList.add('active');
                }
            });
        });
    </script>
</head>
<body>
    <header class="header">
        <div class="logo">Aurora Admin</div>
        <div class="header-actions">
            <button class="menu-toggle">☰</button>
            <a href="admin_profile.html">Profile</a>
            <a href="admin_logout.html" style="color: #E74C3C;">Logout</a>
        </div>
    </header>

    <div class="admin-container">
        <aside class="sidebar">
            <ul class="sidebar-nav">
                <li><a href="admin_dashboard.html">Dashboard</a></li>
                <li><a href="admin_products.html">Products</a></li>
                <li class="active"><a href="admin_inventory.html">Inventory / Stock</a></li>
                <li><a href="admin_orders.html">Orders</a></li>
                <li><a href="admin_accounts.html">Accounts / Users</a></li>
                <li><a href="admin_sales.html">Sales Analytics</a></li>
            </ul>
        </aside>

        <main class="admin-content">
            <section class="content-header">
                <h1>Stocks & Inventory (45 SKUs)</h1>
                <button class="cta-button" style="padding: 0.6rem 1.2rem; font-size: 0.9rem;">+ New Stock Receipt</button>
            </section>
            
            <div class="filter-bar">
                <input type="text" placeholder="Search by SKU or Product Name...">
                <select>
                    <option>Filter by Status</option>
                    <option>In Stock</option>
                    <option>Low Stock</option>
                    <option>Out of Stock</option>
                </select>
                <select>
                    <option>Filter by Warehouse</option>
                    <option>Warehouse A (US)</option>
                    <option>Warehouse B (EU)</option>
                </select>
            </div>

            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Warehouse</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Last Update</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>The Luna Tote (Black)</td>
                            <td>LU-TOTE-BL</td>
                            <td>Warehouse A (US)</td>
                            <td style="font-weight: bold;">45</td>
                            <td><span class="badge badge-success">In Stock</span></td>
                            <td>2 days ago</td>
                            <td><button class="btn-secondary" style="padding: 0.3rem 0.6rem;">Adjust</button></td>
                        </tr>
                        <tr>
                            <td>The Venus Crossbody (Red)</td>
                            <td>VE-CB-RED</td>
                            <td>Warehouse A (US)</td>
                            <td style="color: #E74C3C; font-weight: bold;">8</td>
                            <td><span class="badge badge-warning">Low Stock</span></td>
                            <td>1 hour ago</td>
                            <td><button class="btn-secondary" style="padding: 0.3rem 0.6rem;">Adjust</button></td>
                        </tr>
                        <tr>
                            <td>The Stella Clutch (Grey)</td>
                            <td>ST-CL-GRY</td>
                            <td>Warehouse B (EU)</td>
                            <td style="color: #E74C3C; font-weight: bold;">0</td>
                            <td><span class="badge badge-danger">Out of Stock</span></td>
                            <td>1 week ago</td>
                            <td><button class="cta-button" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">Order</button></td>
                        </tr>
                        <tr>
                            <td>The Saturn Backpack (Cream)</td>
                            <td>SA-BP-CR</td>
                            <td>Warehouse B (EU)</td>
                            <td style="font-weight: bold;">120</td>
                            <td><span class="badge badge-success">In Stock</span></td>
                            <td>5 days ago</td>
                            <td><button class="btn-secondary" style="padding: 0.3rem 0.6rem;">Adjust</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <footer class="footer">
        <div class="footer-bottom">
            &copy; 2025 Aurora Bags Admin.
        </div>
    </footer>
</body>
</html>