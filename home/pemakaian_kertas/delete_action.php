<?php
include '../../conn.php';

session_start();


$no_kertas = $_GET['no_kertas'];
$queryHapusKertas = mysqli_prepare($conn, "delete from KERTAS where no_kertas = ?");
mysqli_stmt_bind_param($queryHapusKertas, "s", $no_kertas);

$queryLogHapusKertas = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
mysqli_stmt_bind_param($queryLogHapusKertas, "ssss", $no_kertas, $action, $keteranganLog, $userid);

$action = "INSERT";
$keteranganLog = $_SESSION['username'] . " menghapus kertas  " . $no_kertas;
$userid = $_SESSION['id_user'];
if (mysqli_stmt_execute($queryHapusKertas)) {
    mysqli_stmt_execute($queryLogHapusKertas);
    mysqli_close($conn);
    $m = "berhasil dihapus";
    header("location:../index.php?content=pemakaian_kertas&t=$m");
} else {
    mysqli_close($conn);
    $m = "gagal dihapus";
    header("location:../index.php?content=pemakaian_kertas&t=$m");
}
