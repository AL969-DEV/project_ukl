<?php
$nama_admin = $_SESSION['nama_lengkap'] ?? 'Admin';
$inisial = strtoupper(substr($nama_admin, 0, 1));
$kata = explode(" ", $nama_admin);
if (count($kata) > 1) {
    $inisial = strtoupper(substr($kata[0], 0, 1) . substr($kata[1], 0, 1));
}
?>
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
        <div class="user-profile">
            <div class="user-avatar"><?= $inisial ?></div>
            <div class="user-info">
                <span class="user-name"><?= htmlspecialchars($nama_admin) ?></span>
                <span class="user-role">Super Admin</span>
            </div>
        </div>
    </div>
</header>
