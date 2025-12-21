<?php
require_once 'include/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$amount = isset($_GET['amount']) ? floatval($_GET['amount']) : 0;
$success = false;
if ($amount > 0) {
    $conn->query("UPDATE users SET balance = balance + $amount WHERE user_id = $user_id");
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wallet Top-up Success</title>
    <link rel="stylesheet" href="css/global.css">
    <style>
        .wallet-success-card { max-width: 400px; margin: 60px auto; background: #fff; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); padding: 32px 24px; text-align:center; }
        .wallet-success-title { font-size: 1.4em; color: #16a34a; margin-bottom: 18px; }
        .wallet-success-amount { font-size: 1.2em; color: #2563eb; margin-bottom: 18px; }
        .wallet-success-link { display:inline-block; margin-top:18px; color:#fff; background:#2563eb; padding:10px 24px; border-radius:6px; text-decoration:none; font-weight:600; }
        .wallet-success-link:hover { background:#1e40af; }
    </style>
</head>
<body>
<?php include 'include/nav.php'; ?>
<div class="wallet-success-card">
    <?php if ($success): ?>
        <div class="wallet-success-title"><i class="fas fa-check-circle"></i> Balance Added Successfully!</div>
        <div class="wallet-success-amount">৳<?php echo number_format($amount,2); ?> has been added to your wallet.</div>
        <a href="wallet.php" class="wallet-success-link">Go to My Wallet</a>
    <?php else: ?>
        <div class="wallet-success-title" style="color:#dc2626;"><i class="fas fa-times-circle"></i> Invalid Amount</div>
        <a href="wallet.php" class="wallet-success-link" style="background:#dc2626;">Back to Wallet</a>
    <?php endif; ?>
</div>
</body>
</html> 