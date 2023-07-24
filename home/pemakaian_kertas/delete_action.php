<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_start();
    if (!isset($_SESSION['status'])) {
        http_response_code(403);
        echo "Anda harus Login untuk mengakses resources ini";
    } else {
        require '../../conn.php';

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
    }
} else {
    http_response_code(405);
}
