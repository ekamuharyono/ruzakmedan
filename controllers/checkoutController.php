<?php

function handleCheckout() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Process form data and send it to the Telegram bot
        $nama = htmlspecialchars($_POST['nama']);
        $nomor = htmlspecialchars($_POST['nomor']);
        $alamat = htmlspecialchars($_POST['alamat']);
        $pesanan = json_decode($_POST['pesanan'], true);

        // Send data to the Telegram bot
        sendToTelegram($nama, $nomor, $alamat, $pesanan);

        // Return response to client (for Vercel API)
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    }
}

// Function to send data to Telegram
function sendToTelegram($nama, $nomor, $alamat, $pesanan) {
    $token = "YOUR_BOT_TOKEN";
    $chat_id = "YOUR_CHAT_ID";
    $message = "*Detail Pemesanan:*\n";
    $message .= "*Nama:* $nama\n";
    $message .= "*Nomor Handphone:* $nomor\n";
    $message .= "*Alamat:* $alamat\n\n";
    $message .= "*Daftar Pesanan:*\n";

    foreach ($pesanan as $item) {
        $message .= "• " . $item['nama'] . " x" . $item['jumlah'] . " Pcs - Rp. " . ($item['harga'] * $item['jumlah']) . "\n";
    }

    // Send the message to Telegram
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($message) . "&parse_mode=Markdown";
    file_get_contents($url);
}
