<?php 
    include '../../../conn.php';
    session_start();

    $queryEditGroupBarang = mysqli_prepare($conn,"update group_barang set nama_group = ?, status_aktif = ?  where id_group = ? ");
    mysqli_stmt_bind_param($queryEditGroupBarang,"sis", $nama_group,  $status,$id_group);

    $nama_group = mysqli_escape_string($conn, $_POST['nama_group']);
    $status = mysqli_escape_string($conn, $_POST['status']);
    $id_group = $_GET['id_group'];

    $queryLogEditGroup = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogEditGroup, "ssss", $no_transaksi, $action, $keterangan, $userid);

    $queryDataGroupLama = mysqli_query($conn, "select * from group_barang where id_group = '$id_group'");
    $rowDataGroupLama = mysqli_fetch_assoc($queryDataGroupLama);

    $editedGroup = array();

    if($nama_group !== $rowDataGroupLama['nama_group']){
        $editedGroup[] = "nama group dari " . $rowDataGroupLama['nama_group'] . " menjadi $nama_group";
    }
    if($status !== $rowDataGroupLama['status_aktif']){
        $editedGroup[] = "status group barang dari " . $rowDataGroupLama['status_aktif'] . " menjadi $status";
    }

    $keteranganLog = implode(', ', $editedGroup);


    $no_transaksi = $id_group;
    $action = "UPDATE" ;
    $keterangan = $_SESSION['username'] . " merubah " . $keteranganLog;
    $userid = $_SESSION['id_user'];

    if(mysqli_stmt_execute($queryEditGroupBarang)){
        mysqli_stmt_execute($queryLogEditGroup);
        mysqli_stmt_close($queryEditGroupBarang);
        mysqli_close($conn);
        header("location:../../index.php?content=group_barang");
    } else {
        mysqli_stmt_close($queryEditGroupBarang);
        mysqli_close($conn);
        header("location:../../index.php?content=group_barang");
    }
?>