<?php
session_start();

if (!isset($_SESSION['id_account']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$bulan = array(
    1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
);
$tanggal_hari_ini = date('j') . ' ' . $bulan[(int)date('m')] . ' ' . date('Y');

include '../includes/config.php';

// Summary queries
$query_total = "SELECT COUNT(*) as total_transaksi, SUM(berat) as total_berat, SUM(poin) as total_poin FROM transaksi_setor";
$result_total = mysqli_query($conn, $query_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_transaksi = $row_total['total_transaksi'] ?? 0;
$total_berat = $row_total['total_berat'] ?? 0;
$total_poin = $row_total['total_poin'] ?? 0;

$query_pending = "SELECT COUNT(*) as menunggu_konfirmasi FROM transaksi_setor WHERE status = 'pending'";
$result_pending = mysqli_query($conn, $query_pending);
$row_pending = mysqli_fetch_assoc($result_pending);
$menunggu_konfirmasi = $row_pending['menunggu_konfirmasi'] ?? 0;

$query_today = "SELECT COUNT(*) as jumlah_transaksi, SUM(berat) as berat_hari_ini FROM transaksi_setor WHERE DATE(tgl_setor) = CURDATE()";
$result_today = mysqli_query($conn, $query_today);
$row_today = mysqli_fetch_assoc($result_today);
$jumlah_transaksi = $row_today['jumlah_transaksi'] ?? 0;
$berat_hari_ini = $row_today['berat_hari_ini'] ?? 0;

$query_status_count = "SELECT status, COUNT(*) as count FROM transaksi_setor WHERE DATE(tgl_setor) = CURDATE() GROUP BY status";
$result_status_count = mysqli_query($conn, $query_status_count);
$status_counts = ['selesai' => 0, 'diproses' => 0, 'pending' => 0];
while($row = mysqli_fetch_assoc($result_status_count)) {
    if(strtolower($row['status']) == 'claimed') {
        $status_counts['selesai'] += $row['count'];
    } elseif(strtolower($row['status']) == 'pending') {
        $status_counts['pending'] += $row['count'];
    } else {
        $status_counts['diproses'] += $row['count'];
    }
}

// Pagination logic
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$total_pages = ceil($total_transaksi / $limit);
if ($page > $total_pages && $total_pages > 0) $page = $total_pages;
$offset = ($page - 1) * $limit;

// Transaction data query
$query_trx = "SELECT ts.*, n.nama_lengkap, n.id_nasabah, ks.nama_sampah, ks.poin_per_kg 
              FROM transaksi_setor ts
              LEFT JOIN nasabah n ON ts.id_profile = n.id_nasabah
              LEFT JOIN kategori_sampah ks ON ts.id_kategori = ks.id_kategori
              ORDER BY ts.tgl_setor DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query_trx);
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

        <?php include '../includes/header_admin.php'; ?>

        <!-- PAGE CONTENT -->
        <div class="page-content">

            <!-- ── Page Title Row ── -->
            <div class="ts-title-row">
                <div>
                    <p class="page-breadcrumb-text">Transaksi Setoran</p>
                    <h1 class="page-title">Riwayat &amp; Transaksi Setoran</h1>
                    <p class="page-subtitle">Pantau dan kelola semua aktifitas setoran sampah nasabah secara real-time</p>
                </div>
            </div>

            <div class="ts-summary-row">
                <div class="ts-summary-card">
                    <div class="ts-summary-icon" style="background:#EFF6FF;color:#3B82F6;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/><path d="M3 10h18M8 2v4M16 2v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div class="ts-summary-body">
                        <p class="ts-summary-value"><?php echo number_format($total_transaksi, 0, ',', '.'); ?></p>
                        <p class="ts-summary-label">Total Transaksi</p>
                        <span class="ts-trend up">▲ Real-time</span>
                    </div>
                </div>

                <div class="ts-summary-card">
                    <div class="ts-summary-icon" style="background:#F0FDF4;color:#16A34A;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M12 3C8 3 5 6 5 10c0 3.5 2.5 6.5 7 10 4.5-3.5 7-6.5 7-10 0-4-3-7-7-7z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><circle cx="12" cy="10" r="2" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <div class="ts-summary-body">
                        <p class="ts-summary-value"><?php echo number_format($total_berat, 2, ',', '.'); ?> <span class="ts-unit">Kg</span></p>
                        <p class="ts-summary-label">Total Berat (Kg)</p>
                        <span class="ts-trend up">▲ Real-time</span>
                    </div>
                </div>

                <div class="ts-summary-card">
                    <div class="ts-summary-icon" style="background:#FFFBEB;color:#F59E0B;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div class="ts-summary-body">
                        <p class="ts-summary-value ts-val-gold"><?php echo number_format($total_poin, 0, ',', '.'); ?></p>
                        <p class="ts-summary-label">Total Poin Diberikan</p>
                        <span class="ts-trend up">▲ Real-time</span>
                    </div>
                </div>

                <div class="ts-summary-card ts-summary-card-alert">
                    <div class="ts-summary-icon" style="background:#FEF2F2;color:#DC2626;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><polyline points="12 6 12 12 16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="ts-summary-body">
                        <p class="ts-summary-value ts-val-red"><?php echo $menunggu_konfirmasi; ?></p>
                        <p class="ts-summary-label">Menunggu Konfirmasi</p>
                        <span class="ts-alert-pill">● Perlu Tindakan</span>
                    </div>
                </div>
            </div>

            <div class="ts-info-strip">
                <div class="ts-info-left">
                    <span class="ts-info-dot"></span>
                    Ringkasan hari ini <strong>(<?php echo $tanggal_hari_ini; ?>)</strong> – Total setoran masuk:
                    <strong><?php echo number_format($berat_hari_ini, 2, ',', '.'); ?> Kg</strong> dari <strong><?php echo $jumlah_transaksi; ?> transaksi</strong>
                </div>
                <div class="ts-info-right">
                    <span class="ts-chip selesai"><?php echo $status_counts['selesai']; ?> Selesai</span>
                    <span class="ts-chip diproses"><?php echo $status_counts['diproses']; ?> Diproses</span>
                    <span class="ts-chip pending"><?php echo $status_counts['pending']; ?> Pending</span>
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

                                <?php if(mysqli_num_rows($result) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)): 
                                        $poin = $row['poin'] > 0 ? $row['poin'] : ($row['berat'] * ($row['poin_per_kg'] ?? 0));
                                        
                                        $nama_parts = explode(' ', trim($row['nama_lengkap'] ?? 'Nasabah'));
                                        $initials = strtoupper(substr($nama_parts[0], 0, 1));
                                        if (count($nama_parts) > 1) {
                                            $initials .= strtoupper(substr($nama_parts[1], 0, 1));
                                        }
                                        
                                        $status_class = strtolower($row['status']) == 'claimed' ? 'selesai' : 'pending';
                                        $status_text = strtolower($row['status']) == 'claimed' ? 'Selesai' : 'Pending';
                                        
                                        $kategori_class = strtolower(explode(' ', $row['nama_sampah'] ?? '')[0]);
                                        if (!in_array($kategori_class, ['plastik', 'kertas', 'logam', 'kaca'])) {
                                            $kategori_class = 'plastik';
                                        }

                                        $tgl = strtotime($row['tgl_setor']);
                                        $tgl_date = date('j M Y', $tgl);
                                        $tgl_time = date('H:i', $tgl);
                                    ?>
                                    <tr>
                                        <td class="ts-td-cb"><input type="checkbox" class="ts-cb"></td>
                                        <td class="ts-td-id">#TRX-<?php echo str_pad($row['id_setor'], 4, '0', STR_PAD_LEFT); ?></td>
                                        <td class="ts-td-tgl">
                                            <p class="ts-tgl-date"><?php echo $tgl_date; ?></p>
                                            <p class="ts-tgl-time"><?php echo $tgl_time; ?></p>
                                        </td>
                                        <td>
                                            <div class="nasabah-cell">
                                                <div class="nasabah-avatar" style="background:#DCFCE7;color:#16A34A;"><?php echo $initials; ?></div>
                                                <div class="nasabah-info">
                                                    <span class="nasabah-name"><?php echo htmlspecialchars($row['nama_lengkap'] ?? 'Nasabah'); ?></span>
                                                    <span class="nasabah-id">NSB-<?php echo str_pad($row['id_nasabah'] ?? 0, 4, '0', STR_PAD_LEFT); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="ts-kat-badge <?php echo $kategori_class; ?>">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                                            <?php echo htmlspecialchars($row['nama_sampah'] ?? 'Lainnya'); ?>
                                        </span></td>
                                        <td class="ts-td-berat"><?php echo number_format($row['berat'], 2, ',', '.'); ?> <span class="ts-unit-small">kg</span></td>
                                        <td class="ts-td-poin">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                            <?php echo number_format($poin, 0, ',', '.'); ?>
                                        </td>
                                        <td><span class="status-badge <?php echo $status_class; ?>">● <?php echo $status_text; ?></span></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 20px;">Belum ada transaksi.</td>
                                    </tr>
                                <?php endif; ?>

                                <?php endwhile; ?>

                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                <div class="table-footer" style="margin: 0; padding: 16px 20px; border-top: 1px solid var(--border-color);">
                    <span class="table-info">
                        Menampilkan transaksi <strong><?php echo ($total_transaksi > 0) ? $offset + 1 : 0; ?>–<?php echo min($offset + $limit, $total_transaksi); ?></strong> dari total <strong><?php echo number_format($total_transaksi, 0, ',', '.'); ?></strong>
                    </span>

                    <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>" class="page-btn" style="text-decoration:none; width:auto; padding:0 12px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" style="transform: rotate(180deg); margin-right: 4px; vertical-align: middle;"><polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Sebelumnya
                            </a>
                        <?php endif; ?>

                        <?php 
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);
                        
                        if ($start_page > 1): ?>
                            <a href="?page=1" class="page-btn" style="text-decoration:none;">1</a>
                            <?php if ($start_page > 2): ?>
                                <span class="page-ellipsis">...</span>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                            <a href="?page=<?php echo $i; ?>" class="page-btn <?php echo ($i == $page) ? 'active' : ''; ?>" style="text-decoration:none;"><?php echo $i; ?></a>
                        <?php endfor; ?>

                        <?php if ($end_page < $total_pages): ?>
                            <?php if ($end_page < $total_pages - 1): ?>
                                <span class="page-ellipsis">...</span>
                            <?php endif; ?>
                            <a href="?page=<?php echo $total_pages; ?>" class="page-btn" style="text-decoration:none;"><?php echo $total_pages; ?></a>
                        <?php endif; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?>" class="page-btn page-next" style="text-decoration:none; width:auto; padding:0 12px;">
                                Berikutnya
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" style="margin-left: 4px; vertical-align: middle;"><polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>

            </div><!-- end ts-table-panel -->

        </div><!-- end page-content -->
    </div><!-- end main-content -->
</div><!-- end app-wrapper -->

</body>
</html>
