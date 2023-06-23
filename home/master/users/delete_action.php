<?php 

    include '../../../conn.php';
    session_start();

    $idUser = $_GET['id_user'];
    $queryHapusUser = mysqli_prepare($conn,"delete from user where id_user = ?");
    mysqli_stmt_bind_param($queryHapusUser, "s", $idUser);


    $queryLogHapusUser = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogHapusUser, "ssss", $no_transaksi, $action, $keterangan, $userid);
    $queryUser = mysqli_query($conn, "select * from user where id_user = '$idUser'");
    $rowUser = mysqli_fetch_assoc($queryUser);
    $no_transaksi = $idUser;
    $action = "DELETE" ;
    $keterangan = $_SESSION['username'] . " menghapus user " . $rowUser['nama'];
    $userid = $_SESSION['id_user'];


    if(mysqli_stmt_execute($queryHapusUser)){
        mysqli_stmt_execute($queryLogHapusUser);
        mysqli_close($conn);
        header("location:../../index.php?content=users");
    } else {
        mysqli_close($conn);
        header("location:../../index.php?content=users");
    }

?>