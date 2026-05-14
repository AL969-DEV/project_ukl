<?php
session_start();
include '../includes/config.php';

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_to_delete = (int)$_GET['id'];
    $stmt = $conn->prepare("DELETE FROM kategori_sampah WHERE id_kategori = ?");
    $stmt->bind_param("i", $id_to_delete);
    if ($stmt->execute()) {
        $_SESSION['success_msg'] = "Kategori berhasil dihapus.";
    } else {
        $_SESSION['error_msg'] = "Gagal menghapus kategori.";
    }
    $stmt->close();
    header("Location: kategori_sampah.php");
    exit();
}

if (!isset($_SESSION['id_account']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$nama_admin = $_SESSION['nama_lengkap'] ?? 'Admin';
$inisial = strtoupper(substr($nama_admin, 0, 1));
$kata = explode(" ", $nama_admin);
if (count($kata) > 1) {
    $inisial = strtoupper(substr($kata[0], 0, 1) . substr($kata[1], 0, 1));
    $inisial = strtoupper(substr($kata[0], 0, 1) . substr($kata[1], 0, 1));
}

$total_kategori = 0;
$poin_tertinggi = 0;
$q_stats = mysqli_query($conn, "SELECT COUNT(*) as total, MAX(poin_per_kg) as max_poin FROM kategori_sampah");
if ($row_stats = mysqli_fetch_assoc($q_stats)) {
    $total_kategori = $row_stats['total'] ?? 0;
    $poin_tertinggi = $row_stats['max_poin'] ?? 0;
}

$query = "SELECT * FROM kategori_sampah ORDER BY id_kategori DESC";
$result = mysqli_query($conn, $query);
$total_data = mysqli_num_rows($result);
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
    
    <div class="main-content">

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
                        <p class="ks-summary-value"><?php echo $total_kategori; ?></p>
                        <p class="ks-summary-label">Total Kategori</p>
                    </div>
                </div>

                <div class="ks-summary-card">
                    <div class="ks-summary-icon" style="background:#ECFDF5;color:#10B981;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <p class="ks-summary-value"><?php echo $total_kategori; ?></p>
                        <p class="ks-summary-label">Kategori Aktif</p>
                    </div>
                </div>

                <div class="ks-summary-card">
                    <div class="ks-summary-icon" style="background:#FFFBEB;color:#F59E0B;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div>
                        <p class="ks-summary-value ks-val-gold"><?php echo number_format($poin_tertinggi, 0, ',', '.'); ?></p>
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

            <?php if (isset($_SESSION['success_msg'])): ?>
                <div style="background-color: #D1FAE5; color: #065F46; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; font-weight: 500;">
                    <?php 
                        echo htmlspecialchars($_SESSION['success_msg']); 
                        unset($_SESSION['success_msg']);
                    ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error_msg'])): ?>
                <div style="background-color: #FEE2E2; color: #B91C1C; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; font-weight: 500;">
                    <?php 
                        echo htmlspecialchars($_SESSION['error_msg']); 
                        unset($_SESSION['error_msg']);
                    ?>
                </div>
            <?php endif; ?>

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
                            <?php if ($total_data > 0): ?>
                                <?php 
                                    $colors = ['blue', 'yellow', 'gray', 'teal', 'purple'];
                                    $i = 0;
                                    while ($row = mysqli_fetch_assoc($result)): 
                                        $color = $colors[$i % count($colors)];
                                        $i++;
                                ?>
                                <tr>
                                    <td class="ks-td-ikon">
                                        <div class="ks-ikon-wrap <?php echo $color; ?>">
                                            <span style="color: white; font-weight: bold; font-size: 16px;">
                                                <?php echo strtoupper(substr($row['nama_sampah'], 0, 1)); ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="ks-nama"><?php echo htmlspecialchars($row['nama_sampah']); ?></p>
                                        <p class="ks-kode">KAT-<?php echo str_pad($row['id_kategori'], 3, '0', STR_PAD_LEFT); ?></p>
                                    </td>
                                    <td class="ks-td-poin">
                                        <span class="ks-poin-badge">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                            <?php echo number_format($row['poin_per_kg'], 0, ',', '.'); ?>
                                        </span>
                                        <span class="ks-poin-unit">Poin/Kg</span>
                                    </td>
                                    <td class="ks-td-desc" style="max-width: 250px; white-space: normal; line-height: 1.4;">
                                        <?php echo !empty($row['deskripsi']) ? htmlspecialchars($row['deskripsi']) : '-'; ?>
                                    </td>
                                    <td class="ks-td-vol">
                                        0 Kg
                                    </td>
                                    <td class="ks-td-status">
                                        <span class="status-badge aktif">● Aktif</span>
                                    </td>
                                    <td class="ks-td-aksi">
                                        <div class="aksi-cell">
                                            <a href="crud_kategori_sampah.php?id=<?php echo $row['id_kategori']; ?>" class="btn-aksi btn-edit" title="Edit">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                            </a>
                                            <a href="kategori_sampah.php?action=delete&id=<?php echo $row['id_kategori']; ?>" class="btn-aksi btn-delete" title="Hapus" onclick="return confirm('Anda yakin ingin menghapus kategori <?php echo htmlspecialchars($row['nama_sampah']); ?>?');">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M9 6V4h6v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 24px;">Belum ada kategori sampah yang ditambahkan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                <div class="table-footer">
                    <span class="table-info">
                        Menampilkan <strong><?php echo $total_data; ?></strong> dari <strong><?php echo $total_data; ?></strong> kategori
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
