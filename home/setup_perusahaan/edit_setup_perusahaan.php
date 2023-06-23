<?php
require_once("../../../tinify-php-master/lib/Tinify/Exception.php");
require_once("../../../tinify-php-master/lib/Tinify/ResultMeta.php");
require_once("../../../tinify-php-master/lib/Tinify/Result.php");
require_once("../../../tinify-php-master/lib/Tinify/Source.php");
require_once("../../../tinify-php-master/lib/Tinify/Client.php");
require_once("../../../tinify-php-master/lib/Tinify.php");
include '../../conn.php';
session_start();

$queryApi = mysqli_query($conn, "select * from api_key where name = `tinify`");
$dataApi = mysqli_fetch_assoc($queryApi);
$keyTinyApi = $dataApi['key'];
\Tinify\setKey("$keyTinyApi");


if (file_exists($_FILES['logo_perusahaan']['tmp_name']) || is_uploaded_file($_FILES['logo_perusahaan']['tmp_name'])) {
    $queryEditPerusahaan = mysqli_prepare($conn, "update setup_perusahaan set inisial = ?, nama = ?, alamat = ?, kota = ?, provinsi = ?, kode_pos = ?, no_telp = ?, no_rek = ?, logo_perusahaan = ?");
    mysqli_stmt_bind_param($queryEditPerusahaan, "sssssisss", $inisial, $nama, $alamat, $kota, $provinsi, $kode_pos, $no_telp, $no_rek, $logo_perusahaan);

    $inisial = mysqli_escape_string($conn, $_POST['inisial']);
    $nama = mysqli_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_escape_string($conn, $_POST['alamat']);
    $kota = mysqli_escape_string($conn, $_POST['kota']);
    $provinsi = mysqli_escape_string($conn, $_POST['provinsi']);
    $kode_pos = mysqli_escape_string($conn, $_POST['kode_pos']);
    $no_telp = mysqli_escape_string($conn, $_POST['no_telp']);
    $no_rek = $_POST['no_rek'];
    $logo_perusahaan;

    if ($_FILES['logo_perusahaan']['error'] === UPLOAD_ERR_OK) {
        $mimeTypes = ['image/jpeg', 'image/png'];
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $_FILES['logo_perusahaan']['tmp_name']);

        if (in_array($mimeType, $mimeTypes)) {
            $sourceAttachment = file_get_contents($_FILES['logo_perusahaan']['tmp_name']);
            $logo_perusahaan = \Tinify\fromBuffer($sourceAttachment)->toBuffer();

            $queryLogEditSetupPerusahaan = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
            mysqli_stmt_bind_param($queryLogEditSetupPerusahaan, "ssss", $no_transaksi, $action, $keterangan, $userid);

            $queryDataPerusahaanLama = mysqli_query($conn, "select * from setup_perusahaan");
            $rowDataPerusahaanLama = mysqli_fetch_assoc($queryDataPerusahaanLama);

            $editedBarang = array();

            if ($inisial !== $rowDataPerusahaanLama['inisial']) {
                $editedBarang[] = "inisial perusahaan dari " . $rowDataPerusahaanLama['inisial'] . " menjadi $inisial";
            }
            if ($nama !== $rowDataPerusahaanLama['nama']) {
                $editedBarang[] = "nama perusahaan dari " . $rowDataPerusahaanLama['nama'] . " menjadi $nama";
            }
            if ($alamat !== $rowDataPerusahaanLama['alamat']) {
                $editedBarang[] = "alamat perusahaan dari " . $rowDataPerusahaanLama['alamat'] . " menjadi $alamat";
            }
            if ($kota !== $rowDataPerusahaanLama['kota']) {
                $editedBarang[] = "kota perusahaan dari " . $rowDataPerusahaanLama['kota'] . " menjadi $kota";
            }
            if ($provinsi !== $rowDataPerusahaanLama['provinsi']) {
                $editedBarang[] = "provinsi perusahaan dari " . $rowDataPerusahaanLama['provinsi'] . " menjadi $provinsi";
            }
            if ($kode_pos !== $rowDataPerusahaanLama['kode_pos']) {
                $editedBarang[] = "kode pos perusahaan dari " . $rowDataPerusahaanLama['kode_pos'] . " menjadi $kode_pos";
            }
            if ($no_telp !== $rowDataPerusahaanLama['no_telp']) {
                $editedBarang[] = "nomor telepon perusahaan dari " . $rowDataPerusahaanLama['no_telp'] . " menjadi $no_telp";
            }
            if ($no_rek !== $rowDataPerusahaanLama['no_rek']) {
                $editedBarang[] = "nomor rekening perusahaan dari " . $rowDataPerusahaanLama['no_rek'] . " menjadi $no_rek";
            }
            $editedBarang[] = "logo perusahaan";

            $keteranganLog = implode(', ', $editedBarang);

            $no_transaksi = "setup perusahaan";
            $action = "UPDATE";
            $keterangan = $_SESSION['username'] . " merubah " . $keteranganLog;
            $userid = $_SESSION['id_user'];
            if (mysqli_stmt_execute($queryEditPerusahaan)) {
                mysqli_stmt_execute($queryLogEditSetupPerusahaan);
                mysqli_stmt_close($queryEditPerusahaan);
                mysqli_close($conn);
                $m = "berhasil mengedit perusahaan";
                header("location:../index.php?content=setup_perusahaan&t=$m");
            } else {
                mysqli_close($conn);
                $m = "gagal mengedit perusahaan";
                header("location:../index.php?content=setup_perusahaan&t=$m");
            }
        } else {
            $m = "hanya menerima file berupa jpeg dan png";
            header("location:../index.php?content=setup_perusahaan&t=$m");
        }
    } else {
        $m = "error dalam mengupload gambar";
        header("location:../index.php?content=setup_perusahaan&t=$m");
    }
} else {
    $queryEditPerusahaan = mysqli_prepare($conn, "update setup_perusahaan set inisial = ?, nama = ?, alamat = ?, kota = ?, provinsi = ?, kode_pos = ?, no_telp = ?, no_rek = ?");
    mysqli_stmt_bind_param($queryEditPerusahaan, "sssssiss", $inisial, $nama, $alamat, $kota, $provinsi, $kode_pos, $no_telp, $no_rek);

    $inisial = mysqli_escape_string($conn, $_POST['inisial']);
    $nama = mysqli_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_escape_string($conn, $_POST['alamat']);
    $kota = mysqli_escape_string($conn, $_POST['kota']);
    $provinsi = mysqli_escape_string($conn, $_POST['provinsi']);
    $kode_pos = mysqli_escape_string($conn, $_POST['kode_pos']);
    $no_telp = mysqli_escape_string($conn, $_POST['no_telp']);
    $no_rek = $_POST['no_rek'];

    $queryLogEditSetupPerusahaan = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogEditSetupPerusahaan, "ssss", $no_transaksi, $action, $keterangan, $userid);

    $queryDataPerusahaanLama = mysqli_query($conn, "select * from setup_perusahaan");
    $rowDataPerusahaanLama = mysqli_fetch_assoc($queryDataPerusahaanLama);

    $editedBarang = array();

    if ($inisial !== $rowDataPerusahaanLama['inisial']) {
        $editedBarang[] = "inisial perusahaan dari " . $rowDataPerusahaanLama['inisial'] . " menjadi $inisial";
    }
    if ($nama !== $rowDataPerusahaanLama['nama']) {
        $editedBarang[] = "nama perusahaan dari " . $rowDataPerusahaanLama['nama'] . " menjadi $nama";
    }
    if ($alamat !== $rowDataPerusahaanLama['alamat']) {
        $editedBarang[] = "alamat perusahaan dari " . $rowDataPerusahaanLama['alamat'] . " menjadi $alamat";
    }
    if ($kota !== $rowDataPerusahaanLama['kota']) {
        $editedBarang[] = "kota perusahaan dari " . $rowDataPerusahaanLama['kota'] . " menjadi $kota";
    }
    if ($provinsi !== $rowDataPerusahaanLama['provinsi']) {
        $editedBarang[] = "provinsi perusahaan dari " . $rowDataPerusahaanLama['provinsi'] . " menjadi $provinsi";
    }
    if ($kode_pos !== $rowDataPerusahaanLama['kode_pos']) {
        $editedBarang[] = "kode pos perusahaan dari " . $rowDataPerusahaanLama['kode_pos'] . " menjadi $kode_pos";
    }
    if ($no_telp !== $rowDataPerusahaanLama['no_telp']) {
        $editedBarang[] = "nomor telepon perusahaan dari " . $rowDataPerusahaanLama['no_telp'] . " menjadi $no_telp";
    }
    if ($no_rek !== $rowDataPerusahaanLama['no_rek']) {
        $editedBarang[] = "nomor rekening perusahaan dari " . $rowDataPerusahaanLama['no_rek'] . " menjadi $no_rek";
    }
    if (empty($editedBarang)) {
        $editedBarang[] = "tidak ada";
    }

    $keteranganLog = implode(', ', $editedBarang);

    $no_transaksi = "setup perusahaan";
    $action = "UPDATE";
    $keterangan = $_SESSION['username'] . " merubah " . $keteranganLog;
    $userid = $_SESSION['id_user'];
    if (mysqli_stmt_execute($queryEditPerusahaan)) {
        mysqli_stmt_execute($queryLogEditSetupPerusahaan);
        mysqli_stmt_close($queryEditPerusahaan);
        mysqli_close($conn);
        $m = "perusahaan berhasil diubah";
        header("location:../index.php?content=setup_perusahaan&t=$m");
    }
}
