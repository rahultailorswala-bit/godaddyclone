<?php
// register.php - User registration with enhanced error handling for duplicate entries
session_start();
include 'db_connect.php';
 
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
 
    // Validate inputs
    if (empty($username) || empty($email) || empty($_POST['password'])) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        try {
            // Check for existing username or email
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetchColumn() > 0) {
                $error = "Username or email already taken.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$username, $email, $password]);
                echo "<script>window.location.href = 'login.php';</script>";
                exit;
            }
        } catch (PDOException $e) {
            $error = "Registration failed: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        .register-form {
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
            border-color: #27ae60;
        }
        button {
            width: 100%;
            padding: 15px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.2em;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #219653;
        }
        .error {
            color: #c0392b;
            text-align: center;
            margin-bottom: 15px;
            font-size: 1.1em;
        }
        .register-form a {
            color: #1a73e8;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 1.1em;
        }
        .register-form a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-form">
        <h2>Register</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <a href="javascript:window.location.href='login.php'">Already have an account? Login</a>
    </div>
</body>
</html>
