<?php
/**
 * Mechaboy Store Server - Data Katalog & Konfigurasi
 * PRP Versi 1.0
 */

// Konfigurasi Toko
define('STORE_NAME', 'Mechaboy Store Server');
define('STORE_TAGLINE', 'Toko Resmi Server Minecraft Mechaboy - Dapatkan Rank, Senjata Legend, & Item Eksklusif');
define('SERVER_IP', 'play.mechaboy.net');
define('SERVER_PORT_JAVA', '25565');
define('SERVER_PORT_BEDROCK', '19132');
define('ADMIN_WHATSAPP', '6281234567890'); // Format internasional tanpa simbol +
define('ADMIN_PIN', '1234'); // PIN untuk login panel admin sederhana

// Metode Pembayaran yang Didukung
$PAYMENT_METHODS = [
    'qris' => [
        'name' => 'QRIS (Semua E-Wallet & M-Banking)',
        'icon' => '📱',
        'desc' => 'DANA, GoPay, OVO, ShopeePay, BCA Mobile, Livin, dll.'
    ],
    'dana' => [
        'name' => 'DANA',
        'icon' => '💙',
        'desc' => 'Transfer instan via aplikasi DANA'
    ],
    'gopay' => [
        'name' => 'GoPay',
        'icon' => '🟢',
        'desc' => 'Transfer instan via Gojek / GoPay'
    ],
    'ovo' => [
        'name' => 'OVO',
        'icon' => '💜',
        'desc' => 'Transfer instan via aplikasi OVO'
    ],
    'shopeepay' => [
        'name' => 'ShopeePay',
        'icon' => '🧡',
        'desc' => 'Transfer instan via ShopeePay'
    ],
    'bca' => [
        'name' => 'Bank BCA',
        'icon' => '🏦',
        'desc' => 'Transfer Antar Bank / M-BCA'
    ],
    'mandiri' => [
        'name' => 'Bank Mandiri',
        'icon' => '💳',
        'desc' => 'Transfer Antar Bank / Livin by Mandiri'
    ]
];

// Tingkat Kelangkaan (Tiers)
$TIERS = [
    'common' => [
        'label' => 'Common',
        'color' => '#a0a0a0',
        'bg' => 'rgba(160, 160, 160, 0.15)'
    ],
    'uncommon' => [
        'label' => 'Uncommon',
        'color' => '#4caf50',
        'bg' => 'rgba(76, 175, 80, 0.15)'
    ],
    'rare' => [
        'label' => 'Rare',
        'color' => '#38bdf8',
        'bg' => 'rgba(56, 189, 248, 0.15)'
    ],
    'epic' => [
        'label' => 'Epic',
        'color' => '#c084fc',
        'bg' => 'rgba(192, 132, 252, 0.15)'
    ],
    'legendary' => [
        'label' => 'Legendary',
        'color' => '#fbbf24',
        'bg' => 'rgba(251, 191, 36, 0.2)'
    ],
    'mythic' => [
        'label' => 'Mythic',
        'color' => '#ef4444',
        'bg' => 'rgba(239, 68, 68, 0.2)'
    ]
];

