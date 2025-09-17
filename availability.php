<?php
// availability.php - Domain availability checker
session_start();
include 'db_connect.php';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $domain_name = trim($_POST['domain_name']);
    if (strpos($domain_name, '.') === false) {
        $domain_name .= '.com';
    }
    $extensions = ['.com', '.net', '.org', '.co', '.tech'];
    $results = [];
    foreach ($extensions as $ext) {
        $full = $domain_name;
        if (strpos($domain_name, '.') !== false) {
            $full = preg_replace('/\.[a-z]+$/', $ext, $domain_name);
        } else {
            $full .= $ext;
        }
        try {
            $stmt = $pdo->prepare("SELECT * FROM domains WHERE domain_full = ?");
            $stmt->execute([$full]);
            $results[$full] = $stmt->fetch() ? false : true;
        } catch (PDOException $e) {
            echo "<script>alert('Database error: " . $e->getMessage() . "');</script>";
        }
    }
} else {
    echo "<script>window.location.href = 'index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domain Availability</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom, #ffffff, #f1f5f9);
            color: #2d3436;
            margin: 0;
            padding: 25px;
        }
        header {
            background: #1a73e8;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .results {
            max-width: 850px;
            margin: auto;
            background: white;
            border: 1px solid #dfe6e9;
            border-radius: 0 0 10px 10px;
            overflow: hidden;
        }
        .result-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px;
            border-bottom: 1px solid #e9ecef;
            transition: background 0.2s;
        }
        .result-item:hover {
            background: #f8f9fa;
        }
        .result-item:last-child {
            border-bottom: none;
        }
        .available {
            color: #27ae60;
            font-weight: 600;
            font-size: 1.2em;
        }
        .taken {
            color: #c0392b;
            font-weight: 600;
            font-size: 1.2em;
        }
        .add-btn {
            background: #27ae60;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background 0.3s ease;
        }
        .add-btn:hover {
            background: #219653;
        }
        .suggestions {
            margin: 40px auto;
            text-align: center;
            font-size: 1.2em;
            color: #34495e;
        }
        @media (max-width: 768px) {
            .result-item {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
            .add-btn {
                margin-top: 15px;
            }
            header {
                padding: 15px;
            }
        }
    </style>
    <script>
        function addToCart(domain) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = 'cart.php';
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'add_domain';
            input.value = domain;
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>
<body>
    <header>
        <h1>Domain Search Results for "<?php echo htmlspecialchars($domain_name); ?>"</h1>
        <a href="javascript:window.location.href='index.php'" style="color: white; text-decoration: none;">Home</a>
    </header>
    <div class="results">
        <?php foreach ($results as $full => $avail): ?>
            <div class="result-item">
                <span><?php echo htmlspecialchars($full); ?></span>
                <span class="<?php echo $avail ? 'available' : 'taken'; ?>">
                    <?php echo $avail ? 'Available' : 'Taken'; ?>
                </span>
                <?php if ($avail): ?>
                    <button class="add-btn" onclick="addToCart('<?php echo htmlspecialchars($full); ?>')">Add to Cart</button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="suggestions">
        <p>Can't find the perfect domain? Try another name!</p>
    </div>
</body>
</html>
