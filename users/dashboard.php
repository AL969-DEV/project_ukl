<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – SolusiSampah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar_user.css">
    <link rel="stylesheet" href="../css/dashboard_user.css">
    <link rel="stylesheet" href="../css/footer_user.css">
</head>
<body>

<?php include '../includes/navbar_user.php'; ?>

<section class="hero-section">
    <div class="hero-inner">
        <div class="hero-left">
            <!-- PHP: ganti dengan echo $nama_user -->
            <p class="hero-greeting">Halo, Nasabah! Selamat datang kembali.</p>
            <h1 class="hero-poin">
                Poin Kamu: <span class="hero-poin-value">
                    <!-- PHP: echo number_format($saldo_poin) -->
                    15.000
                </span>
            </h1>
            <div class="hero-meta">
                <!-- PHP: echo $level | $id_nasabah | $hari_ini -->
                <span class="hero-meta-badge">Level Gold</span>
                <span class="hero-meta-sep">•</span>
                <span>NSB-2024-0091</span>
                <span class="hero-meta-sep">•</span>
                <span>Sabtu, 18 April 2026</span>
            </div>
        </div>
        <div class="hero-right">
            <button class="btn-scan-qr">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M3 7V5a2 2 0 012-2h2M17 3h2a2 2 0 012 2v2M21 17v2a2 2 0 01-2 2h-2M7 21H5a2 2 0 01-2-2v-2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <rect x="7" y="7" width="4" height="4" rx="0.5" stroke="currentColor" stroke-width="1.5"/>
                    <rect x="13" y="7" width="4" height="4" rx="0.5" stroke="currentColor" stroke-width="1.5"/>
                    <rect x="7" y="13" width="4" height="4" rx="0.5" stroke="currentColor" stroke-width="1.5"/>
                    <rect x="13" y="13" width="4" height="4" rx="0.5" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                Scan QR Code
            </button>
            <p class="hero-scan-sub">Klaim poin setoran dengan sacan QR</p>
        </div>
    </div>
</section>

