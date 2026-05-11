<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peringkat Nasabah – SolusiSampah Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard_admin.css">
    <link rel="stylesheet" href="../css/peringkat_nasabah.css">
</head>
<body>

<div class="app-wrapper">

    <?php $active_page = 'peringkat'; include '../includes/sidebar_admin.php'; ?>

    <!-- ===================== MAIN CONTENT ===================== -->
    <div class="main-content">

        <!-- TOP HEADER -->
        <header class="top-header">
            <div class="header-left">
                <span class="header-breadcrumb">
                    <span style="color:var(--green-primary);font-weight:800;">Admin</span> Panel
                </span>
            </div>
            <div class="header-center">
                <div class="search-box">
                    <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="8" stroke="#9CA3AF" stroke-width="2"/><path d="M21 21l-4.35-4.35" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"/></svg>
                    <input type="text" class="search-input" placeholder="Cari nasabah, transaksi...">
                </div>
            </div>
            <div class="header-right">
                <button class="notif-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span class="notif-dot"></span>
                </button>
                <div class="user-profile">
                    <div class="user-avatar">AB</div>
                    <div class="user-info">
                        <span class="user-name">Admin Budi</span>
                        <span class="user-role">Super admin</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <div class="page-content">

            <!-- ── Page Title Row ── -->
            <div class="lb-title-row">
                <div>
                    <p class="page-breadcrumb-text">Laporan</p>
                    <h1 class="page-title">🏆 Peringkat Nasabah <span class="lb-title-light">(Leaderboard)</span></h1>
                    <p class="page-subtitle">Daftar nasabah terbaik berdasarkan akumulasi poin tertinggi.</p>
                </div>
                <div class="lb-title-actions">
                    <div class="lb-period-wrap">
                        <select class="lb-period-select">
                            <option>Bulan Ini</option>
                            <option>Bulan Lalu</option>
                            <option>3 Bulan Terakhir</option>
                            <option>Tahun Ini</option>
                            <option>Semua Waktu</option>
                        </select>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" class="lb-chevron"><path d="M6 9l6 6 6-6" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <button class="lb-btn-export">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><polyline points="7 10 12 15 17 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><line x1="12" y1="15" x2="12" y2="3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        Export
                    </button>
                </div>
            </div>

            <!-- ── Summary Strip ── -->
            <div class="lb-summary-row">
                <div class="lb-summary-card">
                    <div class="lb-summary-icon" style="background:#FFFBEB;color:#F59E0B;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div>
                        <p class="lb-summary-value">248</p>
                        <p class="lb-summary-label">Total Peserta</p>
                    </div>
                </div>
                <div class="lb-summary-card">
                    <div class="lb-summary-icon" style="background:#F0FDF4;color:#16A34A;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" fill="currentColor"/></svg>
                    </div>
                    <div>
                        <p class="lb-summary-value">15.000</p>
                        <p class="lb-summary-label">Poin Tertinggi</p>
                    </div>
                </div>
                <div class="lb-summary-card">
                    <div class="lb-summary-icon" style="background:#EFF6FF;color:#3B82F6;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div>
                        <p class="lb-summary-value">4.218</p>
                        <p class="lb-summary-label">Rata-rata Poin</p>
                    </div>
                </div>
                <div class="lb-summary-card">
                    <div class="lb-summary-icon" style="background:#FFF1F2;color:#E11D48;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><polyline points="17 6 23 6 23 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <p class="lb-summary-value">+18%</p>
                        <p class="lb-summary-label">Naik dari Bulan Lalu</p>
                    </div>
                </div>
            </div>

            <!-- ── PODIUM TOP 3 ── -->
            <div class="lb-podium-section">

                <!-- Juara 2 – Silver (kiri) -->
                <div class="lb-podium-card silver">
                    <div class="lb-podium-rank silver">2</div>
                    <div class="lb-podium-avatar silver">
                        <!-- PHP: echo strtoupper(substr($row2['nama'], 0, 2)) -->
                        BW
                    </div>
                    <div class="lb-podium-medal silver">🥈</div>
                    <p class="lb-podium-name">
                        <!-- PHP: echo $row2['nama'] -->
                        Budi Wahyono
                    </p>
                    <p class="lb-podium-id">NSB-2024-0047</p>
                    <div class="lb-podium-poin silver">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="#94A3B8"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <!-- PHP: echo number_format($row2['total_poin']) -->
                        12.500 Poin
                    </div>
                    <div class="lb-podium-stat">
                        <span>87.3 Kg disetor</span>
                    </div>
                    <div class="lb-podium-base silver">PERINGKAT 2</div>
                </div>

                <!-- Juara 1 – Gold (tengah/lebih tinggi) -->
                <div class="lb-podium-card gold champion">
                    <div class="lb-podium-crown">👑</div>
                    <div class="lb-podium-rank gold">1</div>
                    <div class="lb-podium-avatar gold">
                        <!-- PHP: echo strtoupper(substr($row1['nama'], 0, 2)) -->
                        SR
                    </div>
                    <div class="lb-podium-medal gold">🥇</div>
                    <p class="lb-podium-name champion-name">
                        <!-- PHP: echo $row1['nama'] -->
                        Siti Rahayu
                    </p>
                    <p class="lb-podium-id">NSB-2024-0091</p>
                    <div class="lb-podium-poin gold">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <!-- PHP: echo number_format($row1['total_poin']) -->
                        15.000 Poin
                    </div>
                    <div class="lb-podium-stat">
                        <span>124.6 Kg disetor</span>
                    </div>
                    <div class="lb-podium-base gold">JUARA 1</div>
                </div>

                <!-- Juara 3 – Bronze (kanan) -->
                <div class="lb-podium-card bronze">
                    <div class="lb-podium-rank bronze">3</div>
                    <div class="lb-podium-avatar bronze">
                        <!-- PHP: echo strtoupper(substr($row3['nama'], 0, 2)) -->
                        DN
                    </div>
                    <div class="lb-podium-medal bronze">🥉</div>
                    <p class="lb-podium-name">
                        <!-- PHP: echo $row3['nama'] -->
                        Dewi Novita
                    </p>
                    <p class="lb-podium-id">NSB-2024-0112</p>
                    <div class="lb-podium-poin bronze">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="#D97706"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <!-- PHP: echo number_format($row3['total_poin']) -->
                        10.000 Poin
                    </div>
                    <div class="lb-podium-stat">
                        <span>72.0 Kg disetor</span>
                    </div>
                    <div class="lb-podium-base bronze">PERINGKAT 3</div>
                </div>

            </div><!-- end lb-podium-section -->


            <!-- ── TABEL PERINGKAT 4–10 ── -->
            <div class="lb-table-panel">

                <div class="lb-table-header">
                    <div>
                        <h2 class="lb-table-title">Peringkat Selanjutnya</h2>
                        <p class="lb-table-sub">Posisi 4 hingga 10 berdasarkan total poin</p>
                    </div>
                    <div class="lb-search-wrap">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="8" stroke="#9CA3AF" stroke-width="2"/><path d="M21 21l-4.35-4.35" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"/></svg>
                        <input type="text" class="search-input" placeholder="Cari nasabah...">
                    </div>
                </div>

                <div class="lb-divider"></div>

                <div class="table-wrapper">
                    <table class="data-table lb-table">
                        <thead>
                            <tr>
                                <th class="lb-th-rank">PERINGKAT</th>
                                <th class="lb-th-nasabah">NAMA NASABAH</th>
                                <th class="lb-th-joined">BERGABUNG</th>
                                <th class="lb-th-sampah">TOTAL SAMPAH</th>
                                <th class="lb-th-poin">TOTAL POIN</th>
                                <th class="lb-th-trend">TREND</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- ================================================
                                 PHP LOOP START (peringkat 4-10):
                                 <?php $rank=4; while ($row = mysqli_fetch_assoc($result)): ?>
                                 Ganti nilai dummy dengan echo $row['kolom']
                                 ================================================ -->

                            <tr>
                                <td class="lb-td-rank">
                                    <span class="lb-rank-num">4</span>
                                </td>
                                <td>
                                    <div class="nasabah-cell">
                                        <div class="nasabah-avatar" style="background:#EDE9FE;color:#5B21B6;">AP</div>
                                        <div class="nasabah-info">
                                            <!-- PHP: echo $row['nama'] -->
                                            <span class="nasabah-name">Ahmad Pratama</span>
                                            <!-- PHP: echo $row['id_nasabah'] -->
                                            <span class="nasabah-id">NSB-2024-0112</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="lb-td-joined">
                                    <!-- PHP: echo date('d M Y', strtotime($row['tanggal_bergabung'])) -->
                                    12 Jan 2024
                                </td>
                                <td class="lb-td-sampah">
                                    <!-- PHP: echo $row['total_sampah'] . ' Kg' -->
                                    68.4 Kg
                                </td>
                                <td class="lb-td-poin">
                                    <div class="lb-poin-wrap">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        <!-- PHP: echo number_format($row['total_poin']) -->
                                        <span class="lb-poin-num">9.200</span>
                                    </div>
                                </td>
                                <td class="lb-td-trend">
                                    <span class="lb-trend up">▲ 2</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="lb-td-rank">
                                    <span class="lb-rank-num">5</span>
                                </td>
                                <td>
                                    <div class="nasabah-cell">
                                        <div class="nasabah-avatar" style="background:#FEE2E2;color:#DC2626;">RS</div>
                                        <div class="nasabah-info">
                                            <span class="nasabah-name">Rina Susanti</span>
                                            <span class="nasabah-id">NSB-2024-0205</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="lb-td-joined">05 Feb 2024</td>
                                <td class="lb-td-sampah">59.1 Kg</td>
                                <td class="lb-td-poin">
                                    <div class="lb-poin-wrap">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        <span class="lb-poin-num">7.850</span>
                                    </div>
                                </td>
                                <td class="lb-td-trend">
                                    <span class="lb-trend same">— 0</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="lb-td-rank">
                                    <span class="lb-rank-num">6</span>
                                </td>
                                <td>
                                    <div class="nasabah-cell">
                                        <div class="nasabah-avatar" style="background:#DCFCE7;color:#16A34A;">HK</div>
                                        <div class="nasabah-info">
                                            <span class="nasabah-name">Hendra Kusuma</span>
                                            <span class="nasabah-id">NSB-2024-0318</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="lb-td-joined">20 Feb 2024</td>
                                <td class="lb-td-sampah">51.8 Kg</td>
                                <td class="lb-td-poin">
                                    <div class="lb-poin-wrap">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        <span class="lb-poin-num">6.920</span>
                                    </div>
                                </td>
                                <td class="lb-td-trend">
                                    <span class="lb-trend down">▼ 1</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="lb-td-rank">
                                    <span class="lb-rank-num">7</span>
                                </td>
                                <td>
                                    <div class="nasabah-cell">
                                        <div class="nasabah-avatar" style="background:#FEF3C7;color:#D97706;">LM</div>
                                        <div class="nasabah-info">
                                            <span class="nasabah-name">Lisa Melati</span>
                                            <span class="nasabah-id">NSB-2024-0401</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="lb-td-joined">08 Mar 2024</td>
                                <td class="lb-td-sampah">44.5 Kg</td>
                                <td class="lb-td-poin">
                                    <div class="lb-poin-wrap">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        <span class="lb-poin-num">5.600</span>
                                    </div>
                                </td>
                                <td class="lb-td-trend">
                                    <span class="lb-trend up">▲ 3</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="lb-td-rank">
                                    <span class="lb-rank-num">8</span>
                                </td>
                                <td>
                                    <div class="nasabah-cell">
                                        <div class="nasabah-avatar" style="background:#F3F4F6;color:#374151;">FN</div>
                                        <div class="nasabah-info">
                                            <span class="nasabah-name">Fauzi Nur</span>
                                            <span class="nasabah-id">NSB-2024-0477</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="lb-td-joined">15 Mar 2024</td>
                                <td class="lb-td-sampah">38.2 Kg</td>
                                <td class="lb-td-poin">
                                    <div class="lb-poin-wrap">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        <span class="lb-poin-num">4.380</span>
                                    </div>
                                </td>
                                <td class="lb-td-trend">
                                    <span class="lb-trend same">— 0</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="lb-td-rank">
                                    <span class="lb-rank-num">9</span>
                                </td>
                                <td>
                                    <div class="nasabah-cell">
                                        <div class="nasabah-avatar" style="background:#EFF6FF;color:#3B82F6;">YP</div>
                                        <div class="nasabah-info">
                                            <span class="nasabah-name">Yuli Pratiwi</span>
                                            <span class="nasabah-id">NSB-2024-0512</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="lb-td-joined">02 Apr 2024</td>
                                <td class="lb-td-sampah">30.9 Kg</td>
                                <td class="lb-td-poin">
                                    <div class="lb-poin-wrap">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        <span class="lb-poin-num">3.100</span>
                                    </div>
                                </td>
                                <td class="lb-td-trend">
                                    <span class="lb-trend down">▼ 2</span>
                                </td>
                            </tr>

                            <tr>
                                <td class="lb-td-rank">
                                    <span class="lb-rank-num">10</span>
                                </td>
                                <td>
                                    <div class="nasabah-cell">
                                        <div class="nasabah-avatar" style="background:#FFF1F2;color:#E11D48;">MR</div>
                                        <div class="nasabah-info">
                                            <span class="nasabah-name">Muhammad Rizal</span>
                                            <span class="nasabah-id">NSB-2024-0588</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="lb-td-joined">18 Apr 2024</td>
                                <td class="lb-td-sampah">25.4 Kg</td>
                                <td class="lb-td-poin">
                                    <div class="lb-poin-wrap">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        <span class="lb-poin-num">2.540</span>
                                    </div>
                                </td>
                                <td class="lb-td-trend">
                                    <span class="lb-trend up">▲ 1</span>
                                </td>
                            </tr>

                            <!-- ================================================
                                 PHP LOOP END: <?php $rank++; endwhile; ?>
                                 ================================================ -->
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <span class="table-info">Menampilkan peringkat <strong>4–10</strong> dari <strong>248</strong> nasabah</span>
                    <div class="pagination">
                        <button class="page-btn page-prev" disabled>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="15 18 9 12 15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Previous
                        </button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <span class="page-ellipsis">...</span>
                        <button class="page-btn">25</button>
                        <button class="page-btn page-next">
                            Berikutnya
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                </div>

            </div><!-- end lb-table-panel -->

        </div><!-- end page-content -->
    </div><!-- end main-content -->
</div><!-- end app-wrapper -->

<?php include 'includes/footer.php'; ?>

</body>
</html>
