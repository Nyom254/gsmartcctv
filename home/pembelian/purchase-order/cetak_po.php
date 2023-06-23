<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cetak PO</title>

</head>
<style media="print">
    @page {
        size: A4;
        margin: 12mm;
    }
</style>
<style>
    * {
        font-family: Helvetica, Arial, sans-serif;
        margin: 0;
    }

    body {
        margin: 10px;
        width: 794px;
    }

    h2 {
        font-weight: lighter;
    }

    h3 {
        font-weight: lighter;
    }

    table {
        margin-top: 30px;
        width: 100%;
        border-top: 1px solid black;
        border-collapse: collapse;
    }

    td,
    th {
        padding: 8px;
    }

    tbody{
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }
    /* tfoot td:nth-child(3), tfoot td:nth-child(4), tfoot td:nth-child(5) {
        border-bottom: 1px solid black;
    }    */

</style>

<body>
    <?php

    include '../../../conn.php';

    $noTransaksi = $_GET['no'];
    $queryPerusahaan = mysqli_query($conn, "select * from setup_perusahaan");
    $queryPurchaseOrder = mysqli_query($conn, "select * from purcahse_order where NO_TRANSAKSI = '$noTransaksi'");
    $queryDetailPurchaseOrder = mysqli_query($conn, "select * from detail_purcashe_order where NO_TRANSAKSI = '$noTransaksi'");

    $dataPurchaseOrder = mysqli_fetch_assoc($queryPurchaseOrder);
    $dataPerusahaan = mysqli_fetch_assoc($queryPerusahaan);

    $querySupplier = mysqli_query($conn, "select * from supplier where id_supplier = '" . $dataPurchaseOrder['KODE_SUPPLIER'] . "'");
    $dataSupplier = mysqli_fetch_assoc($querySupplier);

    ?>


    <div>
        <h2><?php echo $dataPerusahaan['nama'] ?></h2>
        <p><?php echo $dataPerusahaan['alamat'] ?></p>
        <p><?php echo $dataPerusahaan['kota'] . ", " . $dataPerusahaan['provinsi'] . " " . $dataPerusahaan['kode_pos'] ?></p>
        <p>Telp. <?php echo $dataPerusahaan['no_telp'] ?></p>
    </div>
    <div>
        <h2 style="text-align: end; padding-right:30px;"><u>PURCHASE ORDER</u></h2>
        <div style="display: flex; justify-content:space-between">
            <div>
                <p>Supplier :</p>
                <h3><?php echo $dataSupplier['nama'] ?></h3>
                <p><?php echo $dataSupplier['alamat'] ?>, <?php echo $dataSupplier['kota'] ?></p>
            </div>
            <div style="width:250px;padding-top:20px;">
                <div style="display:flex;padding-right:30px;">
                    <p style="width:110px">Nomor</p>
                    <p>:<?php echo $dataPurchaseOrder['NO_TRANSAKSI'] ?></p>
                </div>
                <div style="display:flex;padding-right:30px;">
                    <p style="width:110px">Tanggal</p>
                    <p>:<?php $date = $dataPurchaseOrder['TANGGAL']; // The original date in 'Y-m-d' format
                        $reformattedDate = date('d/m/Y', strtotime($date)); // Reformatted date in 'd/m/Y' format
                        echo $reformattedDate; ?></p>
                </div>
            </div>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width:40px">No.</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>

            <?php
            while ($rowDetail = mysqli_fetch_assoc($queryDetailPurchaseOrder)) {
                $queryBarang = mysqli_query($conn, "select nama from barang where id_barang = '" . $rowDetail['KODE_BARANG'] . "'");
                $dataBarang = mysqli_fetch_assoc($queryBarang);
            ?>
                <tr>
                    <td style="text-align: left;"><?php echo $rowDetail['URUTAN'] ?>.</td>
                    <td style="text-align: center;"><?php echo $dataBarang['nama'] ?></td>
                    <td style="text-align: center;"><?php echo $rowDetail['QUANTITY'] ?></td>
                    <td style="text-align: center;"><?php echo number_format($rowDetail['HARGA'], '0', ',', '.'); ?></td>
                    <td style="text-align: center;"><?php echo number_format($rowDetail['HARGA'] * $rowDetail['QUANTITY'], '0', ',', '.'); ?></td>

                </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td style="text-align: right;"><b>DPP:</b></td>
                <td></td>
                <td style="text-align: center;"><?php echo number_format($dataPurchaseOrder['DPP'], '0', ',', '.'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td style="text-align: right;"><b>PPN:</b></td>
                <td></td>
                <td style="text-align: center;"><?php echo number_format($dataPurchaseOrder['PPN'], '0', ',', '.'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td style="text-align: right;"><b>Grand Total:</b></td>
                <td></td>
                <td style="text-align: center;"><?php echo number_format($dataPurchaseOrder['DPP'] + $dataPurchaseOrder['PPN'], '0', ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>

    <div style="display: flex;margin-top:30px">
        <div style="width: 45%">
            <p>Keterangan:</p>
            <p><?php echo $dataPurchaseOrder['KETERANGAN']; ?></p>
        </div>
        <div style="width: 25%;margin-top:30px">
            <p>Pengambil / Penerima,</p>
            <p style="margin-top:40px"><?php echo $dataPurchaseOrder['PENGAMBIL'] ?></p>
        </div>
        <div style="margin-top:30px;">
            <p>Pembuat,</p>
            <p style="margin-top:40px"><?php echo $dataPurchaseOrder['CRUSER'] ?></p>
        </div>
    </div>
</body>
<script>
    // window.addEventListener("load", window.print());
</script>

</html>