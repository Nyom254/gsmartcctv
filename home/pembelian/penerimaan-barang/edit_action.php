<?php
include '../../../conn.php';

session_start();

$queryEditPenerimaan = mysqli_prepare($conn, "UPDATE penerimaan set tgl = ?, no_ref = ?, keterangan = ? where no_penerimaan = ?");
mysqli_stmt_bind_param($queryEditPenerimaan, "ssss", $tanggal, $no_ref, $keterangan, $no_penerimaan);

$no_penerimaan = urldecode($_GET['no']);
$tanggal = mysqli_escape_string($conn, $_POST['tanggal']);
$no_ref = mysqli_escape_string($conn, $_POST['no_ref']);
$keterangan = mysqli_escape_string($conn, $_POST['keterangan']);

$queryLogTambahPO = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
mysqli_stmt_bind_param($queryLogTambahPO, "ssss", $no_penerimaan, $action, $keteranganLog, $userid);

$action = "INSERT";
$keteranganLog = $_SESSION['username'] . " merubah Penerimaan Barang  " . $no_penerimaan;
$userid = $_SESSION['id_user'];


if (mysqli_stmt_execute($queryEditPenerimaan)) {
    mysqli_stmt_execute($queryLogTambahPO);
    mysqli_stmt_close($queryEditPenerimaan);
    mysqli_close($conn);
    $m = "berhasil diubah";
    header("location:../../index.php?content=penerimaan_barang&t=$m");
} else {
    mysqli_stmt_close($queryTambahUser);
    mysqli_close($conn);
    $m = "gagal menambahkan penerimaan barang";
    header("location:../../index.php?content=penerimaan_barang&t=$m");
}
