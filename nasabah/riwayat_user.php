<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'nasabah') {
    header("Location: ../login.php");
    exit;
}

include '../includes/config.php';

$id_account = $_SESSION['id_account'] ?? 0;

// Fetch nasabah data
$query_nasabah = "SELECT * FROM nasabah WHERE id_account = ?";
$stmt_nasabah = mysqli_prepare($conn, $query_nasabah);
mysqli_stmt_bind_param($stmt_nasabah, "i", $id_account);
mysqli_stmt_execute($stmt_nasabah);
$nasabah_data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_nasabah));

$id_nasabah = $nasabah_data['id_nasabah'] ?? 0;

// Total Setoran (transaksi_setor count)
$query_total_setoran = "SELECT COUNT(*) as total FROM transaksi_setor WHERE id_profile = ?";
$stmt_ts = mysqli_prepare($conn, $query_total_setoran);
mysqli_stmt_bind_param($stmt_ts, "i", $id_nasabah);
mysqli_stmt_execute($stmt_ts);
$total_setoran = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_ts))['total'] ?? 0;

// Total Sampah (sum of berat)
$query_total_sampah = "SELECT SUM(berat) as total FROM transaksi_setor WHERE id_profile = ?";
$stmt_ts2 = mysqli_prepare($conn, $query_total_sampah);
mysqli_stmt_bind_param($stmt_ts2, "i", $id_nasabah);
mysqli_stmt_execute($stmt_ts2);
$total_sampah = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_ts2))['total'] ?? 0;

// Total Poin Diterima
$query_total_poin = "SELECT SUM(poin) as total FROM transaksi_setor WHERE id_profile = ? AND status = 'claimed'";
$stmt_ts3 = mysqli_prepare($conn, $query_total_poin);
mysqli_stmt_bind_param($stmt_ts3, "i", $id_nasabah);
mysqli_stmt_execute($stmt_ts3);
$total_poin = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_ts3))['total'] ?? 0;


$filter_tgl = $_GET['tanggal'] ?? '';
$filter_kategori = $_GET['kategori'] ?? '';
$filter_status = $_GET['status'] ?? '';

$where_clauses = ["ts.id_profile = ?"];
$params = [$id_nasabah];
$types = "i";

if (!empty($filter_tgl)) {
    $where_clauses[] = "DATE(ts.tgl_setor) = ?";
    $params[] = $filter_tgl;
    $types .= "s";
}
if (!empty($filter_kategori)) {
    $where_clauses[] = "ks.nama_sampah LIKE ?";
    $params[] = "%$filter_kategori%";
    $types .= "s";
}
if (!empty($filter_status)) {
    $where_clauses[] = "ts.status = ?";
    $params[] = $filter_status;
    $types .= "s";
}

$where_sql = implode(" AND ", $where_clauses);

// Count total records for pagination
$count_sql = "SELECT COUNT(*) as total FROM transaksi_setor ts 
              LEFT JOIN kategori_sampah ks ON ts.id_kategori = ks.id_kategori 
              WHERE $where_sql";
$stmt_count = mysqli_prepare($conn, $count_sql);
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt_count, $types, ...$params);
}
mysqli_stmt_execute($stmt_count);
$total_records = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_count))['total'] ?? 0;

$limit = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;
$total_pages = ceil($total_records / $limit);

// Fetch data
$query_data = "SELECT ts.*, ks.nama_sampah 
               FROM transaksi_setor ts 
               LEFT JOIN kategori_sampah ks ON ts.id_kategori = ks.id_kategori 
               WHERE $where_sql 
               ORDER BY ts.tgl_setor DESC LIMIT ? OFFSET ?";
