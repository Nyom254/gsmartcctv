<?php

require_once("../../tinify-php-master/lib/Tinify/Exception.php");
require_once("../../tinify-php-master/lib/Tinify/ResultMeta.php");
require_once("../../tinify-php-master/lib/Tinify/Result.php");
require_once("../../tinify-php-master/lib/Tinify/Source.php");
require_once("../../tinify-php-master/lib/Tinify/Client.php");
require_once("../../tinify-php-master/lib/Tinify.php");
include '../../conn.php';

$queryApi = mysqli_query($conn, "select * from `api_key` where name = 'tinify'");
$dataApi = mysqli_fetch_assoc($queryApi);
$keyTinyApi = $dataApi['key'];
\Tinify\setKey("$keyTinyApi");

session_start();

$queryTambahInventaris = mysqli_prepare($conn, "insert into inventaris_kantor (no_inventaris, tgl, nama_barang, posisi, keterangan, qty, attachment, cruser, crtime) values(?, ?, ?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($queryTambahInventaris, "sssssisss", $no_inventaris, $tanggal, $nama_barang, $posisi, $keterangan, $quantity, $attachment, $cruser, $crtime);

$no_inventaris = mysqli_escape_string($conn, $_POST['no_inventaris']);
$tanggal = mysqli_escape_string($conn, $_POST['tanggal']);
$nama_barang = mysqli_escape_string($conn, $_POST['nama_barang']);
$posisi = mysqli_escape_string($conn, $_POST['posisi']);
$keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
$quantity = mysqli_escape_string($conn, $_POST['quantity']);
$cruser = $_SESSION['username'];
date_default_timezone_set("Asia/jakarta");
$crtime = date('Y-m-d h:i:s');

$queryLogTambahInvenTarisKantor = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogTambahInvenTarisKantor, "ssss", $no_inventaris, $action, $keteranganLog, $userid);

    $action = "INSERT" ;
    $keteranganLog = $_SESSION['username'] . " menambahkan inventaris kantor  " . $no_inventaris;
    $userid = $_SESSION['id_user'];

if ($_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $mimeTypes = ['image/jpeg', 'image/png', 'iamge/svg+xml', 'image/avif'];
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($fileInfo, $_FILES['gambar']['tmp_name']);

    if (in_array($mimeType, $mimeTypes)) {
        $sourceAttachment = file_get_contents($_FILES['gambar']['tmp_name']);
        $attachment = \Tinify\fromBuffer($sourceAttachment)->toBuffer();
        if (mysqli_stmt_execute($queryTambahInventaris)) {
            mysqli_stmt_execute($queryLogTambahInvenTarisKantor);
            mysqli_stmt_close($queryTambahInventaris);
            mysqli_stmt_close($queryLogTambahInvenTarisKantor);
            mysqli_close($conn);
            $m = "berhasil menambahkan inventaris kantor";
            header("location:../index.php?content=inventaris_kantor&t=$m");
        } else {
            mysqli_stmt_close($queryTambahInventaris);
            mysqli_close($conn);
            $m = "gagal menambahkan inventaris kantor";
            header("location:../index.php?content=inventaris_kantor&t=$m");
        }
    } else {
        mysqli_close($conn);
        $m = "upload gambar dengan format yang benar";
        header("location:../index.php?content=inventaris_kantor&t=$m");
    }
} else {
    mysqli_close($conn);
    $m = "error dalam mengupload gambar";
    header("location:../index.php?content=inventaris_kantor&t=$m");
}
