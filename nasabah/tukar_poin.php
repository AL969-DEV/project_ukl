<?php
session_start();
include '../includes/config.php';

if (!isset($_SESSION['id_account']) || $_SESSION['role'] !== 'nasabah') {
    header("Location: ../login.php");
    exit();
}

$id_account = $_SESSION['id_account'];

// Ambil data nasabah
$qNasabah = mysqli_query($conn, "SELECT * FROM nasabah WHERE id_account = '$id_account'");
$nasabah = mysqli_fetch_assoc($qNasabah);
$saldo_poin = isset($nasabah['total_poin']) ? (int)$nasabah['total_poin'] : 0;
$level_nasabah = "Nasabah"; // Bisa diupdate dengan logika level jika ada

// Ambil data hadiah (filter kategori jika ada)
$kategori_filter = isset($_GET['kategori']) ? mysqli_real_escape_string($conn, $_GET['kategori']) : '';
$query_reward = "SELECT * FROM voucher_reward";
if (!empty($kategori_filter)) {
    $query_reward .= " WHERE kategori_voucher = '$kategori_filter'";
}
$query_reward .= " ORDER BY id_voucher DESC";
$qRewards = mysqli_query($conn, $query_reward);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Hadiah – SolusiSampah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar_user.css">
    <link rel="stylesheet" href="../css/tukar_poin.css">
    <link rel="stylesheet" href="../css/footer_user.css">
</head>
<body>

<?php include '../includes/navbar_user.php'; ?>

