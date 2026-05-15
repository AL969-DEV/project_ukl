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

// -------------------------
// PROSES HAPUS
// -------------------------
if (isset($_GET['delete'])) {
    $id_del = (int)$_GET['delete'];
    
    $qImg = mysqli_query($conn, "SELECT gambar_voucher FROM voucher_reward WHERE id_voucher = $id_del");
    if ($qImg && mysqli_num_rows($qImg) > 0) {
        $rowImg = mysqli_fetch_assoc($qImg);
        if (!empty($rowImg['gambar_voucher']) && file_exists("../uploads/rewards/" . $rowImg['gambar_voucher'])) {
            unlink("../uploads/rewards/" . $rowImg['gambar_voucher']);
        }
    }

    $qDel = "DELETE FROM voucher_reward WHERE id_voucher = $id_del";
    if (mysqli_query($conn, $qDel)) {
        echo "<script>alert('Hadiah berhasil dihapus!'); window.location='kelola_reward.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus hadiah!');</script>";
    }
}

// -------------------------
// PROSES TAMBAH / EDIT
// -------------------------
$edit_mode = false;
$edit_data = [
    'id_voucher' => '',
    'nama_voucher' => '',
    'deskripsi' => '',
    'biaya_poin' => '',
    'stok_voucher' => '',
    'kategori_voucher' => '',
    'gambar_voucher' => ''
];

if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id_edit = (int)$_GET['edit'];
    $qEdit = mysqli_query($conn, "SELECT * FROM voucher_reward WHERE id_voucher = $id_edit");
    if ($qEdit && mysqli_num_rows($qEdit) > 0) {
        $edit_data = mysqli_fetch_assoc($qEdit);
    }
}

if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_hadiah']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = (int)$_POST['harga_poin'];
    $stok = (int)$_POST['stok'];
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $id_voucher_post = isset($_POST['id_voucher']) ? (int)$_POST['id_voucher'] : 0;
    
    // Upload Gambar
    $gambar = '';
    if (isset($_POST['gambar_lama'])) {
        $gambar = $_POST['gambar_lama'];
    }
    
    if (isset($_FILES['gambar_hadiah']) && $_FILES['gambar_hadiah']['error'] == 0) {
        $ext = pathinfo($_FILES['gambar_hadiah']['name'], PATHINFO_EXTENSION);
        $gambar_nama = time() . '_' . uniqid() . '.' . $ext;
        $tmp = $_FILES['gambar_hadiah']['tmp_name'];
        $path = "../uploads/rewards/" . $gambar_nama;
        
        if (move_uploaded_file($tmp, $path)) {
            $gambar = $gambar_nama;
            if ($id_voucher_post > 0 && !empty($_POST['gambar_lama']) && file_exists("../uploads/rewards/" . $_POST['gambar_lama'])) {
                unlink("../uploads/rewards/" . $_POST['gambar_lama']);
            }
        }
    }

    if ($id_voucher_post > 0) {
        $q = "UPDATE voucher_reward SET 
                nama_voucher = '$nama', 
                deskripsi = '$deskripsi', 
                biaya_poin = $harga, 
                stok_voucher = $stok, 
                kategori_voucher = '$kategori', 
                gambar_voucher = '$gambar' 
              WHERE id_voucher = $id_voucher_post";
        $msg = "Hadiah berhasil diperbarui!";
    } else {
        $q = "INSERT INTO voucher_reward (nama_voucher, deskripsi, biaya_poin, stok_voucher, kategori_voucher, gambar_voucher) 
              VALUES ('$nama', '$deskripsi', $harga, $stok, '$kategori', '$gambar')";
        $msg = "Hadiah baru berhasil ditambahkan!";
    }

    if (mysqli_query($conn, $q)) {
        echo "<script>alert('$msg'); window.location='kelola_reward.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data: " . mysqli_error($conn) . "');</script>";
    }
}

$qTotal = mysqli_query($conn, "SELECT COUNT(*) AS total FROM voucher_reward");
$total_hadiah_aktif = $qTotal ? (mysqli_fetch_assoc($qTotal)['total'] ?? 0) : 0;

$penukaran_bulan_ini = 0;
try {
    $qLog = mysqli_query($conn, "SELECT COUNT(*) AS total FROM log_penukaran WHERE MONTH(tanggal_penukaran) = MONTH(CURRENT_DATE()) AND YEAR(tanggal_penukaran) = YEAR(CURRENT_DATE())");
    if ($qLog) {
        $penukaran_bulan_ini = mysqli_fetch_assoc($qLog)['total'] ?? 0;
    }
} catch (Exception $e) {
    try {
        $qLog = mysqli_query($conn, "SELECT COUNT(*) AS total FROM log_penukaran WHERE MONTH(tanggal) = MONTH(CURRENT_DATE()) AND YEAR(tanggal) = YEAR(CURRENT_DATE())");
        if ($qLog) {
            $penukaran_bulan_ini = mysqli_fetch_assoc($qLog)['total'] ?? 0;
        }
    } catch (Exception $e2) {
        $penukaran_bulan_ini = 0;
    }
}

