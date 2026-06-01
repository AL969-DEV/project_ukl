<link rel="stylesheet" href="../css/sidebar_admin.css">
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><img src="../assets/logo.svg" style="width:28px; height:28px;" alt="Logo"></div>
        <div class="brand-text">
            <span class="brand-name">SolusiSampah</span>
            <span class="brand-sub">Bank Sampah Digital</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <p class="nav-section-label">MENU UTAMA</p>
        <ul class="nav-list">
            <li class="nav-item <?php echo (isset($active_page) && $active_page == 'dashboard') ? 'active' : ''; ?>">
                <a href="dashboard.php" class="nav-link">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="8" rx="1.5" fill="currentColor"/><rect x="3" y="14" width="7" height="7" rx="1.5" fill="currentColor"/><rect x="13" y="3" width="8" height="5" rx="1.5" fill="currentColor"/><rect x="13" y="11" width="8" height="10" rx="1.5" fill="currentColor"/></svg>
                    </span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item <?php echo (isset($active_page) && $active_page == 'nasabah') ? 'active' : ''; ?>">
                <a href="kelola_nasabah.php" class="nav-link">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/><path d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M16 3.13a4 4 0 010 7.75M21 21v-2a4 4 0 00-3-3.85" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </span>
                    Kelola Nasabah
                </a>
            </li>
            <li class="nav-item <?php echo (isset($active_page) && $active_page == 'kategori') ? 'active' : ''; ?>">
                <a href="kategori_sampah.php" class="nav-link">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 10h16M4 14h10M4 18h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </span>
                    Kategori Sampah
                </a>
            </li>
            <li class="nav-item <?php echo (isset($active_page) && $active_page == 'transaksi') ? 'active' : ''; ?>">
                <a href="transaksi_setoran.php" class="nav-link">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/><path d="M3 10h18" stroke="currentColor" stroke-width="2"/><path d="M8 2v4M16 2v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </span>
                    Transaksi Setoran
                </a>
            </li>
            <li class="nav-item <?php echo (isset($active_page) && $active_page == 'reward') ? 'active' : ''; ?>">
                <a href="kelola_reward.php" class="nav-link">
                    <span class="nav-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                    </span>
                    Kelola Hadiah
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <a href="../logout.php" class="nav-link footer-link logout">
            <span class="nav-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><polyline points="16 17 21 12 16 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><line x1="21" y1="12" x2="9" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            </span>
            Keluar
        </a>
    </div>
</aside>
