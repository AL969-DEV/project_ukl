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
    <link rel="stylesheet" href="../css/tentang.css">
    <link rel="stylesheet" href="../css/footer_user.css">
</head>
<body>

<?php include '../includes/navbar_user.php'; ?>

<main class="tentang-main">

    <!-- ================================================================
         HERO SECTION
         ================================================================ -->
    <section class="tentang-hero">
        <div class="tentang-container">
            <div class="tentang-hero-grid">

                <!-- Kiri: Teks -->
                <div class="tentang-hero-text">
                    <span class="tentang-hero-tag">🌿 Bank Sampah Digital</span>
                    <h1 class="tentang-hero-title">
                        Tentang <span class="tentang-highlight">SolusiSampah</span>
                    </h1>
                    <p class="tentang-hero-desc">
                        SolusiSampah adalah platform bank sampah digital yang mengajak masyarakat
                        untuk peduli lingkungan sekaligus mendapatkan keuntungan nyata. Dengan
                        teknologi modern, kami menjembatani nasabah dengan bank sampah lokal
                        secara mudah, transparan, dan menyenangkan.
                    </p>
                    <p class="tentang-hero-desc">
                        Setiap kilogram sampah yang kamu setorkan dikonversi menjadi poin
                        yang bisa ditukar dengan hadiah menarik — karena menjaga bumi
                        seharusnya juga menguntungkan.
                    </p>
                    <div class="tentang-hero-actions">
                        <a href="dashboard.php" class="tentang-btn-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10 11v6M14 11v6" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            Mulai Setor Sampah
                        </a>
                        <a href="#visi-misi" class="tentang-btn-outline">
                            Pelajari Lebih Lanjut
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                <path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Quick stats -->
                    <div class="tentang-hero-stats">
                        <div class="tentang-stat-item">
                            <p class="tentang-stat-num">248+</p>
                            <p class="tentang-stat-label">Nasabah Aktif</p>
                        </div>
                        <div class="tentang-stat-divider"></div>
                        <div class="tentang-stat-item">
                            <p class="tentang-stat-num">14.3 T</p>
                            <p class="tentang-stat-label">Sampah Terkumpul</p>
                        </div>
                        <div class="tentang-stat-divider"></div>
                        <div class="tentang-stat-item">
                            <p class="tentang-stat-num">892K</p>
                            <p class="tentang-stat-label">Poin Beredar</p>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Ilustrasi placeholder -->
                <div class="tentang-hero-img-wrap">
                    <div class="tentang-hero-img-placeholder">
                        <div class="tentang-img-inner">
                            <svg width="72" height="72" viewBox="0 0 24 24" fill="none">
                                <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6" stroke="#10B981" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10 11v6M14 11v6" stroke="#10B981" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            <p class="tentang-img-hint">Ilustrasi Bank Sampah Digital</p>
                            <!-- PHP: ganti dengan <img src="assets/img/hero-ilustrasi.png" alt="..."> -->
                        </div>
                    </div>
                    <!-- Decorative floating cards -->
                    <div class="tentang-float-card top-right">
                        <span class="tentang-float-emoji">♻️</span>
                        <div>
                            <p class="tentang-float-label">Ramah Lingkungan</p>
                            <p class="tentang-float-sub">Daur ulang lebih mudah</p>
                        </div>
                    </div>
                    <div class="tentang-float-card bottom-left">
                        <span class="tentang-float-emoji">⭐</span>
                        <div>
                            <p class="tentang-float-label">+15.000 Poin</p>
                            <p class="tentang-float-sub">Reward terkumpul</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="tentang-section" id="visi-misi">
        <div class="tentang-container">

            <div class="tentang-section-header">
                <span class="tentang-section-tag">Arah & Tujuan</span>
                <h2 class="tentang-section-title">Visi &amp; Misi</h2>
                <p class="tentang-section-sub">
                    Landasan yang menggerakkan setiap langkah SolusiSampah dalam menciptakan
                    ekosistem pengelolaan sampah yang lebih baik.
                </p>
            </div>

            <div class="tentang-visi-misi-grid">

                <!-- Card Visi -->
                <div class="tentang-vm-card visi">
                    <div class="tentang-vm-card-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="12" r="3" stroke="white" stroke-width="2"/>
                        </svg>
                    </div>
                    <h3 class="tentang-vm-title">Visi</h3>
                    <p class="tentang-vm-headline">
                        "Mewujudkan Indonesia bebas sampah melalui digitalisasi bank sampah
                        yang merata dan berkelanjutan."
                    </p>
                    <p class="tentang-vm-desc">
                        Kami bermimpi tentang sebuah Indonesia di mana setiap warga negara
                        memiliki akses mudah untuk berpartisipasi dalam pengelolaan sampah
                        yang bertanggung jawab, dan mendapatkan apresiasi atas kontribusi
                        mereka terhadap lingkungan.
                    </p>
                    <div class="tentang-vm-tags">
                        <span class="tentang-vm-tag">🌏 Berkelanjutan</span>
                        <span class="tentang-vm-tag">♻️ Zero Waste</span>
                        <span class="tentang-vm-tag">🤝 Inklusif</span>
                    </div>
                </div>

                <!-- Card Misi -->
                <div class="tentang-vm-card misi">
                    <div class="tentang-vm-card-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="22 4 12 14.01 9 11.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="tentang-vm-title">Misi</h3>
                    <ul class="tentang-misi-list">
                        <li class="tentang-misi-item">
                            <span class="tentang-misi-dot"></span>
                            <div>
                                <p class="tentang-misi-item-title">Edukasi Masyarakat</p>
                                <p class="tentang-misi-item-desc">Meningkatkan kesadaran akan pentingnya memilah dan mendaur ulang sampah melalui kampanye digital.</p>
                            </div>
                        </li>
                        <li class="tentang-misi-item">
                            <span class="tentang-misi-dot"></span>
                            <div>
                                <p class="tentang-misi-item-title">Digitalisasi Bank Sampah</p>
                                <p class="tentang-misi-item-desc">Mendigitalkan proses setoran, pencatatan, dan penukaran poin agar lebih efisien dan transparan.</p>
                            </div>
                        </li>
                        <li class="tentang-misi-item">
                            <span class="tentang-misi-dot"></span>
                            <div>
                                <p class="tentang-misi-item-title">Sistem Reward Nyata</p>
                                <p class="tentang-misi-item-desc">Memberikan insentif berupa poin yang dapat ditukar hadiah sebagai apresiasi atas kontribusi lingkungan.</p>
                            </div>
                        </li>
                        <li class="tentang-misi-item">
                            <span class="tentang-misi-dot"></span>
                            <div>
                                <p class="tentang-misi-item-title">Kemitraan Lokal</p>
                                <p class="tentang-misi-item-desc">Bermitra dengan bank sampah, pengepul, dan pemerintah daerah untuk menciptakan ekosistem daur ulang yang kuat.</p>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>


    <!-- ================================================================
         SECTION FITUR UNGGULAN
         ================================================================ -->
    <section class="tentang-section tentang-section-alt">
        <div class="tentang-container">

            <div class="tentang-section-header">
                <span class="tentang-section-tag">Keunggulan Platform</span>
                <h2 class="tentang-section-title">Mengapa SolusiSampah?</h2>
                <p class="tentang-section-sub">
                    Kami menghadirkan solusi lengkap yang mudah digunakan oleh siapa saja.
                </p>
            </div>

            <div class="tentang-fitur-grid">
                <div class="tentang-fitur-card">
                    <div class="tentang-fitur-icon" style="background:#EFF6FF;color:#3B82F6;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect x="5" y="2" width="14" height="20" rx="3" stroke="currentColor" stroke-width="2"/><path d="M9 18h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="10" r="2" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                    <h4 class="tentang-fitur-title">Scan QR Code</h4>
                    <p class="tentang-fitur-desc">Setoran sampah cepat dan akurat menggunakan teknologi QR Code unik setiap nasabah.</p>
                </div>

                <div class="tentang-fitur-card">
                    <div class="tentang-fitur-icon" style="background:#ECFDF5;color:#10B981;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <h4 class="tentang-fitur-title">Sistem Poin Reward</h4>
                    <p class="tentang-fitur-desc">Setiap kilogram sampah dikonversi menjadi poin yang bisa ditukar hadiah menarik.</p>
                </div>

                <div class="tentang-fitur-card">
                    <div class="tentang-fitur-icon" style="background:#FFF7ED;color:#EA580C;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M18 20V10M12 20V4M6 20v-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h4 class="tentang-fitur-title">Laporan Real-time</h4>
                    <p class="tentang-fitur-desc">Pantau kontribusi sampah dan poin kamu secara real-time dari mana saja.</p>
                </div>

                <div class="tentang-fitur-card">
                    <div class="tentang-fitur-icon" style="background:#FDF4FF;color:#A21CAF;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <h4 class="tentang-fitur-title">Komunitas Peduli</h4>
                    <p class="tentang-fitur-desc">Bergabung bersama ratusan nasabah aktif yang bersama-sama menjaga lingkungan.</p>
                </div>
            </div>

        </div>
    </section>


    <!-- ================================================================
         SECTION PROFIL DEVELOPER
         ================================================================ -->
    <section class="tentang-section">
        <div class="tentang-container">

            <div class="tentang-section-header">
                <span class="tentang-section-tag">Tim Kami</span>
                <h2 class="tentang-section-title">Dikembangkan Oleh</h2>
                <p class="tentang-section-sub">
                    SolusiSampah merupakan proyek UKL (Ujian Kompetensi Lembaga) yang dikerjakan
                    dengan penuh semangat sebagai bentuk kontribusi nyata kepada lingkungan.
                </p>
            </div>

            <!-- Developer Card -->
            <div class="tentang-dev-wrapper">
                <div class="tentang-dev-card">
                    <!-- Avatar placeholder -->
                    <div class="tentang-dev-avatar-wrap">
                        <div class="tentang-dev-avatar">
                            <!-- PHP: ganti dengan <img src="assets/img/foto-developer.jpg" class="tentang-dev-avatar-img" alt="..."> -->
                            <svg width="52" height="52" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="8" r="4" stroke="#10B981" stroke-width="1.8"/>
                                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" stroke="#10B981" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="tentang-dev-avatar-ring"></div>
                    </div>

                    <h3 class="tentang-dev-name">Muhammad Ghani Al Fawwazi</h3>
                    <p class="tentang-dev-role">Siswa SMK · Full-Stack Developer</p>
                    <p class="tentang-dev-school">SMK Telkom Sidoarjo · Jurusan SIJA</p>

                    <p class="tentang-dev-bio">
                        Membangun SolusiSampah sebagai proyek Ujian Kenaikan Level (UKL)
                        dengan tujuan menciptakan solusi digital nyata untuk masalah lingkungan
                        yang ada di masyarakat sekitar.
                    </p>

                    <div class="tentang-dev-stack">
                        <span class="tentang-dev-badge">PHP Native</span>
                        <span class="tentang-dev-badge">MySQL</span>
                        <span class="tentang-dev-badge">HTML & CSS</span>
                        <span class="tentang-dev-badge">JavaScript</span>
                    </div>

                    <div class="tentang-dev-socials">
                        <a href="#" class="tentang-dev-social-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            GitHub
                        </a>
                        <a href="#" class="tentang-dev-social-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            WhatsApp
                        </a>
                        <a href="#" class="tentang-dev-social-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Email
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="tentang-cta">
        <div class="tentang-container">
            <div class="tentang-cta-inner">
                <div class="tentang-cta-text">
                    <h2 class="tentang-cta-title">Siap Berkontribusi untuk Lingkungan?</h2>
                    <p class="tentang-cta-desc">Bergabunglah bersama ratusan nasabah SolusiSampah dan mulai perjalanan hijau kamu hari ini.</p>
                </div>
                <div class="tentang-cta-actions">
                    <a href="dashboard.php" class="tentang-btn-cta-primary">Mulai Sekarang</a>
                    <a href="riwayat_user.php"   class="tentang-btn-cta-outline">Lihat Riwayat</a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include '../includes/footer_user.php'; ?>

</body>
</html>
