<?php
session_start();

if (!isset($_SESSION['id_account']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../includes/config.php';

$nama_admin = $_SESSION['nama_lengkap'] ?? 'Admin';
$inisial = strtoupper(substr($nama_admin, 0, 1));
$kata = explode(" ", $nama_admin);
if (count($kata) > 1) {
    $inisial = strtoupper(substr($kata[0], 0, 1) . substr($kata[1], 0, 1));
}

// Logic Add / Edit
$id_kategori = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$is_edit = $id_kategori > 0;

$nama_kategori = '';
$poin_per_kg = '';
$deskripsi = '';

if ($is_edit) {
    $stmt = $conn->prepare("SELECT * FROM kategori_sampah WHERE id_kategori = ?");
    $stmt->bind_param("i", $id_kategori);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $nama_kategori = $row['nama_sampah'];
        $poin_per_kg = $row['poin_per_kg'];
        $deskripsi = isset($row['deskripsi']) ? $row['deskripsi'] : '';
    } else {
        header("Location: kategori_sampah.php");
        exit();
    }
    $stmt->close();
}

$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $nama_kategori_post = trim($_POST['nama_kategori']);
    $poin_per_kg_post = (int)$_POST['poin_per_kg'];
    $deskripsi_post = trim($_POST['deskripsi']);

    if (empty($nama_kategori_post) || $poin_per_kg_post <= 0) {
        $error_msg = "Nama kategori dan poin per kilogram harus diisi dengan benar.";
    } else {
        if ($is_edit) {
            $stmt = $conn->prepare("UPDATE kategori_sampah SET nama_sampah = ?, poin_per_kg = ?, deskripsi = ? WHERE id_kategori = ?");
            $stmt->bind_param("sisi", $nama_kategori_post, $poin_per_kg_post, $deskripsi_post, $id_kategori);
            if ($stmt->execute()) {
                $_SESSION['success_msg'] = "Kategori sampah berhasil diperbarui!";
                header("Location: kategori_sampah.php");
                exit();
            } else {
                $error_msg = "Gagal memperbarui kategori: " . $conn->error;
            }
            $stmt->close();
        } else {
            $stmt = $conn->prepare("INSERT INTO kategori_sampah (nama_sampah, poin_per_kg, deskripsi) VALUES (?, ?, ?)");
            $stmt->bind_param("sis", $nama_kategori_post, $poin_per_kg_post, $deskripsi_post);
            if ($stmt->execute()) {
                $_SESSION['success_msg'] = "Kategori sampah berhasil ditambahkan!";
                header("Location: kategori_sampah.php");
                exit();
            } else {
                $error_msg = "Gagal menambahkan kategori: " . $conn->error;
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_edit ? 'Edit Kategori Sampah' : 'Tambah Kategori Sampah'; ?> – SolusiSampah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard_admin.css">
    <link rel="stylesheet" href="../css/crud_kategori_sampah.css">
</head>
<body>

<div class="app-wrapper">

    <?php $active_page = 'kategori'; include '../includes/sidebar_admin.php'; ?>

    <!-- ==================== MAIN CONTENT ==================== -->
    <div class="main-content">

        <!-- TOP HEADER — copy-paste identik dari nasabah.html -->
        <header class="top-header">
            <div class="header-left">
                <span class="header-breadcrumb">
                    <span style="color:var(--green-primary);font-weight:800;">Admin</span> Panel
                </span>
            </div>
            <div class="header-center">
                <div class="search-box">
                    <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="8" stroke="#9CA3AF" stroke-width="2"/>
                        <path d="M21 21l-4.35-4.35" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <input type="text" class="search-input" placeholder="Cari nasabah, transaksi...">
                </div>
            </div>
            <div class="header-right">
                <button class="notif-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
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

            <div class="tk-title-row">
                <div>
                    <div class="tk-breadcrumb">
                        <a href="kategori_sampah.php" class="tk-bc-link">Kategori Sampah</a>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none">
                            <polyline points="9 18 15 12 9 6" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="tk-bc-current"><?php echo $is_edit ? 'Edit Kategori' : 'Tambah Kategori Baru'; ?></span>
                    </div>
                    <h1 class="page-title"><?php echo $is_edit ? 'Edit Kategori Sampah' : 'Tambah Kategori Sampah'; ?></h1>
                    <p class="page-subtitle"><?php echo $is_edit ? 'Perbarui informasi kategori sampah ini.' : 'Daftarkan jenis sampah baru beserta nilai poin per kilogramnya.'; ?></p>
                </div>
                <a href="kategori_sampah.php" class="btn-back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                        <polyline points="15 18 9 12 15 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>

            <!-- ── Form Card ── -->
            <div class="tk-card">

                <!-- thin green bar on top — mirip panel .form-card-bar -->
                <div class="tk-card-bar"></div>

                <!-- card header -->
                <div class="tk-card-header">
                    <div class="tk-card-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                            <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke="var(--green-primary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10 11v6M14 11v6" stroke="var(--green-primary)" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <p class="tk-card-title"><?php echo $is_edit ? 'Edit Data Kategori' : 'Data Kategori Baru'; ?></p>
                        <p class="tk-card-sub">Kolom bertanda <span class="req-star">*</span> wajib diisi.</p>
                    </div>
                </div>

                <hr class="tk-divider">

                <?php if ($error_msg): ?>
                    <div style="background-color: #FEE2E2; color: #B91C1C; padding: 12px 16px; border-radius: 8px; margin: 16px 24px; font-size: 14px; font-weight: 500;">
                        <?php echo htmlspecialchars($error_msg); ?>
                    </div>
                <?php endif; ?>

                <!-- ── FORM ── -->
                <form method="POST" action="" autocomplete="off" class="tk-form">

                    <!-- Nama Kategori -->
                    <div class="tk-field">
                        <label class="form-label" for="nama_kategori">
                            Nama Kategori <span class="req-star">*</span>
                        </label>
                        <div class="tk-input-wrap">
                            <span class="tk-input-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    <line x1="7" y1="7" x2="7.01" y2="7" stroke="#9CA3AF" stroke-width="2.5" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <div class="tk-icon-divider"></div>
                            <input
                                type="text"
                                id="nama_kategori"
                                name="nama_kategori"
                                class="form-input tk-input"
                                placeholder="Misal: Plastik PET"
                                value="<?php echo htmlspecialchars($nama_kategori); ?>"
                                required
                                maxlength="80"
                            >
                        </div>
                        <p class="form-hint">Nama kategori akan ditampilkan pada pilihan setoran nasabah.</p>
                    </div>

                    <!-- Poin per Kilogram -->
                    <div class="tk-field">
                        <label class="form-label" for="poin_per_kg">
                            Poin per Kilogram <span class="req-star">*</span>
                        </label>
                        <div class="tk-input-wrap">
                            <span class="tk-input-icon">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="#FEF3C7">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="#F59E0B" stroke-width="1.8" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <div class="tk-icon-divider"></div>
                            <input
                                type="number"
                                id="poin_per_kg"
                                name="poin_per_kg"
                                class="form-input tk-input"
                                placeholder="Misal: 500"
                                value="<?php echo htmlspecialchars($poin_per_kg); ?>"
                                required
                                min="1"
                                max="99999"
                            >
                        </div>
                        <p class="form-hint">Jumlah poin yang diberikan kepada nasabah per 1 kg sampah kategori ini.</p>
                    </div>

                    <!-- Deskripsi -->
                    <div class="tk-field">
                        <label class="form-label" for="deskripsi">Deskripsi</label>
                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            class="form-textarea"
                            rows="5"
                            placeholder="Masukkan detail tentang kategori ini..."
                            maxlength="500"
                            oninput="updateCount(this,'charCount',500)"
                        ><?php echo htmlspecialchars($deskripsi); ?></textarea>
                        <div class="tk-hint-row">
                            <p class="form-hint">Opsional. Jelaskan jenis sampah yang masuk kategori ini.</p>
                            <span class="tk-char-count"><span id="charCount"><?php echo strlen($deskripsi); ?></span> / 500</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="tk-actions">
                        <a href="kategori_sampah.php" class="btn-batal">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                <line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                <line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                            </svg>
                            Batal
                        </a>
                        <button type="submit" name="submit" class="btn-primary-green">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                <polyline points="20 6 9 17 4 12" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <?php echo $is_edit ? 'Simpan Perubahan' : 'Simpan Kategori'; ?>
                        </button>
                    </div>

                </form>
            </div><!-- end tk-card -->

        </div><!-- end page-content -->
    </div><!-- end main-content -->
</div><!-- end app-wrapper -->

<script>
    function updateCount(el, id, max) {
        const n   = el.value.length;
        const el2 = document.getElementById(id);
        if (!el2) return;
        el2.textContent  = n;
        el2.style.color  = n > max * 0.9 ? '#EF4444' : '';
    }
</script>

</body>
</html>
