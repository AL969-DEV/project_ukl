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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Hadiah & Reward – SolusiSampah Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard_admin.css">
    <link rel="stylesheet" href="../css/kelola_reward.css">
</head>
<body>

<div class="app-wrapper">

    <?php $active_page = 'reward'; include '../includes/sidebar_admin.php'; ?>

    <!-- ===================== MAIN CONTENT ===================== -->
    <div class="main-content">

        <!-- TOP HEADER — identik dengan halaman lain -->
        <header class="top-header">
            <div class="header-left">
                <div class="header-breadcrumb-wrap">
                    <span class="header-breadcrumb-green">Admin</span>
                    <span class="header-breadcrumb-text"> Panel</span>
                </div>
                <h1 class="header-page-title">Kelola Hadiah &amp; Reward</h1>
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
                        <span class="user-role">Super Admin</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <div class="page-content">

            <!-- ── SUMMARY CARDS (4 card terpisah seperti di Figma) ── -->
            <div class="kr-summary-row">
                <div class="kr-summary-card">
                    <div class="kr-summary-icon" style="color:#16A34A;background:#F0FDF4;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div>
                        <!-- PHP: echo $total_hadiah_aktif -->
                        <p class="kr-summary-value">24</p>
                        <p class="kr-summary-label">Total Hadiah Aktif</p>
                    </div>
                </div>

                <div class="kr-summary-card">
                    <div class="kr-summary-icon" style="color:#3B82F6;background:#EFF6FF;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 3l-4 4-4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <!-- PHP: echo $penukaran_bulan_ini -->
                        <p class="kr-summary-value">138</p>
                        <p class="kr-summary-label">Penukaran Bulan Ini</p>
                    </div>
                </div>

                <div class="kr-summary-card">
                    <div class="kr-summary-icon" style="color:#D97706;background:#FFFBEB;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="2" y="7" width="20" height="14" rx="2" stroke="currentColor" stroke-width="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div>
                        <!-- PHP: echo $stok_hampir_habis -->
                        <p class="kr-summary-value">6</p>
                        <p class="kr-summary-label">Stok Hampir Habis</p>
                    </div>
                </div>

                <div class="kr-summary-card">
                    <div class="kr-summary-icon" style="color:#DC2626;background:#FEF2F2;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                    </div>
                    <div>
                        <!-- PHP: echo $stok_habis -->
                        <p class="kr-summary-value">3</p>
                        <p class="kr-summary-label">Stok Habis</p>
                    </div>
                </div>
            </div>


            <!-- ── MAIN TWO-COLUMN LAYOUT ── -->
            <div class="kr-main-grid">

                <!-- ─── KOLOM KIRI: Form Tambah ─── -->
                <div class="kr-col-form">
                    <div class="kr-panel">

                        <!-- Panel header -->
                        <div class="kr-panel-header">
                            <div class="kr-panel-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><line x1="12" y1="5" x2="12" y2="19" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/><line x1="5" y1="12" x2="19" y2="12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                            </div>
                            <div>
                                <h2 class="kr-panel-title">Tambah Hadiah Baru</h2>
                                <p class="kr-panel-sub">Kolom bertanda <span class="req">*</span> wajib diisi.</p>
                            </div>
                        </div>

                        <div class="kr-divider"></div>

                        <!-- PHP: ubah action ke proses_tambah_reward.php -->
                        <form method="POST" action="" enctype="multipart/form-data" class="kr-form" autocomplete="off">

                            <!-- Nama Hadiah -->
                            <div class="form-group">
                                <label class="form-label" for="nama_hadiah">
                                    Nama Hadiah <span class="req">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-icon">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 3l-4 4-4-4" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </span>
                                    <input type="text" id="nama_hadiah" name="nama_hadiah"
                                        class="form-input has-icon"
                                        placeholder="Misal: Pulsa 10.000"
                                        required maxlength="100">
                                </div>
                                <p class="form-hint">Nama yang ditampilkan pada katalog penukaran nasabah.</p>
                            </div>

                            <!-- Deskripsi -->
                            <div class="form-group">
                                <label class="form-label" for="deskripsi">Deskripsi Singkat</label>
                                <input type="text" id="deskripsi" name="deskripsi"
                                    class="form-input"
                                    placeholder="Misal: Semua operator, berlaku 30 hari"
                                    maxlength="150">
                            </div>

                            <!-- Row: Harga Poin + Stok -->
                            <div class="kr-form-row-2">
                                <div class="form-group">
                                    <label class="form-label" for="harga_poin">
                                        Harga Poin <span class="req">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <span class="input-icon">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="#FEF3C7"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="#F59E0B" stroke-width="1.8" stroke-linejoin="round"/></svg>
                                        </span>
                                        <input type="number" id="harga_poin" name="harga_poin"
                                            class="form-input has-icon"
                                            placeholder="Misal: 1000"
                                            required min="1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="stok">
                                        Stok Tersedia <span class="req">*</span>
                                    </label>
                                    <div class="input-wrapper">
                                        <span class="input-icon">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><rect x="2" y="7" width="20" height="14" rx="2" stroke="#9CA3AF" stroke-width="1.8"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        </span>
                                        <input type="number" id="stok" name="stok"
                                            class="form-input has-icon"
                                            placeholder="Misal: 50"
                                            required min="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Gambar -->
                            <div class="form-group">
                                <label class="form-label" for="gambar_hadiah">Upload Gambar / Ikon</label>
                                <label class="kr-upload-zone" for="gambar_hadiah" id="uploadZone">
                                    <div class="kr-upload-content" id="uploadContent">
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="color:#9CA3AF;margin-bottom:8px;"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><polyline points="17 8 12 3 7 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><line x1="12" y1="3" x2="12" y2="15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        <p class="kr-upload-title">Klik untuk pilih gambar</p>
                                        <p class="kr-upload-hint">PNG, JPG, WEBP — Maks 2 MB</p>
                                    </div>
                                    <img id="imgPreview" class="kr-upload-preview" src="" alt="" style="display:none;">
                                </label>
                                <input type="file" id="gambar_hadiah" name="gambar_hadiah"
                                    class="kr-upload-hidden"
                                    accept="image/png,image/jpeg,image/webp"
                                    onchange="previewImg(this)">
                            </div>

                            <!-- Kategori -->
                            <div class="form-group">
                                <label class="form-label" for="kategori">Kategori Hadiah</label>
                                <select id="kategori" name="kategori" class="form-select">
                                    <option value="">-- Pilih kategori --</option>
                                    <option value="pulsa">Pulsa / Paket Data</option>
                                    <option value="ewallet">E-Wallet (DANA/GoPay/OVO)</option>
                                    <option value="listrik">Token Listrik</option>
                                    <option value="sembako">Sembako</option>
                                    <option value="voucher">Voucher Belanja</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>

                            <!-- Submit -->
                            <button type="submit" name="submit" class="btn-primary">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><polyline points="20 6 9 17 4 12" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Simpan Hadiah
                            </button>

                        </form>
                    </div>
                </div>


                <!-- ─── KOLOM KANAN: Tabel Daftar Reward ─── -->
                <div class="kr-col-table">
                    <div class="kr-panel">

                        <!-- Panel header -->
                        <div class="kr-panel-header">
                            <div class="kr-panel-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><rect x="9" y="3" width="6" height="4" rx="1" stroke="currentColor" stroke-width="2"/><path d="M9 12h6M9 16h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            </div>
                            <div>
                                <h2 class="kr-panel-title">Daftar Reward Aktif</h2>
                                <!-- PHP: echo 'Total ' . $total_hadiah . ' hadiah terdaftar dalam sistem.' -->
                                <p class="kr-panel-sub">Total <strong>24</strong> hadiah terdaftar dalam sistem.</p>
                            </div>
                        </div>

                        <!-- Toolbar -->
                        <div class="kr-toolbar">
                            <div class="search-box kr-search">
                                <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="8" stroke="#9CA3AF" stroke-width="2"/><path d="M21 21l-4.35-4.35" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"/></svg>
                                <input type="text" class="search-input" placeholder="Cari nama hadiah...">
                            </div>
                            <div class="kr-filter-wrap">
                                <select class="kr-filter-select">
                                    <option>Semua Kategori</option>
                                    <option>Pulsa</option>
                                    <option>E-Wallet</option>
                                    <option>Token Listrik</option>
                                    <option>Sembako</option>
                                </select>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" class="kr-select-arrow"><path d="M6 9l6 6 6-6" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        </div>

                        <div class="kr-divider"></div>

                        <!-- Table -->
                        <div class="table-wrapper">
                            <table class="data-table kr-table">
                                <thead>
                                    <tr>
                                        <th class="col-no">NO</th>
                                        <th class="col-img">GAMBAR</th>
                                        <th>NAMA HADIAH</th>
                                        <th class="col-poin">HARGA POIN</th>
                                        <th class="col-stok">STOK</th>
                                        <th class="col-aksi">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- ================================================
                                         PHP LOOP START:
                                         <?php $no=1; while ($row = mysqli_fetch_assoc($result)): ?>
                                         ================================================ -->
                                    <tr>
                                        <td class="td-no">1</td>
                                        <td class="td-img">
                                            <div class="reward-thumb blue">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="5" y="2" width="14" height="20" rx="3" stroke="white" stroke-width="1.8"/><circle cx="12" cy="9" r="2" fill="white"/><path d="M9 18h6" stroke="white" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="td-name">Pulsa Rp 10.000</p>
                                            <p class="td-desc-small">Semua operator</p>
                                        </td>
                                        <td class="td-poin">
                                            <span class="poin-tag">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                                1.000
                                            </span>
                                        </td>
                                        <td class="td-stok"><span class="stok-pill normal">50</span></td>
                                        <td class="td-aksi">
                                            <div class="aksi-cell">
                                                <a href="#" class="btn-aksi btn-edit" title="Edit">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    Edit
                                                </a>
                                                <a href="#" class="btn-aksi btn-delete" title="Hapus" onclick="return confirm('Hapus hadiah ini?')">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M9 6V4h6v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                                    Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="td-no">2</td>
                                        <td class="td-img">
                                            <div class="reward-thumb purple">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="2" y="5" width="20" height="14" rx="2" stroke="white" stroke-width="1.8"/><path d="M2 10h20" stroke="white" stroke-width="1.8" stroke-linecap="round"/><circle cx="6" cy="15" r="1" fill="white"/><path d="M10 15h4" stroke="white" stroke-width="1.8" stroke-linecap="round"/></svg>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="td-name">DANA Rp 25.000</p>
                                            <p class="td-desc-small">Transfer ke dompet digital DANA</p>
                                        </td>
                                        <td class="td-poin">
                                            <span class="poin-tag">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                                2.500
                                            </span>
                                        </td>
                                        <td class="td-stok"><span class="stok-pill normal">32</span></td>
                                        <td class="td-aksi">
                                            <div class="aksi-cell">
                                                <a href="#" class="btn-aksi btn-edit" title="Edit">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    Edit
                                                </a>
                                                <a href="#" class="btn-aksi btn-delete" title="Hapus" onclick="return confirm('Hapus hadiah ini?')">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M9 6V4h6v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                                    Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="td-no">3</td>
                                        <td class="td-img">
                                            <div class="reward-thumb orange">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="td-name">Token Listrik 20kWh</p>
                                            <p class="td-desc-small">Token PLN prabayar semua meteran</p>
                                        </td>
                                        <td class="td-poin">
                                            <span class="poin-tag">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                                6.000
                                            </span>
                                        </td>
                                        <td class="td-stok"><span class="stok-pill low">7</span></td>
                                        <td class="td-aksi">
                                            <div class="aksi-cell">
                                                <a href="#" class="btn-aksi btn-edit" title="Edit">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    Edit
                                                </a>
                                                <a href="#" class="btn-aksi btn-delete" title="Hapus" onclick="return confirm('Hapus hadiah ini?')">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M9 6V4h6v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                                    Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="td-no">4</td>
                                        <td class="td-img">
                                            <div class="reward-thumb green">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><line x1="3" y1="6" x2="21" y2="6" stroke="white" stroke-width="1.8" stroke-linecap="round"/><path d="M16 10a4 4 0 01-8 0" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="td-name">Paket Sembako 5 Kg</p>
                                            <p class="td-desc-small">Beras, gula, minyak goreng</p>
                                        </td>
                                        <td class="td-poin">
                                            <span class="poin-tag">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                                8.000
                                            </span>
                                        </td>
                                        <td class="td-stok"><span class="stok-pill empty">0</span></td>
                                        <td class="td-aksi">
                                            <div class="aksi-cell">
                                                <a href="#" class="btn-aksi btn-edit" title="Edit">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    Edit
                                                </a>
                                                <a href="#" class="btn-aksi btn-delete" title="Hapus" onclick="return confirm('Hapus hadiah ini?')">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M9 6V4h6v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                                    Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- ================================================
                                         PHP LOOP END: <?php $no++; endwhile; ?>
                                         ================================================ -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="table-footer">
                            <span class="table-info">Menampilkan <strong>1–4</strong> dari <strong>24</strong> hadiah</span>
                            <div class="pagination">
                                <button class="page-btn page-prev" disabled>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="15 18 9 12 15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    Previous
                                </button>
                                <button class="page-btn active">1</button>
                                <button class="page-btn">2</button>
                                <button class="page-btn">3</button>
                                <span class="page-ellipsis">...</span>
                                <button class="page-btn">6</button>
                                <button class="page-btn page-next">
                                    Berikutnya
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                            </div>
                        </div>

                    </div><!-- end kr-panel -->
                </div><!-- end kr-col-table -->

            </div><!-- end kr-main-grid -->
        </div><!-- end page-content -->
    </div><!-- end main-content -->
</div><!-- end app-wrapper -->

<?php include 'includes/footer.php'; ?>

<script>
    function previewImg(input) {
        const preview = document.getElementById('imgPreview');
        const content = document.getElementById('uploadContent');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                content.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</body>
</html>
