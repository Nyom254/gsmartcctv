<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cetak surat jalan</title>

</head>
<style media="print">
    @page {
        size: A4;
        margin: 5mm;
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
        position: relative;
    }

    h2 {
        font-weight: lighter;
    }

    h3 {
        font-weight: lighter;
    }

    .tanggal {
        position: absolute;
        top: 20px;
        right: 100px;
    }

    .kepada {
        position: absolute;
        top: 85px;
        left: 520px;
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


    .footer {
        display: flex;
        flex-direction: column;
        height: 100px;
        align-items: center;
        justify-content: space-between;
    }
</style>

<body>
    <?php

    include '../../../conn.php';

    $noTransaksi = $_GET['no'];
    $queryInvoicePenjualan = mysqli_query($conn, "SELECT * FROM `invoice_penjualan` INNER JOIN customer ON invoice_penjualan.kode_customer = customer.id_customer WHERE invoice_penjualan.no_transaksi = '$noTransaksi'");
    $dataInvoicePenjualan = mysqli_fetch_assoc($queryInvoicePenjualan);

    $departemen = $dataInvoicePenjualan['kode_departemen'];
    $queryPerusahaan = mysqli_query($conn, "SELECT * FROM setup_perusahaan WHERE kode_departemen = '$departemen'");

    $no_so = $dataInvoicePenjualan['no_so'];
    $queryDetailSalesOrder = mysqli_query($conn, "select * from detail_sales_order where no_transaksi = '$no_so'");
    $dataPerusahaan = mysqli_fetch_assoc($queryPerusahaan);
    ?>


    <div>
        <h2><?php echo $dataPerusahaan['nama'] ?></h2>
        <p style="width: 300px;"><?php echo $dataPerusahaan['alamat'] ?></p>
        <p><?php echo $dataPerusahaan['kota'] . ", " . $dataPerusahaan['provinsi'] . " " . $dataPerusahaan['kode_pos'] ?></p>
        <p>Telp. <?php echo $dataPerusahaan['no_telp'] ?></p>
    </div>
    <p class="tanggal"><?php
        $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $formatter->setTimeZone('Asia/Jakarta');
        $date = $dataInvoicePenjualan['tanggal']; // The original date in 'Y-m-d' format
        $formatDate = date('d M Y', strtotime($date)); // Reformatted date in 'd/m/Y' format
        $reformattedDate = $formatter->format(strtotime($formatDate));

        echo $reformattedDate; ?>
    </p>
    <div class="kepada">
        <p>Kepada Yth:</p>
        <p>
            <?php
            echo $dataInvoicePenjualan['nama'];
            ?>
        </p>
        <p>
            <?php
            echo $dataInvoicePenjualan['kota'];
            ?>
        </p>
    </div>
    <div>
        <h2 style="text-align: center; padding-right:30px;"><u>SURAT JALAN</u></h2>
        <div style="display: flex; justify-content:space-between">
            <div style="width:300px;padding-top:20px;display:flex;margin-bottom:-20px;margin-top:20px;">
                <div style="display:flex;padding-right:0;flex-direction:column">
                    <p style="width:70px">Nomor</p>
                </div>
                <div style="display:flex;flex-direction:column">
                    <p>: <?php
                            echo "S" . substr($dataInvoicePenjualan['no_transaksi'], 1);
                            ?></p>
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
            </tr>
        </thead>
        <tbody>

            <?php
            while ($rowDetail = mysqli_fetch_assoc($queryDetailSalesOrder)) {
                $queryBarang = mysqli_query($conn, "select nama from barang where id_barang = '" . $rowDetail['kode_barang'] . "'");
                $dataBarang = mysqli_fetch_assoc($queryBarang);
            ?>
                <tr>
                    <td style="text-align: center;"><?php echo $rowDetail['urutan'] ?>.</td>
                    <td style="text-align: left;"><?php echo $dataBarang['nama'] ?></td>
                    <td style="text-align: center;"><?php echo $rowDetail['quantity'] ?></td>
                </tr>
            <?php
            }
            $queryTotalQty = mysqli_query($conn, "SELECT sum(quantity) as total_qty from detail_sales_order where no_transaksi = '$no_so'");
            $totalQty = mysqli_fetch_assoc($queryTotalQty);
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td style="text-align: right;"><b>Total Qty:</b></td>
                <td style="text-align: center"><b><?php echo $totalQty['total_qty'] ?></b></td>
            </tr>
        </tfoot>
    </table>


    <div style="width: 100%;display: flex;margin-top:30px; justify-content: space-evenly">
        <div class="footer" style="width: 25%;margin-top:30px">
            <p>Penerima, </p>
            <p>(...................................)</p>
        </div>
        <div class="footer" style="margin-top:30px;">
            <p>Pengirim,</p>
            <p>(...................................)</p>
        </div>
    </div>
</body>
<script>
    window.addEventListener("load", window.print());
</script>

</html>