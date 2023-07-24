<?php 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_start();

    if (!isset($_SESSION['status'])) {
        http_response_code(403);
        echo "Anda harus Login untuk mengakses resources ini";
    } else {
    require '../../../conn.php';
    
    $idSupplier = $_GET['id_supplier'];
    $queryHapusSupplier = mysqli_prepare($conn,"delete from supplier where id_supplier = ?");
    mysqli_stmt_bind_param($queryHapusSupplier, "s", $idSupplier);


    $queryLogHapusSupplier = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogHapusSupplier, "ssss", $no_transaksi, $action, $keterangan, $userid);
    $querySupplier = mysqli_query($conn, "select * from supplier where id_supplier = '$idSupplier'");
    $rowSupplier = mysqli_fetch_assoc($querySupplier);
    $no_transaksi = $idSupplier;
    $action = "DELETE" ;
    $keterangan = $_SESSION['username'] . " menghapus supplier " . $rowSupplier['nama'];
    $userid = $_SESSION['id_user'];

    if(mysqli_stmt_execute($queryHapusSupplier)){
        mysqli_stmt_execute($queryLogHapusSupplier);
        mysqli_close($conn);
        header("location:../../index.php?content=supplier");
    } else {
        mysqli_close($conn);
        header("location:../../index.php?content=supplier");
    }
    }
} else {
    http_response_code(405);
}
?>