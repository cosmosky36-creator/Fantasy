<?php
/**
 * Mechaboy Store Server - Toko Server Minecraft Resmi
 * PRP Versi 1.0
 */
require_once __DIR__ . '/data.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(STORE_NAME) ?> - Toko Server Minecraft</title>
    
    <!-- Google Fonts: Pixelify Sans untuk judul bergaya pixel & Nunito untuk isi teks yang nyaman dibaca -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Pixelify+Sans:wght@600;700&display=swap" rel="stylesheet">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <!-- TOP ANNOUNCEMENT BAR -->
    <div class="top-bar">
        <div class="container top-bar-inner">
            <div class="server-online-badge">
                <span class="ping-dot"></span>
                <span>Server Status: Online (Java & Bedrock Ready)</span>
            </div>
            <div>
                <span>IP Server: <strong style="color:var(--mc-gold);"><?= htmlspecialchars(SERVER_IP) ?></strong></span>
                <span style="margin: 0 8px; opacity: 0.4;">|</span>
                <a href="#cara-beli" style="color: var(--text-muted); text-decoration: none;">Panduan Beli</a>
                <span style="margin: 0 8px; opacity: 0.4;">|</span>
                <a href="admin.php" style="color: var(--text-muted); text-decoration: none;" title="Khusus Pengelola Server">Admin</a>
            </div>
        </div>
    </div>

    <!-- NAVBAR / SITE HEADER -->
    <header class="site-header">
        <div class="container navbar">
            <a href="index.php" class="brand-logo">
                <div class="logo-icon">⚔️</div>
                <div class="brand-text">
                    <h1><?= htmlspecialchars(STORE_NAME) ?></h1>
                    <span>Official Minecraft Store</span>
                </div>
            </a>

            <ul class="nav-links">
                <li><a href="#katalog">Katalog Toko</a></li>
                <li><a href="#cara-beli">Cara Membeli</a></li>
                <li><a href="#cek-pesanan">Cek Pesanan</a></li>
            </ul>

            <div class="nav-actions">
                <button class="btn-ip" onclick="copyServerIP('<?= htmlspecialchars(SERVER_IP) ?>')" title="Salin IP Minecraft Server">
                    <span>📋 Salin IP</span>
                </button>
                <button class="btn-cart" id="btnOpenCart" aria-label="Buka Keranjang Belanja">
                    <span>🛒 Keranjang</span>
                    <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
                </button>
            </div>
        </div>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="container">
        
        <!-- HERO SECTION -->
        <section class="hero">
            <div class="hero-badge">⚡ Official Server Store ⚡</div>
            <h2 class="hero-title">Tingkatkan Petualanganmu di <span>Mechaboy</span></h2>
            <p class="hero-desc">
                Dapatkan Rank bergengsi, Senjata Legendaris Tujuh Dosa pemusnah monster, dan item eksklusif server dengan transaksi cepat, transparan, dan terpercaya.
            </p>

            <div class="hero-ip-box">
                <span style="font-size: 13px; color: var(--text-muted);">IP Server:</span>
                <span class="ip-text"><?= htmlspecialchars(SERVER_IP) ?></span>
                <button class="btn-ip" onclick="copyServerIP('<?= htmlspecialchars(SERVER_IP) ?>')">Salin</button>
            </div>
        </section>

        <!-- HIGHLIGHTS BANNER -->
        <div class="features-banner">
            <div class="feature-item">
                <div class="feature-icon">⚡</div>
                <div class="feature-text">
                    <h4>Proses Cepat & Otomatis</h4>
                    <p>Pesanan langsung tercatat dengan kode unik.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🛡️</div>
                <div class="feature-text">
                    <h4>100% Aman & Terpercaya</h4>
                    <p>Pembayaran langsung ke admin resmi server.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">💬</div>
                <div class="feature-text">
                    <h4>Verifikasi via WhatsApp</h4>
                    <p>Konfirmasi bukti pembayaran praktis dalam 1 klik.</p>
                </div>
            </div>
        </div>

        <!-- TOOLBAR: FILTER KATEGORI & PENCARIAN (F2, F3) -->
        <section class="toolbar-section" id="katalog">
            <div class="category-tabs">
                <button class="tab-btn active" data-category="all">Semua Produk (<?= count($PRODUCTS) ?>)</button>
                <button class="tab-btn" data-category="rank">👑 Rank (6)</button>
                <button class="tab-btn" data-category="weapon">⚔️ Senjata Legend (7)</button>
                <button class="tab-btn" data-category="item">📦 Item Spesial (5)</button>
            </div>

            <div class="search-box">
                <input type="text" id="catalogSearch" placeholder="Cari produk, senjata, atau rank..." aria-label="Cari produk">
                <span class="search-icon">🔍</span>
            </div>
        </section>

        <!-- PRODUCT CATALOG GRID (F1) -->
        <section class="catalog-section">
            <div class="product-grid" id="productGrid">
                <?php foreach ($PRODUCTS as $p): ?>
                    <?php
                        $tierInfo = $TIERS[$p['tier']] ?? $TIERS['common'];
                    ?>
                    <article class="product-card"
                        data-id="<?= htmlspecialchars($p['id']) ?>"
                        data-cat="<?= htmlspecialchars($p['cat']) ?>"
                        data-name="<?= htmlspecialchars($p['name']) ?>"
                        data-type="<?= htmlspecialchars($p['type']) ?>"
                        data-price="<?= htmlspecialchars($p['price']) ?>"
                        data-tier="<?= htmlspecialchars($p['tier']) ?>"
                        data-icon="<?= htmlspecialchars($p['icon']) ?>"
                        style="--card-tier-color: <?= $tierInfo['color'] ?>;">
                        
                        <div class="card-top">
                            <span class="tier-badge tier-<?= htmlspecialchars($p['tier']) ?>">
                                <?= htmlspecialchars($tierInfo['label']) ?>
                            </span>
                            <span class="card-cat-label"><?= htmlspecialchars($p['type']) ?></span>
                        </div>

                        <div class="card-icon"><?= $p['icon'] ?></div>
                        
                        <h3 class="product-name"><?= htmlspecialchars($p['name']) ?></h3>
                        <div class="product-type"><?= htmlspecialchars($p['type']) ?></div>

                        <p class="product-desc"><?= htmlspecialchars($p['desc']) ?></p>

                        <?php if (!empty($p['perks'])): ?>
                            <ul class="perks-list">
                                <?php foreach ($p['perks'] as $perk): ?>
                                    <li><?= htmlspecialchars($perk) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <div class="card-bottom">
                            <div class="product-price"><?= format_rupiah($p['price']) ?></div>
                            <button class="btn-add" type="button" aria-label="Tambah <?= htmlspecialchars($p['name']) ?> ke keranjang">
                                <span>+ Tambah</span>
                            </button>
                        </div>
                    </article>
                <?php endforeach; ?>

                <!-- Empty State bila hasil pencarian kosong -->
                <div class="empty-catalog" id="emptyCatalog" style="display: none;">
                    <div class="emoji">🔍</div>
                    <h3>Produk Tidak Ditemukan</h3>
                    <p style="color: var(--text-muted); font-size: 14px;">Coba gunakan kata kunci lain seperti "rank", "sword", "totem", atau bersihkan pencarian.</p>
                </div>
            </div>
        </section>

        <!-- CARA MEMBELI (F12) -->
        <section class="how-to-buy-section" id="cara-beli">
            <div class="section-header">
                <div class="section-title">
                    <span>📖 PANDUAN</span>
                    <div>Cara Membeli di Mechaboy Store</div>
                </div>
            </div>

            <div class="steps-grid">
                <div class="step-card">
                    <span class="step-number">01</span>
                    <h4>Pilih Produk</h4>
                    <p>Jelajahi pilihan Rank, Senjata Legend 7 Dosa, atau Item Spesial dan klik tombol <strong>"+ Tambah"</strong>.</p>
                </div>
                <div class="step-card">
                    <span class="step-number">02</span>
                    <h4>Isi Nickname & Bayar</h4>
                    <p>Buka keranjang belanja, masukkan <strong>Nickname Minecraft</strong> kamu dan tentukan metode pembayaran yang diinginkan.</p>
                </div>
                <div class="step-card">
                    <span class="step-number">03</span>
                    <h4>Buat Pesanan & Chat WA</h4>
                    <p>Klik tombol buat pesanan untuk mendapatkan <strong>Kode Pesanan Unik</strong>, lalu tekan tombol WhatsApp untuk konfirmasi ke admin.</p>
                </div>
                <div class="step-card">
                    <span class="step-number">04</span>
                    <h4>Item Masuk Server</h4>
                    <p>Setelah pembayaran diverifikasi oleh admin, rank atau item kamu langsung diaktifkan di server!</p>
                </div>
            </div>
        </section>

        <!-- CEK PESANAN SECTION -->
        <section class="track-section" id="cek-pesanan">
            <h3 style="font-family: var(--font-pixel); font-size: 20px; color: var(--mc-gold); margin-bottom: 6px;">
                🔎 Cek Status Pesanan
            </h3>
            <p style="color: var(--text-muted); font-size: 14px;">
                Sudah membuat pesanan? Masukkan Kode Pesanan (Contoh: <strong>MB-A1B2C3</strong>) atau Nickname Minecraft kamu untuk melacak statusnya.
            </p>

            <form class="track-form" id="trackOrderForm">
                <input type="text" id="trackOrderInput" placeholder="Masukkan Kode Pesanan atau Nickname..." required>
                <button type="submit" class="btn-ip" style="background: var(--mc-green); color: #000; border-color: #7edc55;">Cari Pesanan</button>
            </form>

            <div class="track-result" id="trackResultBox"></div>
        </section>

    </main>

    <!-- FOOTER (Section 10 & 16) -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h3><?= htmlspecialchars(STORE_NAME) ?></h3>
                    <p><?= htmlspecialchars(STORE_TAGLINE) ?></p>
                    <div style="margin-top: 12px; font-size: 12px;">
                        <div>🎮 IP: <strong><?= htmlspecialchars(SERVER_IP) ?></strong></div>
                        <div>📱 WA Admin: <strong>+<?= htmlspecialchars(ADMIN_WHATSAPP) ?></strong></div>
                    </div>
                </div>

                <div>
                    <h4 style="color: #fff; margin-bottom: 12px; font-size: 14px;">Navigasi Cepat</h4>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 8px; font-size: 13px;">
                        <li><a href="#katalog" style="color: var(--text-muted); text-decoration: none;">Katalog Toko</a></li>
                        <li><a href="#cara-beli" style="color: var(--text-muted); text-decoration: none;">Cara Pembelian</a></li>
                        <li><a href="#cek-pesanan" style="color: var(--text-muted); text-decoration: none;">Status Pesanan</a></li>
                        <li><a href="admin.php" style="color: var(--mc-gold); text-decoration: none;">🔐 Dashboard Pengelola</a></li>
                    </ul>
                </div>

                <div class="footer-disclaimer">
                    <strong style="color: #fff; display: block; margin-bottom: 4px;">Pemberitahuan Hak Cipta & Merek Dagang:</strong>
                    Toko ini bukan merupakan produk resmi Minecraft ataupun Mojang Studios. Kami tidak berafiliasi dengan, atau didukung oleh Mojang AB atau Microsoft. Seluruh aset Minecraft, merek dagang, dan nama adalah milik Mojang AB / Microsoft.
                </div>
            </div>

            <div class="footer-bottom">
                &copy; <?= date('Y') ?> <?= htmlspecialchars(STORE_NAME) ?>. Seluruh hak cipta dilindungi undang-undang.
            </div>
        </div>
    </footer>

    <!-- CART SLIDE-OUT DRAWER (F4, F5, F6) -->
    <div class="cart-overlay" id="cartOverlay"></div>
    <aside class="cart-drawer" id="cartDrawer" role="dialog" aria-labelledby="cartTitle">
        <div class="cart-header">
            <h3 id="cartTitle">🛒 Keranjang Belanja</h3>
            <button class="btn-close-cart" id="btnCloseCart" aria-label="Tutup Keranjang">✕</button>
        </div>

        <div class="cart-body">
            <!-- Empty state -->
            <div class="cart-empty" id="cartEmptyState">
                <div class="cart-empty-icon">🎒</div>
                <h4 style="font-family: var(--font-pixel); font-size: 18px; margin-bottom: 6px;">Keranjang Masih Kosong</h4>
                <p style="font-size: 13px;">Pilih item atau rank dari katalog untuk menambahkannya ke keranjang.</p>
            </div>

            <!-- List item keranjang -->
            <div id="cartItems"></div>
        </div>

        <div class="cart-footer" id="checkoutArea" style="display: none;">
            <div class="cart-total-row">
                <span class="cart-total-label">Total Pembayaran:</span>
                <span class="cart-total-value" id="cartTotalValue">Rp 0</span>
            </div>

            <form class="checkout-form" id="checkoutForm">
                <div class="form-group">
                    <label for="playerNickname">Nickname Minecraft</label>
                    <div class="form-input-avatar-wrap">
                        <img src="https://mc-heads.net/avatar/MHF_Steve/32" id="playerAvatarPreview" class="player-avatar-preview" alt="Skin Avatar">
                        <input type="text" id="playerNickname" name="nickname" placeholder="Contoh: Steve_123" required minlength="3" maxlength="16" autocomplete="off">
                    </div>
                    <span style="font-size: 11px; color: var(--text-dim);">Pastikan huruf besar-kecil nickname sesuai di server.</span>
                </div>

                <div class="form-group">
                    <label for="paymentMethod">Metode Pembayaran</label>
                    <select id="paymentMethod" name="payment_method" class="form-select" required>
                        <option value="">-- Pilih Cara Bayar --</option>
                        <?php foreach ($PAYMENT_METHODS as $key => $m): ?>
                            <option value="<?= htmlspecialchars($key) ?>">
                                <?= $m['icon'] ?> <?= htmlspecialchars($m['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="orderNote">Catatan / Pesan Tambahan (Opsional)</label>
                    <textarea id="orderNote" class="checkout-note" rows="2" placeholder="Contoh: Tolong kirim ke lobby survival"></textarea>
                </div>

                <div class="checkout-error" id="checkoutError"></div>

                <button type="submit" class="btn-checkout" id="btnCheckoutSubmit">
                    Buat Pesanan Sekarang
                </button>
            </form>
        </div>
    </aside>

    <!-- MODAL SUKSES PESANAN (F10) -->
    <div class="modal-overlay" id="orderModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>🎉 Pesanan Berhasil Dibuat!</h3>
                <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">Segera lakukan pembayaran untuk mengaktifkan pesananmu.</p>
            </div>
            <div class="modal-body">
                <div class="order-badge-box">
                    <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; font-weight: 700;">Kode Pesanan Anda</div>
                    <div class="order-code-text" id="orderCodeText">MB-000000</div>
                    <button type="button" class="btn-ip" id="btnCopyOrderCode" style="margin-top: 8px; font-size: 12px; padding: 4px 10px;">📋 Salin Kode</button>
                </div>

                <div class="order-details-summary" id="orderSummaryBox">
                    <!-- Ringkasan diisi via JS -->
                </div>

                <div class="modal-actions">
                    <a href="#" id="btnWhatsAppConfirm" target="_blank" class="btn-whatsapp-confirm">
                        <span>💬 Konfirmasi via WhatsApp</span>
                    </a>
                    <button type="button" class="btn-secondary-close" id="btnCloseModal">Tutup & Kembali ke Toko</button>
                </div>
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFIKASI -->
    <div class="toast-notice" id="toastNotice">Item berhasil ditambahkan!</div>

    <!-- JS Application -->
    <script src="assets/app.js"></script>
</body>
</html>
