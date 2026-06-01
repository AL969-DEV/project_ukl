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

// Transaction data query (all transactions for client-side filtering)
$query_trx = "SELECT ts.*, n.nama_lengkap, n.id_nasabah, ks.nama_sampah, ks.poin_per_kg 
              FROM transaksi_setor ts
              LEFT JOIN nasabah n ON ts.id_profile = n.id_nasabah
              LEFT JOIN kategori_sampah ks ON ts.id_kategori = ks.id_kategori
              ORDER BY ts.tgl_setor DESC";
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
                                <tr data-id="#TRX-<?php echo str_pad($row['id_setor'], 4, '0', STR_PAD_LEFT); ?>"
                                    data-date="<?php echo date('Y-m-d H:i:s', $tgl); ?>"
                                    data-nasabah="<?php echo htmlspecialchars($row['nama_lengkap'] ?? ''); ?>"
                                    data-kategori="<?php echo htmlspecialchars($row['nama_sampah'] ?? ''); ?>"
                                    data-berat="<?php echo $row['berat']; ?>"
                                    data-poin="<?php echo $poin; ?>"
                                    data-status="<?php echo $status_text; ?>">
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
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                <div class="table-footer" style="margin: 0; padding: 16px 20px; border-top: 1px solid var(--border-color);">
                    <span class="table-info"></span>
                    <div class="pagination"></div>
                </div>

            </div><!-- end ts-table-panel -->

        </div><!-- end page-content -->
    </div><!-- end main-content -->
</div><!-- end app-wrapper -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const itemsPerPage = 10;
    let currentPage = 1;

    const tableBody = document.querySelector('.ts-table tbody');
    const allRows = Array.from(tableBody.querySelectorAll('tr')).filter(row => !row.querySelector('td[colspan]'));
    
    const tableInfo = document.querySelector('.table-info');
    const paginationDiv = document.querySelector('.table-footer .pagination');

    function updateTable() {
        const totalItems = allRows.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);

        if (currentPage > totalPages) currentPage = totalPages || 1;
        if (currentPage < 1) currentPage = 1;

        allRows.forEach(row => row.style.display = 'none');

        if (totalItems === 0) {
            tableInfo.innerHTML = 'Menampilkan <strong>0</strong> - <strong>0</strong> dari <strong>0</strong> transaksi';
            paginationDiv.innerHTML = '';
            return;
        }

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, totalItems);

        for (let i = startIndex; i < endIndex; i++) {
            allRows[i].style.display = '';
        }

        tableInfo.innerHTML = `Menampilkan transaksi <strong>${startIndex + 1}–${endIndex}</strong> dari total <strong>${totalItems}</strong>`;
        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        if (totalPages <= 1) {
            paginationDiv.innerHTML = '';
            return;
        }

        let html = '';

        // Previous
        if (currentPage > 1) {
            html += `<button class="page-btn" data-page="${currentPage - 1}" style="width:auto; padding:0 12px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" style="transform: rotate(180deg); margin-right: 4px; vertical-align: middle;"><polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Sebelumnya
            </button>`;
        } else {
            html += `<button class="page-btn" disabled style="width:auto; padding:0 12px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" style="transform: rotate(180deg); margin-right: 4px; vertical-align: middle;"><polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Sebelumnya
            </button>`;
        }

        // Page window logic
        let pagesToShow = [];
        if (totalPages <= 7) {
            for (let p = 1; p <= totalPages; p++) {
                pagesToShow.push(p);
            }
        } else {
            if (currentPage <= 4) {
                pagesToShow = [1, 2, 3, 4, 5, '...', totalPages];
            } else if (currentPage >= totalPages - 3) {
                pagesToShow = [1, '...'];
                for (let p = totalPages - 4; p <= totalPages; p++) {
                    pagesToShow.push(p);
                }
            } else {
                pagesToShow = [1, '...', currentPage - 1, currentPage, currentPage + 1, '...', totalPages];
            }
        }

        pagesToShow.forEach(p => {
            if (p === '...') {
                html += `<span class="page-ellipsis">...</span>`;
            } else {
                html += `<button class="page-btn ${p === currentPage ? 'active' : ''}" data-page="${p}">${p}</button>`;
            }
        });

        // Next
        if (currentPage < totalPages) {
            html += `<button class="page-btn page-next" data-page="${currentPage + 1}" style="width:auto; padding:0 12px;">
                Berikutnya
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" style="margin-left: 4px; vertical-align: middle;"><polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>`;
        } else {
            html += `<button class="page-btn page-next" disabled style="width:auto; padding:0 12px;">
                Berikutnya
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" style="margin-left: 4px; vertical-align: middle;"><polyline points="9 18 15 12 9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>`;
        }

        paginationDiv.innerHTML = html;

        paginationDiv.querySelectorAll('.page-btn[data-page]').forEach(btn => {
            btn.addEventListener('click', function() {
                currentPage = parseInt(this.getAttribute('data-page'));
                updateTable();
            });
        });
    }

    // Initial load
    updateTable();
});
</script>

</body>
</html>
