<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (!isset($_SESSION['status'])) {
        http_response_code(403);
        echo "Anda harus Login untuk mengakses resources ini";
    } else {
        require '../../conn.php';

        $queryTambahkertas = mysqli_prepare($conn, "insert into KERTAS (no_kertas, tgl, jenis, keterangan, qty, kode_user, cruser, kode_barang) values(?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($queryTambahkertas, "ssssisss", $no_kertas, $tanggal, $jenis, $keterangan, $qty, $kode_user, $cruser, $kode_barang);

        $no_kertas = mysqli_escape_string($conn, $_POST['no_kertas']);
        $tanggal = mysqli_escape_string($conn, $_POST['tanggal']);
        $jenis = mysqli_escape_string($conn, $_POST['jenis']);
        $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
        $qty = mysqli_escape_string($conn, $_POST['quantity']);
        $kode_user = mysqli_escape_string($conn, $_POST['kode_user']);
        $cruser = $_SESSION['username'];
        $kode_barang = mysqli_escape_string($conn, $_POST['kode_barang']);

        $queryLogTambahKertas = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
        mysqli_stmt_bind_param($queryLogTambahKertas, "ssss", $no_kertas, $action, $keteranganLog, $userid);

        $action = "INSERT";
        $keteranganLog = $_SESSION['username'] . " menambahkan kertas  " . $no_kertas;
        $userid = $_SESSION['id_user'];


        if (mysqli_stmt_execute($queryTambahkertas)) {
            mysqli_stmt_execute($queryLogTambahKertas);
            mysqli_stmt_close($queryTambahkertas);
            mysqli_stmt_close($queryLogTambahKertas);
            mysqli_close($conn);
            $m = "berhasil menambahkan kertas";
            header("location:../index.php?content=pemakaian_kertas&t=$m");
        } else {
            mysqli_stmt_close($queryTambahkertas);
            mysqli_close($conn);
            $m = "gagal menambahkan kertas";
            header("location:../index.php?content=pemakaian_kertas&t=$m");
        }
    }
} else {
    http_response_code(405);
}
