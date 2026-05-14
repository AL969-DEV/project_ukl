<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$nama_admin = $_SESSION['nama_lengkap'] ?? 'Admin';

// Mengambil inisial (contoh: 'Budi Santoso' -> 'BS')
$inisial = strtoupper(substr($nama_admin, 0, 1));
$kata = explode(" ", $nama_admin);
if (count($kata) > 1) {
    $inisial = strtoupper(substr($kata[0], 0, 1) . substr($kata[1], 0, 1));
}

include '../includes/config.php';

// Menghitung total nasabah nyata dari database
$query_nasabah = "SELECT COUNT(*) as total FROM nasabah";
$result_nasabah = mysqli_query($conn, $query_nasabah);
$row_nasabah = mysqli_fetch_assoc($result_nasabah);
$total_nasabah = $row_nasabah['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel – SolusiSampah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/solusi_sampah/css/dashboard_admin.css">
</head>
<body>

<div class="app-wrapper">

    <?php $active_page = 'dashboard'; include '../includes/sidebar_admin.php'; ?>

    <!-- ===================== MAIN CONTENT ===================== -->
    <div class="main-content">

        <!-- TOP HEADER -->
        <header class="top-header">
            <div class="header-left">
                <span class="header-breadcrumb"><span style="color:var(--green-primary);font-weight:800;">Admin</span> Panel</span>
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
                        <span class="user-role">Super Admin</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <div class="page-content">

            <!-- Page Title -->
            <div class="page-title-section">
                <p class="page-breadcrumb-text">Dashboard</p>
                <h1 class="page-title">Selamat Datang, <?php echo htmlspecialchars($nama_admin); ?></h1>
                <p class="page-subtitle">Ringkasan aktivitas bank sampah hari ini–Kamis, 17 April 2026</p>
            </div>

            <!-- STAT CARDS ROW -->
            <div class="stat-cards-row">
                <div class="stat-card">
                    <div class="stat-card-icon blue">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="7" r="4" stroke="#3B82F6" stroke-width="2"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="stat-card-body">
                        <p class="stat-card-value"><?php echo number_format($total_nasabah, 0, ',', '.'); ?></p>
                        <p class="stat-card-label blue">Total Nasabah</p>
                        <p class="stat-card-sub">Data real time</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-icon green">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 3C8 3 5 6 5 10c0 3.5 2.5 6.5 7 10 4.5-3.5 7-6.5 7-10 0-4-3-7-7-7z" stroke="#16A34A" stroke-width="2" stroke-linejoin="round"/><path d="M12 10v0m0 0a2 2 0 100-4 2 2 0 000 4z" stroke="#16A34A" stroke-width="2"/></svg>
                    </div>
                    <div class="stat-card-body">
                        <p class="stat-card-value">10.356 <span class="stat-unit">Kg</span></p>
                        <p class="stat-card-label green">Total Sampah Terkumpul</p>
                        <p class="stat-card-sub">Setoran bulan ini: 1.148 Kg</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-icon yellow">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="#EAB308" stroke-width="2" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="stat-card-body">
                        <p class="stat-card-value">786.000</p>
                        <p class="stat-card-label yellow">Total Poin Beredar</p>
                        <p class="stat-card-sub">Poin di-redeem bulan ini: 18.500</p>
                    </div>
                </div>
            </div>

            <!-- CATEGORY WEIGHT CARDS ROW -->
            <div class="category-cards-row">
                <div class="category-card plastik">
                    <p class="category-card-label">Plastik</p>
                    <p class="category-card-value">7.879 Kg</p>
                </div>
                <div class="category-card kertas">
                    <p class="category-card-label">Kertas</p>
                    <p class="category-card-value">3.267 Kg</p>
                </div>
                <div class="category-card logam">
                    <p class="category-card-label">Logam</p>
                    <p class="category-card-value">6.823 Kg</p>
                </div>
                <div class="category-card kaca">
                    <p class="category-card-label">Kaca & Lainnya</p>
                    <p class="category-card-value">5.287 Kg</p>
                </div>
            </div>

            <!-- BOTTOM SECTION: QR Generator + Recent Transactions -->
            <div class="bottom-section">

                <!-- QR Code Generator Panel -->
                <div class="panel qr-panel">
                    <div class="panel-header">
                        <h2 class="panel-title">Generate QR Code</h2>
                        <span class="panel-badge-green">Setoran Baru</span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">ID Nasabah</label>
                        <input type="text" class="form-input" placeholder="Contoh: NSB-2024-2025">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Kategori Sampah</label>
                            <select class="form-select">
                                <option value="">-- Pilih kategori --</option>
                                <option value="plastik">Plastik</option>
                                <option value="kertas">Kertas</option>
                                <option value="logam">Logam</option>
                                <option value="kaca">Kaca & Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Berat (Kg)</label>
                            <input type="number" class="form-input" placeholder="0.00">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catatan (opsional)</label>
                        <input type="text" class="form-input" placeholder="Tambahkan catatan...">
                    </div>
                    <button class="btn-generate">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M3 7V5a2 2 0 012-2h2M17 3h2a2 2 0 012 2v2M21 17v2a2 2 0 01-2 2h-2M7 21H5a2 2 0 01-2-2v-2" stroke="white" stroke-width="2" stroke-linecap="round"/><rect x="7" y="7" width="4" height="4" rx="0.5" stroke="white" stroke-width="1.5"/><rect x="13" y="7" width="4" height="4" rx="0.5" stroke="white" stroke-width="1.5"/><rect x="7" y="13" width="4" height="4" rx="0.5" stroke="white" stroke-width="1.5"/><rect x="13" y="13" width="4" height="4" rx="0.5" stroke="white" stroke-width="1.5"/></svg>
                        Generate QR Code
                    </button>
                </div>

                <!-- Recent Transactions Panel -->
                <div class="panel transactions-panel">
                    <div class="panel-header">
                        <div>
                            <h2 class="panel-title">Transaksi Terbaru</h2>
                            <p class="panel-subtitle">12 Transaksi menunggu konfirmasi</p>
                        </div>
                        <div class="tab-group">
                            <button class="tab-btn active">Semua</button>
                            <button class="tab-btn">Hari ini</button>
                            <button class="tab-btn">Selesai</button>
                        </div>
                    </div>

                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID TRANSAKSI</th>
                                    <th>NAMA NASABAH</th>
                                    <th>JENIS SAMPAH</th>
                                    <th>BERAT</th>
                                    <th>POIN</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- =========================================================
                                     PHP LOOP START: Ganti blok <tr> di bawah dengan:
                                     <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                     dan ubah nilai dummy dengan echo $row['kolom']
                                     ========================================================= -->

                                <tr>
                                    <td class="trx-id">#TRX-4821</td>
                                    <td>
                                        <div class="nasabah-cell">
                                            <div class="nasabah-avatar" style="background-color: #FEE2E2; color: #DC2626;">SR</div>
                                            <div class="nasabah-info">
                                                <span class="nasabah-name">Siti Rahayu</span>
                                                <span class="nasabah-id">NSB-2024-0081</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge-jenis plastik">Plastik</span></td>
                                    <td class="berat-cell">2.2 Kg</td>
                                    <td class="poin-cell"><span class="star-icon">&#9733;</span> 160</td>
                                    <td><span class="status-badge selesai">Selesai</span></td>
                                </tr>

                                <tr>
                                    <td class="trx-id">#TRX-4820</td>
                                    <td>
                                        <div class="nasabah-cell">
                                            <div class="nasabah-avatar" style="background-color: #DCFCE7; color: #16A34A;">BW</div>
                                            <div class="nasabah-info">
                                                <span class="nasabah-name">Budi Wahyono</span>
                                                <span class="nasabah-id">NSB-2024-0047</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge-jenis kertas">Kertas</span></td>
                                    <td class="berat-cell">5.8 Kg</td>
                                    <td class="poin-cell"><span class="star-icon">&#9733;</span> 256</td>
                                    <td><span class="status-badge diproses">Diproses</span></td>
                                </tr>

                                <tr>
                                    <td class="trx-id">#TRX-4819</td>
                                    <td>
                                        <div class="nasabah-cell">
                                            <div class="nasabah-avatar" style="background-color: #FEF3C7; color: #B45309;">DN</div>
                                            <div class="nasabah-info">
                                                <span class="nasabah-name">Dewi Novita</span>
                                                <span class="nasabah-id">NSB-2024-0112</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge-jenis logam">Logam</span></td>
                                    <td class="berat-cell">1.5 Kg</td>
                                    <td class="poin-cell"><span class="star-icon">&#9733;</span> 120</td>
                                    <td><span class="status-badge diproses">Diproses</span></td>
                                </tr>

                                <tr>
                                    <td class="trx-id">#TRX-4818</td>
                                    <td>
                                        <div class="nasabah-cell">
                                            <div class="nasabah-avatar" style="background-color: #D1FAE5; color: #065F46;">AP</div>
                                            <div class="nasabah-info">
                                                <span class="nasabah-name">Ahmad Pratama</span>
                                                <span class="nasabah-id">NSB-2024-0112</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge-jenis kaca">Kaca</span></td>
                                    <td class="berat-cell">4.0 Kg</td>
                                    <td class="poin-cell"><span class="star-icon">&#9733;</span> 200</td>
                                    <td><span class="status-badge selesai">Selesai</span></td>
                                </tr>
                                     PHP LOOP END: <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-footer">
                        <span class="table-info">Menampilkan 4 dari 12 transaksi</span>
                        <div class="pagination">
                            <button class="page-btn active">1</button>
                            <button class="page-btn">2</button>
                            <button class="page-btn">3</button>
                            <button class="page-btn page-next">&#8250;</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>
