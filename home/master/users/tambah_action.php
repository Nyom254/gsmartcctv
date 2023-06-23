<?php 
    include '../../../conn.php';

    session_start();

    $queryTambahUser = mysqli_prepare($conn, "insert into user (nama, username, password, level, status_aktif) values (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryTambahUser,"ssssi",$nama,$username,$password, $level, $status_aktif);

    $nama = mysqli_escape_string($conn,$_POST['nama']);
    $username = mysqli_escape_string($conn,$_POST['username']);
    $password = mysqli_escape_string($conn,$_POST['password']);
    $level = mysqli_escape_string($conn, $_POST['level']);
    $status_aktif = mysqli_escape_string($conn, $_POST['status']);

    $queryLogTambahUser = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogTambahUser, "ssss", $no_transaksi, $action, $keterangan, $userid);

    $action = "INSERT" ;
    $keterangan = $_SESSION['username'] . " menambahkan user  " . $nama;
    $userid = $_SESSION['id_user'];

    if (mysqli_stmt_execute($queryTambahUser)){

        $queryUser = mysqli_query($conn, "select id_user from user where nama = '$nama'");
        $id_user = mysqli_fetch_assoc($queryUser);
        $no_transaksi = $id_user['id_user'];

        mysqli_stmt_execute($queryLogTambahUser);
        mysqli_stmt_close($queryTambahUser);
        mysqli_close($conn);
        header("location:../../index.php?content=users");
    } else {
        mysqli_stmt_close($queryTambahUser);
        mysqli_close($conn);
        header("location:../../index.php?content=users");
    }
?>