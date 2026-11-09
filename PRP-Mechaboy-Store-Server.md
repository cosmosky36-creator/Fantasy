# PRP: Website Toko Mechaboy Store Server

Dokumen perencanaan untuk website toko server Minecraft. Versi 1.0.

---

## 1. Ringkasan

**Nama produk:** Mechaboy Store Server
**Jenis:** Website toko online untuk server Minecraft
**Tujuan:** Pemain bisa membeli rank, senjata legend, dan item spesial dengan alur yang singkat, jelas, dan mudah dimengerti.
**Tema:** Sederhana, bernuansa blok Minecraft (hijau rumput, emas, batu gelap), tanpa elemen yang membingungkan.

## 2. Latar Belakang dan Masalah

- Server butuh sumber pendapatan untuk biaya hosting dan pengembangan.
- Penjualan lewat chat sulit dilacak dan rawan salah catat.
- Pemain butuh satu tempat untuk melihat daftar produk, harga, dan manfaat dengan jelas.

## 3. Sasaran dan Ukuran Keberhasilan

| Sasaran | Ukuran |
|---|---|
| Pemain paham isi toko dengan cepat | Semua produk terlihat di satu halaman, bisa difilter dan dicari |
| Proses beli singkat | Dari memilih produk sampai pesanan terbuat maksimal 4 langkah |
| Pesanan tercatat rapi | Setiap pesanan punya kode unik dan tersimpan |
| Mudah dikelola admin | Harga dan produk diubah di satu tempat tanpa menyentuh tampilan |
| Nyaman di HP | Tampilan responsif dan semua tombol mudah ditekan |

## 4. Pengguna

**Pemain (pembeli):** Anak muda hingga dewasa, sebagian besar membuka lewat HP, ingin membeli cepat tanpa membuat akun.
**Admin server:** Mengelola produk, memeriksa pesanan, mengonfirmasi pembayaran, dan memberikan item di server.

## 5. Ruang Lingkup

**Termasuk (versi 1):**
- Katalog produk dalam 3 kategori
- Pencarian dan filter kategori
- Keranjang belanja
- Checkout dengan nickname Minecraft dan metode bayar
- Pencatatan pesanan
- Konfirmasi pembayaran manual lewat WhatsApp
- Tombol salin IP server

**Tidak termasuk (versi 1):**
- Akun pengguna dan login
- Pembayaran otomatis (payment gateway)
- Pengiriman item otomatis ke server
- Halaman admin

## 6. Isi Toko (Katalog)

Harga di bawah hanya usulan awal dan bisa diganti kapan saja.

### 6.1 Rank

| Rank | Tingkat | Harga |
|---|---|---|
| Laskar | Common | Rp 15.000 |
| Ksatria | Uncommon | Rp 35.000 |
| Adipati | Rare | Rp 60.000 |
| Mahapati | Epic | Rp 100.000 |
| Mandala | Legendary | Rp 150.000 |
| Mandala++ | Mythic | Rp 250.000 |

Setiap rank punya prefix, kit, jumlah home, dan perk lain yang makin banyak di tingkat atas.

### 6.2 Senjata Legend (Tujuh Dosa)

| Senjata | Jenis | Harga |
|---|---|---|
| Sin of Wrath | Great Sword | Rp 90.000 |
| Sin of Greed | Scythe | Rp 90.000 |
| Sin of Envy | Crossbow | Rp 85.000 |
| Sin of Gluttony | Dagger | Rp 80.000 |
| Sin of Sloth | Staff | Rp 85.000 |
| Sin of Lust | Hammer | Rp 90.000 |
| Sin of Pride | Sword | Rp 95.000 |

### 6.3 Item Spesial

| Item | Harga |
|---|---|
| Totem of Null | Rp 40.000 |
| Darkness Armor | Rp 120.000 |
| Orbital Strike Cannon | Rp 200.000 |
| Phantom Elytra | Rp 55.000 |
| Legend Crate Key x5 | Rp 30.000 |

## 7. Kebutuhan Fungsional

