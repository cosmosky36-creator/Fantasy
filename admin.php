<?php
/**
 * Mechaboy Store Server - Panel Admin Pesanan Sederhana
 */

require_once __DIR__ . '/data.php';

session_start();

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

// Handle Login
$loginError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $pin = trim($_POST['pin'] ?? '');
    if ($pin === ADMIN_PIN) {
        $_SESSION['admin_auth'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $loginError = 'PIN salah! Silakan coba lagi.';
    }
}

// Cek autentikasi
$isLoggedIn = !empty($_SESSION['admin_auth']);

// Handle Ubah Status Pesanan
$ordersFile = __DIR__ . '/orders.json';
$orders = file_exists($ordersFile) ? (json_decode(file_get_contents($ordersFile), true) ?: []) : [];

if ($isLoggedIn && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $targetId = trim($_POST['order_id'] ?? '');
    $newStatus = trim($_POST['new_status'] ?? '');
    $allowed = ['menunggu_pembayaran', 'lunas', 'selesai', 'dibatalkan'];

    if (in_array($newStatus, $allowed)) {
        foreach ($orders as &$ord) {
            if ($ord['order_id'] === $targetId) {
                $ord['status'] = $newStatus;
                $ord['updated_at'] = date('Y-m-d H:i:s');
                break;
            }
        }
        file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
        header('Location: admin.php?msg=updated');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - <?= htmlspecialchars(STORE_NAME) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Pixelify+Sans:wght@600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #141712;
            --panel-color: #20241b;
            --panel-border: #353b2d;
            --accent-green: #5fae3c;
            --accent-gold: #e6b83a;
            --text-main: #f0f3eb;
            --text-muted: #9ba691;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            padding: 24px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--panel-border);
            margin-bottom: 24px;
        }
        .title {
            font-family: 'Pixelify Sans', cursive;
            font-size: 24px;
            color: var(--accent-gold);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn {
            background-color: var(--accent-green);
            color: #0d170a;
            font-weight: 700;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn:hover { filter: brightness(1.1); }
        .btn-outline {
            background: transparent;
            border: 1px solid var(--panel-border);
            color: var(--text-muted);
        }
        .btn-outline:hover { color: #fff; border-color: #fff; }
        .login-box {
            max-width: 360px;
            margin: 80px auto;
            background: var(--panel-color);
            border: 2px solid var(--panel-border);
            padding: 30px;
            border-radius: 8px;
            text-align: center;
        }
        .input-group {
            margin: 16px 0;
            text-align: left;
        }
        .input-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            color: var(--text-muted);
        }
        .input-group input, .input-group select {
            width: 100%;
            padding: 10px 12px;
            background: #11140f;
            border: 1px solid var(--panel-border);
            border-radius: 6px;
            color: #fff;
            font-size: 14px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: var(--panel-color);
            border: 1px solid var(--panel-border);
            padding: 16px;
            border-radius: 8px;
        }
        .stat-val { font-size: 24px; font-weight: 800; color: var(--accent-gold); }
        .stat-lbl { font-size: 13px; color: var(--text-muted); margin-top: 4px; }
        .table-wrap {
            background: var(--panel-color);
            border: 1px solid var(--panel-border);
            border-radius: 8px;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }
        th, td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--panel-border);
            vertical-align: middle;
        }
        th {
            background: #191c16;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .badge-menunggu_pembayaran { background: rgba(230, 184, 58, 0.2); color: var(--accent-gold); }
        .badge-lunas { background: rgba(56, 189, 248, 0.2); color: #38bdf8; }
        .badge-selesai { background: rgba(95, 174, 60, 0.2); color: var(--accent-green); }
        .badge-dibatalkan { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .avatar {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            vertical-align: middle;
            margin-right: 6px;
        }
        .status-select {
            padding: 4px 8px;
            background: #11140f;
            color: #fff;
            border: 1px solid var(--panel-border);
            border-radius: 4px;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <?php if (!$isLoggedIn): ?>
        <div class="login-box">
            <h2 style="font-family:'Pixelify Sans',cursive; color:var(--accent-gold); margin-bottom: 10px;">🔐 Login Admin</h2>
            <p style="font-size: 13px; color: var(--text-muted);">Masukkan PIN Admin Mechaboy Store (Default: 1234)</p>
            <?php if ($loginError): ?>
                <div style="color: #ef4444; margin-top: 10px; font-size: 13px;"><?= htmlspecialchars($loginError) ?></div>
            <?php endif; ?>
            <form method="POST" style="margin-top: 20px;">
                <input type="hidden" name="action" value="login">
                <div class="input-group">
                    <label for="pin">PIN Keamanan</label>
                    <input type="password" id="pin" name="pin" required autofocus placeholder="Contoh: 1234">
                </div>
                <button type="submit" class="btn" style="width: 100%; justify-content: center;">Masuk ke Panel</button>
                <div style="margin-top: 14px;">
                    <a href="index.php" style="color: var(--text-muted); font-size: 12px; text-decoration: none;">← Kembali ke Toko</a>
                </div>
            </form>
        </div>
    <?php else: ?>
        <?php
            $totalOrders = count($orders);
            $totalIncome = 0;
            $pendingCount = 0;
            $completedCount = 0;
            foreach ($orders as $o) {
                if ($o['status'] === 'selesai' || $o['status'] === 'lunas') {
                    $totalIncome += $o['total'];
                }
                if ($o['status'] === 'menunggu_pembayaran') $pendingCount++;
                if ($o['status'] === 'selesai') $completedCount++;
            }
        ?>
        <div class="header">
            <div>
                <div class="title">⚔️ Mechaboy Store - Admin Dashboard</div>
                <div style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">Kelola pesanan pemain Minecraft server</div>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="index.php" class="btn btn-outline" target="_blank">🌐 Lihat Toko</a>
                <a href="admin.php?logout=1" class="btn btn-outline">🚪 Logout</a>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-val"><?= $totalOrders ?></div>
                <div class="stat-lbl">Total Pesanan</div>
            </div>
            <div class="stat-card">
                <div class="stat-val" style="color: #e6b83a;"><?= $pendingCount ?></div>
                <div class="stat-lbl">Menunggu Bayar</div>
            </div>
            <div class="stat-card">
                <div class="stat-val" style="color: #5fae3c;"><?= $completedCount ?></div>
                <div class="stat-lbl">Pesanan Selesai</div>
            </div>
            <div class="stat-card">
                <div class="stat-val" style="color: #38bdf8;">Rp <?= number_format($totalIncome, 0, ',', '.') ?></div>
                <div class="stat-lbl">Total Pemasukan (Lunas/Selesai)</div>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Waktu / Kode</th>
                        <th>Player (Nickname)</th>
                        <th>Metode Bayar</th>
                        <th>Item Dibeli</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                Belum ada pesanan masuk di orders.json.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>
                                    <strong style="color: var(--accent-gold); font-family: monospace; font-size: 14px;"><?= htmlspecialchars($order['order_id']) ?></strong>
                                    <div style="font-size: 11px; color: var(--text-muted); margin-top: 3px;"><?= htmlspecialchars($order['created_at']) ?></div>
                                </td>
                                <td>
                                    <img src="https://mc-heads.net/avatar/<?= urlencode($order['nickname']) ?>/24" class="avatar" alt="Avatar" onerror="this.style.display='none'">
                                    <strong><?= htmlspecialchars($order['nickname']) ?></strong>
                                </td>
                                <td>
                                    <?= htmlspecialchars(is_array($order['payment_method']) ? $order['payment_method']['name'] : $order['payment_method']) ?>
                                </td>
                                <td>
                                    <div style="font-size: 13px;">
                                        <?php foreach ($order['items'] as $item): ?>
                                            <div>• <?= htmlspecialchars($item['name']) ?> <span style="color: var(--text-muted);">(x<?= $item['qty'] ?>)</span></div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php if (!empty($order['note'])): ?>
                                        <div style="font-size: 11px; color: #fbbf24; margin-top: 4px;">📝 Note: <?= htmlspecialchars($order['note']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong style="color: var(--accent-green);"><?= htmlspecialchars($order['total_formatted'] ?? format_rupiah($order['total'])) ?></strong>
                                </td>
                                <td>
                                    <span class="badge badge-<?= htmlspecialchars($order['status']) ?>">
                                        <?= str_replace('_', ' ', htmlspecialchars($order['status'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" style="display: inline-block;">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">
                                        <select name="new_status" class="status-select" onchange="this.form.submit()">
                                            <option value="menunggu_pembayaran" <?= $order['status'] === 'menunggu_pembayaran' ? 'selected' : '' ?>>Menunggu</option>
                                            <option value="lunas" <?= $order['status'] === 'lunas' ? 'selected' : '' ?>>Lunas</option>
                                            <option value="selesai" <?= $order['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                            <option value="dibatalkan" <?= $order['status'] === 'dibatalkan' ? 'selected' : '' ?>>Batal</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</body>
</html>
