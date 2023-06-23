<?php 
    include '../../../conn.php';
    session_start();

    $queryTambahCustomer = mysqli_prepare($conn,"insert into customer (id_customer, nama, alamat, telp, kota, provinsi, keterangan, status_aktif, email, status) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryTambahCustomer,"sssssssiss", $id_customer, $nama, $alamat, $telp, $kota, $provinsi, $keterangan, $status_aktif, $email, $status);

    $queryIdCustomer= mysqli_query($conn, "select id_customer from customer order by id_customer desc limit 1");
    $cekIdCustomer = $queryIdCustomer -> num_rows;

    if ($cekIdCustomer > 0) {
        $rowIdCustomer = mysqli_fetch_assoc($queryIdCustomer);
        $lastIdCustomer = $rowIdCustomer['id_customer'];

        $id_letter = substr($lastIdCustomer, 0, 1);
        $id_num = intval(substr($lastIdCustomer, 1));
        $id_num++;
        $paddNum = str_pad($id_num, 6, '0', STR_PAD_LEFT);
        $id_customer = $id_letter . $paddNum;
    } else {
        $id_customer = "C000001";
    }

    $nama = mysqli_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_escape_string($conn, $_POST['alamat']);
    $telp = mysqli_escape_string($conn, $_POST['no_telp']);
    $kota = mysqli_escape_string($conn, $_POST['kota']);
    $provinsi = mysqli_escape_string($conn, $_POST['provinsi']);
    $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
    $status_aktif = mysqli_escape_string($conn, $_POST['status_aktif']);
    $email = mysqli_escape_string($conn, $_POST['email']);
    $status = mysqli_escape_string($conn, $_POST['status']);

    $queryLogTambahCustomer = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogTambahCustomer, "ssss", $no_transaksi, $action, $keteranganLog, $userid);

    $no_transaksi = $id_customer;
    $action = "INSERT" ;
    $keteranganLog = $_SESSION['username'] . " menambahkan customer " . $nama;
    $userid = $_SESSION['id_user'];

    if(mysqli_stmt_execute($queryTambahCustomer)) {
        mysqli_stmt_execute($queryLogTambahCustomer);
        mysqli_stmt_close($queryTambahCustomer);
        mysqli_close($conn);
        header("location:../../index.php?content=customer");
    } else {
        mysqli_close($conn);
        header("location:../../index.php?content=customer");
    }
?>