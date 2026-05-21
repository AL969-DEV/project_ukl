<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['id_account']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: kelola_nasabah.php");
    exit();
}

$id_nasabah = (int)$_GET['id'];

// Ambil data saat ini
$q_data = mysqli_query($conn, "SELECT n.*, a.username FROM nasabah n LEFT JOIN accounts a ON n.id_account = a.id_account WHERE n.id_nasabah = $id_nasabah");
if (mysqli_num_rows($q_data) == 0) {
    header("Location: kelola_nasabah.php");
    exit();
}
$nasabah = mysqli_fetch_assoc($q_data);

if (isset($_POST['submit'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $no_telp  = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $alamat   = mysqli_real_escape_string($conn, $_POST['alamat']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    
    $id_account = $nasabah['id_account'];

    mysqli_begin_transaction($conn);

    try {
        // Update account
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
            $query_acc = "UPDATE accounts SET username = '$username', password = '$password' WHERE id_account = $id_account";
        } else {
            $query_acc = "UPDATE accounts SET username = '$username' WHERE id_account = $id_account";
        }
        mysqli_query($conn, $query_acc);
        
        // Update nasabah
        $query_nas = "UPDATE nasabah SET nama_lengkap = '$nama', no_telp = '$no_telp', alamat = '$alamat' WHERE id_nasabah = $id_nasabah";
        mysqli_query($conn, $query_nas);

        mysqli_commit($conn);

        echo "<script>
                alert('Data Nasabah Berhasil Diperbarui!');
                window.location.href='kelola_nasabah.php';
              </script>";

    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script>alert('Gagal Mengubah Data: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nasabah – SolusiSampah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard_admin.css">
    <link rel="stylesheet" href="../css/tambah_nasabah.css">
</head>
<body>

<div class="app-wrapper">

    <?php $active_page = 'nasabah'; include '../includes/sidebar_admin.php'; ?>

    <div class="main-content">

        <?php include '../includes/header_admin.php'; ?>

        <div class="page-content">

            <div class="page-title-section">
                <nav class="breadcrumb-nav">
                    <a href="kelola_nasabah.php" class="breadcrumb-link">Kelola Nasabah</a>
                    <span class="breadcrumb-sep">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="9 18 15 12 9 6" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <span class="breadcrumb-current">Edit Nasabah</span>
                </nav>
                <h1 class="page-title">Edit Nasabah</h1>
                <p class="page-subtitle">Perbarui informasi data nasabah.</p>
            </div>

            <div class="form-card">

                <div class="form-card-header">
                    <div class="form-card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="9" cy="7" r="4" stroke="white" stroke-width="2"/><path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" stroke="white" stroke-width="2" stroke-linecap="round"/><path d="M16 3.13a4 4 0 010 7.75M21 21v-2a4 4 0 00-3-3.85" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div>
                        <h2 class="form-card-title">Edit Data Nasabah</h2>
                        <p class="form-card-subtitle">Semua kolom bertanda <span class="required-mark">*</span> wajib diisi.</p>
                    </div>
                </div>

                <div class="form-card-divider"></div>

                <form method="POST" action="" class="nasabah-form" autocomplete="off">

                    <div class="form-section">
                        <h3 class="form-section-title">
                            <span class="form-section-num">01</span>
                            Informasi Pribadi
                        </h3>
                        <div class="form-grid-2">

                            <div class="form-group">
                                <label class="form-label" for="nama_lengkap">
                                    Nama Lengkap <span class="required-mark">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="8" r="4" stroke="#9CA3AF" stroke-width="1.8"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    </span>
                                    <input
                                        type="text"
                                        id="nama_lengkap"
                                        name="nama_lengkap"
                                        class="form-input has-icon"
                                        value="<?php echo htmlspecialchars($nasabah['nama_lengkap']); ?>"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="no_telepon">
                                    No. Telepon <span class="required-mark">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.01 1.18 2 2 0 012 .01h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 14.92z" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </span>
                                    <input
                                        type="text"
                                        id="no_telepon"
                                        name="no_telp"
                                        class="form-input has-icon"
                                        value="<?php echo htmlspecialchars($nasabah['no_telp']); ?>"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="form-group form-group-full">
                                <label class="form-label" for="alamat">
                                    Alamat Lengkap <span class="required-mark">*</span>
                                </label>
                                <textarea
                                    id="alamat"
                                    name="alamat"
                                    class="form-textarea"
                                    rows="3"
                                    required
                                ><?php echo htmlspecialchars($nasabah['alamat']); ?></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="form-card-divider"></div>

                    <!-- SECTION 2: Akun & Keamanan -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <span class="form-section-num">02</span>
                            Akun &amp; Keamanan
                        </h3>
                        <div class="form-grid-2">

                            <div class="form-group">
                                <label class="form-label" for="username">
                                    Username <span class="required-mark">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="4" stroke="#9CA3AF" stroke-width="1.8"/><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z" stroke="#9CA3AF" stroke-width="1.8"/><path d="M12 16v-4M12 8h.01" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    </span>
                                    <input
                                        type="text"
                                        id="username"
                                        name="username"
                                        class="form-input has-icon"
                                        value="<?php echo htmlspecialchars($nasabah['username']); ?>"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password">
                                    Password Baru
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><rect x="3" y="11" width="18" height="11" rx="2" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 11V7a5 5 0 0110 0v4" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </span>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="form-input has-icon has-icon-right"
                                        placeholder="Kosongkan jika tidak ingin diubah"
                                    >
                                    <button type="button" class="toggle-password" onclick="togglePassword('password', this)" title="Tampilkan password">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="#9CA3AF" stroke-width="1.8"/></svg>
                                    </button>
                                </div>
                                <p class="form-hint">Hanya isi jika ingin mengubah password.</p>
                            </div>

                        </div>
                    </div>

                    <div class="form-card-divider"></div>

                    <!-- TOMBOL AKSI -->
                    <div class="form-actions">
                        <a href="kelola_nasabah.php" class="btn-batal">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><line x1="18" y1="6" x2="6" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><line x1="6" y1="6" x2="18" y2="18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            Batal
                        </a>
                        <button type="submit" name="submit" class="btn-simpan">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><polyline points="20 6 9 17 4 12" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div><!-- end form-card -->

        </div><!-- end page-content -->
    </div><!-- end main-content -->
</div><!-- end app-wrapper -->

<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.innerHTML = isHidden
            ? `<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><line x1="1" y1="1" x2="23" y2="23" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round"/></svg>`
            : `<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="#9CA3AF" stroke-width="1.8"/></svg>`;
    }
</script>

</body>
</html>