<main class="main-content">
    <div class="container">
        <div class="content-grid">

            <!-- ── LEFT COLUMN ── -->
            <div class="col-left">

                <!-- Riwayat Setoran Terbaru -->
                <div class="card riwayat-card">
                    <div class="card-header">
                        <h2 class="card-title">Riwayat Setoran Terbaru</h2>
                        <a href="#" class="link-arrow">
                            Lihat semua riwayat
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    </div>

                    <div class="table-wrap">
                        <table class="riwayat-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>TANGGAL</th>
                                    <th>JENIS SAMPAH</th>
                                    <th>BERAT</th>
                                    <th>POIN DITERIMA</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- ================================================
                                     PHP LOOP START:
                                     [while ($row = mysqli_fetch_assoc($result)):]
                                     Ganti nilai dummy di bawah dengan echo $row['kolom']
                                     ================================================ -->
                                <tr>
                                    <td class="td-id">#S-4821</td>
                                    <td class="td-date">18 April 2026</td>
                                    <td><span class="badge-jenis plastik">Plastik PET</span></td>
                                    <td class="td-berat">3.2 Kg</td>
                                    <td class="td-poin">+ 1.600</td>
                                    <td><span class="badge-status selesai">● Selesai</span></td>
                                </tr>
                                <tr>
                                    <td class="td-id">#S-4815</td>
                                    <td class="td-date">15 April 2026</td>
                                    <td><span class="badge-jenis kertas">Kertas/Kardus</span></td>
                                    <td class="td-berat">3.2 Kg</td>
                                    <td class="td-poin">+ 1.600</td>
                                    <td><span class="badge-status selesai">● Selesai</span></td>
                                </tr>
                                <tr>
                                    <td class="td-id">#S-4815</td>
                                    <td class="td-date">15 April 2026</td>
                                    <td><span class="badge-jenis kertas">Kertas/Kardus</span></td>
                                    <td class="td-berat">3.2 Kg</td>
                                    <td class="td-poin">+ 1.600</td>
                                    <td><span class="badge-status selesai">● Selesai</span></td>
                                </tr>
                                <tr>
                                    <td class="td-id">#S-4815</td>
                                    <td class="td-date">15 April 2026</td>
                                    <td><span class="badge-jenis kertas">Kertas/Kardus</span></td>
                                    <td class="td-berat">3.2 Kg</td>
                                    <td class="td-poin">+ 1.600</td>
                                    <td><span class="badge-status selesai">● Selesai</span></td>
                                </tr>
                                <tr>
                                    <td class="td-id">#S-4815</td>
                                    <td class="td-date">15 April 2026</td>
                                    <td><span class="badge-jenis kertas">Kertas/Kardus</span></td>
                                    <td class="td-berat">3.2 Kg</td>
                                    <td class="td-poin">+ 1.600</td>
                                    <td><span class="badge-status selesai">● Selesai</span></td>
                                </tr>
                                <!-- ================================================
                                     PHP LOOP END: [endwhile;]
                                     ================================================ -->
                            </tbody>
                        </table>
                    </div>
                </div><!-- end riwayat-card -->

            </div><!-- end col-left -->


            <!-- ── RIGHT COLUMN ── -->
            <div class="col-right">

                <!-- Total Sampah Disetor -->
                <div class="card stat-card">
                    <p class="stat-card-label">TOTAL SAMPAH DISETOR</p>
                    <div class="sampah-big-num">
                        <!-- PHP: echo $total_sampah_kg -->
                        18.3
                    </div>
                    <p class="sampah-unit-label">Kilogram bulan ini</p>
                    <div class="progress-wrap">
                        <div class="progress-bar">
                            <!-- PHP: ganti style width dengan persentase, misal ($total/$target*100).'%' -->
                            <div class="progress-fill" style="width: 37%;"></div>
                        </div>
                        <div class="progress-labels">
                            <span>0 Kg</span>
                            <span>37% dari target 50 kg</span>
                        </div>
                    </div>
                </div>

                <!-- Jumlah Penukaran Voucher -->
                <div class="card stat-card">
                    <p class="stat-card-label">JUMLAH PENUKARAN VOUCHER</p>
                    <div class="voucher-big-num">
                        <!-- PHP: echo $total_penukaran -->
                        5
                    </div>
                    <p class="voucher-sub-label">Penukaran berhasil</p>
                    <div class="voucher-list">
                        <!-- PHP: loop voucher aktif -->
                        <div class="voucher-item">
                            <span class="voucher-name">Pulsa Rp 10.000</span>
                            <span class="voucher-badge aktif">Aktif</span>
                        </div>
                        <div class="voucher-item">
                            <span class="voucher-name">DANA Rp 25.000</span>
                            <span class="voucher-badge aktif">Aktif</span>
                        </div>
                        <div class="voucher-item">
                            <span class="voucher-name">Token Listrik</span>
                            <span class="voucher-badge digunakan">Digunakan</span>
                        </div>
                    </div>
                </div>

                <!-- Peringkat Lingkungan -->
                <div class="card stat-card peringkat-card">
                    <p class="stat-card-label">PERINGKAT LINGKUNGAN</p>
                    <div class="peringkat-big-num">
                        <!-- PHP: echo '#' . $peringkat_user -->
                        #3
                    </div>
                    <p class="peringkat-sub">
                        <!-- PHP: echo 'Dari ' . $total_nasabah . ' nasabah aktif' -->
                        Dari 248 nasabah aktif
                    </p>
                    <p class="peringkat-hint">
                        <!-- PHP: echo $poin_kurang . ' lagi untuk peringkat #1' -->
                        Butuh 1.700 poin lagi untuk menuju peringkat #1
                    </p>
                    <a href="#" class="peringkat-arrow-link">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

            </div><!-- end col-right -->

        </div><!-- end content-grid -->


        <!-- ── KATALOG PENUKARAN HADIAH ── -->
        <section class="katalog-section">
            <div class="katalog-header">
                <h2 class="katalog-title">Katalog Penukaran Hadiah</h2>
                <a href="#" class="link-green">Lihat semua hadiah →</a>
            </div>

            <div class="katalog-grid">

                <!-- PHP: loop dari database hadiah, tampilkan maks 4 item -->

                <!-- Card 1 -->
                <div class="hadiah-card">
                    <div class="hadiah-img-wrap">
                        <!-- PHP: ganti dengan <img src="<?= $row['gambar'] ?>" ...> -->
                        <div class="hadiah-img-placeholder"></div>
                    </div>
                    <div class="hadiah-body">
                        <!-- PHP: echo $row['nama_hadiah'] -->
                        <p class="hadiah-name">DANA Rp 25.000</p>
                        <!-- PHP: echo $row['deskripsi'] -->
                        <p class="hadiah-desc">Transfer ke dompet digital DANA</p>
                        <p class="hadiah-poin">
                            Harga: <strong>
                                <!-- PHP: echo number_format($row['poin_dibutuhkan']) . ' poin' -->
                                2.500 poin
                            </strong>
                        </p>
                        <button class="btn-tukar">Tukar Sekarang</button>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="hadiah-card">
                    <div class="hadiah-img-wrap">
                        <div class="hadiah-img-placeholder"></div>
                    </div>
                    <div class="hadiah-body">
                        <p class="hadiah-name">Token Listrik 20kWh</p>
                        <p class="hadiah-desc">Token PLN prabayar semua meteran</p>
                        <p class="hadiah-poin">Harga: <strong>5.000 poin</strong></p>
                        <button class="btn-tukar">Tukar Sekarang</button>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="hadiah-card">
                    <div class="hadiah-img-wrap">
                        <div class="hadiah-img-placeholder"></div>
                    </div>
                    <div class="hadiah-body">
                        <p class="hadiah-name">Pulsa Rp 10.000</p>
                        <p class="hadiah-desc">Semua operator</p>
                        <p class="hadiah-poin">Harga: <strong>1.000 poin</strong></p>
                        <button class="btn-tukar">Tukar Sekarang</button>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="hadiah-card">
                    <div class="hadiah-img-wrap">
                        <div class="hadiah-img-placeholder"></div>
                    </div>
                    <div class="hadiah-body">
                        <p class="hadiah-name">Shopee Rp 50.000</p>
                        <p class="hadiah-desc">Voucher belanja online</p>
                        <p class="hadiah-poin">Harga: <strong>5.000 poin</strong></p>
                        <button class="btn-tukar">Tukar Sekarang</button>
                    </div>
                </div>

            </div><!-- end katalog-grid -->
        </section>

    </div><!-- end container -->
</main>


<?php include '../includes/footer_user.php'; ?>

</body>
</html>

