<?php
// This script is automatically included before index.php by the server configuration.
// It reads the webhook URL from the server environment and makes it available to JavaScript.
$webhookUrl = getenv('N8N_WEBHOOK_URL');
if ($webhookUrl) {
    // Use json_encode to ensure the URL is safely escaped as a JavaScript string.
    echo "<script>window.N8N_WEBHOOK_URL = " . json_encode($webhookUrl) . ";</script>";
}
?>