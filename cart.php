<?php
// cart.php - Shopping cart
session_start();
include 'db_connect.php';
 
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
 
if (isset($_POST['add_domain'])) {
    $domain = $_POST['add_domain'];
    if (!in_array($domain, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $domain;
    }
}
 
if (isset($_POST['checkout'])) {
    if (!isset($_SESSION['user_id'])) {
        echo "<script>window.location.href = 'login.php';</script>";
        exit;
    }
    foreach ($_SESSION['cart'] as $domain) {
        $expiration = date('Y-m-d', strtotime('+1 year'));
        try {
            $stmt = $pdo->prepare("INSERT INTO domains (domain_full, user_id, expiration_date) VALUES (?, ?, ?)");
            $stmt->execute([$domain, $_SESSION['user_id'], $expiration]);
        } catch (PDOException $e) {
            echo "<script>alert('Error registering domain: " . $e->getMessage() . "');</script>";
        }
    }
    $_SESSION['cart'] = [];
    echo "<script>window.location.href = 'dashboard.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <style>
        body {
            font-family: 'Verdana', sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 25px;
        }
        .cart-container {
            max-width: 750px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }
        .cart-item {
            padding: 20px;
            border-bottom: 1px solid #dfe6e9;
            font-size: 1.2em;
            color: #2d3436;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .checkout-btn {
            background: #f1c40f;
            color: #2d3436;
            border: none;
            padding: 18px;
            width: 100%;
            font-size: 1.4em;
            cursor: pointer;
            border-radius: 8px;
            margin-top: 25px;
            transition: background 0.3s ease;
        }
        .checkout-btn:hover {
            background: #e1b800;
        }
        .cart-container a {
            display: inline-block;
            margin-top: 25px;
            color: #1a73e8;
            text-decoration: none;
            font-size: 1.1em;
        }
        .cart-container a:hover {
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            .cart-container {
                padding: 20px;
            }
            .cart-item {
                font-size: 1em;
            }
            .checkout-btn {
                font-size: 1.2em;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <h2>Your Cart</h2>
        <?php if (empty($_SESSION['cart'])): ?>
            <p>Cart is empty.</p>
        <?php else: ?>
            <?php foreach ($_SESSION['cart'] as $domain): ?>
                <div class="cart-item"><?php echo htmlspecialchars($domain); ?></div>
            <?php endforeach; ?>
            <form method="POST">
                <button type="submit" name="checkout" class="checkout-btn">Proceed to Checkout (Dummy)</button>
            </form>
        <?php endif; ?>
        <a href="javascript:window.location.href='index.php'">Continue Shopping</a>
    </div>
</body>
</html>
