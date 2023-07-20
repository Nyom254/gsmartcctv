<?php
    include '../../../conn.php';

    session_start();

    $queryTambahPenerimaan = mysqli_prepare($conn,"insert into penerimaan (no_penerimaan, tgl, no_po, no_ref, kode_supplier, keterangan) values (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryTambahPenerimaan, "ssssss", $no_penerimaan, $tanggal, $no_po, $no_ref, $kode_supplier, $keterangan);

    $no_penerimaan = mysqli_escape_string($conn, $_POST['no_penerimaan']);
    $tanggal = mysqli_escape_string($conn,$_POST['tanggal'] );
    $no_po = mysqli_escape_string($conn, $_POST['no_po']);
    $kode_supplier = mysqli_escape_string($conn, $_POST['kode_vendor']);
    $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
    $no_ref = mysqli_escape_string($conn, $_POST['no_ref']);

    $kode_barang = $_POST['kode-barang'];
    $quantity = $_POST['qty-terima'];

    $gudang = $_POST['gudang'];

    $queryLogTambahPO = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogTambahPO, "ssss", $no_penerimaan, $action, $keteranganLog, $userid);

    $action = "INSERT" ;
    $keteranganLog = $_SESSION['username'] . " menambahkan Penerimaan Barang  " . $no_penerimaan;
    $userid = $_SESSION['id_user'];

    if(array_key_exists('kode-barang', $_POST)){
        if(mysqli_stmt_execute($queryTambahPenerimaan)){
            for($i = 0; $i < count($_POST['kode-barang']); $i++){
                $queryTambahDetailPenerimaan = mysqli_prepare($conn, "insert into detail_penerimaan (no_penerimaan, kode_barang, quantity) values (?, ?, ?)");
                mysqli_stmt_bind_param($queryTambahDetailPenerimaan, "ssi", $no_penerimaan, $kode_barang[$i], $quantity[$i]);

                if(isset($quantity[$i]) && $quantity[$i] != '' && $quantity[$i] != 0) {
                        $queryTambahSaldoStok = mysqli_prepare($conn, "INSERT into saldo_stok (no_transaksi, tgl, gudang, kode_barang, qty, satuan, harga, status_stok, kode_departmen) values (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        mysqli_stmt_bind_param($queryTambahSaldoStok, "ssssisiis", $no_penerimaan, $tanggal, $gudang, $kode_barang[$i], $quantity[$i], $satuan, $harga, $status_stok, $kode_departemen);
                        $queryBarang = mysqli_query($conn, "select satuan, harga, type, kode_departemen from barang where id_barang = '$kode_barang[$i]'");
                        $dataBarang = mysqli_fetch_assoc($queryBarang);
                        $satuan = $dataBarang['satuan'];
                        $harga = $dataBarang['harga'];
                        $status_stok;
                        if($dataBarang['type'] == 'non_persediaan') {
                            $status_stok = 0;
                        } else {
                            $status_stok = 1;
                        }
                        $kode_departemen = $dataBarang['kode_departemen'];
                        mysqli_stmt_execute($queryTambahSaldoStok);
                        mysqli_stmt_execute($queryTambahDetailPenerimaan);
                }
            }
            mysqli_stmt_execute($queryLogTambahPO);
            mysqli_stmt_close($queryTambahDetailPenerimaan);
            mysqli_stmt_close($queryTambahPenerimaan);
            mysqli_close($conn);
            $m = "berhasil ditambahkan";
            header("location:../../index.php?content=penerimaan_barang&t=$m");
        } else {
            mysqli_stmt_close($queryTambahUser);
            mysqli_close($conn);
            $m = "gagal menambahkan penerimaan barang";
            header("location:../../index.php?content=penerimaan_barang&t=$m");
        }
    
    } else {
        $m = "mohon isi barang yang diterima ";
        header("location:../../index.php?content=tambah-penerimaan_barang&t=$m");
    }

?>