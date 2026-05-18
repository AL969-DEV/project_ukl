<?php
session_start();
include '../includes/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id_account']) || $_SESSION['role'] !== 'nasabah') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$id_account = $_SESSION['id_account'];
$id_voucher = isset($_POST['id_voucher']) ? (int)$_POST['id_voucher'] : 0;

if ($id_voucher <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Voucher tidak valid.']);
    exit();
}

// Get nasabah data
$query_nasabah = "SELECT * FROM nasabah WHERE id_account = ?";
$stmt_nasabah = mysqli_prepare($conn, $query_nasabah);
mysqli_stmt_bind_param($stmt_nasabah, "i", $id_account);
mysqli_stmt_execute($stmt_nasabah);
$nasabah = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_nasabah));

if (!$nasabah) {
    echo json_encode(['status' => 'error', 'message' => 'Data nasabah tidak ditemukan.']);
    exit();
}

$id_nasabah = $nasabah['id_nasabah'];
$total_poin = (int)$nasabah['total_poin'];

// Get voucher data
$query_voucher = "SELECT * FROM voucher_reward WHERE id_voucher = ?";
$stmt_voucher = mysqli_prepare($conn, $query_voucher);
mysqli_stmt_bind_param($stmt_voucher, "i", $id_voucher);
mysqli_stmt_execute($stmt_voucher);
$voucher = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_voucher));

if (!$voucher) {
    echo json_encode(['status' => 'error', 'message' => 'Voucher tidak ditemukan.']);
    exit();
}

$biaya_poin = (int)$voucher['biaya_poin'];
$stok = (int)$voucher['stok_voucher'];

if ($stok <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Stok voucher habis.']);
    exit();
}

if ($total_poin < $biaya_poin) {
    echo json_encode(['status' => 'error', 'message' => 'Poin tidak cukup untuk menukar hadiah ini.']);
    exit();
}

// Begin transaction
mysqli_begin_transaction($conn);

try {
    // 1. Kurangi poin nasabah
    $new_poin = $total_poin - $biaya_poin;
    $qUpdatePoin = "UPDATE nasabah SET total_poin = ? WHERE id_nasabah = ?";
    $stmt1 = mysqli_prepare($conn, $qUpdatePoin);
    mysqli_stmt_bind_param($stmt1, "ii", $new_poin, $id_nasabah);
    mysqli_stmt_execute($stmt1);

    // 2. Kurangi stok voucher
    $qUpdateStok = "UPDATE voucher_reward SET stok_voucher = stok_voucher - 1 WHERE id_voucher = ?";
    $stmt2 = mysqli_prepare($conn, $qUpdateStok);
    mysqli_stmt_bind_param($stmt2, "i", $id_voucher);
    mysqli_stmt_execute($stmt2);

    // 3. Catat di log_penukaran
    $qLog = "INSERT INTO log_penukaran (id_profile, id_voucher, tgl_tukar) VALUES (?, ?, NOW())";
    $stmt3 = mysqli_prepare($conn, $qLog);
    mysqli_stmt_bind_param($stmt3, "ii", $id_nasabah, $id_voucher);
    mysqli_stmt_execute($stmt3);

    mysqli_commit($conn);
    echo json_encode(['status' => 'success', 'message' => 'Penukaran poin berhasil!']);
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat memproses penukaran.']);
}
?>
