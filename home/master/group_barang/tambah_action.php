<?php 
    include '../../../conn.php';
    session_start();


    $queryTambahGroupBarang = mysqli_prepare($conn, "insert into group_barang (id_group, nama_group, status_aktif) values (?, ?, ?)");
    mysqli_stmt_bind_param($queryTambahGroupBarang, "ssi", $id_group, $nama_group, $status);

    $queryIdGroup= mysqli_query($conn, "select id_group from group_barang order by id_group desc limit 1");
    $cekIdGroup = $queryIdGroup -> num_rows;

    if ($cekIdGroup > 0) {
        $rowIdGroup = mysqli_fetch_assoc($queryIdGroup);
        $lastIdGroup = $rowIdGroup['id_group'];

        $id_letter = substr($lastIdGroup, 0, 1);
        $id_num = intval(substr($lastIdGroup, 1));
        $id_num++;
        $paddNum = str_pad($id_num, 6, '0', STR_PAD_LEFT);
        $id_group = $id_letter . $paddNum;
    } else {
        $id_group = "G000001";
    }

    $nama_group = mysqli_escape_string($conn, $_POST['nama_group']);
    $status = mysqli_escape_string($conn, $_POST['status']);

    $queryLogTambahGroup = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogTambahGroup, "ssss", $no_transaksi, $action, $keterangan, $userid);

    $no_transaksi = $id_group;
    $action = "INSERT" ;
    $keterangan = $_SESSION['username'] . " menambahkan group barang  " . $nama_group;
    $userid = $_SESSION['id_user'];

    if(mysqli_stmt_execute($queryTambahGroupBarang)){
        mysqli_stmt_execute($queryLogTambahGroup);
        mysqli_close($conn);
        header("location:../../index.php?content=group_barang");
    } else {
        mysqli_close($conn);
        header("location:../../index.php?content=group_barang");
    }

?>