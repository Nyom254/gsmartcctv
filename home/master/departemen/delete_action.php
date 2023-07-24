<?php 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_start();

    if (!isset($_SESSION['status'])) {
        http_response_code(403);
    } else {
    require '../../../conn.php';
    session_start();

    $kode = $_GET['kode'];
    $queryHapusDepartemen = mysqli_prepare($conn,"delete from departemen where kode = ?");
    mysqli_stmt_bind_param($queryHapusDepartemen, "s", $kode);

    $queryLogHapusDepartemen = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogHapusDepartemen, "ssss", $no_transaksi, $action, $keterangan, $userid);
    $queryDepartemen = mysqli_query($conn, "select * from departemen where kode = '$kode'");
    $rowDepartemen = mysqli_fetch_assoc($queryDepartemen);
    $no_transaksi = $kode;
    $action = "DELETE" ;
    $keterangan = $_SESSION['username'] . " menghapus departemen " . $rowDepartemen['nama'];
    $userid = $_SESSION['id_user'];

    if(mysqli_stmt_execute($queryHapusDepartemen)){
        mysqli_stmt_execute($queryLogHapusDepartemen);
        mysqli_close($conn);
        $m = "departemen berhasil dihapus";
        header("location:../../index.php?content=departemen&t=$m");
    } else {
        mysqli_close($conn);
        $m = "departemen gagal dihapus";
        header("location:../../index.php?content=departemen&t=$m");
    }
    }
} else {
    http_response_code(405);
}