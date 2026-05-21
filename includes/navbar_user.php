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

        <!-- Right: User Profile -->
        <div class="navbar-right">
            <div class="navbar-user">
                <div class="navbar-avatar"><?= htmlspecialchars($inisial_nav) ?></div>
                <span class="navbar-username"><?= htmlspecialchars($nama_user_nav) ?></span>
            </div>
            <a href="../logout.php" class="logout-btn" aria-label="Keluar" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
            </a>
        </div>

    </div>
</header>