| Kode | Kebutuhan | Prioritas |
|---|---|---|
| F1 | Menampilkan produk per kategori dengan nama, deskripsi, tingkat kelangkaan, dan harga | Wajib |
| F2 | Filter kategori (Semua, Rank, Senjata Legend, Item Spesial) | Wajib |
| F3 | Pencarian produk berdasarkan nama atau jenis | Wajib |
| F4 | Menambah, mengurangi, dan menghapus produk di keranjang | Wajib |
| F5 | Keranjang tersimpan walau halaman ditutup | Wajib |
| F6 | Form checkout: nickname Minecraft dan metode pembayaran | Wajib |
| F7 | Validasi nickname (3-16 karakter: huruf, angka, `_`, `.`) | Wajib |
| F8 | Server menghitung ulang harga sendiri, bukan percaya harga dari browser | Wajib |
| F9 | Pesanan mendapat kode unik (contoh: MB-A1B2C3) dan disimpan | Wajib |
| F10 | Setelah pesanan jadi, tampil ringkasan dan tombol WhatsApp berisi detail pesanan | Wajib |
| F11 | Tombol salin IP server | Penting |
| F12 | Bagian "Cara Membeli" | Penting |

## 8. Kebutuhan Non-Fungsional

- **Kemudahan:** Bahasa Indonesia sederhana, tombol menyebut aksinya dengan jelas (Tambah, Buat Pesanan).
- **Responsif:** Nyaman dari layar HP sampai desktop.
- **Aksesibilitas:** Fokus keyboard terlihat, kontras warna cukup, animasi dikurangi bila pengguna memintanya.
- **Kecepatan:** Tanpa library besar, tanpa gambar berat.
- **Keamanan dasar:** Validasi di server, output di halaman di-escape, batas jumlah per item, kode pesanan acak.
- **Perawatan:** Semua data toko ada di satu bagian yang mudah diedit.

## 9. Alur Pengguna

```
Buka toko
   |
   v
Lihat / cari / filter produk
   |
   v
Tekan "Tambah"  -->  Keranjang terisi
   |
   v
Buka keranjang --> isi nickname + pilih metode bayar
   |
   v
Tekan "Buat Pesanan"
   |            \
   |             \-- gagal validasi --> pesan kesalahan jelas, isi form diperbaiki
   v
Pesanan dibuat + kode pesanan muncul
   |
   v
Kirim bukti bayar via WhatsApp
   |
   v
Admin konfirmasi --> admin memberikan item di server
```

## 10. Struktur Halaman

1. **Header:** logo dan nama toko, menu (Rank, Senjata, Item, Cara Beli), tombol Keranjang dengan jumlah barang.
2. **Hero:** nama toko, kalimat singkat, tombol salin IP server.
3. **Alat bantu:** tab kategori dan kolom pencarian.
4. **Bagian Rank:** kartu 6 rank.
5. **Bagian Senjata Legend:** kartu 7 senjata.
6. **Bagian Item Spesial:** kartu item.
7. **Cara Membeli:** 4 langkah.
8. **Footer:** hak cipta dan catatan bahwa toko bukan produk resmi Mojang/Microsoft.
9. **Panel Keranjang (geser dari kanan):** daftar barang, total, form checkout.
10. **Dialog Pesanan Berhasil:** kode pesanan, ringkasan, tombol WhatsApp.

**Isi kartu produk:** ikon, tingkat kelangkaan, nama, jenis senjata (bila ada), deskripsi singkat, harga, tombol Tambah.

## 11. Arah Desain

| Elemen | Pilihan |
|---|---|
| Warna dasar | Batu gelap `#1c1f1a`, panel `#272b24` |
| Warna utama | Hijau rumput `#5fae3c` |
| Warna harga dan aksen | Emas `#e6b83a` |
| Warna kelangkaan | Common abu, Uncommon hijau, Rare biru, Epic ungu, Legendary emas, Mythic merah |
| Huruf judul | Pixelify Sans (gaya piksel) |
| Huruf isi | Nunito (mudah dibaca) |
| Gaya | Sudut kecil, garis tegas, bayangan tipis, mirip blok |
| Mode | Gelap dan terang mengikuti pengaturan perangkat |

Prinsip: satu hal yang paling menonjol adalah kartu produk berwarna sesuai kelangkaan, sisanya dibuat tenang.

## 12. Rancangan Teknis

**Teknologi:** PHP (sisi server), HTML, CSS, JavaScript tanpa framework.
**Penyimpanan:** `localStorage` untuk keranjang di browser, file `orders.json` untuk pesanan.

**Struktur berkas:**

Opsi A, satu berkas (versi ringkas):
```
index.php   -> data produk + proses checkout + HTML + CSS + JS
orders.json -> dibuat otomatis
```

Opsi B, dipisah (lebih rapi untuk dikembangkan):
```
index.php        -> halaman toko
data.php         -> pengaturan dan produk
checkout.php     -> proses pesanan
assets/style.css -> tampilan
assets/app.js    -> keranjang, filter, checkout
orders.json      -> dibuat otomatis
```

