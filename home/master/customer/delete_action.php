<?php 
    include '../../../conn.php';
    session_start();

    $id_customer = $_GET['id_customer'];

    $queryHapusCustomer = mysqli_prepare($conn,"delete from customer where id_customer = ?");
    mysqli_stmt_bind_param($queryHapusCustomer, "s", $id_customer);

    $queryLogHapusCustomer = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogHapusCustomer, "ssss", $no_transaksi, $action, $keterangan, $userid);
    $queryCustomer = mysqli_query($conn, "select * from customer where id_customer = '$id_customer'");
    $rowCustomer = mysqli_fetch_assoc($queryCustomer);
    $no_transaksi = $id_customer;
    $action = "DELETE" ;
    $keterangan = $_SESSION['username'] . " menghapus customer " . $rowCustomer['nama'];
    $userid = $_SESSION['id_user'];


    if(mysqli_stmt_execute($queryHapusCustomer)) {
        mysqli_stmt_execute($queryLogHapusCustomer);
        mysqli_close($conn);
        header("location:../../index.php?content=customer");
    } else {
        mysqli_close($conn);
        header("location:../../index.php?content=customer");
    }

?>