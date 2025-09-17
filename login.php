<?php
// login.php - User login
session_start();
include 'db_connect.php';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
 
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo "<script>window.location.href = 'dashboard.php';</script>";
            exit;
        } else {
            $error = "Invalid credentials.";
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #f1f5f9, #dfe6e9);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-form {
            background: white;
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
            width: 400px;
        }
        input {
            width: 100%;
            padding: 15px;
            margin: 12px 0;
            border: 1px solid #dfe6e9;
            border-radius: 6px;
            font-size: 1.2em;
            outline: none;
            transition: border-color 0.3s;
        }
        input:focus {
            border-color: #1a73e8;
        }
        button {
            width: 100%;
            padding: 15px;
            background: #1a73e8;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.2em;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #1557b0;
        }
        .error {
            color: #c0392b;
            text-align: center;
            margin-bottom: 15px;
            font-size: 1.1em;
        }
        .login-form a {
            color: #1a73e8;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 1.1em;
        }
        .login-form a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="javascript:window.location.href='register.php'">Don't have an account? Register</a>
    </div>
</body>
</html>
