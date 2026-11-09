<?php
/**
 * Mechaboy Store Server - Backend Checkout Processor
 * PRP Versi 1.0 (Kebutuhan F6, F7, F8, F9, F10)
 */

header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/data.php';

// Hanya terima metode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Metode request tidak diizinkan. Gunakan POST.']);
    exit;
}

// Ambil input JSON atau POST Form
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    $data = $_POST;
}

$nickname = trim($data['nickname'] ?? '');
$paymentMethod = trim($data['payment_method'] ?? '');
$cartItems = $data['items'] ?? [];
$note = trim($data['note'] ?? '');

// 1. Validasi Nickname (F7, Section 13)
if (empty($nickname)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Nickname Minecraft wajib diisi!']);
    exit;
}

if (!validate_nickname($nickname)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Nickname 3-16 karakter: huruf, angka, _ atau .']);
    exit;
}

// 2. Validasi Metode Pembayaran (Section 13)
if (empty($paymentMethod) || !isset($PAYMENT_METHODS[$paymentMethod])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Pilih metode pembayaran.']);
    exit;
}

// 3. Validasi Keranjang (Section 13)
if (!is_array($cartItems) || count($cartItems) === 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Keranjang masih kosong.']);
    exit;
}

// 4. Hitung ulang total di server (F8: Server menghitung ulang harga sendiri)
$verifiedItems = [];
$totalPrice = 0;

foreach ($cartItems as $cartItem) {
    $productId = $cartItem['id'] ?? '';
    $qty = intval($cartItem['qty'] ?? 1);

    // Filter batas per item: 1-20 (Section 13)
    if ($qty < 1) continue;
    if ($qty > 20) $qty = 20;

    // Pastikan produk ada di katalog backend (data.php)
    $product = get_product($productId);
    if (!$product) continue;

    $subtotal = $product['price'] * $qty;
    $totalPrice += $subtotal;

    $verifiedItems[] = [
        'id' => $product['id'],
        'name' => $product['name'],
        'category' => $product['cat'],
        'tier' => $product['tier'],
        'type' => $product['type'],
        'icon' => $product['icon'],
        'price' => $product['price'],
        'price_formatted' => format_rupiah($product['price']),
        'qty' => $qty,
        'subtotal' => $subtotal,
        'subtotal_formatted' => format_rupiah($subtotal)
    ];
}

if (count($verifiedItems) === 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Tidak ada produk valid di keranjang Anda.']);
    exit;
}

// 5. Generate Kode Unik Pesanan (F9: Contoh MB-A1B2C3)
$orderId = generate_order_id();
$createdAt = date('Y-m-d H:i:s');
$ordersFile = __DIR__ . '/orders.json';

// Baca data pesanan lama
$orders = [];
if (file_exists($ordersFile)) {
    $existing = file_get_contents($ordersFile);
    $orders = json_decode($existing, true) ?: [];
}

// Pastikan kode order unik
$existingIds = array_column($orders, 'order_id');
while (in_array($orderId, $existingIds)) {
    $orderId = generate_order_id();
}

$orderRecord = [
    'order_id' => $orderId,
    'created_at' => $createdAt,
    'nickname' => $nickname,
    'payment_method' => [
        'key' => $paymentMethod,
        'name' => $PAYMENT_METHODS[$paymentMethod]['name']
    ],
    'note' => $note,
    'items' => $verifiedItems,
    'total' => $totalPrice,
    'total_formatted' => format_rupiah($totalPrice),
    'status' => 'menunggu_pembayaran' // Sesuai Bagian 12 PRP
];

// Simpan ke orders.json dengan file locking
array_unshift($orders, $orderRecord);
file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);

// 6. Buat Teks WhatsApp (F10)
$itemSummaryLines = [];
foreach ($verifiedItems as $item) {
    $itemSummaryLines[] = "• {$item['name']} (x{$item['qty']}) - {$item['subtotal_formatted']}";
}
$itemsSummaryText = implode("\n", $itemSummaryLines);

$waMessage = "Halo Admin " . STORE_NAME . "! 🎮\n\n"
    . "Saya ingin konfirmasi pesanan baru:\n"
    . "━━━━━━━━━━━━━━━━━━━\n"
    . "🔖 *Kode Pesanan:* {$orderId}\n"
    . "👤 *Nickname MC:* {$nickname}\n"
    . "💳 *Metode Bayar:* " . $PAYMENT_METHODS[$paymentMethod]['name'] . "\n"
    . "📦 *Daftar Barang:*\n" . $itemsSummaryText . "\n"
    . "💰 *Total Pembayaran:* " . format_rupiah($totalPrice) . "\n"
    . ($note ? "📝 *Catatan:* {$note}\n" : "")
    . "━━━━━━━━━━━━━━━━━━━\n"
    . "Mohon info nomor rekening / QRIS untuk pembayaran ya min. Terima kasih!";

$waUrl = "https://wa.me/" . ADMIN_WHATSAPP . "?text=" . urlencode($waMessage);

// Response Sukses
echo json_encode([
    'success' => true,
    'message' => 'Pesanan berhasil dibuat!',
    'order' => [
        'order_id' => $orderId,
        'created_at' => $createdAt,
        'nickname' => $nickname,
        'payment_method' => $PAYMENT_METHODS[$paymentMethod]['name'],
        'items' => $verifiedItems,
        'total' => $totalPrice,
        'total_formatted' => format_rupiah($totalPrice),
        'whatsapp_url' => $waUrl,
        'whatsapp_message' => $waMessage
    ]
]);
