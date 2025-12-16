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
    <title>Dashboard | Aurora Admin</title>
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
        }
        a { text-decoration: none; color: var(--color-text); transition: color var(--transition-speed); }
        a:hover { color: var(--color-primary); }

        .header {
            background-color: rgba(255, 255, 255, 0.95); padding: 1rem 5vw; display: flex;
            justify-content: space-between; align-items: center; width: 100%;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.05); 
            flex-shrink: 0;
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
        
        .dashboard-stats {
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
            border-left: 5px solid var(--color-primary); 
            transition: transform var(--transition-speed);
        }
        .card:hover { transform: translateY(-3px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
        .card h3 { font-size: 1rem; color: var(--color-light-text); margin-bottom: 0.5rem; }
        .card p { font-size: 2.2rem; font-family: var(--font-sans); font-weight: bold; color: var(--color-text); margin-bottom: 0.5rem; }
        .card a { color: var(--color-primary); font-weight: bold; font-size: 0.85rem; }

        .data-table-container { background-color: #FFFFFF; border-radius: 6px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th, .data-table td { padding: 1rem 1.2rem; text-align: left; border-bottom: 1px solid #eee; }
        .data-table th { background-color: #f9f9f9; font-weight: 600; text-transform: uppercase; font-size: 0.8rem; color: var(--color-light-text); }
        .data-table tr:hover { background-color: #fafafa; }

        .badge { padding: 0.3rem 0.7rem; border-radius: 12px; font-size: 0.8rem; font-weight: bold; display: inline-block; letter-spacing: 0.5px;}
        .badge-success { background-color: #4CAF50; color: white; } 
        .badge-warning { background-color: #FFC107; color: var(--color-text); } 
        .badge-primary { background-color: var(--color-primary); color: white; }
        
        .footer { background-color: var(--color-text); color: white; padding: 1rem 5vw; text-align: center; font-size: 0.85rem; flex-shrink: 0; }
        .footer-bottom { color: rgba(255, 255, 255, 0.5); }

        @media (max-width: 900px) {
            .menu-toggle { display: block; }
            .sidebar {
                width: 0; padding: 0; position: fixed; left: 0; top: 66px; 
                height: 100%; overflow-y: auto; z-index: 900; transition: width var(--transition-speed);
            }
            .sidebar.active { width: 200px; padding: 1rem 0; box-shadow: 5px 0 10px rgba(0, 0, 0, 0.1); }
            .admin-content { padding: 2rem 5vw; margin-left: 0; }
            .dashboard-stats { grid-template-columns: 1fr; }

            .data-table, .data-table thead, .data-table tbody, .data-table th, .data-table td, .data-table tr { display: block; }
            .data-table thead tr { position: absolute; top: -9999px; left: -9999px; }
            .data-table tr { border: 1px solid #ccc; margin-bottom: 1rem; }
            .data-table td { border: none; border-bottom: 1px solid #eee; position: relative; padding-left: 50%; text-align: right; }
            .data-table td:before { 
                position: absolute; top: 1rem; left: 6px; width: 45%; padding-right: 10px; white-space: nowrap; 
                text-align: left; font-weight: bold; color: var(--color-light-text);
            }
            td:nth-of-type(1):before { content: "Order ID"; }
            td:nth-of-type(2):before { content: "Customer"; }
            td:nth-of-type(3):before { content: "Total"; }
            td:nth-of-type(4):before { content: "Status"; }
            td:nth-of-type(5):before { content: "Date"; }
            td:nth-of-type(6):before { content: "Action"; }
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
                <h1>Dashboard Overview</h1>
            </section>
            
            <section class="dashboard-stats">
                <div class="card">
                    <h3>Total Revenue (Last 30 Days)</h3>
                    <p>$18,450</p>
                    <a href="admin_sales.html">View Report →</a>
                </div>
                <div class="card">
                    <h3>Pending Orders</h3>
                    <p>6</p>
                    <a href="admin_orders.html">Process Orders →</a>
                </div>
                <div class="card">
                    <h3>Low Stock Alerts</h3>
                    <p style="color: #E74C3C;">3 Items</p>
                    <a href="admin_inventory.html">Update Stock →</a>
                </div>
                <div class="card">
                    <h3>New Signups (Week)</h3>
                    <p>42</p>
                    <a href="admin_accounts.html">Manage Users →</a>
                </div>
            </section>

            <section class="recent-activity">
                <h2 style="font-family: var(--font-serif); font-weight: normal; margin-bottom: 1.5rem;">Recent Orders</h2>
                <div class="data-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#A9089</td>
                                <td>Sara Lee</td>
                                <td>$289.00</td>
                                <td><span class="badge badge-success">New</span></td>
                                <td>1 min ago</td>
                                <td><button class="btn-secondary" style="padding: 0.3rem 0.6rem;">View</button></td>
                            </tr>
                            <tr>
                                <td>#A9088</td>
                                <td>Mark Smith</td>
                                <td>$450.00</td>
                                <td><span class="badge badge-warning">Processing</span></td>
                                <td>3 hours ago</td>
                                <td><button class="btn-secondary" style="padding: 0.3rem 0.6rem;">View</button></td>
                            </tr>
                            <tr>
                                <td>#A9087</td>
                                <td>Lia Wong</td>
                                <td>$199.00</td>
                                <td><span class="badge badge-primary">Shipped</span></td>
                                <td>Yesterday</td>
                                <td><button class="btn-secondary" style="padding: 0.3rem 0.6rem;">View</button></td>
                            </tr>
                        </tbody>
                    </table>
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

        });

    </script>
</body>
</html>