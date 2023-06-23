<?php 
    include '../../conn.php';

    
    session_start();
    
    $no_inventaris = $_GET['no_inventaris'];

    $queryDeleteInventarisKantor = mysqli_prepare($conn, "delete from inventaris_kantor where no_inventaris = ?");
    mysqli_stmt_bind_param($queryDeleteInventarisKantor, "s", $no_inventaris);
    $queryLogTambahInvenTarisKantor = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogTambahInvenTarisKantor, "ssss", $no_inventaris, $action, $keteranganLog, $userid);

    $action = "INSERT" ;
    $keteranganLog = $_SESSION['username'] . " menghapus inventaris kantor  " . $no_inventaris;
    $userid = $_SESSION['id_user'];


    if (mysqli_stmt_execute($queryDeleteInventarisKantor) > 0) {
        mysqli_stmt_execute($queryLogTambahInvenTarisKantor);
        mysqli_stmt_close($queryLogTambahInvenTarisKantor);
        mysqli_close($conn);
        $m = "berhasil menghapus inventaris kantor";
        header("location:../index.php?content=inventaris_kantor&t=$m");
    } else {
        mysqli_close($conn);
        $m = "gagal menghapus inventaris kantor";
        header("location:../index.php?content=inventaris_kantor&t=$m");
    }

?>