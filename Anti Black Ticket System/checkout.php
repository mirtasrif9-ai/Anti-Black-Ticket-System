<?php

require __DIR__ . "/vendor/autoload.php";

// Load Stripe secret from environment (do NOT commit secrets).
$stripe_secret_key = getenv('STRIPE_SECRET');
if (!$stripe_secret_key) {
    // Fallback placeholder for local dev; keep empty to avoid accidental usage
    $stripe_secret_key = '';
}
\Stripe\Stripe::setApiKey($stripe_secret_key);

$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost/success.php",
    "cancel_url" => "http://localhost/stripe-index.php",
    "locale" => "auto",
    "line_items" => [
        [
            "quantity" => 1,
            "price_data" => [
                "currency" => "usd",
                "unit_amount" => 2000,
                "product_data" => [
                    "name" => "T-shirt"
                ]
            ]
        ],
        [
            "quantity" => 2,
            "price_data" => [
                "currency" => "usd",
                "unit_amount" => 700,
                "product_data" => [
                    "name" => "Hat"
                ]
            ]
        ]        
    ]
]);

http_response_code(303);
header("Location: " . $checkout_session->url);