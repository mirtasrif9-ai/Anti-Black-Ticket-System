<?php
require_once 'include/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
// Fetch user info
$stmt = $conn->prepare('SELECT name, phone_number, balance FROM users WHERE user_id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($name, $phone, $balance);
$stmt->fetch();
$stmt->close();

$success = '';
$error = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wallet - Chorolin Tickets</title>
    <link rel="stylesheet" href="css/global.css">
    <style>
        .wallet-card { max-width: 400px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); padding: 32px 24px; }
        .wallet-title { font-size: 1.5em; color: #2563eb; margin-bottom: 18px; text-align:center; }
        .wallet-info { margin-bottom: 18px; }
        .wallet-info label { color: #888; font-weight: 500; }
        .wallet-balance { font-size: 1.3em; color: #047857; font-weight: bold; margin-bottom: 18px; text-align:center; }
        .wallet-form input[type='number'] { padding: 8px 12px; border-radius: 6px; border: 1px solid #bbb; width: 100%; margin-bottom: 10px; }
        .wallet-form button { background: #635bff; color: #fff; border: none; border-radius: 6px; padding: 10px 0; width: 100%; font-size: 1.1em; font-weight: 600; cursor: pointer; }
        .wallet-form button:hover { background: #4338ca; }
        .wallet-success { color: #16a34a; text-align:center; margin-bottom:10px; }
        .wallet-error { color: #dc2626; text-align:center; margin-bottom:10px; }
    </style>
</head>
<body>
<?php include 'include/nav.php'; ?>
<div class="wallet-card">
    <div class="wallet-title"><i class="fas fa-wallet"></i> My Wallet</div>
    <div class="wallet-info"><label>Name:</label> <?php echo htmlspecialchars($name); ?></div>
    <div class="wallet-info"><label>Phone:</label> <?php echo htmlspecialchars($phone); ?></div>
    <div class="wallet-balance">Balance: ৳<?php echo number_format($balance,2); ?></div>
    <?php if ($success): ?><div class="wallet-success"><?php echo $success; ?></div><?php endif; ?>
    <?php if ($error): ?><div class="wallet-error"><?php echo $error; ?></div><?php endif; ?>
    <form method="POST" class="wallet-form" autocomplete="off" action="stripe_checkout.php">
        <label for="add_amount">Add Balance (৳):</label>
        <input type="number" min="100" step="1" name="add_amount" id="add_amount" required>
        <button type="submit">Add Balance (Stripe)</button>
    </form>
    <div style="text-align:center; margin-top:10px; color:#888; font-size:0.95em;">* Stripe payment is simulated for demo.</div>
</div>
</body>
</html> 