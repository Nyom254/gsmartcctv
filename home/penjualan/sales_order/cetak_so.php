<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cetak SO</title>

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

    tbody {
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
    $queryPurchaseOrder = mysqli_query($conn, "select * from sales_order where no_transaksi = '$noTransaksi'");
    $queryDetailPurchaseOrder = mysqli_query($conn, "select * from detail_sales_order where no_transaksi = '$noTransaksi'");

    $dataPurchaseOrder = mysqli_fetch_assoc($queryPurchaseOrder);
    $dataPerusahaan = mysqli_fetch_assoc($queryPerusahaan);
    ?>


    <div>
        <h2><?php echo $dataPerusahaan['nama'] ?></h2>
        <p><?php echo $dataPerusahaan['alamat'] ?></p>
        <p><?php echo $dataPerusahaan['kota'] . ", " . $dataPerusahaan['provinsi'] . " " . $dataPerusahaan['kode_pos'] ?></p>
        <p>Telp. <?php echo $dataPerusahaan['no_telp'] ?></p>
    </div>
    <div>
        <h2 style="text-align: end; padding-right:30px;"><u>SALES ORDER</u></h2>
        <div style="display: flex; justify-content:space-between">
            <div>

            </div>
            <div style="width:300px;padding-top:20px;display:flex;">
                <div style="display:flex;padding-right:0;flex-direction:column">
                    <p style="width:110px">Nomor</p>
                    <p style="width:110px">Tanggal</p>
                </div>
                <div style="display:flex;flex-direction:column">
                    <p>: <?php echo $dataPurchaseOrder['no_transaksi'] ?></p>
                    <p>: <?php $date = $dataPurchaseOrder['tanggal']; // The original date in 'Y-m-d' format
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
                <th>Diskon</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>

            <?php
            while ($rowDetail = mysqli_fetch_assoc($queryDetailPurchaseOrder)) {
                $queryBarang = mysqli_query($conn, "select nama from barang where id_barang = '" . $rowDetail['kode_barang'] . "'");
                $dataBarang = mysqli_fetch_assoc($queryBarang);
            ?>
                <tr>
                    <td style="text-align: center;"><?php echo $rowDetail['urutan'] ?>.</td>
                    <td style="text-align: left;"><?php echo $dataBarang['nama'] ?></td>
                    <td style="text-align: center;"><?php echo $rowDetail['quantity'] ?></td>
                    <td style="text-align: right;"><?php echo number_format($rowDetail['harga'], '2', ',', '.'); ?></td>
                    <td style="text-align: right;"><?php echo number_format($rowDetail['diskon'], '2', ',', '.'); ?></td>
                    <td style="text-align: right;"><?php echo number_format(($rowDetail['harga'] * $rowDetail['quantity']) - ($rowDetail['quantity'] * $rowDetail['diskon']), '2', ',', '.');  ?></td>

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
                <td style="text-align: center;"><?php echo number_format($dataPurchaseOrder['dpp'], '2', ',', '.'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td style="text-align: right;"><b>PPN:</b></td>
                <td></td>
                <td style="text-align: center;"><?php echo number_format($dataPurchaseOrder['ppn'], '2', ',', '.'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td style="text-align: right;"><b>Grand Total:</b></td>
                <td></td>
                <td style="text-align: center;"><?php echo number_format($dataPurchaseOrder['dpp'] + $dataPurchaseOrder['ppn'], '2', ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>

    <div style="display: flex;margin-top:30px">
        <div style="width: 45%">
            <p>Keterangan:</p>
            <p><?php echo $dataPurchaseOrder['keterangan']; ?></p>
        </div>
        <div style="width: 25%;margin-top:30px">
        </div>
        <div style="margin-top:30px;">
            <p>Pembuat,</p>
            <p style="margin-top:40px"><?php echo $dataPurchaseOrder['cruser'] ?></p>
        </div>
    </div>
</body>
<script>
    window.addEventListener("load", window.print());
</script>

</html>