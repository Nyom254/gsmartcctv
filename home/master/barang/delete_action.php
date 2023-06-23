<?php 
    include '../../../conn.php';
    session_start();
    $queryHapusBarang = mysqli_prepare($conn,"delete from barang where id_barang = ?");
    mysqli_stmt_bind_param($queryHapusBarang, "s", $idBarang);
    $idBarang = $_GET['id_barang'];
    
    $queryLogHapusBarang = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogHapusBarang, "ssss", $no_transaksi, $action, $keterangan, $userid);
    $queryBarang = mysqli_query($conn, "select * from barang where id_barang = '$idBarang'");
    $rowBarang = mysqli_fetch_assoc($queryBarang);
    $no_transaksi = $idBarang;
    $action = "DELETE" ;
    $keterangan = $_SESSION['username'] . " menghapus barang " . $rowBarang['nama'];
    $userid = $_SESSION['id_user'];

    if(mysqli_stmt_execute($queryHapusBarang)){
        mysqli_stmt_execute($queryLogHapusBarang);
        mysqli_close($conn);
        $m = "barang berhasil terhapus";
        header("location:../../index.php?content=barang");
    } else {
        mysqli_close($conn);
        $m = "barang berhasil terhapus";
        header("location:../../index.php?content=barang");
    }

?>