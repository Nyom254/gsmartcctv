<?php
    include '../../../conn.php';

    session_start();

    $queryTambahDepartemen = mysqli_prepare($conn, "insert into departemen (kode, nama, keterangan, status_aktif, inisial) values(?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryTambahDepartemen, "sssis", $kode, $nama, $keterangan, $status_aktif, $inisial);


    $queryKodeDepartemen= mysqli_query($conn, "select kode from departemen order by kode desc limit 1");
    $cekKodeBarang = $queryKodeDepartemen -> num_rows;

    if ($cekKodeBarang > 0) {
        $rowKodeBarang = mysqli_fetch_assoc($queryKodeDepartemen);
        $lastIdBarang = $rowKodeBarang['kode'];

        $id_letter = substr($lastIdBarang, 0, 1);
        $id_num = intval(substr($lastIdBarang, 1));
        $id_num++;
        $paddNum = str_pad($id_num, 6, '0', STR_PAD_LEFT);
        $kode = $id_letter . $paddNum;
    } else {
        $kode = "D000001";
    }
    $nama = mysqli_escape_string($conn, $_POST['nama']);
    $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
    $status_aktif = mysqli_escape_string($conn, $_POST['status']);
    $inisial = mysqli_escape_string($conn, $_POST['inisial']);

    $queryLogHapusDepartemen = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogHapusDepartemen, "ssss", $no_transaksi, $action, $keteranganLog, $userid);
    $no_transaksi = $kode;
    $action = "DELETE" ;
    $keteranganLog = $_SESSION['username'] . " menambah departemen " . $nama;
    $userid = $_SESSION['id_user'];


    if(mysqli_stmt_execute($queryTambahDepartemen)){
        mysqli_stmt_close($queryTambahDepartemen);
        mysqli_close($conn);
        $m = "berhasil menambahakan departemen";
        header("location:../../index.php?content=departemen&t=$m");
    } else {
        mysqli_stmt_close($queryTambahDepartemen);
        mysqli_close($conn);
        $m = "berhasil menambahakan departemen";
        header("location:../../index.php?content=departemen&t=$m");
    }

    
?>