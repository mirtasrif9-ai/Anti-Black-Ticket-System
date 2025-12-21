<?php
require_once 'vendor/autoload.php';
require_once 'include/db.php';

// Load Stripe secret from environment variable (do NOT commit secrets)
\Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET'));

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_amount'])) {
    $amount = floatval($_POST['add_amount']);
    if ($amount <= 0) {
        header('Location: wallet.php?error=invalid_amount');
        exit();
    }
    $user_id = $_SESSION['user_id'];
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'bdt',
                'product_data' => [
                    'name' => 'Wallet Top-up',
                ],
                'unit_amount' => intval($amount * 100), // Stripe expects amount in cents
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/wallet_success.php?session_id={CHECKOUT_SESSION_ID}&amount=' . $amount,
        'cancel_url' => 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/wallet.php?error=cancel',
        'metadata' => [
            'user_id' => $user_id,
        ],
    ]);
    header('Location: ' . $session->url);
    exit();
} else {
    header('Location: wallet.php?error=invalid_request');
    exit();
} 