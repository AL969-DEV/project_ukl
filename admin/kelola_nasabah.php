<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['id_account']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

// Handle Delete Nasabah
if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    // Ambil id_account untuk menghapus akun login juga
    $q_acc = mysqli_query($conn, "SELECT id_account FROM nasabah WHERE id_nasabah = $id_hapus");
    if ($q_acc && mysqli_num_rows($q_acc) > 0) {
        $row_acc = mysqli_fetch_assoc($q_acc);
        $id_acc = $row_acc['id_account'];
        
        mysqli_begin_transaction($conn);
        try {
            mysqli_query($conn, "DELETE FROM nasabah WHERE id_nasabah = $id_hapus");
            mysqli_query($conn, "DELETE FROM accounts WHERE id_account = $id_acc");
            mysqli_commit($conn);
            echo "<script>alert('Data nasabah berhasil dihapus!'); window.location.href='kelola_nasabah.php';</script>";
            exit;
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo "<script>alert('Gagal menghapus nasabah: " . mysqli_error($conn) . "'); window.location.href='kelola_nasabah.php';</script>";
        }
    }
}

// Total Poin Beredar
$q_poin = mysqli_query($conn, "SELECT SUM(total_poin) as sum_poin FROM nasabah");
$row_poin = mysqli_fetch_assoc($q_poin);
$total_poin_beredar = $row_poin['sum_poin'] ?? 0;

// Ambil data nasabah dan total sampahnya
$query = "SELECT n.*, a.username, 
          (SELECT SUM(berat) FROM transaksi_setor ts WHERE ts.id_profile = n.id_nasabah AND ts.status = 'claimed') as total_sampah 
          FROM nasabah n 
          LEFT JOIN accounts a ON n.id_account = a.id_account
          ORDER BY n.id_nasabah DESC";
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

        <?php include '../includes/header_admin.php'; ?>

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
                        <p class="summary-card-value"><?php echo $total_nasabah; ?></p>
                        <p class="summary-card-label">Nasabah Aktif</p>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-card-icon" style="background-color: #EFF6FF;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="#3B82F6" stroke-width="2"/><path d="M3 10h18" stroke="#3B82F6" stroke-width="2"/><path d="M8 2v4M16 2v4" stroke="#3B82F6" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div class="summary-card-body">
                        <p class="summary-card-value">-</p>
                        <p class="summary-card-label">Bergabung Bulan Ini</p>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-card-icon" style="background-color: #FFFBEB;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="#F59E0B" stroke-width="2" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="summary-card-body">
                        <p class="summary-card-value" style="color: #F59E0B;"><?php echo number_format($total_poin_beredar, 0, ',', '.'); ?></p>
                        <p class="summary-card-label">Total poin beredar</p>
                    </div>
                </div>
            </div>

            <!-- TABLE PANEL -->
            <div class="table-panel">

                <!-- TOOLBAR -->
                <div class="toolbar">
                    <div class="toolbar-left" style="width: 100%;">
                        <div class="search-box toolbar-search" style="margin: 0; max-width: 300px;">
                            <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="8" stroke="#9CA3AF" stroke-width="2"/><path d="M21 21l-4.35-4.35" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"/></svg>
                            <input type="text" id="searchInput" class="search-input" placeholder="Cari Nama Nasabah..." onkeyup="searchTable()">
                        </div>
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
                                        <span class="kontak-email"><?php echo htmlspecialchars($row['username'] ?? '-'); ?></span>
                                        <span class="kontak-phone"><?php echo htmlspecialchars($row['no_telp'] ?? '-'); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="poin-cell">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                        <span class="poin-value"><?php echo number_format($row['total_poin'], 0, ',', '.'); ?></span>
                                    </div>
                                </td>
                                <td class="sampah-cell"><?php echo number_format($row['total_sampah'] ?? 0, 2, ',', '.'); ?> <span class="unit">kg</span></td>
                                <td><span class="status-badge aktif">Aktif</span></td>
                                <td class="bergabung-cell">-</td>
                                <td>
                                    <div class="aksi-cell">

                                        <a href="edit_nasabah.php?id=<?php echo $row['id_nasabah']; ?>" class="btn-aksi btn-edit" title="Edit">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </a>
                                        <a href="?hapus=<?php echo $row['id_nasabah']; ?>" class="btn-aksi btn-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus nasabah ini?')">
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
                            
                            <tr id="searchEmptyRow" style="display: none;">
                                <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada nasabah yang cocok dengan pencarian.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- TABLE FOOTER / PAGINATION -->
                <div class="table-footer">
                    <span class="table-info">Menampilkan <strong><?php echo $total_nasabah; ?></strong> nasabah</span>
                    <div class="pagination" style="display: none;">
                        <button class="page-btn page-prev" disabled>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="15 18 9 12 15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Previous
                        </button>
                        <button class="page-btn active">1</button>
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

<script>
function searchTable() {
    let input = document.getElementById("searchInput");
    let filter = input.value.toLowerCase();
    let table = document.querySelector(".nasabah-table tbody");
    let tr = table.getElementsByTagName("tr");
    let emptyRow = document.getElementById("searchEmptyRow");
    let visibleCount = 0;

    for (let i = 0; i < tr.length; i++) {
        // Skip empty message rows
        if (tr[i].id === "searchEmptyRow" || tr[i].querySelector("td[colspan]")) {
            continue;
        }
        
        let nameSpan = tr[i].querySelector(".nasabah-name");
        if (nameSpan) {
            let nameValue = nameSpan.textContent || nameSpan.innerText;
            if (nameValue.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
                visibleCount++;
            } else {
                tr[i].style.display = "none";
            }
        }
    }
    
    // Show 'no results' row if nothing found
    if (emptyRow) {
        if (visibleCount === 0 && filter !== "" && table.querySelectorAll("tr").length > 2) {
            emptyRow.style.display = "";
        } else {
            emptyRow.style.display = "none";
        }
    }
}
</script>

</body>
</html>
