<?php
require_once("../../../tinify-php-master/lib/Tinify/Exception.php");
require_once("../../../tinify-php-master/lib/Tinify/ResultMeta.php");
require_once("../../../tinify-php-master/lib/Tinify/Result.php");
require_once("../../../tinify-php-master/lib/Tinify/Source.php");
require_once("../../../tinify-php-master/lib/Tinify/Client.php");
require_once("../../../tinify-php-master/lib/Tinify.php");
include '../../conn.php';

$queryApi = mysqli_query($conn, "select * from api_key where name = `tinify`");
$dataApi = mysqli_fetch_assoc($queryApi);
$keyTinyApi = $dataApi['key'];
\Tinify\setKey("$keyTinyApi");
session_start();

if (file_exists($_FILES['gambar']['tmp_name']) || is_uploaded_file($_FILES['gambar']['tmp_name'])) {

    if (filesize($_FILES['gambar']['tmp_name']) < 20000000) {
        $queryEditInventaris = mysqli_prepare($conn, "update inventaris_kantor set tgl = ?, nama_barang = ?, posisi = ?, keterangan = ?, qty = ?, attachment = ?, mduser = ?, mdtime = ? where no_inventaris = ?");
        mysqli_stmt_bind_param($queryEditInventaris, "ssssissss", $tanggal, $nama_barang, $posisi, $keterangan, $qty, $attachment, $mduser, $mdtime, $no_inventaris);

        $tanggal = mysqli_escape_string($conn, $_POST['tanggal']);
        $nama_barang = mysqli_escape_string($conn, $_POST['nama_barang']);
        $posisi = mysqli_escape_string($conn, $_POST['posisi']);
        $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
        $qty = mysqli_escape_string($conn, $_POST['quantity']);
        $no_inventaris = mysqli_escape_string($conn, $_POST['no_inventaris']);
        $mduser = $_SESSION['username'];
        date_default_timezone_set("Asia/jakarta");
        $mdtime = date('Y-m-d h:i:s');

        $queryLogEditInventarisKantor = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
        mysqli_stmt_bind_param($queryLogEditInventarisKantor, "ssss", $no_transaksi, $action, $keteranganLog, $userid);

        $queryDataInventarisKantorLama = mysqli_query($conn, "select * from inventaris_kantor where no_inventaris = '$no_inventaris'");
        $rowDataInventarisLama = mysqli_fetch_assoc($queryDataInventarisKantorLama);

        $editedInventarisKantor = array();

        if ($tanggal !== $rowDataInventarisLama['tgl']) {
            $editedInventarisKantor[] = "tanggal inventaris dari " . $rowDataInventarisLama['tgl'] . " menjadi $tanggal";
        }
        if ($nama_barang !== $rowDataInventarisLama['nama_barang']) {
            $editedInventarisKantor[] = "nama barang inventaris dari " . $rowDataInventarisLama['nama_barang'] . " menjadi $nama_barang";
        }
        if ($posisi !== $rowDataInventarisLama['posisi']) {
            $editedInventarisKantor[] = "posisi inventaris dari " . $rowDataInventarisLama['posisi'] . " menjadi $posisi";
        }
        if ($keterangan !== $rowDataInventarisLama['keterangan']) {
            $editedInventarisKantor[] = "keterangan inventaris dari " . $rowDataInventarisLama['keterangan'] . " menjadi $keterangan";
        }
        if ($qty !== $rowDataInventarisLama['qty']) {
            $editedInventarisKantor[] = "quantity inventaris dari " . $rowDataInventarisLama['qty'] . " menjadi $qty";
        }
        $editedInventarisKantor[] = "attachment inventaris";

        $isiKeteranganLog = implode(', ', $editedInventarisKantor);

        $no_transaksi = $no_inventaris;
        $action = "UPDATE";
        $keteranganLog = $_SESSION['username'] . " merubah " . $isiKeteranganLog;
        $userid = $_SESSION['id_user'];

        if ($_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $mimeTypes = ['image/jpeg', 'image/png', 'iamge/svg+xml', 'image/avif'];
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfo, $_FILES['gambar']['tmp_name']);

            if (in_array($mimeType, $mimeTypes)) {
                $sourceAttachment = file_get_contents($_FILES['gambar']['tmp_name']);
                $attachment = \Tinify\fromBuffer($sourceAttachment)->toBuffer();
                if (mysqli_stmt_execute($queryEditInventaris)) {
                    mysqli_stmt_execute($queryLogEditInventarisKantor);
                    mysqli_stmt_close($queryEditInventaris);
                    mysqli_stmt_close($queryLogEditInventarisKantor);
                    mysqli_close($conn);
                    $m = "berhasil mengubah inventaris kantor";
                    header("location:../index.php?content=inventaris_kantor&t=$m");
                } else {
                    mysqli_stmt_close($queryEditInventaris);
                    mysqli_close($conn);
                    $m = "gagal mengubah inventaris kantor";
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
    } else {
        $m = "gambar tidak boleh lebih dar 1 MB";
        header("location:../index.php?content=inventaris_kantor&t=$m");
    }
} else {
    $queryEditInventaris = mysqli_prepare($conn, "update inventaris_kantor set tgl = ?, nama_barang = ?, posisi = ?, keterangan = ?, qty = ?, mduser = ?, mdtime = ? where no_inventaris = ?");
    mysqli_stmt_bind_param($queryEditInventaris, "ssssisss", $tanggal, $nama_barang, $posisi, $keterangan, $qty, $mduser, $mdtime, $no_inventaris);

    $tanggal = mysqli_escape_string($conn, $_POST['tanggal']);
    $nama_barang = mysqli_escape_string($conn, $_POST['nama_barang']);
    $posisi = mysqli_escape_string($conn, $_POST['posisi']);
    $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
    $qty = mysqli_escape_string($conn, $_POST['quantity']);
    $no_inventaris = mysqli_escape_string($conn, $_POST['no_inventaris']);
    $mduser = $_SESSION['username'];
    date_default_timezone_set("Asia/jakarta");
    $mdtime = date('Y-m-d h:i:s');

    $queryLogEditInventarisKantor = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogEditInventarisKantor, "ssss", $no_transaksi, $action, $keteranganLog, $userid);

    $queryDataInventarisKantorLama = mysqli_query($conn, "select * from inventaris_kantor where no_inventaris = '$no_inventaris'");
    $rowDataInventarisLama = mysqli_fetch_assoc($queryDataInventarisKantorLama);

    $editedInventarisKantor = array();

    if ($tanggal !== $rowDataInventarisLama['tgl']) {
        $editedInventarisKantor[] = "tanggal inventaris dari " . $rowDataInventarisLama['tgl'] . " menjadi $tanggal";
    }
    if ($nama_barang !== $rowDataInventarisLama['nama_barang']) {
        $editedInventarisKantor[] = "nama barang inventaris dari " . $rowDataInventarisLama['nama_barang'] . " menjadi $nama_barang";
    }
    if ($posisi !== $rowDataInventarisLama['posisi']) {
        $editedInventarisKantor[] = "posisi inventaris dari " . $rowDataInventarisLama['posisi'] . " menjadi $posisi";
    }
    if ($keterangan !== $rowDataInventarisLama['keterangan']) {
        $editedInventarisKantor[] = "keterangan inventaris dari " . $rowDataInventarisLama['keterangan'] . " menjadi $keterangan";
    }
    if ($qty !== $rowDataInventarisLama['qty']) {
        $editedInventarisKantor[] = "quantity inventaris dari " . $rowDataInventarisLama['qty'] . " menjadi $qty";
    }

    $isiKeteranganLog = implode(', ', $editedInventarisKantor);

    $no_transaksi = $no_inventaris;
    $action = "UPDATE";
    $keteranganLog = $_SESSION['username'] . " merubah " . $isiKeteranganLog;
    $userid = $_SESSION['id_user'];

    if (mysqli_stmt_execute($queryEditInventaris)) {
        mysqli_stmt_execute($queryLogEditInventarisKantor);
        mysqli_stmt_close($queryEditInventaris);
        mysqli_stmt_close($queryLogEditInventarisKantor);
        mysqli_close($conn);
        $m = "berhasil mengubah inventaris kantor";
        header("location:../index.php?content=inventaris_kantor&t=$m");
    } else {
        mysqli_stmt_close($queryEditInventaris);
        mysqli_close($conn);
        $m = "gagal mengubah inventaris kantor";
        header("location:../index.php?content=inventaris_kantor&t=$m");
    }
}
