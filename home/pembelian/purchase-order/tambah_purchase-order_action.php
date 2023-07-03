<?php 
    include '../../../conn.php';
    session_start();
    $queryTambahPurchaseOrder = mysqli_prepare($conn, "insert into purcahse_order (NO_TRANSAKSI, TANGGAL, NO_REF, KODE_SUPPLIER, KETERANGAN, JATUH_TEMPO, DISKON, DPP, PPN, JENIS_PPN, SUBTOTAL, PPN_PERSENTASE, BATAL, TERM, PENGAMBIL, CRUSER, kode_departemen) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryTambahPurchaseOrder, "ssssssdddsdiiisss", $no_transaksi, $tanggal, $no_ref, $kode_supplier, $keterangan, $jatuh_tempo, $diskon, $dpp, $ppn, $jenis_ppn, $subtotal, $ppn_persentase, $batal, $term, $pengambil, $cruser, $kode_departemen);

    $no_transaksi = mysqli_escape_string($conn, $_POST['no_transaksi']);
    $tanggal = mysqli_escape_string($conn, $_POST['tanggal']);
    $no_ref = mysqli_escape_string($conn, $_POST['no_ref']);
    $kode_supplier = mysqli_escape_string($conn, $_POST['supplier']);
    $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
    $postTanggalJatuhTempo = mysqli_escape_string($conn, $_POST['jatuh_tempo']);
    $jatuh_tempo = date('Y-m-d', strtotime($postTanggalJatuhTempo)) ;
    $diskon = mysqli_escape_string($conn, $_POST['diskon']);
    $dpp = mysqli_escape_string($conn, $_POST['dpp']);
    $ppn = mysqli_escape_string($conn, $_POST['ppn']);
    $jenis_ppn = mysqli_escape_string($conn, $_POST['jenis_ppn']);
    $subtotal = mysqli_escape_string($conn, $_POST['subtotal']);
    $ppn_persentase = mysqli_escape_string($conn, $_POST['ppn-persen']);
    $batal = 0;
    $term = mysqli_escape_string($conn, $_POST['term']);
    $pengambil = mysqli_escape_string($conn, $_POST['pengambil']);
    $cruser = $_SESSION['username'];
    $kode_departemen = mysqli_escape_string($conn, $_POST['departemen']);


    $kode_barang = $_POST['kode-barang'];
    $quantity = $_POST['quantity'];
    $harga = $_POST['harga'];
    $diskon_barang = $_POST['diskon-barang'];
    $diskon_persentase_barang = $_POST['diskon-persentase'];
    $urutan = $_POST['no-urut'];
    
    

    $queryLogTambahPO = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogTambahPO, "ssss", $no_transaksi, $action, $keteranganLog, $userid);

    $action = "INSERT" ;
    $keteranganLog = $_SESSION['username'] . " menambahkan Purchase Order  " . $no_transaksi;
    $userid = $_SESSION['id_user'];

    if(array_key_exists('kode-barang', $_POST)){
        if(mysqli_stmt_execute($queryTambahPurchaseOrder)){
            for($i = 0; $i < count($_POST['kode-barang']); $i++){
                $queryTambahDetailPurchaseOrder = mysqli_prepare($conn, "insert into detail_purcashe_order (NO_TRANSAKSI, KODE_BARANG, QUANTITY, HARGA, DISKON, DISKON_PERSENTASE, URUTAN) values (?, ?, ?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($queryTambahDetailPurchaseOrder, "ssiiiii", $no_transaksi, $kode_barang[$i], $quantity[$i], $harga[$i], $diskon_barang[$i], $diskon_persentase_barang[$i], $urutan[$i]);
                mysqli_stmt_execute($queryTambahDetailPurchaseOrder);
            }
            mysqli_stmt_execute($queryLogTambahPO);
            mysqli_stmt_close($queryTambahDetailPurchaseOrder);
            mysqli_stmt_close($queryTambahPurchaseOrder);
            mysqli_close($conn);
            header("location:../../index.php?content=purchase-order");
        } else {
            mysqli_close($conn);
            header("location:../../index.php?content=purchase-order");
        }
    
    } else {
        $m = "mohon isi barang yang akan di PO";
        header("location:../../index.php?content=tambah-purchase-order&t=$m");
    }
