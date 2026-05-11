<?php
session_start();
include '../includes/config.php'; // Sesuaikan path koneksi database kamu

// Cek apakah admin sudah login
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


if (isset($_POST['submit'])) {
    // 1. Ambil data dari form
    $nama     = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $no_telp  = mysqli_real_escape_string($conn, $_POST['no_telp']);
    $alamat   = mysqli_real_escape_string($conn, $_POST['alamat']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
    $role     = 'nasabah';

    // 2. Mulai Transaksi (Agar jika satu gagal, semua batal - Standar Profesional UKL)
    mysqli_begin_transaction($conn);

    try {
        // LANGKAH A: Simpan ke tabel ACCOUNTS
        $query_acc = "INSERT INTO accounts (username, password, role) VALUES ('$username', '$password', '$role')";
        mysqli_query($conn, $query_acc);
        
        // Ambil ID yang barusan dibuat di tabel accounts
        $id_account = mysqli_insert_id($conn);

        // LANGKAH B: Simpan ke tabel NASABAH menggunakan ID tadi
        $query_nas = "INSERT INTO nasabah (id_account, nama_lengkap, email, no_telp, alamat) 
                      VALUES ('$id_account', '$nama', '$email', '$no_telp', '$alamat')";
        mysqli_query($conn, $query_nas);

        // Jika semua OK, simpan permanen
        mysqli_commit($conn);

        echo "<script>
                alert('Nasabah Baru Berhasil Ditambahkan!');
                window.location.href='kelola_nasabah.php';
              </script>";

    } catch (Exception $e) {
        // Jika ada yang error, batalkan semua perubahan
        mysqli_rollback($conn);
        echo "<script>alert('Gagal Menambah Data: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Nasabah Baru – SolusiSampah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard_admin.css">
    <link rel="stylesheet" href="../css/tambah_nasabah.css">
</head>
<body>

<div class="app-wrapper">

    <?php $active_page = 'nasabah'; include '../includes/sidebar_admin.php'; ?>

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
                        <span class="user-role">Super admin</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <div class="page-content">

            <!-- Breadcrumb + Judul -->
            <div class="page-title-section">
                <nav class="breadcrumb-nav">
                    <a href="kelola_nasabah.php" class="breadcrumb-link">Kelola Nasabah</a>
                    <span class="breadcrumb-sep">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><polyline points="9 18 15 12 9 6" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <span class="breadcrumb-current">Tambah Nasabah Baru</span>
                </nav>
                <h1 class="page-title">Tambah Nasabah Baru</h1>
                <p class="page-subtitle">Isi formulir di bawah untuk mendaftarkan nasabah baru ke sistem.</p>
            </div>

            <!-- FORM CARD -->
            <div class="form-card">

                <div class="form-card-header">
                    <div class="form-card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="9" cy="7" r="4" stroke="white" stroke-width="2"/><path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" stroke="white" stroke-width="2" stroke-linecap="round"/><path d="M16 3.13a4 4 0 010 7.75M21 21v-2a4 4 0 00-3-3.85" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div>
                        <h2 class="form-card-title">Tambah Data Nasabah</h2>
                        <p class="form-card-subtitle">Semua kolom bertanda <span class="required-mark">*</span> wajib diisi.</p>
                    </div>
                </div>

                <div class="form-card-divider"></div>

                <!-- PHP: ganti action="" dengan nama file PHP pemroses, misal action="proses_tambah_nasabah.php" -->
                <form method="POST" action="" class="nasabah-form" autocomplete="off">

                    <!-- SECTION 1: Informasi Pribadi -->
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
                                        placeholder="Contoh: Siti Rahayu"
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
                                        placeholder="Contoh: 0812-3456-7890"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="form-group form-group-full">
                                <label class="form-label" for="email">
                                    Alamat Email <span class="required-mark">*</span>
                                </label>
                                <div class="input-wrapper">
                                    <span class="input-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><polyline points="22,6 12,13 2,6" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </span>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        class="form-input has-icon"
                                        placeholder="Contoh: siti.rahayu@gmail.com"
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
                                    placeholder="Contoh: Jl. Pahlawan No. 45, Kel. Keputih, Kec. Sukolilo, Surabaya"
                                    required
                                ></textarea>
                                <p class="form-hint">Tulis alamat lengkap termasuk kelurahan dan kecamatan.</p>
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
                                        placeholder="Contoh: siti_rahayu"
                                        required
                                    >
                                </div>
                                <p class="form-hint">Gunakan huruf kecil, angka, dan garis bawah ( _ ). Tanpa spasi.</p>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password">
                                    Password <span class="required-mark">*</span>
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
                                        placeholder="Minimal 8 karakter"
                                        required
                                    >
                                    <button type="button" class="toggle-password" onclick="togglePassword('password', this)" title="Tampilkan password">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="#9CA3AF" stroke-width="1.8"/></svg>
                                    </button>
                                </div>
                                <p class="form-hint">Minimal 8 karakter, kombinasikan huruf dan angka.</p>
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
                            Simpan Nasabah
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
