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
        <button class="notif-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span class="notif-dot"></span>
        </button>
        <div class="user-profile">
            <div class="user-avatar"><?= $inisial ?></div>
            <div class="user-info">
                <span class="user-name"><?= htmlspecialchars($nama_admin) ?></span>
                <span class="user-role">Super Admin</span>
            </div>
        </div>
    </div>
</header>
