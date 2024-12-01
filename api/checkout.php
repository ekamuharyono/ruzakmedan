<?php
// Ambil data dari request POST
$nama = htmlspecialchars($_POST['nama']);
$nomor = htmlspecialchars($_POST['nomor']);
$alamat = htmlspecialchars($_POST['alamat']);
$pesanan = json_decode($_POST['pesanan'], true);

// Token dan Chat ID Bot Telegram Anda
$token = "8092616728:AAEqil4Bz6P8ptbrakBdFEn8ft-PkNCnLf4";  // Ganti dengan token bot Anda
$chat_id = "1045573640";  // Ganti dengan chat ID Anda

// Pesan yang akan dikirim ke Telegram
$message = "*Detail Pemesanan:*\n";
$message .= "*Nama:* $nama\n";
$message .= "*Nomor Handphone:* $nomor\n";
$message .= "*Alamat:* $alamat\n\n";
$message .= "*Daftar Pesanan:*\n";

// Menambahkan detail pesanan ke pesan
foreach ($pesanan as $item) {
    $message .= "• " . $item['nama'] . " x" . $item['jumlah'] . " Pcs - Rp. " . ($item['harga'] * $item['jumlah']) . "\n";
}

// Kirim pesan ke Telegram menggunakan API
$url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($message) . "&parse_mode=Markdown";

// Menggunakan cURL untuk mengirim pesan ke Telegram
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

// Cek jika pesan berhasil dikirim
if ($response) {
    echo "Pesanan berhasil dikirim!";
} else {
    echo "Terjadi kesalahan saat mengirim pesan.";
}
?>
