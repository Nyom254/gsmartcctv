<?php 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_start();

    if (!isset($_SESSION['status'])) {
        http_response_code(403);
        echo "Anda harus Login untuk mengakses resources ini";
    } else {
    require '../../../conn.php';

    $kode = $_GET['kode'];
    $queryHapusGudang = mysqli_prepare($conn,"delete from Gudang where kode = ?");
    mysqli_stmt_bind_param($queryHapusGudang, "s", $kode);


    $queryLogHapusGudang = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogHapusGudang, "ssss", $no_transaksi, $action, $keterangan, $userid);
    $queryGudang = mysqli_query($conn, "select * from Gudang where kode = '$kode'");
    $rowGudang = mysqli_fetch_assoc($queryGudang);
    $no_transaksi = $kode;
    $action = "DELETE" ;
    $keterangan = $_SESSION['username'] . " menghapus gudang " . $rowGudang['nama'];
    $userid = $_SESSION['id_user'];


    if(mysqli_stmt_execute($queryHapusGudang)){
        mysqli_stmt_execute($queryLogHapusGudang);
        mysqli_close($conn);
        $m = "gudang berhasil dihapus";
        header("location:../../index.php?content=gudang&t=$m");
    } else {
        mysqli_close($conn);
        $m = "gudang gagal dihapus";
        header("location:../../index.php?content=gudang&t=$m");
    }
    }
} else {
    http_response_code(405);
}
?>
