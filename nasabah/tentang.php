<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'nasabah') {
    header("Location: ../index.php");
    exit;
}

include '../includes/config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang – SolusiSampah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar_user.css">
    <link rel="stylesheet" href="../css/tentang.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../css/footer_user.css">
</head>
<body>

<?php include '../includes/navbar_user.php'; ?>

<div class="about-wrapper">

    <!-- ── 1. HERO HEADER ── -->
    <section class="about-hero">
        <h2 class="about-hero-title">Tentang SolusiSampah</h2>
        <p class="about-hero-desc">
            SolusiSampah adalah platform bank sampah digital yang memudahkan masyarakat
            dalam menyetorkan sampah, memantau kontribusi lingkungan, dan menukarkan
            poin reward — semua dalam satu aplikasi yang sederhana dan transparan.
        </p>
        <p class="about-hero-desc">
            Kami percaya bahwa setiap kilogram sampah yang dikelola dengan benar adalah
            langkah nyata menuju lingkungan yang lebih bersih dan lestari.
        </p>
    </section>

    <div class="about-divider"></div>

    <!-- ── 2. VISI & MISI ── -->
    <section class="about-vm-section">
        <h3 class="about-section-title">Visi &amp; Misi</h3>

        <!-- Visi -->
        <div class="about-vm-card">
            <div class="about-vm-card-label">
                <span class="about-vm-icon">👁️</span>
                Visi
            </div>
            <p class="about-vm-text">
                Mewujudkan Indonesia bebas sampah melalui digitalisasi bank sampah
                yang merata, transparan, dan berkelanjutan untuk seluruh lapisan masyarakat.
            </p>
        </div>

        <!-- Misi -->
        <div class="about-vm-card">
            <div class="about-vm-card-label">
                <span class="about-vm-icon">🎯</span>
                Misi
            </div>
            <ul class="about-misi-list">
                <li class="about-misi-item">Mengedukasi masyarakat tentang pentingnya memilah dan mendaur ulang sampah.</li>
                <li class="about-misi-item">Mendigitalkan proses setoran, pencatatan, dan penukaran poin di bank sampah.</li>
                <li class="about-misi-item">Memberikan reward nyata sebagai apresiasi atas kontribusi lingkungan nasabah.</li>
                <li class="about-misi-item">Bermitra dengan bank sampah dan pemerintah lokal untuk ekosistem daur ulang yang kuat.</li>
            </ul>
        </div>
    </section>

    <div class="about-divider"></div>

    <!-- ── 3. DEVELOPER PROFILE ── -->
    <section class="about-dev-section">
        <h3 class="about-section-title">Dikembangkan Oleh</h3>

        <div class="about-dev-card">

            <!-- Avatar -->
            <div class="about-dev-avatar">
                <!-- PHP: ganti dengan <img src="assets/foto.jpg" class="about-dev-avatar-img" alt="Foto Developer"> -->
                <svg width="44" height="44" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="8" r="4" stroke="#50C878" stroke-width="1.8"/>
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" stroke="#50C878" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </div>

            <!-- Info -->
            <h4 class="about-dev-name">Muhammad Ghani Al Fawwazi</h4>
            <p class="about-dev-role">Siswa SMK · Full-Stack Developer</p>
            <p class="about-dev-school">SMK Telkom Sidoarjo · Jurusan SIJA</p>

            <!-- ── 4. TECH STACK BADGES ── -->
            <div class="about-tech-row">
                <span class="about-tech-badge">PHP Native</span>
                <span class="about-tech-badge">MySQL</span>
                <span class="about-tech-badge">HTML &amp; CSS</span>
                <span class="about-tech-badge">JavaScript</span>
            </div>

        </div>
    </section>

</div>

<?php include '../includes/footer_user.php'; ?>

</body>
</html>

