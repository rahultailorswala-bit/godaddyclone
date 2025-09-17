<?php
// dashboard.php - User dashboard for domain management with functional remove action
session_start();
include 'db_connect.php';
 
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit;
}
 
// Handle domain removal
if (isset($_POST['remove_domain'])) {
    $domain = $_POST['remove_domain'];
    try {
        $stmt = $pdo->prepare("DELETE FROM domains WHERE domain_full = ? AND user_id = ?");
        $stmt->execute([$domain, $_SESSION['user_id']]);
        echo "<script>alert('Domain " . htmlspecialchars($domain) . " removed successfully.'); window.location.href = 'dashboard.php';</script>";
        exit;
    } catch (PDOException $e) {
        echo "<script>alert('Error removing domain: " . $e->getMessage() . "');</script>";
    }
}
 
try {
    $stmt = $pdo->prepare("SELECT * FROM domains WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $domains = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "<script>alert('Error fetching domains: " . $e->getMessage() . "');</script>";
    $domains = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom, #f1f5f9, #ffffff);
            margin: 0;
            padding: 25px;
        }
        .dashboard {
            max-width: 950px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        th, td {
            padding: 18px;
            text-align: left;
            border-bottom: 1px solid #dfe6e9;
        }
        th {
            background: #1a73e8;
            color: white;
            font-size: 1.2em;
        }
        .action-btn {
            background: #00b894;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 8px;
            transition: background 0.3s ease;
        }
        .action-btn:hover {
            background: #009e7f;
        }
        .remove-btn {
            background: #c0392b;
        }
        .remove-btn:hover {
            background: #a93226;
        }
        .dashboard a {
            color: #1a73e8;
            text-decoration: none;
            margin-right: 15px;
            font-size: 1.1em;
        }
        .dashboard a:hover {
            text-decoration: underline;
        }
        @media (max-width: 768px) {
            table {
                font-size: 0.95em;
            }
            .action-btn {
                display: block;
                margin: 8px 0;
            }
            .dashboard {
                padding: 20px;
            }
        }
    </style>
    <script>
        function renew(domain) {
            alert('Renewal for ' + domain + ' simulated. Expiration extended.');
        }
        function transfer(domain) {
            alert('Transfer for ' + domain + ' is non-functional.');
        }
        function removeDomain(domain) {
            if (confirm('Are you sure you want to remove ' + domain + '?')) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = 'dashboard.php';
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'remove_domain';
                input.value = domain;
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> - Your Domains</h2>
        <table>
            <tr>
                <th>Domain</th>
                <th>Expiration</th>
                <th>Actions</th>
            </tr>
            <?php if (empty($domains)): ?>
                <tr><td colspan="3">No domains registered.</td></tr>
            <?php else: ?>
                <?php foreach ($domains as $dom): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($dom['domain_full']); ?></td>
                        <td><?php echo htmlspecialchars($dom['expiration_date']); ?></td>
                        <td>
                            <button class="action-btn" onclick="renew('<?php echo htmlspecialchars($dom['domain_full']); ?>')">Renew</button>
                            <button class="action-btn" onclick="transfer('<?php echo htmlspecialchars($dom['domain_full']); ?>')">Transfer</button>
                            <button class="action-btn remove-btn" onclick="removeDomain('<?php echo htmlspecialchars($dom['domain_full']); ?>')">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
        <a href="javascript:window.location.href='index.php'">Home</a> | <a href="javascript:window.location.href='logout.php'">Logout</a>
    </div>
</body>
</html>
