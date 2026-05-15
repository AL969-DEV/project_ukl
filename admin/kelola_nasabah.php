<?php
session_start();
include '../includes/config.php';

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

// Ambil data nasabah dari database
$query = "SELECT * FROM nasabah ORDER BY id_nasabah DESC";
$result = mysqli_query($conn, $query);
$total_nasabah = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Nasabah – SolusiSampah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard_admin.css">
    <link rel="stylesheet" href="../css/kelola_nasabah.css">
</head>
<body>

<div class="app-wrapper">

    <?php $active_page = 'nasabah'; include '../includes/sidebar_admin.php'; ?>

    <!-- ===================== MAIN CONTENT ===================== -->
    <div class="main-content">

        <!-- TOP HEADER -->
        <header class="top-header">
            <div class="header-left">
                <span class="header-breadcrumb"><span style="color: var(--green-primary); font-weight:800;">Admin</span> Panel</span>
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
            <div class="page-title-row">
                <div class="page-title-section">
                    <p class="page-breadcrumb-text">Kelola Nasabah</p>
                    <h1 class="page-title">Daftar Nasabah</h1>
                    <p class="page-subtitle">Kelola daftar nasabah terdaftar – <?php echo $total_nasabah; ?> nasabah aktif</p>
                </div>
                <a href="crud_kelola_nasabah.php" class="btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><line x1="12" y1="5" x2="12" y2="19" stroke="white" stroke-width="2.5" stroke-linecap="round"/><line x1="5" y1="12" x2="19" y2="12" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>
                    Tambah Nasabah Baru
                </a>
            </div>

            <div class="summary-cards-row">
                <div class="summary-card">
                    <div class="summary-card-icon" style="background-color: #FEF3C7;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="#D97706" stroke-width="2" stroke-linecap="round"/><circle cx="9" cy="7" r="4" stroke="#D97706" stroke-width="2"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="#D97706" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div class="summary-card-body">
                        <p class="summary-card-value"><?php echo $total_nasabah; ?></p>
                        <p class="summary-card-label">Total Nasabah</p>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-card-icon" style="background-color: #ECFDF5;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#16A34A" stroke-width="2"/><path d="M9 12l2 2 4-4" stroke="#16A34A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="summary-card-body">
                        <p class="summary-card-value">221</p>
                        <p class="summary-card-label">Nasabah Aktif</p>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-card-icon" style="background-color: #EFF6FF;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="#3B82F6" stroke-width="2"/><path d="M3 10h18" stroke="#3B82F6" stroke-width="2"/><path d="M8 2v4M16 2v4" stroke="#3B82F6" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div class="summary-card-body">
                        <p class="summary-card-value">12</p>
                        <p class="summary-card-label">Bergabung Bulan Ini</p>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-card-icon" style="background-color: #FFFBEB;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="#F59E0B" stroke-width="2" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="summary-card-body">
                        <p class="summary-card-value" style="color: #F59E0B;">892K</p>
                        <p class="summary-card-label">Total poin beredar</p>
                    </div>
                </div>
            </div>

            <!-- TABLE PANEL -->
            <div class="table-panel">

                <!-- TOOLBAR -->
                <div class="toolbar">
                    <div class="toolbar-left">
                        <div class="search-box toolbar-search">
                            <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="8" stroke="#9CA3AF" stroke-width="2"/><path d="M21 21l-4.35-4.35" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"/></svg>
                            <input type="text" class="search-input" placeholder="Cari Nama">
                        </div>

                        <div class="filter-select-wrapper">
                            <select class="filter-select">
                                <option value="">Semua Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Non-Aktif</option>
                            </select>
                            <svg class="filter-select-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>

                        <div class="filter-select-wrapper">
                            <select class="filter-select">
                                <option value="">Semua Wilayah</option>
                                <option value="utara">Surabaya Utara</option>
                                <option value="selatan">Surabaya Selatan</option>
                                <option value="timur">Surabaya Timur</option>
                                <option value="barat">Surabaya Barat</option>
                            </select>
                            <svg class="filter-select-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>

                        <div class="filter-select-wrapper">
                            <select class="filter-select">
                                <option value="terbaru">Urutkan: Terbaru</option>
                                <option value="terlama">Urutkan: Terlama</option>
                                <option value="poin_tertinggi">Poin Tertinggi</option>
                                <option value="poin_terendah">Poin Terendah</option>
                            </select>
                            <svg class="filter-select-arrow" width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>

                    <div class="toolbar-right">
                        <button class="btn-export">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><polyline points="7 10 12 15 17 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><line x1="12" y1="15" x2="12" y2="3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            Export
                        </button>
                    </div>
                </div>

                <!-- DATA TABLE -->
                <div class="table-wrapper">
                    <table class="data-table nasabah-table">
                        <thead>
                            <tr>
                                <th class="col-check">
                                    <input type="checkbox" class="cb-all">
                                </th>
                                <th>NASABAH</th>
                                <th>KONTAK</th>
                                <th>SALDO POIN</th>
                                <th>TOTAL SAMPAH</th>
                                <th>STATUS</th>
                                <th>BERGABUNG</th>
                                <th class="col-aksi">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if ($total_nasabah > 0): 
                                while ($row = mysqli_fetch_assoc($result)): 
                                    // Membuat inisial nama
                                    $nama_parts = explode(' ', trim($row['nama_lengkap']));
                                    $initials = strtoupper(substr($nama_parts[0], 0, 1));
                                    if (count($nama_parts) > 1) {
                                        $initials .= strtoupper(substr($nama_parts[1], 0, 1));
                                    }
                            ?>
                            <tr>
                                <td class="col-check"><input type="checkbox"></td>
                                <td>
                                    <div class="nasabah-cell">
                                        <div class="nasabah-avatar" style="background-color:#DCFCE7; color:#16A34A;"><?php echo $initials; ?></div>
                                        <div class="nasabah-info">
                                            <span class="nasabah-name"><?php echo htmlspecialchars($row['nama_lengkap']); ?></span>
                                            <span class="nasabah-id">NSB-<?php echo str_pad($row['id_nasabah'], 4, '0', STR_PAD_LEFT); ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="kontak-cell">
                                        <span class="kontak-email"><?php echo htmlspecialchars($row['email'] ?? '-'); ?></span>
                                        <span class="kontak-phone"><?php echo htmlspecialchars($row['no_telp'] ?? '-'); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="poin-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        <span class="poin-value"><?php echo number_format($row['total_poin'], 0, ',', '.'); ?></span>
                                    </div>
                                </td>
                                <td class="sampah-cell">0 <span class="unit">kg</span></td>
                                <td><span class="status-badge aktif">Aktif</span></td>
                                <td class="bergabung-cell">Baru</td>
                                <td>
                                    <div class="aksi-cell">
                                        <a href="#" class="btn-aksi btn-detail" title="Detail">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                                        </a>
                                        <a href="#" class="btn-aksi btn-edit" title="Edit">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </a>
                                        <a href="#" class="btn-aksi btn-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus nasabah ini?')">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M9 6V4h6v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                                endwhile; 
                            else:
                            ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 20px;">Belum ada data nasabah.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- TABLE FOOTER / PAGINATION -->
                <div class="table-footer">
                    <span class="table-info">Menampilkan <strong>1–9</strong> dari <strong>248</strong> nasabah</span>
                    <div class="pagination">
                        <button class="page-btn page-prev" disabled>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="15 18 9 12 15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Previous
                        </button>
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

            </div><!-- end table-panel -->

        </div><!-- end page-content -->
    </div><!-- end main-content -->
</div><!-- end app-wrapper -->

</body>
</html>