**Model data produk:**

| Kolom | Arti |
|---|---|
| id | Kode unik produk |
| cat | rank / weapon / item |
| name | Nama produk |
| type | Jenis senjata (opsional) |
| price | Harga dalam rupiah |
| tier | common sampai mythic |
| icon | Ikon emoji |
| desc | Deskripsi singkat |

**Model data pesanan:** order_id, waktu, nickname, metode bayar, daftar item (id, nama, jumlah, subtotal), total, status (awal: menunggu pembayaran).

**Pengaturan toko:** nama, tagline, IP server, nomor WhatsApp admin, daftar metode pembayaran.

## 13. Aturan Validasi

| Data | Aturan | Pesan bila salah |
|---|---|---|
| Nickname | 3-16 karakter, huruf/angka/`_`/`.` | "Nickname 3-16 karakter: huruf, angka, _ atau ." |
| Metode bayar | Harus salah satu dari daftar | "Pilih metode pembayaran." |
| Keranjang | Minimal 1 item | "Keranjang masih kosong." |
| Jumlah per item | 1-20 | Item di luar batas diabaikan |
| Id produk | Harus ada di katalog | Item tidak dikenal diabaikan |

## 14. Kriteria Penerimaan

- [ ] Semua 6 rank, 7 senjata legend, dan item spesial tampil dengan harga benar.
- [ ] Nama toko "Mechaboy Store Server" tampil di header, hero, dan judul tab.
- [ ] Filter dan pencarian bekerja, dan muncul pesan bila tidak ada hasil.
- [ ] Keranjang bisa ditambah, dikurangi, dan tetap ada setelah halaman dimuat ulang.
- [ ] Checkout menolak nickname atau metode bayar yang tidak valid dengan pesan jelas.
- [ ] Total di server selalu dihitung dari harga katalog.
- [ ] Pesanan berhasil muncul di `orders.json` dengan kode unik.
- [ ] Tombol WhatsApp membuka chat admin dengan detail pesanan terisi.
- [ ] Tampilan rapi di layar HP (lebar 360 px) dan desktop.
- [ ] Seluruh fitur bisa dipakai dengan keyboard.

## 15. Tahapan Pengerjaan

| Tahap | Pekerjaan |
|---|---|
| 1. Persiapan | Konfirmasi katalog, harga, IP server, nomor WhatsApp, metode bayar |
| 2. Desain | Tetapkan warna, huruf, dan tata letak halaman |
| 3. Pembangunan | Katalog, filter, keranjang, checkout, pencatatan pesanan |
| 4. Pengujian | Cek kriteria penerimaan di HP dan desktop |
| 5. Peluncuran | Upload ke hosting, lindungi `orders.json`, uji satu pesanan nyata |
| 6. Pengembangan lanjut | Lihat bagian 17 |

## 16. Risiko dan Penanganan

| Risiko | Penanganan |
|---|---|
| `orders.json` bisa dibuka publik | Blokir akses lewat pengaturan server atau simpan di luar folder publik |
| Pesanan palsu atau spam | Batasi jumlah pesanan per waktu, verifikasi lewat bukti bayar |
| Salah memberikan item | Kode pesanan dan nickname selalu dicatat, admin mencocokkan sebelum memberi |
| Hosting tidak mendukung tulis file | Pindah ke database atau kirim pesanan ke email/WhatsApp |
| Harga di browser dimanipulasi | Harga selalu dihitung ulang di server |
| Pelanggaran merek dagang | Cantumkan bahwa toko bukan produk resmi Mojang/Microsoft |

## 17. Pengembangan Berikutnya

1. Halaman admin untuk melihat pesanan dan mengubah status (menunggu, lunas, selesai).
2. Pembayaran otomatis dengan payment gateway (QRIS dan e-wallet).
3. Pengiriman item otomatis ke server lewat plugin atau RCON.
4. Kode promo dan diskon.
5. Riwayat pembelian per nickname.
6. Paket bundel (misalnya rank + senjata).
7. Pengumuman event dan halaman peraturan server.

## 18. Hal yang Perlu Anda Putuskan

- Harga final tiap produk.
- Perk lengkap tiap rank dan efek tiap senjata.
- IP server dan nomor WhatsApp admin.
- Metode pembayaran yang benar-benar dipakai.
- Apakah memakai satu berkas (Opsi A) atau dipisah (Opsi B).
- Daftar item tambahan selain yang sudah ada.
