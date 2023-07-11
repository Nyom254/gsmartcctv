<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Sales Order</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?">Home</a></li>
                    <li class="breadcrumb-item">Sales Order</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="?content=tambah-sales-order" class="btn btn-primary mb-2">Tambah SO</a>
                        <table id="example1" class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Pembuat</th>
                                    <th>Customer</th>
                                    <th>Keterangan</th>
                                    <th>Jatuh Tempo </th>
                                    <th>Total</th>
                                    <th>Lama Invoice</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dataSO = mysqli_query($conn, "SELECT sales_order.no_transaksi, sales_order.tanggal, sales_order.lama_invoice, customer.nama, sales_order.cruser, sales_order.keterangan, sales_order.jatuh_tempo, sales_order.dpp + sales_order.ppn AS total, CASE WHEN SUM(so_invoice.st) > 0 AND SUM(so_invoice.st) < COUNT(so_invoice.no_transaksi) THEN 'partial' WHEN so_invoice.stk = 1 THEN 'terpenuhi' ELSE 'baru' END AS status FROM sales_order LEFT JOIN so_invoice ON sales_order.no_transaksi = so_invoice.no_transaksi INNER JOIN customer ON customer.id_customer = sales_order.kode_customer GROUP BY sales_order.no_transaksi;");
                                $cekDataSO = $dataSO->num_rows;

                                if ($cekDataSO > 0) {
                                    while ($rowSO = mysqli_fetch_assoc($dataSO)) { ?>
                                        <tr onclick="getDetailSalesOrder('<?php echo $rowSO['no_transaksi'] ?>')">
                                            <td><?php echo $rowSO['no_transaksi']  ?></td>
                                            <td><?php echo $rowSO['tanggal'] ?></td>
                                            <td><?php echo $rowSO['cruser'] ?></td>
                                            <td><?php echo $rowSO['nama'] ?></td>
                                            <td class="text-break"><?php echo $rowSO['keterangan']  ?></td>
                                            <td><?php echo $rowSO['jatuh_tempo']  ?></td>
                                            <td><?php
                                                echo number_format($rowSO['total'], '2', ",", ".");
                                                ;
                                                ?></td>
                                            <td><?php if($rowSO['lama_invoice'] != null) { echo  $rowSO['lama_invoice'] . " hari"; } ?> </td>
                                            <td><?php echo $rowSO['status'] ?></td>
                                            <td class="small">
                                                <a class="a" href="./penjualan/sales_order/cetak_so.php?no=<?php echo $rowSO['no_transaksi'] ?>" target="_blank" style="cursor: pointer;">Cetak SO</a> 
                                                <?php
                                                if ($rowSO['lama_invoice'] == null){
                                                ?>
                                                |
                                                <a class="a" href="?content=edit-sales-order&no=<?php echo $rowSO['no_transaksi'] ?>" style="cursor: pointer;">Edit</a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6>Detail Purchase Order</h6>
                    </div>
                    <div class="card-body small">
                        <table class="table table-striped table-responsive-md table-hover detail-purchase-order" id="info-detail-purchase-order">
                            <thead>
                                <tr>
                                    <th>No Urut</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Keterangan</th>
                                    <th>Quantity</th>
                                    <th>Harga</th>
                                    <th>Diskon (%)</th>
                                    <th>Diskon</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function getDetailSalesOrder(noTransaksi) {

        var xhr = new XMLHttpRequest()
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText)
                const table = document.querySelector(".detail-purchase-order")
                for (var i = 1; i < table.rows.length;) {
                    table.deleteRow(i);
                }
                for (var i = 0; i < response.length; i++) {
                    let item = response[i]
                    var newRow = table.insertRow()
                    var cell1 = newRow.insertCell(0)
                    cell1.innerHTML = item.urutan

                    var cell2 = newRow.insertCell(1)
                    cell2.innerHTML = item.kode_barang
                    
                    var cell3 = newRow.insertCell(2)
                    cell3.innerHTML = item.nama
                    
                    var cell4 = newRow.insertCell(3)
                    cell4.innerHTML = item.keterangan

                    var cell5 = newRow.insertCell(4)
                    cell5.innerHTML = item.quantity

                    var cell6 = newRow.insertCell(5)
                    const harga = parseInt(item.harga)
                    cell6.innerHTML = harga.toLocaleString('en-IE', {useGrouping: true})

                    var cell7 = newRow.insertCell(6)
                    cell7.innerHTML = item.diskon_persentase

                    var cell8 = newRow.insertCell(7)
                    cell8.innerHTML = item.diskon
                }
            }
        }
        xhr.open('GET', './penjualan/sales_order/data_detail-sales-order.php?no=' + noTransaksi, true)
        xhr.send()
    }
</script>