<?php 
    include '../../../conn.php';
    session_start();

    $queryTambahGudang = mysqli_prepare($conn, "insert into Gudang (kode, nama, alamat, penanggung_jawab, status_aktif) values (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryTambahGudang, "ssssi", $kode, $nama, $alamat, $penanggung_jawab, $status_aktif);
    $queryKodeGudang = mysqli_query($conn, "select kode from Gudang order by kode desc limit 1");
    $cekKodeGudang = $queryKodeGudang -> num_rows;

    if ($cekKodeGudang > 0) {
        $rowKodeGudang = mysqli_fetch_assoc($queryKodeGudang);
        $lastKode = $rowKodeGudang['kode'];

        $id_letter = substr($lastKode, 0, 2);
        $id_num = intval(substr($lastKode, 2));
        $id_num++;
        $paddNum = str_pad($id_num, 2, '0', STR_PAD_LEFT);
        $kode = $id_letter . $paddNum;
    } else {
        $kode = "GD01";
    }

    $nama = mysqli_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_escape_string($conn, $_POST['alamat']);
    $penanggung_jawab = mysqli_escape_string($conn, $_POST['penanggung_jawab']);
    $status_aktif = $_POST['status'];

    $queryLogTambahGudang = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogTambahGudang, "ssss", $no_transaksi, $action, $keteranganLog, $userid);

    $no_transaksi = $kode;
    $action = "INSERT" ;
    $keteranganLog = $_SESSION['username'] . " menambahkan gudang  " . $nama;
    $userid = $_SESSION['id_user'];

    if(mysqli_stmt_execute($queryTambahGudang)){
        mysqli_stmt_execute($queryLogTambahGudang);
        mysqli_close($conn);
        $m = "gudang berhasil ditambahkan";
        header("location:../../index.php?content=gudang&t=$m");
    }
    else {
        mysqli_close($conn);
        $m = "gudang gagal ditambahkan";
        header(("location:../../index.php?content=gudang&t=$m"));
    }

?>