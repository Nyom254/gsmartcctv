<?php
require_once("../../tinify-php-master/lib/Tinify/Exception.php");
require_once("../../tinify-php-master/lib/Tinify/ResultMeta.php");
require_once("../../tinify-php-master/lib/Tinify/Result.php");
require_once("../../tinify-php-master/lib/Tinify/Source.php");
require_once("../../tinify-php-master/lib/Tinify/Client.php");
require_once("../../tinify-php-master/lib/Tinify.php");
require '../../conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (!isset($_SESSION['status'])) {
        http_response_code(403);
        echo "Anda harus Login untuk mengakses resources ini";
    } else {

        $queryApi = mysqli_query($conn, "select key from `api_key` where name = 'tinify'");
        $dataApi = mysqli_fetch_assoc($queryApi);
        $keyTinyApi = $dataApi['key'];
        \Tinify\setKey("$keyTinyApi");


        if (file_exists($_FILES['logo_perusahaan']['tmp_name']) || is_uploaded_file($_FILES['logo_perusahaan']['tmp_name'])) {
            $queryTambahPerusahaan = mysqli_prepare($conn, "insert into setup_perusahaan (inisial, nama, alamat, kota, provinsi, kode_pos, no_telp, no_rek, logo_perusahaan, kode_departemen) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($queryTambahPerusahaan, "sssssissss", $inisial, $nama, $alamat, $kota, $provinsi, $kode_pos, $no_telp, $no_rek, $logo_perusahaan, $kode_departemen);

            $inisial = mysqli_escape_string($conn, $_POST['inisial']);
            $nama = mysqli_escape_string($conn, $_POST['nama']);
            $alamat = mysqli_escape_string($conn, $_POST['alamat']);
            $kota = mysqli_escape_string($conn, $_POST['kota']);
            $provinsi = mysqli_escape_string($conn, $_POST['provinsi']);
            $kode_pos = mysqli_escape_string($conn, $_POST['kode_pos']);
            $no_telp = mysqli_escape_string($conn, $_POST['no_telp']);
            $no_rek = $_POST['no_rek'];
            $kode_departemen = mysqli_escape_string($conn, $_POST['departemen']);
            $logo_perusahaan;

            if ($_FILES['logo_perusahaan']['error'] === UPLOAD_ERR_OK) {
                $mimeTypes = ['image/jpeg', 'image/png'];
                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($fileInfo, $_FILES['logo_perusahaan']['tmp_name']);

                if (in_array($mimeType, $mimeTypes)) {
                    $sourceAttachment = file_get_contents($_FILES['logo_perusahaan']['tmp_name']);
                    $logo_perusahaan = \Tinify\fromBuffer($sourceAttachment)->toBuffer();

                    $queryLogTambahSetupPerusahaan = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
                    mysqli_stmt_bind_param($queryLogTambahSetupPerusahaan, "ssss", $no_transaksi, $action, $keterangan, $userid);

                    $no_transaksi = "setup perusahaan";
                    $action = "INSERT";
                    $keterangan = $_SESSION['username'] . " menambah perusahaan " . $nama;
                    $userid = $_SESSION['id_user'];
                    if (mysqli_stmt_execute($queryTambahPerusahaan)) {
                        mysqli_stmt_execute($queryLogTambahSetupPerusahaan);
                        mysqli_stmt_close($queryTambahPerusahaan);
                        mysqli_close($conn);
                        $m = "berhasil menambah perusahaan";
                        header("location:../index.php?content=setup_perusahaan&t=$m");
                    } else {
                        mysqli_close($conn);
                        $m = "gagal menambah perusahaan";
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
            $queryTambahPerusahaan = mysqli_prepare($conn, "insert into setup_perusahaan (inisial, nama, alamat, kota, provinsi, kode_pos, no_telp, no_rek, logo_perusahaan, kode_departemen) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($queryTambahPerusahaan, "sssssissss", $inisial, $nama, $alamat, $kota, $provinsi, $kode_pos, $no_telp, $no_rek, $logo_perusahaan, $kode_departemen);

            $inisial = mysqli_escape_string($conn, $_POST['inisial']);
            $nama = mysqli_escape_string($conn, $_POST['nama']);
            $alamat = mysqli_escape_string($conn, $_POST['alamat']);
            $kota = mysqli_escape_string($conn, $_POST['kota']);
            $provinsi = mysqli_escape_string($conn, $_POST['provinsi']);
            $kode_pos = mysqli_escape_string($conn, $_POST['kode_pos']);
            $no_telp = mysqli_escape_string($conn, $_POST['no_telp']);
            $no_rek = $_POST['no_rek'];
            $kode_departemen = mysqli_escape_string($conn, $_POST['departemen']);

            $queryLogTambahSetupPerusahaan = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
            mysqli_stmt_bind_param($queryLogTambahSetupPerusahaan, "ssss", $no_transaksi, $action, $keterangan, $userid);

            $no_transaksi = "setup perusahaan";
            $action = "UPDATE";
            $keterangan = $_SESSION['username'] . " menambah perusahaan " . $nama;
            $userid = $_SESSION['id_user'];
            if (mysqli_stmt_execute($queryTambahPerusahaan)) {
                mysqli_stmt_execute($queryLogTambahSetupPerusahaan);
                mysqli_stmt_close($queryTambahPerusahaan);
                mysqli_close($conn);
                $m = "perusahaan berhasil ditambah";
                header("location:../index.php?content=setup_perusahaan&t=$m");
            }
        }
    }
} else {
    http_response_code(405);
}
