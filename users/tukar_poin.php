<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Hadiah – SolusiSampah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar_user.css">
    <link rel="stylesheet" href="../css/tukar_poin.css">
    <link rel="stylesheet" href="../css/footer_user.css">
</head>
<body>

<?php include '../includes/navbar_user.php'; ?>

<main class="katalog-main">

    <section class="katalog-hero">
        <div class="katalog-hero-inner">
            <div class="katalog-hero-left">
                <p class="katalog-hero-label">Saldo Poin Kamu</p>
                <div class="katalog-hero-poin-row">
                    <span class="katalog-hero-star">⭐</span>
                    <!-- PHP: echo number_format($saldo_poin) -->
                    <span class="katalog-hero-poin-num">15.000 Poin</span>
                    <!-- PHP: echo $level_nasabah -->
                    <span class="katalog-hero-level">Level Gold</span>
                </div>
            </div>
            <div class="katalog-hero-right">
                <a href="riwayat-penukaran.php" class="katalog-hero-history-btn">
                    Lihat Riwayat Penukaran
                </a>
            </div>
        </div>
    </section>

    <!-- ================================================================
         FILTER BAR
         ================================================================ -->
    <div class="katalog-filter-bar">
        <div class="katalog-filter-inner">
            <!-- Category pills -->
            <div class="katalog-category-pills">
                <span class="katalog-cat-label">Kategori:</span>
                <!-- PHP: loop kategori hadiah -->
                <button class="katalog-pill active">Semua</button>
                <button class="katalog-pill">Voucher Digital</button>
                <button class="katalog-pill">Produk Sembako</button>
                <button class="katalog-pill">Merchandise</button>
                <button class="katalog-pill">Layanan</button>
            </div>

            <!-- Search + Sort -->
            <div class="katalog-filter-right">
                <div class="katalog-search-wrap">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="8" stroke="#9CA3AF" stroke-width="2"/><path d="M21 21l-4.35-4.35" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"/></svg>
                    <input type="text" class="katalog-search-input" placeholder="Cari hadiah...">
                </div>
                <div class="katalog-sort-wrap">
                    <select class="katalog-sort-select">
                        <option>Poin Terendah</option>
                        <option>Poin Tertinggi</option>
                        <option>Terpopuler</option>
                        <option>Terbaru</option>
                    </select>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" class="katalog-sort-chevron"><path d="M6 9l6 6 6-6" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- ================================================================
         GRID HADIAH
         ================================================================ -->
    <div class="katalog-container">

        <h2 class="katalog-section-title">Semua Hadiah</h2>

        <div class="katalog-grid">

            <!-- ── CARD 1: Voucher DANA (terpopuler, mampu ditukar) ── -->
            <div class="katalog-card">
                <div class="katalog-card-img-wrap">
                    <!-- PHP: <img src="uploads/<?= $row['gambar'] ?>" class="katalog-card-img" alt="<?= $row['nama'] ?>"> -->
                    <div class="katalog-card-img-placeholder dana">
                        <!-- Logo DANA visual placeholder -->
                        <div class="katalog-img-dana-logo">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="white" fill-opacity="0.25"/><path d="M8 12h8M12 8v8" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>
                            <span>DANA</span>
                        </div>
                    </div>
                    <span class="katalog-card-badge popular">TERPOPULER</span>
                </div>
                <div class="katalog-card-body">
                    <!-- PHP: echo $row['kategori'] -->
                    <p class="katalog-card-kategori">Voucher Digital</p>
                    <!-- PHP: echo $row['nama_hadiah'] -->
                    <h3 class="katalog-card-name">Voucher Dana Rp. 10.000</h3>
                    <!-- PHP: echo $row['deskripsi'] -->
                    <p class="katalog-card-desc">Transfer langsung ke dompet DANA kamu.</p>
                    <div class="katalog-card-poin-row">
                        <div class="katalog-card-poin">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <!-- PHP: echo number_format($row['harga_poin']) -->
                            <span class="katalog-card-poin-num">1.000</span>
                            <span class="katalog-card-poin-label">poin</span>
                        </div>
                    </div>
                    <!-- PHP: echo $row['stok'] > 0 ? 'Stok Tersedia' : 'Stok Habis' -->
                    <p class="katalog-card-stok tersedia">Stok Tersedia</p>
                </div>
                <div class="katalog-card-footer">
                    <!-- PHP: if ($saldo >= $row['harga_poin'] && $row['stok'] > 0): -->
                    <button class="katalog-btn-tukar">TUKAR SEKARANG</button>
                    <!-- PHP: endif; -->
                </div>
            </div>

            <!-- ── CARD 2: Pulsa Rp.10.000 (mampu ditukar) ── -->
            <div class="katalog-card">
                <div class="katalog-card-img-wrap">
                    <div class="katalog-card-img-placeholder pulsa">
                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none"><rect x="5" y="2" width="14" height="20" rx="3" stroke="white" stroke-width="2"/><path d="M9 18h6" stroke="white" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="9" r="2.5" fill="white"/></svg>
                    </div>
                </div>
                <div class="katalog-card-body">
                    <p class="katalog-card-kategori">Voucher Digital</p>
                    <h3 class="katalog-card-name">Pulsa Rp. 10.000</h3>
                    <p class="katalog-card-desc">Semua operator (Telkomsel, XL, Indosat)</p>
                    <div class="katalog-card-poin-row">
                        <div class="katalog-card-poin">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span class="katalog-card-poin-num">1.000</span>
                            <span class="katalog-card-poin-label">poin</span>
                        </div>
                    </div>
                    <p class="katalog-card-stok tersedia">Stok Tersedia</p>
                </div>
                <div class="katalog-card-footer">
                    <button class="katalog-btn-tukar">TUKAR SEKARANG</button>
                </div>
            </div>

            <!-- ── CARD 3: Token Listrik 20kWh (mampu ditukar) ── -->
            <div class="katalog-card">
                <div class="katalog-card-img-wrap">
                    <div class="katalog-card-img-placeholder token">
                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>
                <div class="katalog-card-body">
                    <p class="katalog-card-kategori">Layanan</p>
                    <h3 class="katalog-card-name">Token Listrik 20kWh</h3>
                    <p class="katalog-card-desc">Token PLN prabayar semua meteran.</p>
                    <div class="katalog-card-poin-row">
                        <div class="katalog-card-poin">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span class="katalog-card-poin-num">5.000</span>
                            <span class="katalog-card-poin-label">poin</span>
                        </div>
                    </div>
                    <p class="katalog-card-stok tersedia">Stok Tersedia</p>
                </div>
                <div class="katalog-card-footer">
                    <button class="katalog-btn-tukar">TUKAR SEKARANG</button>
                </div>
            </div>

            <!-- ── CARD 4: Shopee Voucher (mampu ditukar) ── -->
            <div class="katalog-card">
                <div class="katalog-card-img-wrap">
                    <div class="katalog-card-img-placeholder shopee">
                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><line x1="3" y1="6" x2="21" y2="6" stroke="white" stroke-width="2" stroke-linecap="round"/><path d="M16 10a4 4 0 01-8 0" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>
                <div class="katalog-card-body">
                    <p class="katalog-card-kategori">Voucher Digital</p>
                    <h3 class="katalog-card-name">Shopee Rp. 50.000</h3>
                    <p class="katalog-card-desc">Voucher belanja online Shopee.</p>
                    <div class="katalog-card-poin-row">
                        <div class="katalog-card-poin">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span class="katalog-card-poin-num">5.000</span>
                            <span class="katalog-card-poin-label">poin</span>
                        </div>
                    </div>
                    <p class="katalog-card-stok tersedia">Stok Tersedia</p>
                </div>
                <div class="katalog-card-footer">
                    <button class="katalog-btn-tukar">TUKAR SEKARANG</button>
                </div>
            </div>

            <!-- ── CARD 5: Paket Sembako (STOK HABIS) ── -->
            <div class="katalog-card katalog-card-disabled">
                <div class="katalog-card-img-wrap">
                    <div class="katalog-card-img-placeholder sembako">
                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none"><path d="M3 9h18v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 9l2.45-4.9A2 2 0 017.24 3h9.52a2 2 0 011.8 1.1L21 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 3v6" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <span class="katalog-card-badge stok-habis">STOK HABIS</span>
                </div>
                <div class="katalog-card-body">
                    <p class="katalog-card-kategori">Produk Sembako</p>
                    <h3 class="katalog-card-name">Paket Sembako 5 Kg</h3>
                    <p class="katalog-card-desc">Beras, gula, minyak goreng pilihan.</p>
                    <div class="katalog-card-poin-row">
                        <div class="katalog-card-poin">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="#9CA3AF"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span class="katalog-card-poin-num">8.000</span>
                            <span class="katalog-card-poin-label">poin</span>
                        </div>
                    </div>
                    <p class="katalog-card-stok habis">Stok Habis</p>
                </div>
                <div class="katalog-card-footer">
                    <button class="katalog-btn-tukar disabled" disabled>STOK HABIS</button>
                </div>
            </div>

            <!-- ── CARD 6: E-Wallet GoPay (POIN TIDAK CUKUP) ── -->
            <div class="katalog-card katalog-card-disabled">
                <div class="katalog-card-img-wrap">
                    <div class="katalog-card-img-placeholder gopay">
                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none"><rect x="2" y="5" width="20" height="14" rx="2" stroke="white" stroke-width="2"/><path d="M2 10h20" stroke="white" stroke-width="2" stroke-linecap="round"/><circle cx="6" cy="15" r="1" fill="white"/><path d="M10 15h4" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                </div>
                <div class="katalog-card-body">
                    <p class="katalog-card-kategori">Voucher Digital</p>
                    <h3 class="katalog-card-name">GoPay Rp. 100.000</h3>
                    <p class="katalog-card-desc">Saldo GoPay langsung ke akunmu.</p>
                    <div class="katalog-card-poin-row">
                        <div class="katalog-card-poin">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="#9CA3AF"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span class="katalog-card-poin-num">20.000</span>
                            <span class="katalog-card-poin-label">poin</span>
                        </div>
                    </div>
                    <p class="katalog-card-stok kurang">Poin Tidak Cukup</p>
                </div>
                <div class="katalog-card-footer">
                    <button class="katalog-btn-tukar disabled" disabled>POIN TIDAK CUKUP</button>
                </div>
            </div>

            <!-- ── CARD 7: OVO (placeholder kosong) ── -->
            <div class="katalog-card">
                <div class="katalog-card-img-wrap">
                    <div class="katalog-card-img-placeholder ovo">
                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="white" stroke-width="2"/><path d="M8 12a4 4 0 108 0 4 4 0 00-8 0z" stroke="white" stroke-width="2"/></svg>
                    </div>
                </div>
                <div class="katalog-card-body">
                    <p class="katalog-card-kategori">Voucher Digital</p>
                    <h3 class="katalog-card-name">OVO Cash Rp. 25.000</h3>
                    <p class="katalog-card-desc">Top up OVO langsung ke akunmu.</p>
                    <div class="katalog-card-poin-row">
                        <div class="katalog-card-poin">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span class="katalog-card-poin-num">2.500</span>
                            <span class="katalog-card-poin-label">poin</span>
                        </div>
                    </div>
                    <p class="katalog-card-stok tersedia">Stok Tersedia</p>
                </div>
                <div class="katalog-card-footer">
                    <button class="katalog-btn-tukar">TUKAR SEKARANG</button>
                </div>
            </div>

            <!-- ── CARD 8: Merchandise Tote Bag ── -->
            <div class="katalog-card">
                <div class="katalog-card-img-wrap">
                    <div class="katalog-card-img-placeholder merch">
                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4H6z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 6h18" stroke="white" stroke-width="2" stroke-linecap="round"/><path d="M9 10a3 3 0 006 0" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                </div>
                <div class="katalog-card-body">
                    <p class="katalog-card-kategori">Merchandise</p>
                    <h3 class="katalog-card-name">Tote Bag SolusiSampah</h3>
                    <p class="katalog-card-desc">Tas ramah lingkungan eksklusif.</p>
                    <div class="katalog-card-poin-row">
                        <div class="katalog-card-poin">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span class="katalog-card-poin-num">3.000</span>
                            <span class="katalog-card-poin-label">poin</span>
                        </div>
                    </div>
                    <p class="katalog-card-stok tersedia">Stok Tersedia</p>
                </div>
                <div class="katalog-card-footer">
                    <button class="katalog-btn-tukar">TUKAR SEKARANG</button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer_user.php'; ?>

</body>
</html>