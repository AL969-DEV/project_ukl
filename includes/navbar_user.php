<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<header class="navbar">
    <div class="navbar-inner">

        <a href="dashboard.php" class="navbar-logo">
            <img src="../assets/logo.svg" style="width: 28px; height: 28px; margin-right: 8px;" alt="Logo">
            <div class="logo-text">
                <span class="logo-solid">Solusi</span><span class="logo-bold">Sampah</span>
            </div>
        </a>

        <!-- Nav Links -->
        <nav class="navbar-links">
            <a href="dashboard.php" class="nav-link <?= ($currentPage == 'dashboard.php') ? 'active' : '' ?>">Beranda</a>
            <a href="riwayat_user.php" class="nav-link <?= ($currentPage == 'riwayat_user.php' || $currentPage == 'riwayat_setoran.php') ? 'active' : '' ?>">Riwayat</a>
            <a href="tukar_poin.php" class="nav-link <?= ($currentPage == 'tukar_poin.php') ? 'active' : '' ?>">Tukar Poin</a>
            <a href="tentang.php" class="nav-link <?= ($currentPage == 'tentang.php') ? 'active' : '' ?>">Tentang</a>
        </nav>

        <!-- Right: Notif + User -->
        <div class="navbar-right">
            <button class="notif-btn" aria-label="Notifikasi">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M13.73 21a2 2 0 01-3.46 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                <span class="notif-dot"></span>
            </button>
            <div class="navbar-user">
                <!-- PHP: ganti "SR" dengan inisial $nama_user, ganti teks dengan echo $nama_user -->
                <div class="navbar-avatar">SR</div>
                <span class="navbar-username">Siti Rahayu</span>
            </div>
        </div>

    </div>
</header>
