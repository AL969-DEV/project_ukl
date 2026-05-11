<?php
session_start();

if (!isset($_SESSION['id_account']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$nama_admin = $_SESSION['nama_lengkap'] ?? 'Admin';
$inisial = strtoupper(substr($nama_admin, 0, 1));
$kata = explode(" ", $nama_admin);
if (count($kata) > 1) {
    $inisial = strtoupper(substr($kata[0], 0, 1) . substr($kata[1], 0, 1));
}

$bulan = array(
    1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
);
$tanggal_hari_ini = date('j') . ' ' . $bulan[(int)date('m')] . ' ' . date('Y');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Setoran – SolusiSampah Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard_admin.css">
    <link rel="stylesheet" href="../css/transaksi_setoran.css">
</head>
<body>

<div class="app-wrapper">

    <?php $active_page = 'transaksi'; include '../includes/sidebar_admin.php'; ?>

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
                    <div class="user-avatar"><?php echo $inisial; ?></div>
                    <div class="user-info">
                        <span class="user-name"><?php echo htmlspecialchars($nama_admin); ?></span>
                        <span class="user-role">Super admin</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <div class="page-content">

            <!-- ── Page Title Row ── -->
            <div class="ts-title-row">
                <div>
                    <p class="page-breadcrumb-text">Transaksi Setoran</p>
                    <h1 class="page-title">Riwayat &amp; Transaksi Setoran</h1>
                    <p class="page-subtitle">Pantau dan kelola semua aktifitas setoran sampah nasabah secara real-time</p>
                </div>
                <div class="ts-title-actions">
                    <button class="ts-btn-secondary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 9h18M9 21V9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Export Excel
                    </button>
                    <button class="ts-btn-secondary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M6 9V2h12v7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><rect x="6" y="14" width="12" height="8" rx="1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Cetak Laporan
                    </button>
                    <a href="#" class="ts-btn-primary">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><line x1="12" y1="5" x2="12" y2="19" stroke="white" stroke-width="2.5" stroke-linecap="round"/><line x1="5" y1="12" x2="19" y2="12" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>
                        Input Manual
                    </a>
                </div>
            </div>

            <!-- ── 4 Summary Cards ── -->
            <div class="ts-summary-row">
                <!-- Card 1: Total Transaksi -->
                <div class="ts-summary-card">
                    <div class="ts-summary-icon" style="background:#EFF6FF;color:#3B82F6;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/><path d="M3 10h18M8 2v4M16 2v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div class="ts-summary-body">
                        <!-- PHP: echo number_format($total_transaksi) -->
                        <p class="ts-summary-value">1.482</p>
                        <p class="ts-summary-label">Total Transaksi</p>
                        <span class="ts-trend up">▲ 6.2% Bulan Ini</span>
                    </div>
                </div>

                <!-- Card 2: Total Berat -->
                <div class="ts-summary-card">
                    <div class="ts-summary-icon" style="background:#F0FDF4;color:#16A34A;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M12 3C8 3 5 6 5 10c0 3.5 2.5 6.5 7 10 4.5-3.5 7-6.5 7-10 0-4-3-7-7-7z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><circle cx="12" cy="10" r="2" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <div class="ts-summary-body">
                        <!-- PHP: echo number_format($total_berat, 0, ',', '.') -->
                        <p class="ts-summary-value">14.320 <span class="ts-unit">Kg</span></p>
                        <p class="ts-summary-label">Total Berat (Kg)</p>
                        <span class="ts-trend up">▲ 8.7% Bulan Ini</span>
                    </div>
                </div>

                <!-- Card 3: Total Poin -->
                <div class="ts-summary-card">
                    <div class="ts-summary-icon" style="background:#FFFBEB;color:#F59E0B;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div class="ts-summary-body">
                        <!-- PHP: echo number_format($total_poin) -->
                        <p class="ts-summary-value ts-val-gold">892.500</p>
                        <p class="ts-summary-label">Total Poin Diberikan</p>
                        <span class="ts-trend down">▼ 1.3% Bulan Ini</span>
                    </div>
                </div>

                <!-- Card 4: Menunggu Konfirmasi -->
                <div class="ts-summary-card ts-summary-card-alert">
                    <div class="ts-summary-icon" style="background:#FEF2F2;color:#DC2626;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><polyline points="12 6 12 12 16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="ts-summary-body">
                        <!-- PHP: echo $menunggu_konfirmasi -->
                        <p class="ts-summary-value ts-val-red">12</p>
                        <p class="ts-summary-label">Menunggu Konfirmasi</p>
                        <span class="ts-alert-pill">● Perlu Tindakan</span>
                    </div>
                </div>
            </div>

            <!-- ── Info Strip (ringkasan hari ini) ── -->
            <div class="ts-info-strip">
                <div class="ts-info-left">
                    <span class="ts-info-dot"></span>
                    <!-- PHP: echo "Ringkasan hari ini ($tanggal) – Total setoran masuk: $berat_hari_ini Kg dari $jumlah_transaksi transaksi" -->
                    Ringkasan hari ini <strong>(<?php echo $tanggal_hari_ini; ?>)</strong> – Total setoran masuk:
                    <strong>142.5 Kg</strong> dari <strong>24 transaksi</strong>
                </div>
                <div class="ts-info-right">
                    <span class="ts-chip selesai">18 Selesai</span>
                    <span class="ts-chip diproses">5 Diproses</span>
                    <span class="ts-chip pending">1 Pending</span>
                </div>
            </div>

            <!-- ── Table Panel ── -->
            <div class="ts-table-panel">

                <!-- Toolbar Row 1 -->
                <div class="ts-toolbar">
                    <div class="ts-search-wrap">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="8" stroke="#9CA3AF" stroke-width="2"/><path d="M21 21l-4.35-4.35" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"/></svg>
                        <input type="text" class="search-input" placeholder="Cari nama nasabah, ID transaksi...">
                    </div>

                    <!-- Filter: Kategori -->
                    <div class="ts-filter-wrap">
                        <select class="ts-filter-select">
                            <option>Semua Kategori</option>
                            <option>Plastik PET</option>
                            <option>Kertas/Kardus</option>
                            <option>Logam/Besi</option>
                            <option>Kaca/Botol</option>
                            <option>Elektronik</option>
                        </select>
                        <svg class="ts-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>

                    <!-- Filter: Status -->
                    <div class="ts-filter-wrap">
                        <select class="ts-filter-select">
                            <option>Semua Status</option>
                            <option>Selesai</option>
                            <option>Diproses</option>
                            <option>Pending</option>
                            <option>Ditolak</option>
                        </select>
                        <svg class="ts-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>

                    <!-- Date range -->
                    <div class="ts-date-input">
                        <input type="date" class="ts-date-field" value="2026-04-18">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="#9CA3AF" stroke-width="1.8"/><path d="M3 10h18M8 2v4M16 2v4" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round"/></svg>
                    </div>

                    <div class="ts-date-input">
                        <input type="date" class="ts-date-field" value="2026-04-18">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="#9CA3AF" stroke-width="1.8"/><path d="M3 10h18M8 2v4M16 2v4" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round"/></svg>
                    </div>
                </div>

                <!-- Toolbar Row 2 -->
                <div class="ts-toolbar-row2">
                    <div class="ts-filter-wrap">
                        <select class="ts-filter-select">
                            <option>Terbaru Pertama</option>
                            <option>Terlama Pertama</option>
                            <option>Poin Terbanyak</option>
                            <option>Berat Terbesar</option>
                        </select>
                        <svg class="ts-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <button class="ts-btn-reset">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        Reset Filter
                    </button>
                </div>

                <!-- Table -->
                <div class="table-wrapper">
                    <table class="data-table ts-table">
                        <thead>
                            <tr>
                                <th class="ts-th-cb">
                                    <input type="checkbox" class="ts-cb">
                                </th>
                                <th class="ts-th-id">ID TRANSAKSI</th>
                                <th class="ts-th-tgl">TANGGAL</th>
                                <th class="ts-th-nasabah">NAMA NASABAH</th>
                                <th class="ts-th-kat">KATEGORI</th>
                                <th class="ts-th-berat">BERAT</th>
                                <th class="ts-th-poin">TOTAL POIN</th>
                                <th class="ts-th-status">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- ================================================
                                 PHP LOOP START:
                                 <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                 Ganti nilai dummy dengan echo $row['kolom']
                                 ================================================ -->

                            <tr>
                                <td class="ts-td-cb"><input type="checkbox" class="ts-cb"></td>
                                <td class="ts-td-id">#TRX-4821</td>
                                <td class="ts-td-tgl">
                                    <p class="ts-tgl-date">18 April 2026</p>
                                    <p class="ts-tgl-time">09:14</p>
                                </td>
                                <td>
                                    <div class="nasabah-cell">
                                        <div class="nasabah-avatar" style="background:#DCFCE7;color:#16A34A;">SR</div>
                                        <div class="nasabah-info">
                                            <span class="nasabah-name">Siti Rahayu</span>
                                            <span class="nasabah-id">NSB-2024-0091</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="ts-kat-badge plastik">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                                    Plastik PET
                                </span></td>
                                <td class="ts-td-berat">3.2 <span class="ts-unit-small">kg</span></td>
                                <td class="ts-td-poin">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    1.600
                                </td>
                                <td><span class="status-badge selesai">● Selesai</span></td>
                            </tr>

                            <tr>
                                <td class="ts-td-cb"><input type="checkbox" class="ts-cb"></td>
                                <td class="ts-td-id">#TRX-4820</td>
                                <td class="ts-td-tgl">
                                    <p class="ts-tgl-date">18 April 2026</p>
                                    <p class="ts-tgl-time">09:08</p>
                                </td>
                                <td>
                                    <div class="nasabah-cell">
                                        <div class="nasabah-avatar" style="background:#DCFCE7;color:#16A34A;">SR</div>
                                        <div class="nasabah-info">
                                            <span class="nasabah-name">Budi Wahyono</span>
                                            <span class="nasabah-id">NSB-2024-0399</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="ts-kat-badge kertas">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                                    Kertas/Kardus
                                </span></td>
                                <td class="ts-td-berat">4.7 <span class="ts-unit-small">kg</span></td>
                                <td class="ts-td-poin">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    1.740
                                </td>
                                <td><span class="status-badge selesai">● Selesai</span></td>
                            </tr>

                            <tr>
                                <td class="ts-td-cb"><input type="checkbox" class="ts-cb"></td>
                                <td class="ts-td-id">#TRX-4820</td>
                                <td class="ts-td-tgl">
                                    <p class="ts-tgl-date">18 April 2026</p>
                                    <p class="ts-tgl-time">09:08</p>
                                </td>
                                <td>
                                    <div class="nasabah-cell">
                                        <div class="nasabah-avatar" style="background:#DCFCE7;color:#16A34A;">SR</div>
                                        <div class="nasabah-info">
                                            <span class="nasabah-name">Budi Wahyono</span>
                                            <span class="nasabah-id">NSB-2024-0399</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="ts-kat-badge kertas">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                                    Kertas/Kardus
                                </span></td>
                                <td class="ts-td-berat">4.7 <span class="ts-unit-small">kg</span></td>
                                <td class="ts-td-poin">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    1.740
                                </td>
                                <td><span class="status-badge selesai">● Selesai</span></td>
                            </tr>

                            <tr>
                                <td class="ts-td-cb"><input type="checkbox" class="ts-cb"></td>
                                <td class="ts-td-id">#TRX-4820</td>
                                <td class="ts-td-tgl">
                                    <p class="ts-tgl-date">18 April 2026</p>
                                    <p class="ts-tgl-time">09:08</p>
                                </td>
                                <td>
                                    <div class="nasabah-cell">
                                        <div class="nasabah-avatar" style="background:#DCFCE7;color:#16A34A;">SR</div>
                                        <div class="nasabah-info">
                                            <span class="nasabah-name">Budi Wahyono</span>
                                            <span class="nasabah-id">NSB-2024-0399</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="ts-kat-badge kertas">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                                    Kertas/Kardus
                                </span></td>
                                <td class="ts-td-berat">4.7 <span class="ts-unit-small">kg</span></td>
                                <td class="ts-td-poin">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    1.740
                                </td>
                                <td><span class="status-badge selesai">● Selesai</span></td>
                            </tr>

                            <tr>
                                <td class="ts-td-cb"><input type="checkbox" class="ts-cb"></td>
                                <td class="ts-td-id">#TRX-4820</td>
                                <td class="ts-td-tgl">
                                    <p class="ts-tgl-date">18 April 2026</p>
                                    <p class="ts-tgl-time">09:08</p>
                                </td>
                                <td>
                                    <div class="nasabah-cell">
                                        <div class="nasabah-avatar" style="background:#DCFCE7;color:#16A34A;">SR</div>
                                        <div class="nasabah-info">
                                            <span class="nasabah-name">Budi Wahyono</span>
                                            <span class="nasabah-id">NSB-2024-0399</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="ts-kat-badge kertas">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                                    Kertas/Kardus
                                </span></td>
                                <td class="ts-td-berat">4.7 <span class="ts-unit-small">kg</span></td>
                                <td class="ts-td-poin">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    1.740
                                </td>
                                <td><span class="status-badge selesai">● Selesai</span></td>
                            </tr>

                            <tr>
                                <td class="ts-td-cb"><input type="checkbox" class="ts-cb"></td>
                                <td class="ts-td-id">#TRX-4820</td>
                                <td class="ts-td-tgl">
                                    <p class="ts-tgl-date">18 April 2026</p>
                                    <p class="ts-tgl-time">09:08</p>
                                </td>
                                <td>
                                    <div class="nasabah-cell">
                                        <div class="nasabah-avatar" style="background:#DCFCE7;color:#16A34A;">SR</div>
                                        <div class="nasabah-info">
                                            <span class="nasabah-name">Budi Wahyono</span>
                                            <span class="nasabah-id">NSB-2024-0399</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="ts-kat-badge kertas">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                                    Kertas/Kardus
                                </span></td>
                                <td class="ts-td-berat">4.7 <span class="ts-unit-small">kg</span></td>
                                <td class="ts-td-poin">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    1.740
                                </td>
                                <td><span class="status-badge selesai">● Selesai</span></td>
                            </tr>

                            <tr>
                                <td class="ts-td-cb"><input type="checkbox" class="ts-cb"></td>
                                <td class="ts-td-id">#TRX-4820</td>
                                <td class="ts-td-tgl">
                                    <p class="ts-tgl-date">18 April 2026</p>
                                    <p class="ts-tgl-time">09:08</p>
                                </td>
                                <td>
                                    <div class="nasabah-cell">
                                        <div class="nasabah-avatar" style="background:#DCFCE7;color:#16A34A;">SR</div>
                                        <div class="nasabah-info">
                                            <span class="nasabah-name">Budi Wahyono</span>
                                            <span class="nasabah-id">NSB-2024-0399</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="ts-kat-badge kertas">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                                    Kertas/Kardus
                                </span></td>
                                <td class="ts-td-berat">4.7 <span class="ts-unit-small">kg</span></td>
                                <td class="ts-td-poin">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    1.740
                                </td>
                                <td><span class="status-badge selesai">● Selesai</span></td>
                            </tr>

                            <!-- ================================================
                                 PHP LOOP END: <?php endwhile; ?>
                                 ================================================ -->
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                <div class="table-footer">
                    <span class="table-info">
                        Menampilkan <strong>1–7</strong> dari <strong>1.482</strong> transaksi
                    </span>
                    <div class="pagination">
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <span class="page-ellipsis">...</span>
                        <button class="page-btn">149</button>
                        <button class="page-btn page-next">
                            Berikutnya
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                </div>

            </div><!-- end ts-table-panel -->

        </div><!-- end page-content -->
    </div><!-- end main-content -->
</div><!-- end app-wrapper -->

<?php include 'includes/footer.php'; ?>

</body>
</html>
