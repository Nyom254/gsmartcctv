<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_start();

    if (!isset($_SESSION['status'])) {
        http_response_code(403);
    } else {
        require '../../../conn.php';

        $idGroup = $_GET['id_group'];
        $queryHapusGroupBarang = mysqli_prepare($conn, "delete from group_barang where id_group = ?");
        mysqli_stmt_bind_param($queryHapusGroupBarang, "s", $idGroup);

        $queryLogHapusGroup = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
        mysqli_stmt_bind_param($queryLogHapusGroup, "ssss", $no_transaksi, $action, $keterangan, $userid);
        $queryGroup = mysqli_query($conn, "select * from group_barang where id_group = '$idGroup'");
        $rowGroup = mysqli_fetch_assoc($queryGroup);
        $no_transaksi = $idGroup;
        $action = "DELETE";
        $keterangan = $_SESSION['username'] . " menghapus group barang " . $rowGroup['nama_group'];
        $userid = $_SESSION['id_user'];

        if (mysqli_stmt_execute($queryHapusGroupBarang)) {
            mysqli_stmt_execute($queryLogHapusGroup);
            mysqli_close($conn);
            header("location:../../index.php?content=group_barang");
        } else {
            mysqli_close($conn);
            header("location:../../index.php?content=group_barang");
        }
    }
} else {
    http_response_code(405);
}
