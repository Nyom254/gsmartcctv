<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (!isset($_SESSION['status'])) {
        http_response_code(403);
        echo "Anda harus Login untuk mengakses resources ini";
    } else {
        require '../../../conn.php';

        $queryTambahBarang = mysqli_prepare($conn, "insert into barang (id_barang, nama, harga, status_aktif, satuan, group_barang, type, kode_departemen) values (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($queryTambahBarang, "ssiissss", $id_barang, $nama_barang, $harga, $status_aktif, $satuan, $group_barang, $type, $kode_departemen);


        $queryIdBarang = mysqli_query($conn, "select id_barang from barang order by id_barang desc limit 1");
        $cekIdBarang = $queryIdBarang->num_rows;

        if ($cekIdBarang > 0) {
            $rowIdBarang = mysqli_fetch_assoc($queryIdBarang);
            $lastIdBarang = $rowIdBarang['id_barang'];

            $id_letter = substr($lastIdBarang, 0, 1);
            $id_num = intval(substr($lastIdBarang, 1));
            $id_num++;
            $paddNum = str_pad($id_num, 6, '0', STR_PAD_LEFT);
            $id_barang = $id_letter . $paddNum;
        } else {
            $id_barang = "B000001";
        }

        $nama_barang = mysqli_escape_string($conn, $_POST['nama']);
        $harga = mysqli_escape_string($conn, $_POST['harga']);
        $satuan = mysqli_escape_string($conn, $_POST['satuan']);
        $status_aktif = mysqli_escape_string($conn, $_POST['status']);
        $group_barang = mysqli_escape_string($conn, $_POST['group_barang']);
        $type = mysqli_escape_string($conn, $_POST['type']);
        $kode_departemen = mysqli_escape_string($conn, $_POST['departemen']);


        $queryLogTambahBarang = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
        mysqli_stmt_bind_param($queryLogTambahBarang, "ssss", $no_transaksi, $action, $keterangan, $userid);

        $no_transaksi = $id_barang;
        $action = "INSERT";
        $keterangan = $_SESSION['username'] . " menambahkan barang " . $nama_barang;
        $userid = $_SESSION['id_user'];


        if (mysqli_stmt_execute($queryTambahBarang)) {
            mysqli_stmt_execute($queryLogTambahBarang);
            mysqli_close($conn);
            header("location:../../index.php?content=barang");
        } else {
            mysqli_close($conn);
            $m = "barang gagal ditambahkan";
            header("location:../index.php?content=barang");
        }
    }
} else {
    http_response_code(405);
}