$qHampirHabis = mysqli_query($conn, "SELECT COUNT(*) AS total FROM voucher_reward WHERE stok_voucher > 0 AND stok_voucher <= 10");
$stok_hampir_habis = $qHampirHabis ? mysqli_fetch_assoc($qHampirHabis)['total'] : 0;

$qHabis = mysqli_query($conn, "SELECT COUNT(*) AS total FROM voucher_reward WHERE stok_voucher = 0");
$stok_habis = $qHabis ? mysqli_fetch_assoc($qHabis)['total'] : 0;

// Untuk Tabel
$qRewards = mysqli_query($conn, "SELECT * FROM voucher_reward ORDER BY id_voucher DESC");
$total_tampil = $qRewards ? mysqli_num_rows($qRewards) : 0;
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

    <div class="main-content">

        <header class="top-header">
            <div class="header-left">
                <span class="header-breadcrumb">
                    <span style="color:var(--green-primary);font-weight:800;">Admin</span> <span style="color:var(--text-secondary);font-weight:500;">Panel</span>
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
                    <div class="user-avatar"><?= $inisial ?></div>
                    <div class="user-info">
                        <span class="user-name"><?= htmlspecialchars($nama_admin) ?></span>
                        <span class="user-role">Super Admin</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <div class="page-content">

            <!-- ── PAGE TITLE ── -->
            <div class="page-title-section">
                <p class="page-breadcrumb-text">Kelola Reward</p>
                <h1 class="page-title">Daftar Hadiah &amp; Reward</h1>
                <p class="page-subtitle">Kelola hadiah penukaran poin, harga, dan ketersediaan stok untuk nasabah.</p>
            </div>

            <!-- ── SUMMARY CARDS (4 card terpisah seperti di Figma) ── -->
            <div class="kr-summary-row">
                <div class="kr-summary-card">
                    <div class="kr-summary-icon" style="color:#16A34A;background:#F0FDF4;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div>
                        <p class="kr-summary-value"><?= number_format($total_hadiah_aktif, 0, ',', '.') ?></p>
                        <p class="kr-summary-label">Total Hadiah Aktif</p>
                    </div>
                </div>

                <div class="kr-summary-card">
                    <div class="kr-summary-icon" style="color:#3B82F6;background:#EFF6FF;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 3l-4 4-4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div>
                        <p class="kr-summary-value"><?= number_format($penukaran_bulan_ini, 0, ',', '.') ?></p>
                        <p class="kr-summary-label">Penukaran Bulan Ini</p>
                    </div>
                </div>

                <div class="kr-summary-card">
                    <div class="kr-summary-icon" style="color:#D97706;background:#FFFBEB;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="2" y="7" width="20" height="14" rx="2" stroke="currentColor" stroke-width="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div>
                        <p class="kr-summary-value"><?= number_format($stok_hampir_habis, 0, ',', '.') ?></p>
                        <p class="kr-summary-label">Stok Hampir Habis</p>
                    </div>
                </div>

                <div class="kr-summary-card">
                    <div class="kr-summary-icon" style="color:#DC2626;background:#FEF2F2;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
                    </div>
                    <div>
                        <p class="kr-summary-value"><?= number_format($stok_habis, 0, ',', '.') ?></p>
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
                                <h2 class="kr-panel-title"><?= $edit_mode ? 'Edit Hadiah' : 'Tambah Hadiah Baru' ?></h2>
                                <p class="kr-panel-sub">Kolom bertanda <span class="req">*</span> wajib diisi.</p>
                            </div>
                        </div>

                        <div class="kr-divider"></div>

                        <form method="POST" action="kelola_reward.php" enctype="multipart/form-data" class="kr-form" autocomplete="off">
                            <?php if ($edit_mode): ?>
                                <input type="hidden" name="id_voucher" value="<?= $edit_data['id_voucher'] ?>">
                                <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($edit_data['gambar_voucher']) ?>">
                            <?php endif; ?>

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
                                        value="<?= htmlspecialchars($edit_data['nama_voucher']) ?>"
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
                                    value="<?= htmlspecialchars($edit_data['deskripsi']) ?>"
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
                                            value="<?= htmlspecialchars($edit_data['biaya_poin']) ?>"
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
                                            value="<?= htmlspecialchars($edit_data['stok_voucher']) ?>"
                                            required min="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Gambar -->
                            <div class="form-group">
                                <label class="form-label" for="gambar_hadiah">Upload Gambar / Ikon</label>
                                <label class="kr-upload-zone" for="gambar_hadiah" id="uploadZone">
                                    <div class="kr-upload-content" id="uploadContent" <?= (!empty($edit_data['gambar_voucher'])) ? 'style="display:none;"' : '' ?>>
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" style="color:#9CA3AF;margin-bottom:8px;"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><polyline points="17 8 12 3 7 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><line x1="12" y1="3" x2="12" y2="15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                                        <p class="kr-upload-title">Klik untuk pilih gambar</p>
                                        <p class="kr-upload-hint">PNG, JPG, WEBP — Maks 2 MB</p>
                                    </div>
                                    <img id="imgPreview" class="kr-upload-preview" src="<?= (!empty($edit_data['gambar_voucher'])) ? '../uploads/rewards/' . htmlspecialchars($edit_data['gambar_voucher']) : '' ?>" alt="" <?= (!empty($edit_data['gambar_voucher'])) ? 'style="display:block;"' : 'style="display:none;"' ?>>
                                </label>
                                <input type="file" id="gambar_hadiah" name="gambar_hadiah"
                                    class="kr-upload-hidden"
                                    accept="image/png,image/jpeg,image/webp"
                                    onchange="previewImg(this)">
                            </div>

                            <!-- Kategori -->
                            <div class="form-group">
                                <label class="form-label" for="kategori">Kategori Hadiah</label>
                                <select id="kategori" name="kategori" class="form-select" required>
                                    <option value="">-- Pilih kategori --</option>
                                    <option value="pulsa" <?= ($edit_data['kategori_voucher'] == 'pulsa') ? 'selected' : '' ?>>Pulsa / Paket Data</option>
                                    <option value="ewallet" <?= ($edit_data['kategori_voucher'] == 'ewallet') ? 'selected' : '' ?>>E-Wallet (DANA/GoPay/OVO)</option>
                                    <option value="listrik" <?= ($edit_data['kategori_voucher'] == 'listrik') ? 'selected' : '' ?>>Token Listrik</option>
                                    <option value="sembako" <?= ($edit_data['kategori_voucher'] == 'sembako') ? 'selected' : '' ?>>Sembako</option>
                                    <option value="voucher" <?= ($edit_data['kategori_voucher'] == 'voucher') ? 'selected' : '' ?>>Voucher Belanja</option>
                                    <option value="lainnya" <?= ($edit_data['kategori_voucher'] == 'lainnya') ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                            </div>

                            <!-- Submit -->
                            <div style="display:flex; gap:10px;">
                                <button type="submit" name="submit" class="btn-primary" style="flex:1;">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><polyline points="20 6 9 17 4 12" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <?= $edit_mode ? 'Simpan Perubahan' : 'Simpan Hadiah' ?>
                                </button>
                                <?php if ($edit_mode): ?>
                                    <a href="kelola_reward.php" class="btn-primary" style="background:#6B7280; flex:1; text-align:center;">Batal</a>
                                <?php endif; ?>
                            </div>

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
                                <p class="kr-panel-sub">Total <strong><?= $total_hadiah_aktif ?></strong> hadiah terdaftar dalam sistem.</p>
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
                                    <?php 
                                    if ($qRewards && mysqli_num_rows($qRewards) > 0):
                                        $no = 1; 
                                        while ($row = mysqli_fetch_assoc($qRewards)): 
                                            // Menentukan warna badge stok
                                            $stok_class = 'normal';
                                            if ($row['stok_voucher'] == 0) $stok_class = 'empty';
                                            elseif ($row['stok_voucher'] <= 10) $stok_class = 'low';
                                    ?>
                                    <tr>
                                        <td class="td-no"><?= $no++ ?></td>
                                        <td class="td-img">
                                            <?php if (!empty($row['gambar_voucher'])): ?>
                                                <img src="../uploads/rewards/<?= htmlspecialchars($row['gambar_voucher']) ?>" alt="Reward" style="width:40px;height:40px;object-fit:cover;border-radius:6px;">
                                            <?php else: ?>
                                                <div class="reward-thumb blue">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="5" y="2" width="14" height="20" rx="3" stroke="white" stroke-width="1.8"/><circle cx="12" cy="9" r="2" fill="white"/><path d="M9 18h6" stroke="white" stroke-width="1.8" stroke-linecap="round"/></svg>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <p class="td-name"><?= htmlspecialchars($row['nama_voucher']) ?></p>
                                            <p class="td-desc-small"><?= htmlspecialchars($row['deskripsi']) ?></p>
                                        </td>
                                        <td class="td-poin">
                                            <span class="poin-tag">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="#F59E0B"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                                <?= number_format($row['biaya_poin'], 0, ',', '.') ?>
                                            </span>
                                        </td>
                                        <td class="td-stok"><span class="stok-pill <?= $stok_class ?>"><?= $row['stok_voucher'] ?></span></td>
                                        <td class="td-aksi">
                                            <div class="aksi-cell">
                                                <a href="kelola_reward.php?edit=<?= $row['id_voucher'] ?>" class="btn-aksi btn-edit" title="Edit">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    Edit
                                                </a>
                                                <a href="kelola_reward.php?delete=<?= $row['id_voucher'] ?>" class="btn-aksi btn-delete" title="Hapus" onclick="return confirm('Hapus hadiah ini?')">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M9 6V4h6v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                                    Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php 
                                        endwhile; 
                                    else:
                                    ?>
                                    <tr>
                                        <td colspan="6" style="text-align:center; padding:20px;">Belum ada data reward.</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-footer">
                            <span class="table-info">Menampilkan <strong><?= $total_tampil ?></strong> hadiah</span>
                            <!--
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
                            -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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
