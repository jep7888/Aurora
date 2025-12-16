<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Aurora Admin</title>
    <style>
        /* === GLOBAL STYLES (Copied from index.php) === */
        :root {
            --color-primary: #B5838D; /* Blush Pink */
            --color-secondary: #F6F4F1; /* Soft Beige/Off-White */
            --color-accent: #E5C3A6; /* Soft Rose Gold/Copper */
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

        /* Profile is handled by header actions, but we put an empty active link to keep the JS happy */
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

        /* === BUTTONS & FORMS (Professional/Elegant Enhancements) === */
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
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 0.5rem; color: var(--color-light-text); font-size: 0.9rem; }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px; font-family: var(--font-sans);
            transition: border-color var(--transition-speed), box-shadow var(--transition-speed);
        }
        .form-group input:focus { border-color: var(--color-primary); box-shadow: 0 0 0 1px rgba(181, 131, 141, 0.5); outline: none; }
        
        /* Profile Card */
        .card {
            background-color: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            max-width: 600px; margin: 0 auto;
        }
        .profile-picture {
            width: 100px; height: 100px; background-color: var(--color-secondary); border-radius: 50%;
            margin: 0 auto 1.5rem; display: flex; justify-content: center; align-items: center;
            color: var(--color-primary); font-size: 2rem; cursor: pointer; border: 3px solid var(--color-accent);
        }
        .badge { padding: 0.3rem 0.7rem; border-radius: 12px; font-size: 0.8rem; font-weight: bold; display: inline-block; letter-spacing: 0.5px;}
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
            <a href="admin_profile.html" class="active">Profile</a>
            <a href="admin_logout.html" style="color: #E74C3C;">Logout</a>
        </div>
    </header>

    <div class="admin-container">
        <aside class="sidebar">
            <ul class="sidebar-nav">
                <li><a href="admin_dashboard.html">Dashboard</a></li>
                <li><a href="admin_products.html">Products</a></li>
                <li><a href="admin_inventory.html">Inventory / Stock</a></li>
                <li><a href="admin_orders.html">Orders</a></li>
                <li><a href="admin_accounts.html">Accounts / Users</a></li>
                <li><a href="admin_sales.html">Sales Analytics</a></li>
            </ul>
        </aside>

        <main class="admin-content">
            <section class="content-header">
                <h1>My Profile & Settings</h1>
            </section>
            
            <div class="card">
                <div class="profile-picture">AV</div> 
                <p style="text-align: center; color: var(--color-primary); font-weight: bold; margin-bottom: 2rem;">Super Administrator <span class="badge badge-primary">Admin</span></p>

                <form>
                    <h2 style="font-family: var(--font-serif); font-weight: normal; margin-bottom: 1rem; font-size: 1.5rem;">Personal Details</h2>
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" value="Aurora Validator">
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" value="admin@aurorabags.com">
                    </div>
                    
                    <h2 style="font-family: var(--font-serif); font-weight: normal; margin: 2rem 0 1rem; padding-top: 1rem; border-top: 1px dashed #eee; font-size: 1.5rem;">Security</h2>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" id="password" placeholder="Enter new password">
                    </div>
                    
                    <button type="submit" class="cta-button" style="margin-top: 1rem;">Update Profile & Password</button>
                    <button type="button" class="btn-secondary" style="margin-left: 1rem;">Cancel</button>
                </form>
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