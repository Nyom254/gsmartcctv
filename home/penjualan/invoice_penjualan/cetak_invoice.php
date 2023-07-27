<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cetak invoice</title>

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
    $queryInvoicePenjualan = mysqli_query($conn, "SELECT * FROM `invoice_penjualan` INNER JOIN customer ON invoice_penjualan.kode_customer = customer.id_customer WHERE invoice_penjualan.no_transaksi = '$noTransaksi'");
    $dataInvoicePenjualan = mysqli_fetch_assoc($queryInvoicePenjualan);
    $departemen = $dataInvoicePenjualan['kode_departemen'];
    $queryPerusahaan = mysqli_query($conn, "SELECT * FROM setup_perusahaan WHERE kode_departemen = '$departemen'");

    $queryDetailSalesOrder = mysqli_query($conn, "select * from detail_invoice_penjualan where no_transaksi = '$noTransaksi'");
    $dataPerusahaan = mysqli_fetch_assoc($queryPerusahaan);
    ?>


    <div>
        <h2 style="text-align: end; padding-right:30px;"><u>INVOICE</u></h2>
        <div style="display: flex; justify-content:space-between">
            <div>
                <p>Customer :</p>
                <h3><?php echo $dataInvoicePenjualan['nama'] ?></h3>
                <p><?php echo $dataInvoicePenjualan['alamat'] ?>, <?php echo $dataInvoicePenjualan['kota'] ?></p>
            </div>
            <div style="width:300px;padding-top:20px;display:flex;">
                <div style="display:flex;padding-right:0;flex-direction:column">
                    <p style="width:110px">Nomor</p>
                    <p style="width:110px">Tanggal</p>
                </div>
                <div style="display:flex;flex-direction:column">
                    <p>: <?php echo $dataInvoicePenjualan['no_transaksi'] ?></p>
                    <p>: <?php $date = $dataInvoicePenjualan['tanggal']; // The original date in 'Y-m-d' format
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
            $urutan = 0;
            while ($rowDetail = mysqli_fetch_assoc($queryDetailSalesOrder)) {
                $queryBarang = mysqli_query($conn, "select nama from barang where id_barang = '" . $rowDetail['kode_barang'] . "'");
                $dataBarang = mysqli_fetch_assoc($queryBarang);
                $urutan += 1;
            ?>
                <tr>
                    <td style="text-align: center;"><?php echo $urutan ?>.</td>
                    <td style="text-align: left;"><?php echo $dataBarang['nama'] ?></td>
                    <td style="text-align: center;"><?php echo $rowDetail['quantity'] ?></td>
                    <td style="text-align: right;"><?php echo number_format($rowDetail['harga'], '0', ',', '.'); ?></td>
                    <td style="text-align: right;"><?php echo number_format($rowDetail['diskon'], '0', ',', '.'); ?></td>
                    <td style="text-align: right;"><?php echo number_format(($rowDetail['harga'] * $rowDetail['quantity']) - ($rowDetail['quantity'] * $rowDetail['diskon']), '0', ',', '.');  ?></td>

                </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right;"><b>DPP:</b></td>
                <td></td>
                <td style="text-align: right;"><?php echo number_format($dataInvoicePenjualan['dpp'], '0', ',', '.'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right;"><b>PPN:</b></td>
                <td></td>
                <td style="text-align: right;"><?php echo number_format($dataInvoicePenjualan['ppn'], '2', ',', '.'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right;border-top: 1px solid black;"><b>Grand Total:</b></td>
                <td style="border-top: 1px solid black;"></td>
                <td style="text-align: right;border-top: 1px solid black;"><?php echo number_format($dataInvoicePenjualan['dpp'] + $dataInvoicePenjualan['ppn'], '2', ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>


    <div style="width: 45%">
        <p>Keterangan:</p>
        <p><?php echo htmlspecialchars($dataInvoicePenjualan['keterangan']); ?></p>
    </div>
    <div style="display: flex;margin-top:30px">
        <div style="width: 45%">
            <p>Nomor Rekening BCA:</p>
            <p><?php echo htmlspecialchars($dataPerusahaan['no_rek']); ?></p>
        </div>
        <div style="width: 25%;margin-top:30px">
            <p>Pengirim, </p>
            <p style="margin-top:40px"><?php echo ($dataInvoicePenjualan['pengirim']) ?></p>
        </div>
        <div style="margin-top:30px;">
            <p>Pembuat,</p>
            <p style="margin-top:40px"><?php echo htmlspecialchars($dataInvoicePenjualan['cruser']) ?></p>
        </div>
    </div>
</body>
<script>
    window.addEventListener("load", window.print());
</script>

</html>