$stmt_data = mysqli_prepare($conn, $query_data);
$types_data = $types . "ii";
$params_data = array_merge($params, [$limit, $offset]);
mysqli_stmt_bind_param($stmt_data, $types_data, ...$params_data);
mysqli_stmt_execute($stmt_data);
$result_data = mysqli_stmt_get_result($stmt_data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Setoran – SolusiSampah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Panggil CSS Navbar, Riwayat User, dan Footer di sini -->
    <link rel="stylesheet" href="../css/navbar_user.css">
    <link rel="stylesheet" href="../css/riwayat_user.css">
    <link rel="stylesheet" href="../css/footer_user.css">
</head>
<body>
<?php include '../includes/navbar_user.php'; ?>

<main class="riwayat-main">
    <div class="riwayat-container">

        <div class="riwayat-page-header">
            <h1 class="riwayat-page-title">Riwayat Setoran Kamu</h1>
            <p class="riwayat-page-sub">Lihat semua kontribusi sampah yang telah kamu tukar menjadi poin</p>
        </div>

        <div class="riwayat-summary-row">
            <div class="riwayat-stat-card">
                <p class="riwayat-stat-label">TOTAL SETORAN</p>
                <p class="riwayat-stat-value"><?= number_format($total_setoran, 0, ',', '.') ?></p>
                <p class="riwayat-stat-unit">Transaksi</p>
            </div>
            <div class="riwayat-stat-card">
                <p class="riwayat-stat-label">TOTAL SAMPAH</p>
                <p class="riwayat-stat-value"><?= number_format($total_sampah, 1, ',', '.') ?></p>
                <p class="riwayat-stat-unit">Kilogram</p>
            </div>
            <div class="riwayat-stat-card">
                <p class="riwayat-stat-label">TOTAL POIN</p>
                <p class="riwayat-stat-value riwayat-stat-gold"><?= number_format($total_poin, 0, ',', '.') ?></p>
                <p class="riwayat-stat-unit">Poin diterima</p>
            </div>
        </div>
        <form method="GET" action="" class="riwayat-filter-bar">
            <div class="riwayat-filter-date-wrap">
                <input type="date" name="tanggal" class="riwayat-filter-input riwayat-date-input"
                    value="<?= htmlspecialchars($filter_tgl) ?>">
                <svg class="riwayat-date-icon" width="15" height="15" viewBox="0 0 24 24" fill="none">
                    <rect x="3" y="4" width="18" height="18" rx="2" stroke="#9CA3AF" stroke-width="1.8"/>
                    <path d="M3 10h18M8 2v4M16 2v4" stroke="#9CA3AF" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </div>

            <div class="riwayat-filter-select-wrap">
                <select name="kategori" class="riwayat-filter-input riwayat-select-input">
                    <option value="">Semua Kategori</option>
                    <option value="Plastik" <?= stripos($filter_kategori, 'Plastik') !== false ? 'selected' : '' ?>>Plastik PET</option>
                    <option value="Kertas" <?= stripos($filter_kategori, 'Kertas') !== false ? 'selected' : '' ?>>Kertas / Kardus</option>
                    <option value="Logam" <?= stripos($filter_kategori, 'Logam') !== false ? 'selected' : '' ?>>Logam / Besi</option>
                    <option value="Kaca" <?= stripos($filter_kategori, 'Kaca') !== false ? 'selected' : '' ?>>Kaca / Botol</option>
                    <option value="Elektronik" <?= stripos($filter_kategori, 'Elektronik') !== false ? 'selected' : '' ?>>Elektronik</option>
                </select>
                <svg class="riwayat-select-chevron" width="13" height="13" viewBox="0 0 24 24" fill="none">
                    <path d="M6 9l6 6 6-6" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <div class="riwayat-filter-select-wrap">
                <select name="status" class="riwayat-filter-input riwayat-select-input">
                    <option value="">Semua Status</option>
                    <option value="claimed" <?= $filter_status == 'claimed' ? 'selected' : '' ?>>Selesai</option>
                    <option value="pending" <?= $filter_status == 'pending' ? 'selected' : '' ?>>Pending</option>
                </select>
                <svg class="riwayat-select-chevron" width="13" height="13" viewBox="0 0 24 24" fill="none">
                    <path d="M6 9l6 6 6-6" stroke="#6B7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <button type="submit" class="riwayat-btn-reset">Filter</button>
            <?php if (!empty($_GET)): ?>
                <a href="riwayat_user.php" class="riwayat-btn-reset" style="background-color:#f3f4f6; color:#374151; text-decoration:none; margin-left:8px;">Reset</a>
            <?php endif; ?>
        </form>
        <!-- ── Tabel Transaksi ── -->
        <div class="riwayat-table-card">

            <div class="riwayat-table-card-header">
                <h2 class="riwayat-table-title">Semua Transaksi</h2>
                <p class="riwayat-table-count">Menampilkan <?= mysqli_num_rows($result_data) ?> dari <?= $total_records ?> transaksi</p>
            </div>

            <div class="riwayat-table-wrap">
                <table class="riwayat-table">
                    <thead>
                        <tr>
                            <th class="riwayat-th-tgl">TANGGAL</th>
                            <th class="riwayat-th-kat">JENIS SAMPAH</th>
                            <th class="riwayat-th-berat">BERAT</th>
                            <th class="riwayat-th-poin">POIN DIDAPAT</th>
                            <th class="riwayat-th-status">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result_data) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result_data)): 
                                $kategori_class = strtolower(explode(' ', $row['nama_sampah'] ?? 'plastik')[0]);
                                $is_claimed = $row['status'] === 'claimed';
                                // Calculate rate based on points and weight if needed, or if it's stored
                                $rate = $row['berat'] > 0 ? floor($row['poin'] / $row['berat']) : 0;
                            ?>
                            <tr class="riwayat-tr">
                                <td class="riwayat-td-tgl"><?= date('d F Y', strtotime($row['tgl_setor'])) ?></td>
                                <td>
                                    <span class="riwayat-kat-badge <?= $kategori_class ?>"><?= htmlspecialchars($row['nama_sampah'] ?? 'Lainnya') ?></span>
                                </td>
                                <td class="riwayat-td-berat"><?= number_format($row['berat'], 1, ',', '.') ?> Kg</td>
                                <td class="riwayat-td-poin">
                                    <p class="riwayat-poin-value">+ <?= number_format($row['poin'], 0, ',', '.') ?> Poin</p>
                                    <p class="riwayat-poin-rate"><?= number_format($rate, 0, ',', '.') ?> poin/kg</p>
                                </td>
                                <td>
                                    <?php if ($is_claimed): ?>
                                        <span class="riwayat-status-badge selesai">● Selesai</span>
                                    <?php else: ?>
                                        <span class="riwayat-status-badge pending" style="background-color: #FEF9C3; color: #CA8A04;">○ Pending</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 20px;">Belum ada riwayat setoran.</td>
                            </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <div class="riwayat-pagination-row">
                <p class="riwayat-pagination-info">
                    Halaman <?= $page ?> dari <?= $total_pages ?>
                </p>
                <div class="riwayat-pagination">
                    <?php
                    $qs = $_GET;
                    if ($page > 1) {
                        $qs['page'] = $page - 1;
                        $prev_url = '?' . http_build_query($qs);
                        echo "<a href='$prev_url' class='riwayat-page-btn prev'>
                                <svg width='14' height='14' viewBox='0 0 24 24' fill='none'><polyline points='15 18 9 12 15 6' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg>
                                Previous
                              </a>";
                    } else {
                        echo "<button class='riwayat-page-btn prev' disabled>
                                <svg width='14' height='14' viewBox='0 0 24 24' fill='none'><polyline points='15 18 9 12 15 6' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg>
                                Previous
                              </button>";
                    }

                    for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++) {
                        $qs['page'] = $i;
                        $url = '?' . http_build_query($qs);
                        $active = $i == $page ? 'active' : '';
                        echo "<a href='$url' class='riwayat-page-btn num $active'>$i</a>";
                    }

                    if ($page < $total_pages) {
                        $qs['page'] = $page + 1;
                        $next_url = '?' . http_build_query($qs);
                        echo "<a href='$next_url' class='riwayat-page-btn next'>
                                Next
                                <svg width='14' height='14' viewBox='0 0 24 24' fill='none'><polyline points='9 18 15 12 9 6' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg>
                              </a>";
                    } else {
                        echo "<button class='riwayat-page-btn next' disabled>
                                Next
                                <svg width='14' height='14' viewBox='0 0 24 24' fill='none'><polyline points='9 18 15 12 9 6' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/></svg>
                              </button>";
                    }
                    ?>
                </div>
            </div>
            <?php endif; ?>

        </div><!-- end riwayat-table-card -->

    </div><!-- end riwayat-container -->
</main>

<?php include '../includes/footer_user.php'; ?>

</body>
</html>