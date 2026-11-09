/**
 * Mechaboy Store Server - Client Application Script
 * PRP Versi 1.0 (Kebutuhan F1 - F12)
 */

(function () {
    'use strict';

    // State Aplikasi
    const STORAGE_KEY = 'mechaboy_cart_v1';
    let cart = [];

    // Inisialisasi Keranjang dari LocalStorage (F5)
    try {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored) {
            cart = JSON.parse(stored);
            if (!Array.isArray(cart)) cart = [];
        }
    } catch (e) {
        console.warn('Gagal membaca localStorage:', e);
        cart = [];
    }

    // Elemen DOM
    const cartOverlay = document.getElementById('cartOverlay');
    const cartDrawer = document.getElementById('cartDrawer');
    const btnOpenCart = document.getElementById('btnOpenCart');
    const btnCloseCart = document.getElementById('btnCloseCart');
    const cartBadge = document.getElementById('cartBadge');
    const cartItemsContainer = document.getElementById('cartItems');
    const cartEmptyState = document.getElementById('cartEmptyState');
    const cartTotalValue = document.getElementById('cartTotalValue');
    const checkoutArea = document.getElementById('checkoutArea');
    const checkoutForm = document.getElementById('checkoutForm');
    const inputNickname = document.getElementById('playerNickname');
    const avatarPreview = document.getElementById('playerAvatarPreview');
    const checkoutError = document.getElementById('checkoutError');
    const btnCheckoutSubmit = document.getElementById('btnCheckoutSubmit');

    // Filter & Search
    const searchInput = document.getElementById('catalogSearch');
    const categoryTabs = document.querySelectorAll('.tab-btn');
    const productCards = document.querySelectorAll('.product-card');
    const emptyCatalog = document.getElementById('emptyCatalog');

    // Modal Sukses
    const orderModal = document.getElementById('orderModal');
    const orderCodeText = document.getElementById('orderCodeText');
    const orderSummaryBox = document.getElementById('orderSummaryBox');
    const btnWhatsAppConfirm = document.getElementById('btnWhatsAppConfirm');
    const btnCloseModal = document.getElementById('btnCloseModal');
    const btnCopyOrderCode = document.getElementById('btnCopyOrderCode');

    // Toast
    const toast = document.getElementById('toastNotice');

    // ==========================================================
    // UTILITIES
    // ==========================================================
    function formatRupiah(number) {
        return 'Rp ' + Number(number).toLocaleString('id-ID');
    }

    function showToast(message) {
        if (!toast) return;
        toast.textContent = message;
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
        }, 2800);
    }

    function saveCart() {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(cart));
        } catch (e) {
            console.error('Gagal menyimpan cart:', e);
        }
        renderCart();
    }

    // ==========================================================
    // CART OPERATIONS (F4, F5)
    // ==========================================================
    function addToCart(product) {
        const existingIndex = cart.findIndex(item => item.id === product.id);
        if (existingIndex > -1) {
            if (cart[existingIndex].qty < 20) {
                cart[existingIndex].qty += 1;
                showToast(`+1 ${product.name} ditambahkan!`);
            } else {
                showToast(`Maksimal 20 item per produk!`);
            }
        } else {
            cart.push({
                id: product.id,
                name: product.name,
                type: product.type || '',
                price: Number(product.price),
                icon: product.icon || '📦',
                tier: product.tier || 'common',
                qty: 1
            });
            showToast(`${product.name} masuk ke keranjang!`);
        }
        saveCart();
    }

    function updateCartQty(productId, delta) {
        const index = cart.findIndex(item => item.id === productId);
        if (index === -1) return;

        cart[index].qty += delta;
        if (cart[index].qty <= 0) {
            cart.splice(index, 1);
        } else if (cart[index].qty > 20) {
            cart[index].qty = 20;
        }
        saveCart();
    }

    function removeCartItem(productId) {
        cart = cart.filter(item => item.id !== productId);
        saveCart();
    }

    function getCartTotal() {
        return cart.reduce((total, item) => total + (item.price * item.qty), 0);
    }

    function getCartCount() {
        return cart.reduce((count, item) => count + item.qty, 0);
    }

    function renderCart() {
        const totalCount = getCartCount();
        const totalPrice = getCartTotal();

        // Update Badge
        if (cartBadge) {
            cartBadge.textContent = totalCount;
            cartBadge.style.display = totalCount > 0 ? 'inline-block' : 'none';
        }

        if (cartTotalValue) {
            cartTotalValue.textContent = formatRupiah(totalPrice);
        }

        // Render Item List
        if (!cartItemsContainer) return;

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '';
            if (cartEmptyState) cartEmptyState.style.display = 'block';
            if (checkoutArea) checkoutArea.style.display = 'none';
        } else {
            if (cartEmptyState) cartEmptyState.style.display = 'none';
            if (checkoutArea) checkoutArea.style.display = 'block';

            let html = '';
            cart.forEach(item => {
                const subtotal = item.price * item.qty;
                html += `
                    <div class="cart-item" data-id="${item.id}">
                        <div class="cart-item-icon">${item.icon}</div>
                        <div class="cart-item-info">
                            <div class="cart-item-name">${item.name}</div>
                            <div class="cart-item-price">${formatRupiah(item.price)}</div>
                        </div>
                        <div class="cart-item-qty">
                            <button class="qty-btn" onclick="window.MechaboyApp.updateQty('${item.id}', -1)" aria-label="Kurangi">−</button>
                            <span class="qty-count">${item.qty}</span>
                            <button class="qty-btn" onclick="window.MechaboyApp.updateQty('${item.id}', 1)" aria-label="Tambah">+</button>
                        </div>
                        <button class="btn-remove-item" onclick="window.MechaboyApp.removeItem('${item.id}')" title="Hapus Item">🗑️</button>
                    </div>
                `;
            });
            cartItemsContainer.innerHTML = html;
        }

        if (btnCheckoutSubmit) {
            btnCheckoutSubmit.textContent = `Buat Pesanan Sekarang (${formatRupiah(totalPrice)})`;
        }
    }

    // ==========================================================
    // DRAWER TOGGLE
    // ==========================================================
    function openCart() {
        if (cartOverlay) cartOverlay.classList.add('open');
        if (cartDrawer) cartDrawer.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeCart() {
        if (cartOverlay) cartOverlay.classList.remove('open');
        if (cartDrawer) cartDrawer.classList.remove('open');
        document.body.style.overflow = '';
    }

    if (btnOpenCart) btnOpenCart.addEventListener('click', openCart);
    if (btnCloseCart) btnCloseCart.addEventListener('click', closeCart);
    if (cartOverlay) cartOverlay.addEventListener('click', closeCart);

    // ==========================================================
    // AVATAR PREVIEW & NICKNAME VALIDATION (F6, F7)
    // ==========================================================
    if (inputNickname) {
        let timer = null;
        inputNickname.addEventListener('input', function (e) {
            const nick = e.target.value.trim();
            clearTimeout(timer);

            // Validasi regex: 3-16 chars [a-zA-Z0-9_.]
            const isValid = /^[a-zA-Z0-9_.]{3,16}$/.test(nick);

            if (isValid && avatarPreview) {
                timer = setTimeout(() => {
                    avatarPreview.src = `https://mc-heads.net/avatar/${encodeURIComponent(nick)}/32`;
                }, 400);
            } else if (avatarPreview) {
                avatarPreview.src = 'https://mc-heads.net/avatar/MHF_Steve/32';
            }
        });
    }

    // ==========================================================
    // CHECKOUT PROCESS (F6, F7, F8, F9, F10)
    // ==========================================================
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            if (checkoutError) {
                checkoutError.style.display = 'none';
                checkoutError.textContent = '';
            }

            const nickname = inputNickname ? inputNickname.value.trim() : '';
            const paymentSelect = document.getElementById('paymentMethod');
            const paymentMethod = paymentSelect ? paymentSelect.value : '';
            const noteInput = document.getElementById('orderNote');
            const note = noteInput ? noteInput.value.trim() : '';

            // Client Validation
            if (!nickname) {
                showError('Nickname Minecraft wajib diisi!');
                inputNickname.focus();
                return;
            }

            if (!/^[a-zA-Z0-9_.]{3,16}$/.test(nickname)) {
                showError('Nickname 3-16 karakter: huruf, angka, _ atau .');
                inputNickname.focus();
                return;
            }

            if (!paymentMethod) {
                showError('Pilih metode pembayaran.');
                if (paymentSelect) paymentSelect.focus();
                return;
            }

            if (cart.length === 0) {
                showError('Keranjang masih kosong.');
                return;
            }

            // Disable button loading
            if (btnCheckoutSubmit) {
                btnCheckoutSubmit.disabled = true;
                btnCheckoutSubmit.textContent = 'Memproses Pesanan...';
            }

            const payload = {
                nickname: nickname,
                payment_method: paymentMethod,
                note: note,
                items: cart.map(item => ({
                    id: item.id,
                    qty: item.qty
                }))
            };

            try {
                // Kirim ke endpoint backend checkout.php
                const res = await fetch('checkout.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();

                if (!res.ok || !data.success) {
                    throw new Error(data.message || 'Gagal memproses pesanan.');
                }

                // Berhasil!
                handleOrderSuccess(data.order);

            } catch (err) {
                console.warn('Backend request gagal, menggunakan fallback client generator:', err);
                // Fallback jika dibuka langsung via file:// atau tanpa PHP server
                fallbackProcessOrder(nickname, paymentMethod, note);
            } finally {
                if (btnCheckoutSubmit) {
                    btnCheckoutSubmit.disabled = false;
                    renderCart();
                }
            }
        });
    }

    function showError(msg) {
        if (checkoutError) {
            checkoutError.textContent = msg;
            checkoutError.style.display = 'block';
        } else {
            alert(msg);
        }
    }

    function fallbackProcessOrder(nickname, paymentMethod, note) {
        // Fallback jika server PHP offline
        const characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        let code = '';
        for (let i = 0; i < 6; i++) {
            code += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        const orderId = 'MB-' + code;
        const total = getCartTotal();

        const itemLines = cart.map(it => `• ${it.name} (x${it.qty}) - ${formatRupiah(it.price * it.qty)}`).join('\n');
        const waMsg = `Halo Admin Mechaboy Store! 🎮\n\n`
            + `Saya ingin konfirmasi pesanan baru:\n`
            + `━━━━━━━━━━━━━━━━━━━\n`
            + `🔖 *Kode Pesanan:* ${orderId}\n`
            + `👤 *Nickname MC:* ${nickname}\n`
            + `💳 *Metode Bayar:* ${paymentMethod.toUpperCase()}\n`
            + `📦 *Daftar Barang:*\n${itemLines}\n`
            + `💰 *Total Pembayaran:* ${formatRupiah(total)}\n`
            + (note ? `📝 *Catatan:* ${note}\n` : '')
            + `━━━━━━━━━━━━━━━━━━━\n`
            + `Mohon info pembayaran ya min. Terima kasih!`;

        const waUrl = `https://wa.me/6281234567890?text=${encodeURIComponent(waMsg)}`;

        handleOrderSuccess({
            order_id: orderId,
            nickname: nickname,
            payment_method: paymentMethod.toUpperCase(),
            total_formatted: formatRupiah(total),
            items: [...cart],
            whatsapp_url: waUrl
        });
    }

    function handleOrderSuccess(order) {
        // Kosongkan keranjang
        cart = [];
        saveCart();
        closeCart();

        // Tampilkan Modal
        if (orderCodeText) orderCodeText.textContent = order.order_id;
        if (btnWhatsAppConfirm) {
            btnWhatsAppConfirm.href = order.whatsapp_url;
        }

        if (orderSummaryBox) {
            let itemsHtml = order.items.map(it => `
                <div class="summary-line">
                    <span>${it.name} × ${it.qty}</span>
                    <span>${it.subtotal_formatted || formatRupiah(it.price * it.qty)}</span>
                </div>
            `).join('');

            orderSummaryBox.innerHTML = `
                <div class="summary-line">
                    <span style="color:var(--text-muted);">Player Nickname:</span>
                    <strong style="color:#fff;">${order.nickname}</strong>
                </div>
                <div class="summary-line">
                    <span style="color:var(--text-muted);">Metode Pembayaran:</span>
                    <span>${order.payment_method}</span>
                </div>
                <div style="margin: 10px 0; border-top: 1px dashed var(--border-color); padding-top: 10px;">
                    ${itemsHtml}
                </div>
                <div class="summary-line">
                    <span>Total Pembayaran:</span>
                    <span style="color:var(--mc-gold);">${order.total_formatted}</span>
                </div>
            `;
        }

        if (orderModal) orderModal.classList.add('open');
    }

    // Modal Close
    if (btnCloseModal) {
        btnCloseModal.addEventListener('click', function () {
            if (orderModal) orderModal.classList.remove('open');
        });
    }

    if (btnCopyOrderCode) {
        btnCopyOrderCode.addEventListener('click', function () {
            if (orderCodeText) {
                navigator.clipboard.writeText(orderCodeText.textContent.trim()).then(() => {
                    showToast('Kode Pesanan berhasil disalin!');
                });
            }
        });
    }

    // ==========================================================
    // FILTER & SEARCH CATALOG (F1, F2, F3)
    // ==========================================================
    let currentCategory = 'all';
    let currentSearchTerm = '';

    function filterCatalog() {
        let visibleCount = 0;

        productCards.forEach(card => {
            const cat = card.getAttribute('data-cat') || '';
            const name = (card.getAttribute('data-name') || '').toLowerCase();
            const type = (card.getAttribute('data-type') || '').toLowerCase();
            const tier = (card.getAttribute('data-tier') || '').toLowerCase();

            const matchCat = (currentCategory === 'all' || cat === currentCategory);
            const matchSearch = (!currentSearchTerm || 
                name.includes(currentSearchTerm) || 
                type.includes(currentSearchTerm) ||
                tier.includes(currentSearchTerm)
            );

            if (matchCat && matchSearch) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (emptyCatalog) {
            emptyCatalog.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    // Category Tabs click
    categoryTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            categoryTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentCategory = this.getAttribute('data-category') || 'all';
            filterCatalog();
        });
    });

    // Search Input
    if (searchInput) {
        searchInput.addEventListener('input', function (e) {
            currentSearchTerm = e.target.value.toLowerCase().trim();
            filterCatalog();
        });
    }

    // Add buttons on product cards
    document.querySelectorAll('.btn-add').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const card = this.closest('.product-card');
            if (!card) return;

            const product = {
                id: card.getAttribute('data-id'),
                name: card.getAttribute('data-name'),
                type: card.getAttribute('data-type'),
                price: Number(card.getAttribute('data-price')),
                icon: card.getAttribute('data-icon') || '📦',
                tier: card.getAttribute('data-tier') || 'common'
            };
            addToCart(product);
        });
    });

    // ==========================================================
    // COPY SERVER IP (F11)
    // ==========================================================
    window.copyServerIP = function (ip) {
        const textToCopy = ip || 'play.mechaboy.net';
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(textToCopy).then(() => {
                showToast(`IP Server ${textToCopy} tersalin!`);
            }).catch(() => {
                fallbackCopy(textToCopy);
            });
        } else {
            fallbackCopy(textToCopy);
        }
    };

    function fallbackCopy(text) {
        const temp = document.createElement('textarea');
        temp.value = text;
        document.body.appendChild(temp);
        temp.select();
        document.execCommand('copy');
        document.body.removeChild(temp);
        showToast(`IP Server ${text} tersalin!`);
    }

    // ==========================================================
    // CEK PESANAN / ORDER TRACKING
    // ==========================================================
    const trackOrderForm = document.getElementById('trackOrderForm');
    const trackOrderInput = document.getElementById('trackOrderInput');
    const trackResultBox = document.getElementById('trackResultBox');

    if (trackOrderForm) {
        trackOrderForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const query = trackOrderInput ? trackOrderInput.value.trim() : '';
            if (!query) return;

            if (trackResultBox) {
                trackResultBox.innerHTML = '<div style="color:var(--text-muted);">Mencari pesanan...</div>';
            }

            try {
                const res = await fetch(`check_order.php?q=${encodeURIComponent(query)}`);
                const data = await res.json();

                if (!res.ok || !data.success || data.orders.length === 0) {
                    trackResultBox.innerHTML = `
                        <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; padding: 14px; border-radius: var(--radius-sm); color: #fca5a5;">
                            Pesanan dengan ID atau Nickname "<strong>${query}</strong>" tidak ditemukan. Pastikan kode sudah benar (Contoh: MB-A1B2C3).
                        </div>
                    `;
                    return;
                }

                let html = '<div style="display:flex; flex-direction:column; gap:12px;">';
                data.orders.forEach(ord => {
                    const statusClass = `badge-${ord.status}`;
                    const statusName = ord.status.replace('_', ' ').toUpperCase();
                    html += `
                        <div style="background: #23271e; border: 1px solid var(--border-color); padding: 16px; border-radius: var(--radius-sm);">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <strong style="font-family:monospace; color:var(--mc-gold); font-size:16px;">${ord.order_id}</strong>
                                <span class="badge ${statusClass}">${statusName}</span>
                            </div>
                            <div style="font-size:13px; color:var(--text-muted); margin-bottom:6px;">
                                Nickname: <strong style="color:#fff;">${ord.nickname}</strong> | Waktu: ${ord.created_at}
                            </div>
                            <div style="font-size:13px; color:var(--text-muted);">
                                Total: <strong style="color:var(--mc-green);">${ord.total_formatted}</strong> (${typeof ord.payment_method === 'object' ? ord.payment_method.name : ord.payment_method})
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                trackResultBox.innerHTML = html;

            } catch (err) {
                trackResultBox.innerHTML = `
                    <div style="color: var(--text-muted); font-size: 13px;">
                        Fitur cek status memerlukan server PHP aktif. Silakan hubungi admin di WhatsApp untuk konfirmasi langsung!
                    </div>
                `;
            }
        });
    }

    // Expose to window for inline onclick handlers
    window.MechaboyApp = {
        addToCart: addToCart,
        updateQty: updateCartQty,
        removeItem: removeCartItem,
        openCart: openCart,
        closeCart: closeCart
    };

    // Render awal
    renderCart();
})();
