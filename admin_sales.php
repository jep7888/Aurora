<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales | Aurora Admin</title>
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

        /* === BUTTONS & FORMS === */
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
        
        /* === SALES COMPONENTS (Based on Dashboard Cards) === */
        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        .card {
            background-color: #FFFFFF;
            padding: 1.5rem;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: transform var(--transition-speed);
        }
        .card h3 { font-size: 1rem; color: var(--color-light-text); margin-bottom: 0.5rem; }
        .card p { font-size: 2.2rem; font-family: var(--font-sans); font-weight: bold; color: var(--color-text); margin-bottom: 0.5rem; }
        .chart-placeholder {
            height: 250px;
            background-color: var(--color-secondary);
            border: 1px dashed var(--color-accent);
            border-radius: 4px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--color-light-text);
            font-family: var(--font-serif);
            font-size: 1.1rem;
        }
        
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
            .analytics-grid { grid-template-columns: 1fr; }
        }
    </style>
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
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="admin_products.php">Products</a></li>
                <li><a href="admin_orders.php">Orders</a></li>
                <li><a href="admin_accounts.php">Accounts / Users</a></li>
                <li class="active"><a href="admin_sales.php">Sales Analytics</a></li>
            </ul>
        </aside>

        <main class="admin-content">
            <section class="content-header">
                <h1>Sales Performance Dashboard</h1>
                <div style="display: flex; gap: 1rem;">
                    <select class="btn-secondary" style="font-weight: normal; padding: 0.6rem 1rem;">
                        <option>Last 30 Days</option>
                        <option>Last 90 Days</option>
                        <option>Year to Date</option>
                    </select>
                    <button class="cta-button" style="padding: 0.6rem 1rem; font-size: 0.9rem;">Export Report</button>
                </div>
            </section>
            
            <section class="analytics-grid">
                <div class="card" style="border-left: 5px solid var(--color-primary);">
                    <h3>Total Revenue</h3>
                    <p>$18,450.00</p>
                    <span style="color: #4CAF50; font-weight: bold; font-size: 0.9rem;">+12.5% vs Last Period</span>
                </div>
                <div class="card" style="border-left: 5px solid #4CAF50;">
                    <h3>Total Orders</h3>
                    <p>320</p>
                    <span style="color: #E74C3C; font-weight: bold; font-size: 0.9rem;">-3.1% vs Last Period</span>
                </div>
                <div class="card" style="border-left: 5px solid var(--color-accent);">
                    <h3>Avg. Order Value (AOV)</h3>
                    <p>$145.50</p>
                    <span style="color: #4CAF50; font-weight: bold; font-size: 0.9rem;">+1.8% vs Last Period</span>
                </div>
            </section>

            <section class="analytics-grid" style="grid-template-columns: 2fr 1fr;">
                <div class="card">
                    <h2 style="font-family: var(--font-serif); font-weight: normal; margin-bottom: 1rem;">Revenue Trend</h2>
                    <div class="chart-placeholder">Placeholder for Revenue Trend Line Chart</div>
                </div>
                <div class="card">
                    <h2 style="font-family: var(--font-serif); font-weight: normal; margin-bottom: 1rem;">Top Product</h2>
                    <div style="padding: 1rem 0; border-bottom: 1px solid #eee;">
                        <span style="font-weight: bold;">The Luna Tote</span>
                        <p style="font-size: 1.5rem; color: var(--color-primary); margin: 0.5rem 0 0;">$5,100</p>
                    </div>
                    <div style="padding: 1rem 0;">
                        <span style="font-weight: bold;">The Venus Crossbody</span>
                        <p style="font-size: 1.5rem; color: var(--color-primary); margin: 0.5rem 0 0;">$3,800</p>
                    </div>
                </div>
            </section>
        </main>
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
            const page = path.split("/").pop().toLowerCase(); 

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
    </script>
</body>
</html>