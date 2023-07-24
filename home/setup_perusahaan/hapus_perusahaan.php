<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_start();
    if (!isset($_SESSION['status'])) {
        http_response_code(403);
    } else {
        require '../../conn.php';

        $id = $_GET['id'];

        $queryHapusPerusahaan = mysqli_prepare($conn, "delete from setup_perusahaan where id = ?");
        mysqli_stmt_bind_param($queryHapusPerusahaan, "i", $id);

        $queryLogHapusSetupPerusahaan = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
        mysqli_stmt_bind_param($queryLogHapusSetupPerusahaan, "ssss", $no_transaksi, $action, $keterangan, $userid);

        $no_transaksi = "setup perusahaan";
        $action = "DELETE";
        $keterangan = $_SESSION['username'] . " menghapus perusahaan ";
        $userid = $_SESSION['id_user'];

        if (mysqli_stmt_execute($queryHapusPerusahaan)) {
            mysqli_stmt_execute($queryLogHapusSetupPerusahaan);
            mysqli_stmt_close($queryHapusPerusahaan);
            mysqli_stmt_close($queryLogHapusSetupPerusahaan);
            mysqli_close($conn);
            $m = "berhasil menghapus perusahaan";
            header("location:../index.php?content=setup_perusahaan&t=$m");
        } else {
            mysqli_close($conn);
            $m = "gagal menghapus perusahaan";
            header("location:../index.php?content=setup_perusahaan&t=$m");
        }
    }
} else {
    http_response_code(405);
}
