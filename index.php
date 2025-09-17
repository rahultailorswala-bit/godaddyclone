<?php
// index.php - Homepage
session_start();
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DomainHub - Home</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ffffff, #e6f0fa);
            color: #2c3e50;
        }
        header {
            background: #1a73e8;
            color: white;
            padding: 25px;
            text-align: center;
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }
        .logo {
            font-size: 2.8em;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .search-container {
            margin: 60px auto;
            max-width: 750px;
            padding: 35px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }
        .search-bar {
            display: flex;
            justify-content: center;
        }
        .search-bar input {
            width: 65%;
            padding: 18px;
            border: 1px solid #dfe6e9;
            border-radius: 8px 0 0 8px;
            font-size: 1.3em;
            outline: none;
            transition: border-color 0.3s;
        }
        .search-bar input:focus {
            border-color: #1a73e8;
        }
        .search-bar button {
            padding: 18px 50px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 0 8px 8px 0;
            cursor: pointer;
            font-size: 1.3em;
            transition: background 0.3s ease;
        }
        .search-bar button:hover {
            background: #219653;
        }
        .promotions {
            text-align: center;
            margin: 50px 20px;
            padding: 25px;
            background: #fff8e1;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .promotions h2 {
            color: #1a73e8;
            font-size: 2em;
        }
        .pricing {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 25px;
            margin: 50px 20px;
        }
        .plan {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            text-align: center;
            width: 240px;
            transition: transform 0.3s ease;
        }
        .plan:hover {
            transform: translateY(-8px);
        }
        .plan h3 {
            color: #1a73e8;
            font-size: 1.7em;
        }
        .extensions {
            text-align: center;
            margin: 40px;
            font-size: 1.4em;
            color: #34495e;
        }
        footer {
            background: #2d3436;
            color: white;
            text-align: center;
            padding: 20px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        @media (max-width: 768px) {
            .search-container {
                margin: 30px 15px;
                padding: 20px;
            }
            .search-bar input, .search-bar button {
                font-size: 1.1em;
                padding: 14px;
            }
            .plan {
                width: 100%;
                margin: 15px 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">DomainHub</div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="javascript:window.location.href='dashboard.php'" style="color: white; margin-left: 25px; text-decoration: none;">Dashboard</a>
            <a href="javascript:window.location.href='logout.php'" style="color: white; margin-left: 25px; text-decoration: none;">Logout</a>
        <?php else: ?>
            <a href="javascript:window.location.href='login.php'" style="color: white; margin-left: 25px; text-decoration: none;">Login</a>
            <a href="javascript:window.location.href='register.php'" style="color: white; margin-left: 25px; text-decoration: none;">Register</a>
        <?php endif; ?>
    </header>
    <div class="search-container">
        <form class="search-bar" method="POST" action="availability.php">
            <input type="text" name="domain_name" placeholder="Search for your dream domain..." required>
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="extensions">
        Top Extensions: .com, .net, .org, .co, .tech
    </div>
    <div class="promotions">
        <h2>Exclusive Deals</h2>
        <p>Register .com domains for just $0.99 for the first year!</p>
    </div>
    <div class="pricing">
        <div class="plan">
            <h3>.com</h3>
            <p>$11.99/year</p>
        </div>
        <div class="plan">
            <h3>.net</h3>
            <p>$13.99/year</p>
        </div>
        <div class="plan">
            <h3>.org</h3>
            <p>$12.99/year</p>
        </div>
    </div>
    <footer>&copy; 2025 DomainHub. All rights reserved.</footer>
</body>
</html>
