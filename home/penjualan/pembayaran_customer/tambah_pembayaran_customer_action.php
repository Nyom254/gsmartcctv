<?php
session_start();

require_once("../../../tinify-php-master/lib/Tinify/Exception.php");
require_once("../../../tinify-php-master/lib/Tinify/ResultMeta.php");
require_once("../../../tinify-php-master/lib/Tinify/Result.php");
require_once("../../../tinify-php-master/lib/Tinify/Source.php");
require_once("../../../tinify-php-master/lib/Tinify/Client.php");
require_once("../../../tinify-php-master/lib/Tinify.php");
include '../../../conn.php';

$queryApi = mysqli_query($conn, "select * from `api_key` where name = 'tinify'");
$dataApi = mysqli_fetch_assoc($queryApi);
$keyTinyApi = $dataApi['key'];
\Tinify\setKey("$keyTinyApi");

$queryTambahPembayaranCustomer = mysqli_prepare($conn, "INSERT INTO pembayaran_customer (no_pembayaran, tanggal, kode_departemen, kode_customer, jenis_pembayaran, nama_bank, attachment, total, selisih, cruser) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($queryTambahPembayaranCustomer, "sssssssdds", $no_pembayaran, $tanggal, $kode_departemen, $kode_customer, $jenis_pembayaran, $nama_bank, $attachment, $total, $selisih, $cruser);

$no_pembayaran = mysqli_escape_string($conn, $_POST['no_pembayaran']);
$tanggal = mysqli_escape_string($conn, $_POST['tanggal']);
$kode_departemen = mysqli_escape_string($conn, $_POST['departemen']);
$kode_customer = mysqli_escape_string($conn, $_POST['customer']);
$jenis_pembayaran = mysqli_escape_string($conn, $_POST['jenis_pembayaran']);
$nama_bank = mysqli_escape_string($conn, $_POST['nama_bank']);
$total = mysqli_escape_string($conn, $_POST['totalBayar']);
$selisih = mysqli_escape_string($conn, $_POST['selisih']);
$attachment = null;
$cruser = $_SESSION['username'];

$no_invoice = $_POST['no-invoice'];
$tagihan = $_POST['tagihan'];
$potongan = $_POST['potongan'];
$bayar = $_POST['bayar'];


$queryLogTambahInvenTarisKantor = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
mysqli_stmt_bind_param($queryLogTambahInvenTarisKantor, "ssss", $no_pembayaran, $action, $keteranganLog, $userid);

$action = "INSERT";
$keteranganLog = $_SESSION['username'] . " menambahkan pembayaran customer  " . $no_pembayaran;
$userid = $_SESSION['id_user'];


if (array_key_exists('no-invoice', $_POST)) {
    if (file_exists($_FILES['attachment']['tmp_name']) || is_uploaded_file($_FILES['attachment']['tmp_name'])) {
        if (filesize($_FILES['attachment']['tmp_name']) < 20000000) {
            if ($_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
                $mimeTypes = ['image/jpeg', 'image/png', 'iamge/svg+xml', 'image/avif'];
                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($fileInfo, $_FILES['attachment']['tmp_name']);
                if (in_array($mimeType, $mimeTypes)) {
                    $sourceAttachment = file_get_contents($_FILES['attachment']['tmp_name']);
                    $attachment = \Tinify\fromBuffer($sourceAttachment)->toBuffer();
                    if (mysqli_stmt_execute($queryTambahPembayaranCustomer)) {
                        for ($i = 0; $i < count($_POST['no-invoice']); $i++) {
                            $queryTambahDetailPembayaran = mysqli_prepare($conn, "INSERT INTO detail_pembayaran (no_pembayaran, no_invoice, tagihan, potongan, bayar) VALUES(?, ?, ?, ?, ?)");
                            mysqli_stmt_bind_param($queryTambahDetailPembayaran, "ssddd", $no_pembayaran, $no_invoice[$i], $tagihan[$i], $potongan[$i], $bayar[$i]);

                            $queryUpdateInvoice = mysqli_prepare($conn, "UPDATE invoice_penjualan set status = 1, lama_pembayaran = ? where no_transaksi = ?");
                            mysqli_stmt_bind_param($queryUpdateInvoice, "is", $lama_pembayaran, $no_invoice[$i]);

                            $queryGetTanggalInvoice = mysqli_query($conn, "SELECT tanggal from invoice_penjualan where no_transaksi = '$no_invoice[$i]'");
                            $rowTanggalInvoice = mysqli_fetch_assoc($queryGetTanggalInvoice);
                            $tanggalInvoice = DateTime::createFromFormat('Y-m-d', $rowTanggalInvoice['tanggal']);
                            $tanggalPembayaran = DateTime::createFromFormat('Y-m-d', $tanggal);
                            $interval = $tanggalInvoice->diff($tanggalPembayaran);
                            $lama_pembayaran = $interval->days;
                            mysqli_stmt_execute($queryUpdateInvoice);
                            mysqli_stmt_execute($queryTambahDetailPembayaran);
                        }
                        mysqli_stmt_execute($queryLogTambahInvenTarisKantor);
                        mysqli_stmt_close($queryTambahPembayaranCustomer);
                        mysqli_stmt_close($queryTambahDetailPembayaran);
                        mysqli_stmt_close($queryLogTambahInvenTarisKantor);
                        mysqli_close($conn);
                        $m = "pembayaran customer berhasil ditambahkan";
                        header("location:../../index.php?content=pembayaran_customer&t=$m");
                    }
                }
            }
        }
    } else {
        if (mysqli_stmt_execute($queryTambahPembayaranCustomer)) {
            for ($i = 0; $i < count($_POST['no-invoice']); $i++) {
                $queryTambahDetailPembayaran = mysqli_prepare($conn, "INSERT INTO detail_pembayaran (no_pembayaran, no_invoice, tagihan, potongan, bayar) VALUES(?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($queryTambahDetailPembayaran, "ssddd", $no_pembayaran, $no_invoice[$i], $tagihan[$i], $potongan[$i], $bayar[$i]);

                $queryUpdateInvoice = mysqli_prepare($conn, "UPDATE invoice_penjualan set status = 1, lama_pembayaran = ? where no_transaksi = ?");
                mysqli_stmt_bind_param($queryUpdateInvoice, "is", $lama_pembayaran, $no_invoice[$i]);

                $queryGetTanggalInvoice = mysqli_query($conn, "SELECT tanggal from invoice_penjualan where no_transaksi = '$no_invoice[$i]'");
                $rowTanggalInvoice = mysqli_fetch_assoc($queryGetTanggalInvoice);
                $tanggalInvoice = DateTime::createFromFormat('Y-m-d', $rowTanggalInvoice['tanggal']);
                $tanggalPembayaran = DateTime::createFromFormat('Y-m-d', $tanggal);
                $interval = $tanggalInvoice->diff($tanggalPembayaran);
                $lama_pembayaran = $interval->days;
                mysqli_stmt_execute($queryUpdateInvoice);

                mysqli_stmt_execute($queryTambahDetailPembayaran);
            }
            mysqli_stmt_execute($queryLogTambahInvenTarisKantor);
            mysqli_stmt_close($queryTambahPembayaranCustomer);
            mysqli_stmt_close($queryLogTambahInvenTarisKantor);
            mysqli_close($conn);
            $m = "pembayaran customer berhasil ditambahkan";
            header("location:../../index.php?content=pembayaran_customer&t=$m");
        } else {
            mysqli_stmt_close($queryTambahPembayaranCustomer);
            mysqli_close($conn);
            $m = "pembayaran customer gagal ditambahkan";
            header("location:../../index.php?content=tambah_pembayaran_customer&t=$m");
        }
    }
} else {
    mysqli_close($conn);
    $m = "mohon isi invoice";
    header("location:../../index.php?content=tambah_pembayaran_customer&t=$m");
}