<main class="katalog-main">

    <section class="katalog-hero">
        <div class="katalog-hero-inner">
            <div class="katalog-hero-left">
                <p class="katalog-hero-label">Saldo Poin Kamu</p>
                <div class="katalog-hero-poin-row">
                    <span class="katalog-hero-star">⭐</span>
                    <span class="katalog-hero-poin-num"><?= number_format($saldo_poin, 0, ',', '.') ?> Poin</span>
                    <span class="katalog-hero-level"><?= $level_nasabah ?></span>
                </div>
            </div>
            <div class="katalog-hero-right">
                <a href="riwayat-penukaran.php" class="katalog-hero-history-btn">
                    Lihat Riwayat Penukaran
                </a>
            </div>
        </div>
    </section>

    <div class="katalog-filter-bar">
        <div class="katalog-filter-inner">
            <div class="katalog-category-pills">
                <span class="katalog-cat-label">Kategori:</span>
                <a href="tukar_poin.php" class="katalog-pill <?= empty($kategori_filter) ? 'active' : '' ?>">Semua</a>
                <a href="tukar_poin.php?kategori=pulsa" class="katalog-pill <?= $kategori_filter == 'pulsa' ? 'active' : '' ?>">Pulsa / Paket Data</a>
                <a href="tukar_poin.php?kategori=ewallet" class="katalog-pill <?= $kategori_filter == 'ewallet' ? 'active' : '' ?>">E-Wallet</a>
                <a href="tukar_poin.php?kategori=listrik" class="katalog-pill <?= $kategori_filter == 'listrik' ? 'active' : '' ?>">Token Listrik</a>
                <a href="tukar_poin.php?kategori=sembako" class="katalog-pill <?= $kategori_filter == 'sembako' ? 'active' : '' ?>">Sembako</a>
                <a href="tukar_poin.php?kategori=voucher" class="katalog-pill <?= $kategori_filter == 'voucher' ? 'active' : '' ?>">Voucher Belanja</a>
                <a href="tukar_poin.php?kategori=lainnya" class="katalog-pill <?= $kategori_filter == 'lainnya' ? 'active' : '' ?>">Lainnya</a>
            </div>
        </div>
    </div>

    <div class="katalog-container">

        <h2 class="katalog-section-title">Semua Hadiah</h2>

        <div class="katalog-grid">
            <?php 
            if ($qRewards && mysqli_num_rows($qRewards) > 0):
                while ($row = mysqli_fetch_assoc($qRewards)): 
                    $can_afford = $saldo_poin >= $row['biaya_poin'];
                    $has_stock = $row['stok_voucher'] > 0;
                    
                    $card_class = "katalog-card";
                    if (!$has_stock || !$can_afford) {
                        $card_class .= " katalog-card-disabled";
                    }
                    
                    $placeholder_class = "merch";
                    if ($row['kategori_voucher'] == 'pulsa') $placeholder_class = "pulsa";
                    if ($row['kategori_voucher'] == 'ewallet') $placeholder_class = "dana";
                    if ($row['kategori_voucher'] == 'listrik') $placeholder_class = "token";
                    if ($row['kategori_voucher'] == 'sembako') $placeholder_class = "sembako";
            ?>
            
            <div class="<?= $card_class ?>">
                <div class="katalog-card-img-wrap" style="position: relative; height: 160px;">
                    <?php if (!empty($row['gambar_voucher'])): ?>
                        <img src="../<?= htmlspecialchars($row['gambar_voucher']) ?>" class="katalog-card-img" alt="<?= htmlspecialchars($row['nama_voucher']) ?>" style="width: 100%; height: 160px; object-fit: cover; display: block; border-radius: 12px 12px 0 0;">
                    <?php else: ?>
                        <div style="background-color: #E5E7EB; border-radius: 12px 12px 0 0; display: flex; align-items: center; justify-content: center; height: 100%; width: 100%;">
                            <span style="color: #9CA3AF; font-size: 14px; font-weight: 500;">No Image</span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!$has_stock): ?>
                        <span class="katalog-card-badge stok-habis" style="position: absolute; top: 12px; right: 12px; background: #EF4444; color: white; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; z-index: 2;">STOK HABIS</span>
                    <?php endif; ?>
                </div>

                <div class="katalog-card-body">
                    <p class="katalog-card-kategori"><?= htmlspecialchars(ucfirst($row['kategori_voucher'])) ?></p>
                    <h3 class="katalog-card-name"><?= htmlspecialchars($row['nama_voucher']) ?></h3>
                    <p class="katalog-card-desc"><?= htmlspecialchars($row['deskripsi']) ?></p>
                    <div class="katalog-card-poin-row">
                        <div class="katalog-card-poin">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="<?= ($has_stock && $can_afford) ? '#F59E0B' : '#9CA3AF' ?>"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span class="katalog-card-poin-num"><?= number_format($row['biaya_poin'], 0, ',', '.') ?></span>
                            <span class="katalog-card-poin-label">poin</span>
                        </div>
                    </div>
                    <?php if (!$has_stock): ?>
                        <p class="katalog-card-stok habis" style="color: #EF4444; font-size: 13px; font-weight: 600; margin-top: auto;">Stok Habis</p>
                    <?php elseif (!$can_afford): ?>
                        <p class="katalog-card-stok kurang" style="color: #EF4444; font-size: 13px; font-weight: 600; margin-top: auto;">Poin Tidak Cukup</p>
                    <?php else: ?>
                        <p class="katalog-card-stok tersedia" style="color: #10B981; font-size: 13px; font-weight: 600; margin-top: auto;">Stok Tersedia (<?= $row['stok_voucher'] ?>)</p>
                    <?php endif; ?>
                </div>
                <div class="katalog-card-footer">
                    <?php if (!$has_stock): ?>
                        <button class="katalog-btn-tukar disabled" disabled>STOK HABIS</button>
                    <?php else: ?>
                        <button class="katalog-btn-tukar" onclick="tukarPoin(<?= $row['id_voucher'] ?>)">TUKAR SEKARANG</button>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php 
                endwhile; 
            else:
            ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: white; border-radius: 16px; border: 1px solid #E5E7EB;">
                    <p style="color: #6B7280; font-size: 15px;">Belum ada hadiah yang tersedia saat ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include '../includes/footer_user.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function tukarPoin(idVoucher) {
    Swal.fire({
        title: 'Konfirmasi Penukaran',
        text: "Apakah kamu yakin ingin menukar poin dengan hadiah ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#16A34A',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Tukar!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Memproses...',
                text: 'Menukar poin...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            const formData = new FormData();
            formData.append('id_voucher', idVoucher);

            fetch('ajax_tukar_poin.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#16A34A'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Terjadi kesalahan'
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Koneksi ke server gagal.', 'error');
            });
        }
    })
}
</script>

</body>
</html>