<?php
/**
 * Mechaboy Store Server - Cek Status Pesanan
 */

header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/data.php';

$query = trim($_GET['q'] ?? '');

if (empty($query)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Masukkan Kode Pesanan atau Nickname Minecraft.']);
    exit;
}

$ordersFile = __DIR__ . '/orders.json';
if (!file_exists($ordersFile)) {
    echo json_encode(['success' => true, 'orders' => []]);
    exit;
}

$orders = json_decode(file_get_contents($ordersFile), true) ?: [];
$found = [];

foreach ($orders as $order) {
    if (strcasecmp($order['order_id'], $query) === 0 || strcasecmp($order['nickname'], $query) === 0) {
        $found[] = $order;
    }
}

echo json_encode([
    'success' => true,
    'query' => $query,
    'count' => count($found),
    'orders' => $found
]);