// Katalog Produk Berdasarkan PRP Bagian 6
$PRODUCTS = [
    // 6.1 Rank
    'rank_laskar' => [
        'id' => 'rank_laskar',
        'cat' => 'rank',
        'name' => 'Rank Laskar',
        'type' => 'Rank Server',
        'price' => 15000,
        'tier' => 'common',
        'icon' => '🛡️',
        'desc' => 'Rank awal pejuang server. Akses kit Laskar harian, 2 slot /sethome, prefix [Laskar] abu perak, & command /workbench.',
        'perks' => [
            'Prefix [Laskar] eksklusif',
            '2 Set Home (/sethome)',
            'Kit Laskar setiap 24 jam',
            'Akses meja kerja portabel /craft'
        ]
    ],
    'rank_ksatria' => [
        'id' => 'rank_ksatria',
        'cat' => 'rank',
        'name' => 'Rank Ksatria',
        'type' => 'Rank Server',
        'price' => 35000,
        'tier' => 'uncommon',
        'icon' => '⚔️',
        'desc' => 'Rank ksatria tangguh. Akses kit Ksatria berzirah besi, 4 slot /sethome, prefix [Ksatria] hijau, serta command /feed saat lapar.',
        'perks' => [
            'Semua perk Rank Laskar',
            'Prefix [Ksatria] hijau terang',
            '4 Set Home (/sethome)',
            'Kit Senjata & Zirah Besi Pilihan',
            'Akses command /feed (pulihkan lapar)'
        ]
    ],
    'rank_adipati' => [
        'id' => 'rank_adipati',
        'cat' => 'rank',
        'name' => 'Rank Adipati',
        'type' => 'Rank Server',
        'price' => 60000,
        'tier' => 'rare',
        'icon' => '👑',
        'desc' => 'Rank bangsawan terhormat. Akses kit Adipati berzirah berlian, 7 slot /sethome, prefix [Adipati] biru, serta izin terbang (/fly) di area claim sendiri.',
        'perks' => [
            'Semua perk Rank Ksatria',
            'Prefix [Adipati] biru royal',
            '7 Set Home (/sethome)',
            'Terbang bebas (/fly) di dalam claim pribadi',
            'Akses Anvil portabel (/anvil) & /enderchest'
        ]
    ],
    'rank_mahapati' => [
        'id' => 'rank_mahapati',
        'cat' => 'rank',
        'name' => 'Rank Mahapati',
        'type' => 'Rank Server',
        'price' => 100000,
        'tier' => 'epic',
        'icon' => '💎',
        'desc' => 'Rank jenderal perang legendaris. Akses kit Mahapati Netherite, 10 slot /sethome, prefix [Mahapati] ungu menyala, /fly global di semua world, dan /heal.',
        'perks' => [
            'Semua perk Rank Adipati',
            'Prefix [Mahapati] ungu epik',
            '10 Set Home (/sethome)',
            'Mode Terbang Global (/fly)',
            'Pemulihan instan /heal & deteksi player /near'
        ]
    ],
    'rank_mandala' => [
        'id' => 'rank_mandala',
        'cat' => 'rank',
        'name' => 'Rank Mandala',
        'type' => 'Rank Server',
        'price' => 150000,
        'tier' => 'legendary',
        'icon' => '🌟',
        'desc' => 'Rank penguasa semesta Mechaboy. Membuka semua fasilitas tertinggi server, 15 slot home, prefix [Mandala] emas berkilau, efek glow aura, & kit dewa berkala.',
        'perks' => [
            'Semua perk Rank Mahapati',
            'Prefix [Mandala] emas bercahaya',
            '15 Set Home (/sethome)',
            'Efek Kosmetik Partikel & Glow Aura kustom',
            'Kit Dewa Berkala + Bypass cooldown teleport'
        ]
    ],
    'rank_mandala_plus' => [
        'id' => 'rank_mandala_plus',
        'cat' => 'rank',
        'name' => 'Rank Mandala++',
        'type' => 'Rank Server',
        'price' => 250000,
        'tier' => 'mythic',
        'icon' => '⚡',
        'desc' => 'Puncak kasta tertinggi tak tertandingi di server. Custom tag nama RGB bergerak, unlimited home, prioritas slot join saat server 100% penuh, dan status VIP Discord.',
        'perks' => [
            'Semua fasilitas seluruh tingkatan rank',
            'Prefix [Mandala++] RGB Animasi Pelangi',
            'Unlimited Slot /sethome tanpa batas',
            'Slot Prioritas (Bisa masuk saat server penuh)',
            'Role VIP Khusus di Discord Official Server'
        ]
    ],

    // 6.2 Senjata Legend (Tujuh Dosa)
    'sin_wrath' => [
        'id' => 'sin_wrath',
        'cat' => 'weapon',
        'name' => 'Sin of Wrath',
        'type' => 'Great Sword',
        'price' => 90000,
        'tier' => 'legendary',
        'icon' => '🔥',
        'desc' => 'Pedang raksasa amarah berkobar. Mengeluarkan gelombang tebasan api beruntun (Fire Wrath) dengan knockback dahsyat yang membakar lawan di sekitarnya.',
        'perks' => [
            'Damage Dasar: +18 Attack Damage',
            'Skill Aktif: Fire Wrath Explosion (AOE Fire)',
            'Knockback III & Sharpness VI Built-in'
        ]
    ],
    'sin_greed' => [
        'id' => 'sin_greed',
        'cat' => 'weapon',
        'name' => 'Sin of Greed',
        'type' => 'Scythe',
        'price' => 90000,
        'tier' => 'legendary',
        'icon' => '💰',
        'desc' => 'Sabit pemanen jiwa serakah. Setiap mob atau musuh yang ditumbangkan melipatgandakan koin server sebesar 2.5x dan memberikan lifesteal 15%.',
        'perks' => [
            'Damage Dasar: +16 Attack Damage',
            'Pasif: 2.5x Pengganda Koin/EXP Mob',
            '15% Lifesteal memulihkan HP tiap tebasan'
        ]
    ],
    'sin_envy' => [
        'id' => 'sin_envy',
        'cat' => 'weapon',
        'name' => 'Sin of Envy',
        'type' => 'Crossbow',
        'price' => 85000,
        'tier' => 'legendary',
        'icon' => '🎯',
        'desc' => 'Busur silang dengki beracun. Menembakkan 3 anak panah mistis sekaligus dengan efek Slowing III dan racun mematikan (Fatal Poison).',
        'perks' => [
            'Tembakan Multishot 3x otomatis',
            'Efek Status: Slowness III + Fatal Wither/Poison',
            'Kecepatan reload panah +50%'
        ]
    ],
    'sin_gluttony' => [
        'id' => 'sin_gluttony',
        'cat' => 'weapon',
        'name' => 'Sin of Gluttony',
        'type' => 'Dagger',
        'price' => 80000,
        'tier' => 'legendary',
        'icon' => '🥩',
        'desc' => 'Belati lapar darah berkecepatan tinggi. Serangan bertubi-tubi mengisi hunger bar seketika dan mengembalikan darah pengguna secepat kilat.',
        'perks' => [
            'Attack Speed: +2.5 Kecepatan Serang',
            'Pasif: Hunger Bar tidak pernah habis saat bertarung',
            'Regenerasi instan saat menyerang musuh beruntun'
        ]
    ],
    'sin_sloth' => [
        'id' => 'sin_sloth',
        'cat' => 'weapon',
        'name' => 'Sin of Sloth',
        'type' => 'Staff',
        'price' => 85000,
        'tier' => 'legendary',
        'icon' => '💤',
        'desc' => 'Tongkat sihir kelumpuhan waktu. Mengeluarkan kubah energi gravitasi (Time Freeze) radius 8 blok yang membekukan gerakan monster dan lawan.',
        'perks' => [
            'Skill Aktif: Freeze Field radius 8 blok selama 4 detik',
            'Memberikan debuff Mining Fatigue & Blindness pada target',
            'Meningkatkan Defense pengguna sebesar 25%'
        ]
    ],
    'sin_lust' => [
        'id' => 'sin_lust',
        'cat' => 'weapon',
        'name' => 'Sin of Lust',
        'type' => 'Hammer',
        'price' => 90000,
        'tier' => 'legendary',
        'icon' => '💖',
        'desc' => 'Palu pemikat petir kosmis. Hantaman kuat ke tanah menciptakan badai petir berantai (Chain Lightning) yang menyengat musuh dan melumpuhkannya 2 detik.',
        'perks' => [
            'Damage Hantaman: +20 Ground Slam Damage',
            'Skill: Petir Berantai (Chain Lightning ke 5 musuh)',
            'Stun lawan selama 2 detik'
        ]
    ],
    'sin_pride' => [
        'id' => 'sin_pride',
        'cat' => 'weapon',
        'name' => 'Sin of Pride',
        'type' => 'Sword',
        'price' => 95000,
        'tier' => 'legendary',
        'icon' => '🦁',
        'desc' => 'Pedang keagungan raja tak terkalahkan. Menghasilkan True Damage yang berlipat ganda semakin tinggi persentase sisa darah pengguna saat bertarung.',
        'perks' => [
            'Damage Dasar: +22 Attack Damage',
            'Pasif: +40% Bonus True Damage saat HP di atas 80%',
            'Aura Raja: Memberikan efek Weakness pada musuh sekitar'
        ]
    ],

    // 6.3 Item Spesial
    'item_totem_null' => [
        'id' => 'item_totem_null',
        'cat' => 'item',
        'name' => 'Totem of Null',
        'type' => 'Item Spesial',
        'price' => 40000,
        'tier' => 'rare',
        'icon' => '🧿',
        'desc' => 'Totem pelindung kehampaan. Jika kamu jatuh ke dalam Void (The End) atau jurang kematian, totem ini pecah dan menteleportasi kamu kembali ke spawn dengan seluruh inventory utuh.',
        'perks' => [
            'Penyelamat kematian jatuh ke Void',
            'Inventory 100% aman terselamatkan',
            'Teleportasi darurat otomatis ke /spawn'
        ]
    ],
    'item_darkness_armor' => [
        'id' => 'item_darkness_armor',
        'cat' => 'item',
        'name' => 'Darkness Armor Set',
        'type' => 'Armor Set',
        'price' => 120000,
        'tier' => 'epic',
        'icon' => '🖤',
        'desc' => '1 Set Komplit Zirah Kegelapan (Helm, Chestplate, Leggings, Boots). Kebal efek racun/debuff, resistensi ledakan 80%, serta Night Vision tanpa batas.',
        'perks' => [
            '1 Set Lengkap Netherite Gelap Bertuah',
            'Resistensi Ledakan (Blast Protection V) 80%',
            'Permanent Night Vision & Kebal Racun Wither'
        ]
    ],
    'item_orbital_cannon' => [
        'id' => 'item_orbital_cannon',
        'cat' => 'item',
        'name' => 'Orbital Strike Cannon',
        'type' => 'Alat Tempur',
        'price' => 200000,
        'tier' => 'mythic',
        'icon' => '🛰️',
        'desc' => 'Alat pemanggil laser satelit antariksa. Klik kanan untuk membidik koordinat sasaran, pancaran sinar laser raksasa akan jatuh dari langit dengan ledakan spektakuler.',
        'perks' => [
            'Visual Laser Beam Angkasa super megah',
            'Daya hancur masif target (Area of Effect 15 blok)',
            '3x Penggunaan per hari dengan cooldown teratur'
        ]
    ],
    'item_phantom_elytra' => [
        'id' => 'item_phantom_elytra',
        'cat' => 'item',
        'name' => 'Phantom Elytra',
        'type' => 'Sayap Legend',
        'price' => 55000,
        'tier' => 'legendary',
        'icon' => '🪽',
        'desc' => 'Sayap bayangan abadi (Unbreakable) yang tidak akan pernah rusak. Kecepatan meluncur 2x lipat elytra normal dan meninggalkan jejak partikel asap bayangan mistis.',
        'perks' => [
            'Sifat Abadi: Unbreakable (Tidak bisa pecah)',
            'Kecepatan luncur terbang 200%',
            'Efek Partikel Mistis Phantom Smoke Trail'
        ]
    ],
    'item_crate_key' => [
        'id' => 'item_crate_key',
        'cat' => 'item',
        'name' => 'Legend Crate Key x5',
        'type' => 'Kunci Gacha',
        'price' => 30000,
        'tier' => 'rare',
        'icon' => '🗝️',
        'desc' => 'Bundel berisi 5 Kunci Crate Legendaris untuk membuka Peti Harta Legenda di Lobby Server. Berpeluang memenangkan Rank Mandala, Senjata Langka, atau Uang Jutaan Ingame.',
        'perks' => [
            '5x Kesempatan Buka Peti Legenda di Spawn',
            'Peluang memenangkan Senjata Dosa & Senjata Boss',
            '100% Dijamin mendapat item tier Rare atau lebih tinggi'
        ]
    ]
];

// Fungsi Pembantu
function format_rupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}

function get_product($id) {
    global $PRODUCTS;
    return $PRODUCTS[$id] ?? null;
}

function validate_nickname($nick) {
    // F7: Validasi nickname (3-16 karakter: huruf, angka, _, .)
    return preg_match('/^[a-zA-Z0-9_.]{3,16}$/', $nick);
}

function generate_order_id() {
    // F9: Format MB-XXXXXX
    $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
    $code = '';
    for ($i = 0; $i < 6; $i++) {
        $code .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return 'MB-' . $code;
}
