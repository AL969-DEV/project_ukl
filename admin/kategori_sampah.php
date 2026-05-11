<?php
session_start();
// include '../includes/config.php'; // Uncomment if DB is needed later

// Cek apakah admin sudah login
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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Sampah – SolusiSampah Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard_admin.css">
    <link rel="stylesheet" href="../css/kategori_sampah.css">
</head>
<body>

<div class="app-wrapper">

    <?php $active_page = 'kategori'; include '../includes/sidebar_admin.php'; ?>

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

        <div class="page-content">
            <div class="ks-title-row">
                <div>
                    <p class="page-breadcrumb-text">Kategori Sampah</p>
                    <h1 class="page-title">Kategori Sampah</h1>
                    <p class="page-subtitle">Atur jenis sampah dan nilai poin per kilogram untuk seluruh nasabah</p>
                </div>
                <a href="crud_kategori_sampah.php" class="ks-btn-tambah">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><line x1="12" y1="5" x2="12" y2="19" stroke="white" stroke-width="2.5" stroke-linecap="round"/><line x1="5" y1="12" x2="19" y2="12" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>
                    Tambah Kategori
                </a>
            </div>

            <div class="ks-summary-row">
                <div class="ks-summary-card">
                    <div class="ks-summary-icon" style="background:#F0FDF4;color:#16A34A;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div>
                        <!-- PHP: echo $total_kategori -->
                        <p class="ks-summary-value">8</p>
                        <p class="ks-summary-label">Total Kategori</p>
                    </div>
                </div>

                <div class="ks-summary-card">
                    <div class="ks-summary-icon" style="background:#ECFDF5;color:#10B981;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <!-- PHP: echo $kategori_aktif -->
                        <p class="ks-summary-value">7</p>
                        <p class="ks-summary-label">Kategori Aktif</p>
                    </div>
                </div>

                <div class="ks-summary-card">
                    <div class="ks-summary-icon" style="background:#FFFBEB;color:#F59E0B;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div>
                        <!-- PHP: echo number_format($poin_tertinggi) -->
                        <p class="ks-summary-value ks-val-gold">500</p>
                        <p class="ks-summary-label">Poin Tertinggi/Kg</p>
                    </div>
                </div>

                <div class="ks-summary-card">
                    <div class="ks-summary-icon" style="background:#EFF6FF;color:#3B82F6;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <!-- PHP: echo $total_sampah_diterima -->
                        <p class="ks-summary-value">14.3 T</p>
                        <p class="ks-summary-label">Total Sampah Diterima</p>
                    </div>
                </div>
            </div>

            <!-- ── Table Panel ── -->
            <div class="ks-table-panel">

                <!-- Toolbar -->
                <div class="ks-toolbar">
                    <div class="ks-search-wrap">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="8" stroke="#9CA3AF" stroke-width="2"/><path d="M21 21l-4.35-4.35" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"/></svg>
                        <input type="text" class="search-input" placeholder="Cari Nama Kategori...">
                    </div>

                    <div class="ks-filter-wrap">
                        <select class="ks-filter-select">
                            <option>Semua Status</option>
                            <option>Aktif</option>
                            <option>Non-Aktif</option>
                        </select>
                        <svg class="ks-select-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>

                    <div class="ks-filter-wrap">
                        <select class="ks-filter-select">
                            <option>Urutkan: Poin Tertinggi</option>
                            <option>Urutkan: Poin Terendah</option>
                            <option>Urutkan: Nama A-Z</option>
                            <option>Urutkan: Terbaru</option>
                        </select>
                        <svg class="ks-select-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-wrapper">
                    <table class="data-table ks-table">
                        <thead>
                            <tr>
                                <th class="ks-th-ikon">IKON</th>
                                <th class="ks-th-nama">NAMA KATEGORI</th>
                                <th class="ks-th-poin">NILAI POIN</th>
                                <th class="ks-th-desc">DESKRIPSI</th>
                                <th class="ks-th-vol">VOLUME DITERIMA</th>
                                <th class="ks-th-status">STATUS</th>
                                <th class="ks-th-aksi">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- ================================================
                                 PHP LOOP START:
                                 <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                 Ganti nilai dummy dengan echo $row['kolom']
                                 ================================================ -->

                            <tr>
                                <td class="ks-td-ikon">
                                    <!-- PHP: ganti dengan <img src="<?= $row['ikon'] ?>"> atau emoji -->
                                    <div class="ks-ikon-wrap blue">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                </td>
                                <td>
                                    <!-- PHP: echo $row['nama_kategori'] + $row['kode'] -->
                                    <p class="ks-nama">Plastik PET</p>
                                    <p class="ks-kode">KAT-001</p>
                                </td>
                                <td class="ks-td-poin">
                                    <span class="ks-poin-badge">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        <!-- PHP: echo number_format($row['poin_per_kg']) -->
                                        500
                                    </span>
                                    <span class="ks-poin-unit">Poin/Kg</span>
                                </td>
                                <td class="ks-td-desc">
                                    <!-- PHP: echo $row['deskripsi'] -->
                                    Botol plastik bening (air mineral, minuman), wadah makanan transparan, kemasan PET daur ulang.
                                </td>
                                <td class="ks-td-vol">
                                    <!-- PHP: echo $row['volume_diterima'] . ' Kg' -->
                                    5.820 Kg
                                </td>
                                <td class="ks-td-status">
                                    <!-- PHP: $row['status'] == 'aktif' ? 'aktif' : 'nonaktif' -->
                                    <span class="status-badge aktif">● Aktif</span>
                                </td>
                                <td class="ks-td-aksi">
                                    <div class="aksi-cell">
                                        <a href="#" class="btn-aksi btn-detail" title="Detail">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                                        </a>
                                        <a href="#" class="btn-aksi btn-edit" title="Edit">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </a>
                                        <a href="#" class="btn-aksi btn-delete" title="Hapus" onclick="return confirm('Hapus kategori ini?')">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M9 6V4h6v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="ks-td-ikon">
                                    <div class="ks-ikon-wrap yellow">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><polyline points="14 2 14 8 20 8" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><line x1="16" y1="13" x2="8" y2="13" stroke="white" stroke-width="1.8" stroke-linecap="round"/><line x1="16" y1="17" x2="8" y2="17" stroke="white" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    </div>
                                </td>
                                <td>
                                    <p class="ks-nama">Kertas / Kardus</p>
                                    <p class="ks-kode">KAT-002</p>
                                </td>
                                <td class="ks-td-poin">
                                    <span class="ks-poin-badge">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        300
                                    </span>
                                    <span class="ks-poin-unit">Poin/Kg</span>
                                </td>
                                <td class="ks-td-desc">
                                    Kardus bekas, koran, majalah, kertas HVS, buku lama, dan semua jenis kertas yang dapat didaur ulang.
                                </td>
                                <td class="ks-td-vol">3.410 Kg</td>
                                <td class="ks-td-status"><span class="status-badge aktif">● Aktif</span></td>
                                <td class="ks-td-aksi">
                                    <div class="aksi-cell">
                                        <a href="#" class="btn-aksi btn-detail" title="Detail"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg></a>
                                        <a href="#" class="btn-aksi btn-edit" title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                                        <a href="#" class="btn-aksi btn-delete" title="Hapus" onclick="return confirm('Hapus kategori ini?')"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M9 6V4h6v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></a>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="ks-td-ikon">
                                    <div class="ks-ikon-wrap gray">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                </td>
                                <td>
                                    <p class="ks-nama">Logam / Besi</p>
                                    <p class="ks-kode">KAT-003</p>
                                </td>
                                <td class="ks-td-poin">
                                    <span class="ks-poin-badge">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        450
                                    </span>
                                    <span class="ks-poin-unit">Poin/Kg</span>
                                </td>
                                <td class="ks-td-desc">
                                    Kaleng bekas, besi tua, aluminium, tembaga, dan logam campuran lainnya yang masih layak daur ulang.
                                </td>
                                <td class="ks-td-vol">2.190 Kg</td>
                                <td class="ks-td-status"><span class="status-badge aktif">● Aktif</span></td>
                                <td class="ks-td-aksi">
                                    <div class="aksi-cell">
                                        <a href="#" class="btn-aksi btn-detail" title="Detail"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg></a>
                                        <a href="#" class="btn-aksi btn-edit" title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                                        <a href="#" class="btn-aksi btn-delete" title="Hapus" onclick="return confirm('Hapus kategori ini?')"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M9 6V4h6v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></a>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="ks-td-ikon">
                                    <div class="ks-ikon-wrap teal">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="white" stroke-width="1.8"/></svg>
                                    </div>
                                </td>
                                <td>
                                    <p class="ks-nama">Kaca / Botol</p>
                                    <p class="ks-kode">KAT-004</p>
                                </td>
                                <td class="ks-td-poin">
                                    <span class="ks-poin-badge">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        200
                                    </span>
                                    <span class="ks-poin-unit">Poin/Kg</span>
                                </td>
                                <td class="ks-td-desc">
                                    Botol kaca bekas minuman, toples, cermin pecah, dan semua bahan kaca yang dapat dilebur ulang.
                                </td>
                                <td class="ks-td-vol">3.410 Kg</td>
                                <td class="ks-td-status"><span class="status-badge aktif">● Aktif</span></td>
                                <td class="ks-td-aksi">
                                    <div class="aksi-cell">
                                        <a href="#" class="btn-aksi btn-detail" title="Detail"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg></a>
                                        <a href="#" class="btn-aksi btn-edit" title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                                        <a href="#" class="btn-aksi btn-delete" title="Hapus" onclick="return confirm('Hapus kategori ini?')"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M9 6V4h6v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></a>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="ks-td-ikon">
                                    <div class="ks-ikon-wrap purple">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="5" y="2" width="14" height="20" rx="3" stroke="white" stroke-width="1.8"/><path d="M9 18h6" stroke="white" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="9" r="2" fill="white"/></svg>
                                    </div>
                                </td>
                                <td>
                                    <p class="ks-nama">Elektronik Bekas</p>
                                    <p class="ks-kode">KAT-005</p>
                                </td>
                                <td class="ks-td-poin">
                                    <span class="ks-poin-badge">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        800
                                    </span>
                                    <span class="ks-poin-unit">Poin/Kg</span>
                                </td>
                                <td class="ks-td-desc">
                                    Ponsel rusak, komputer tua, kabel listrik, baterai bekas, dan semua komponen elektronik yang masih dapat diproses.
                                </td>
                                <td class="ks-td-vol">380 Kg</td>
                                <td class="ks-td-status"><span class="status-badge aktif">● Aktif</span></td>
                                <td class="ks-td-aksi">
                                    <div class="aksi-cell">
                                        <a href="#" class="btn-aksi btn-detail" title="Detail"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg></a>
                                        <a href="#" class="btn-aksi btn-edit" title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                                        <a href="#" class="btn-aksi btn-delete" title="Hapus" onclick="return confirm('Hapus kategori ini?')"><svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M9 6V4h6v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></a>
                                    </div>
                                </td>
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
                        Menampilkan <strong>5</strong> dari <strong>8</strong> kategori
                    </span>
                    <div class="pagination">
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn page-next">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                </div>

            </div><!-- end ks-table-panel -->

        </div><!-- end page-content -->
    </div><!-- end main-content -->
</div><!-- end app-wrapper -->

<?php include 'includes/footer.php'; ?>

</body>
</html>
