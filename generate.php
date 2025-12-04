<?php

// Set the content type of the response to HTML
header('Content-Type: text/html; charset=utf-8');

// 1. Get the webhook URL from the environment variable.
$webhookUrl = getenv('N8N_WEBHOOK_URL');
if (!$webhookUrl) {
    // If not set (e.g., in local development), fall back to the local config file.
    if (file_exists('config.local.php')) {
        $webhookUrl = require 'config.local.php';
    }
}

// If the URL is still not found, return a server error.
if (!$webhookUrl) {
    http_response_code(500);
    echo "Configuration error: Webhook URL is not set on the server.";
    exit;
}

// 2. Get the raw POST data from the client-side request.
$clientData = file_get_contents('php://input');

// 3. Forward the request to the n8n webhook using cURL.
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $clientData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: text/plain', // Match the content type sent by the client
    'Content-Length: ' . strlen($clientData)
]);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// 4. Echo the response from n8n directly back to the client.
http_response_code($httpcode);
echo $response;