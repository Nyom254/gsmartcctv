<?php 
    include '../../../conn.php';
    session_start();

    $queryEditDepartemen = mysqli_prepare($conn,"update departemen set nama = ?, keterangan = ?, status_aktif = ?, inisial = ? where kode = ? ");
    mysqli_stmt_bind_param($queryEditDepartemen,"ssiss", $nama, $keterangan, $status, $inisial,$kode);

    $nama = mysqli_escape_string($conn, $_POST['nama']);
    $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
    $status = mysqli_escape_string($conn, $_POST['status']);
    $inisial = mysqli_escape_string($conn, $_POST['inisial']);
    $kode = $_GET['kode'];

    $queryLogEditDepartemen = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogEditDepartemen, "ssss", $no_transaksi, $action, $keteranganLog, $userid);

    $queryDataDepartemenLama = mysqli_query($conn, "select * from departemen where kode = '$kode'");
    $rowDataDepartemenLama = mysqli_fetch_assoc($queryDataDepartemenLama);

    $editedDepartemen = array();

    if($nama !== $rowDataDepartemenLama['nama']){
        $editedDepartemen[] = "nama departemen dari " . $rowDataDepartemenLama['nama'] . " menjadi $nama";
    }
    if($keterangan !== $rowDataDepartemenLama['keterangan']){
        $editedDepartemen[] = "keterangan departemen dari " . $rowDataDepartemenLama['keterangan'] . " menjadi $keterangan";
    }
    if($status !== $rowDataDepartemenLama['status_aktif']){
        $editedDepartemen[] = "status departemen dari " . $rowDataDepartemenLama['status_aktif'] . " menjadi $status";
    }

    $isiKeteranganLog = implode(', ', $editedDepartemen);


    $no_transaksi = $kode;
    $action = "UPDATE" ;
    $keteranganLog = $_SESSION['username'] . " merubah " . $isiKeteranganLog;
    $userid = $_SESSION['id_user'];

    if(mysqli_stmt_execute($queryEditDepartemen)){
        mysqli_stmt_execute($queryLogEditDepartemen);
        mysqli_stmt_close($queryEditDepartemen);
        mysqli_close($conn);
        $m = "departemen berhasil diubah";
        header("location:../../index.php?content=departemen&t=$m");
    } else {
        mysqli_stmt_close($queryEditDepartemen);
        mysqli_close($conn);
        $m = "departemen berhasil diubah";
        header("location:../../index.php?content=departemen&t=$m");
    }
