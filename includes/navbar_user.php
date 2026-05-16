<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$nama_user_nav = $_SESSION['nama_lengkap'] ?? 'Nasabah';
$inisial_nav = strtoupper(substr($nama_user_nav, 0, 1));
$kata_nav = explode(" ", $nama_user_nav);
if (count($kata_nav) > 1) {
    $inisial_nav = strtoupper(substr($kata_nav[0], 0, 1) . substr($kata_nav[1], 0, 1));
}
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
                <div class="navbar-avatar"><?= htmlspecialchars($inisial_nav) ?></div>
                <span class="navbar-username"><?= htmlspecialchars($nama_user_nav) ?></span>
            </div>
        </div>

    </div>
</header>
