<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts | Aurora Admin</title>
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
        .btn-danger {
            background-color: #E74C3C; color: white; border: 1px solid #E74C3C; padding: 0.6rem 1.2rem; font-size: 0.9rem; 
            letter-spacing: 0.5px; border-radius: 4px; transition: all var(--transition-speed); cursor: pointer;
        }
        .btn-danger:hover { background-color: #C0392B; border-color: #C0392B; }
        
        /* Search Bar (Form Styling) */
        .search-bar { margin-bottom: 1.5rem; display: flex; gap: 1rem; }
        .search-bar input, .search-bar select {
            padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px; font-family: var(--font-sans); flex-grow: 1;
            transition: border-color var(--transition-speed), box-shadow var(--transition-speed);
        }
        .search-bar input:focus, .search-bar select:focus { border-color: var(--color-primary); box-shadow: 0 0 0 1px rgba(181, 131, 141, 0.5); outline: none; }
        .search-bar select { flex-grow: 0; min-width: 150px; }
        
        /* === TABLES === */
        .data-table-container { background-color: #FFFFFF; border-radius: 6px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th, .data-table td { padding: 1rem 1.2rem; text-align: left; border-bottom: 1px solid #eee; }
        .data-table th { background-color: #f9f9f9; font-weight: 600; text-transform: uppercase; font-size: 0.8rem; color: var(--color-light-text); }
        .data-table tr:hover { background-color: #fafafa; }

        /* Status Badges */
        .badge { padding: 0.3rem 0.7rem; border-radius: 12px; font-size: 0.8rem; font-weight: bold; display: inline-block; letter-spacing: 0.5px;}
        .badge-success { background-color: #4CAF50; color: white; } 
        .badge-danger { background-color: #E74C3C; color: white; }
        .badge-primary { background-color: var(--color-primary); color: white; }

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
            .search-bar { flex-direction: column; }
            .search-bar select { min-width: 100%; }

            /* Mobile Table Stack */
            .data-table, .data-table thead, .data-table tbody, .data-table th, .data-table td, .data-table tr { display: block; }
            .data-table thead tr { position: absolute; top: -9999px; left: -9999px; }
            .data-table tr { border: 1px solid #ccc; margin-bottom: 1rem; }
            .data-table td { border: none; border-bottom: 1px solid #eee; position: relative; padding-left: 50%; text-align: right; }
            .data-table td:before { 
                position: absolute; top: 1rem; left: 6px; width: 45%; padding-right: 10px; white-space: nowrap; 
                text-align: left; font-weight: bold; color: var(--color-light-text);
            }
            /* Specific column labels for Accounts */
            td:nth-of-type(1):before { content: "User ID"; }
            td:nth-of-type(2):before { content: "Name"; }
            td:nth-of-type(3):before { content: "Email"; }
            td:nth-of-type(4):before { content: "Role"; }
            td:nth-of-type(5):before { content: "Status"; }
            td:nth-of-type(6):before { content: "Actions"; }
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
                <li><a href="admin_sales.php">Sales Analytics</a></li>
            </ul>
        </aside>

        <main class="admin-content">
            <section class="content-header">
                <h1>User Accounts (1,245)</h1>
                <button class="cta-button" style="padding: 0.6rem 1.2rem; font-size: 0.9rem;">+ New Admin</button>
            </section>
            
            <div class="search-bar">
                <input type="text" placeholder="Search by name, email, or ID...">
                <select>
                    <option>Filter by Role</option>
                    <option>Customer</option>
                    <option>Admin</option>
                </select>
                <select>
                    <option>Filter by Status</option>
                    <option>Active</option>
                    <option>Banned</option>
                </select>
            </div>

            <div class="data-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#U1001</td>
                            <td>Aurora Validator</td>
                            <td>admin@aurorabags.com</td>
                            <td><span class="badge badge-primary">Admin</span></td>
                            <td><span class="badge badge-success">Active</span></td>
                            <td>
                                <button class="btn-secondary" style="padding: 0.3rem 0.6rem;">Edit</button>
                                <button class="btn-danger" style="padding: 0.3rem 0.6rem;">Ban</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#U1002</td>
                            <td>Jane Doe</td>
                            <td>jane.doe@email.com</td>
                            <td>Customer</td>
                            <td><span class="badge badge-success">Active</span></td>
                            <td>
                                <button class="btn-secondary" style="padding: 0.3rem 0.6rem;">View</button>
                                <button class="btn-danger" style="padding: 0.3rem 0.6rem;">Ban</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#U1003</td>
                            <td>Mark R.</td>
                            <td>mark.r@email.com</td>
                            <td>Customer</td>
                            <td><span class="badge badge-danger">Banned</span></td>
                            <td>
                                <button class="btn-secondary" style="padding: 0.3rem 0.6rem;">View</button>
                                <button class="cta-button" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">Unban</button>
                            </td>
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