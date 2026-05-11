<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Setoran – SolusiSampah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Panggil CSS Navbar, Riwayat User, dan Footer di sini -->
    <link rel="stylesheet" href="../css/navbar_user.css">
    <link rel="stylesheet" href="../css/riwayat_user.css">
    <link rel="stylesheet" href="../css/footer_user.css">
</head>
<body>

<?php include '../includes/navbar_user.php'; ?>

<main class="riwayat-main">
    <div class="riwayat-container">

        <div class="riwayat-page-header">
            <h1 class="riwayat-page-title">Riwayat Setoran Kamu</h1>
            <p class="riwayat-page-sub">Lihat semua kontribusi sampah yang telah kamu tukar menjadi poin</p>
        </div>

        <div class="riwayat-summary-row">
            <div class="riwayat-stat-card">
                <p class="riwayat-stat-label">TOTAL SETORAN</p>
                <p class="riwayat-stat-value">24</p>
                <p class="riwayat-stat-unit">Transaksi</p>
            </div>
            <div class="riwayat-stat-card">
                <p class="riwayat-stat-label">TOTAL SAMPAH</p>
                <p class="riwayat-stat-value">82.4</p>
                <p class="riwayat-stat-unit">Kilogram</p>
            </div>
            <div class="riwayat-stat-card">
                <p class="riwayat-stat-label">TOTAL POIN</p>
                <p class="riwayat-stat-value riwayat-stat-gold">15.000</p>
                <p class="riwayat-stat-unit">Poin diterima</p>
            </div>
        </div>

        <div class="riwayat-filter-bar">
            <div class="riwayat-filter-date-wrap">
                <input type="date" name="tanggal" class="riwayat-filter-input riwayat-date-input"
                    value="2026-04-18">
                <svg class="riwayat-date-icon" width="15" height="15" viewBox="0 0 24 24" fill="none">
                    <rect x="3" y="4" width="18" height="18" rx="2" stroke="#9CA3AF" stroke-width="1.8"/>
                    <path d="M3 10h18M8 2v4M16 2v4" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </div>

            <div class="riwayat-filter-select-wrap">
                <select name="kategori" class="riwayat-filter-input riwayat-select-input">
                    <option value="">Semua Kategori</option>
                    <option value="plastik">Plastik PET</option>
                    <option value="kertas">Kertas / Kardus</option>
                    <option value="logam">Logam / Besi</option>
                    <option value="kaca">Kaca / Botol</option>
                    <option value="elektronik">Elektronik</option>
                </select>
                <svg class="riwayat-select-chevron" width="13" height="13" viewBox="0 0 24 24" fill="none">
                    <path d="M6 9l6 6 6-6" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <div class="riwayat-filter-select-wrap">
                <select name="status" class="riwayat-filter-input riwayat-select-input">
                    <option value="">Semua Status</option>
                    <option value="selesai">Selesai</option>
                    <option value="diproses">Diproses</option>
                    <option value="pending">Pending</option>
                </select>
                <svg class="riwayat-select-chevron" width="13" height="13" viewBox="0 0 24 24" fill="none">
                    <path d="M6 9l6 6 6-6" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <button type="submit" class="riwayat-btn-reset">Reset</button>
        </div>
        <!-- PHP: </form> -->

        <!-- ── Tabel Transaksi ── -->
        <div class="riwayat-table-card">

            <div class="riwayat-table-card-header">
                <h2 class="riwayat-table-title">Semua Transaksi</h2>
                <!-- PHP: echo 'Menampilkan ' . count($data) . ' dari ' . $total . ' transaksi' -->
                <p class="riwayat-table-count">Menampilkan 8 dari 24 transaksi</p>
            </div>

            <div class="riwayat-table-wrap">
                <table class="riwayat-table">
                    <thead>
                        <tr>
                            <th class="riwayat-th-tgl">TANGGAL</th>
                            <th class="riwayat-th-kat">JENIS SAMPAH</th>
                            <th class="riwayat-th-berat">BERAT</th>
                            <th class="riwayat-th-poin">POIN DIDAPAT</th>
                            <th class="riwayat-th-status">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="riwayat-tr">
                            <td class="riwayat-td-tgl">18 April 2026</td>
                            <td>
                                <span class="riwayat-kat-badge plastik">Plastik PET</span>
                            </td>
                            <td class="riwayat-td-berat">3.2 Kg</td>
                            <td class="riwayat-td-poin">
                                <p class="riwayat-poin-value">+ 1.600 Poin</p>
                                <p class="riwayat-poin-rate">500 poin/kg</p>
                            </td>
                            <td>
                                <span class="riwayat-status-badge selesai">● Selesai</span>
                            </td>
                        </tr>

                        <tr class="riwayat-tr">
                            <td class="riwayat-td-tgl">18 April 2026</td>
                            <td><span class="riwayat-kat-badge plastik">Plastik PET</span></td>
                            <td class="riwayat-td-berat">3.2 Kg</td>
                            <td class="riwayat-td-poin">
                                <p class="riwayat-poin-value">+ 1.600 Poin</p>
                                <p class="riwayat-poin-rate">500 poin/kg</p>
                            </td>
                            <td><span class="riwayat-status-badge selesai">● Selesai</span></td>
                        </tr>

                        <tr class="riwayat-tr">
                            <td class="riwayat-td-tgl">18 April 2026</td>
                            <td><span class="riwayat-kat-badge plastik">Plastik PET</span></td>
                            <td class="riwayat-td-berat">3.2 Kg</td>
                            <td class="riwayat-td-poin">
                                <p class="riwayat-poin-value">+ 1.600 Poin</p>
                                <p class="riwayat-poin-rate">500 poin/kg</p>
                            </td>
                            <td><span class="riwayat-status-badge selesai">● Selesai</span></td>
                        </tr>

                        <tr class="riwayat-tr">
                            <td class="riwayat-td-tgl">18 April 2026</td>
                            <td><span class="riwayat-kat-badge plastik">Plastik PET</span></td>
                            <td class="riwayat-td-berat">3.2 Kg</td>
                            <td class="riwayat-td-poin">
                                <p class="riwayat-poin-value">+ 1.600 Poin</p>
                                <p class="riwayat-poin-rate">500 poin/kg</p>
                            </td>
                            <td><span class="riwayat-status-badge selesai">● Selesai</span></td>
                        </tr>

                        <tr class="riwayat-tr">
                            <td class="riwayat-td-tgl">18 April 2026</td>
                            <td><span class="riwayat-kat-badge kertas">Kertas/Kardus</span></td>
                            <td class="riwayat-td-berat">5.0 Kg</td>
                            <td class="riwayat-td-poin">
                                <p class="riwayat-poin-value">+ 1.500 Poin</p>
                                <p class="riwayat-poin-rate">300 poin/kg</p>
                            </td>
                            <td><span class="riwayat-status-badge diproses">● Diproses</span></td>
                        </tr>

                        <tr class="riwayat-tr">
                            <td class="riwayat-td-tgl">18 April 2026</td>
                            <td><span class="riwayat-kat-badge plastik">Plastik PET</span></td>
                            <td class="riwayat-td-berat">3.2 Kg</td>
                            <td class="riwayat-td-poin">
                                <p class="riwayat-poin-value">+ 1.600 Poin</p>
                                <p class="riwayat-poin-rate">500 poin/kg</p>
                            </td>
                            <td><span class="riwayat-status-badge selesai">● Selesai</span></td>
                        </tr>

                        <tr class="riwayat-tr">
                            <td class="riwayat-td-tgl">17 April 2026</td>
                            <td><span class="riwayat-kat-badge logam">Logam/Besi</span></td>
                            <td class="riwayat-td-berat">2.1 Kg</td>
                            <td class="riwayat-td-poin">
                                <p class="riwayat-poin-value">+ 945 Poin</p>
                                <p class="riwayat-poin-rate">450 poin/kg</p>
                            </td>
                            <td><span class="riwayat-status-badge selesai">● Selesai</span></td>
                        </tr>

                        <tr class="riwayat-tr">
                            <td class="riwayat-td-tgl">17 April 2026</td>
                            <td><span class="riwayat-kat-badge plastik">Plastik PET</span></td>
                            <td class="riwayat-td-berat">3.2 Kg</td>
                            <td class="riwayat-td-poin">
                                <p class="riwayat-poin-value">+ 1.600 Poin</p>
                                <p class="riwayat-poin-rate">500 poin/kg</p>
                            </td>
                            <td><span class="riwayat-status-badge selesai">● Selesai</span></td>
                        </tr>

                        <!-- ================================================
                             PHP LOOP END: [endwhile;]
                             ================================================ -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="riwayat-pagination-row">
                <p class="riwayat-pagination-info">
                    <!-- PHP: echo "Halaman $page dari $total_pages" -->
                    Halaman 1 dari 3
                </p>
                <div class="riwayat-pagination">
                    <button class="riwayat-page-btn prev" disabled>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="15 18 9 12 15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Previous
                    </button>
                    <button class="riwayat-page-btn num active">1</button>
                    <button class="riwayat-page-btn num">2</button>
                    <button class="riwayat-page-btn num">3</button>
                    <button class="riwayat-page-btn next">
                        Next
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>

        </div><!-- end riwayat-table-card -->

    </div><!-- end riwayat-container -->
</main>

<?php include '../includes/footer_user.php'; ?>

</body>
</html>