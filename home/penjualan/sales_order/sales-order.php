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
                                    <th>Pengirim</th>
                                    <th>Customer</th>
                                    <th>Keterangan</th>
                                    <th>Term</th>
                                    <th>Jatuh Tempo </th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dataSO = mysqli_query($conn, "SELECT * FROM sales_order INNER JOIN (SELECT id_customer, nama FROM customer)AS cust ON sales_order.kode_customer = cust.id_customer;");
                                $cekDataSO = $dataSO->num_rows;

                                if ($cekDataSO > 0) {
                                    while ($rowSO = mysqli_fetch_assoc($dataSO)) { ?>
                                        <tr onclick="getDetailSalesOrder('<?php echo $rowSO['no_transaksi'] ?>')">
                                            <td><?php echo $rowSO['no_transaksi']  ?></td>
                                            <td><?php echo $rowSO['tanggal'] ?></td>
                                            <td><?php echo $rowSO['pengirim'] ?></td>
                                            <td><?php echo $rowSO['nama'] ?></td>
                                            <td class="text-break"><?php echo $rowSO['keterangan']  ?></td>
                                            <td><?php echo $rowSO['term']  ?></td>
                                            <td><?php echo $rowSO['jatuh_tempo']  ?></td>
                                            <td><?php
                                                $jumlahTotal = $rowSO['dpp'] + $rowSO['ppn'] ;
                                                $total = number_format($jumlahTotal, '2', ",", ".");
                                                echo $total;
                                                ?></td>
                                            <td class="small">
                                                <a class="a" href="./penjualan/sales_order/cetak_so.php?no=<?php echo $rowSO['no_transaksi'] ?>" target="_blank" style="cursor: pointer;">Cetak SO</a>
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
                    cell3.innerHTML = item.quantity

                    var cell4 = newRow.insertCell(3)
                    const harga = parseInt(item.harga)
                    cell4.innerHTML = harga.toLocaleString('en-IE', {useGrouping: true})

                    var cell5 = newRow.insertCell(4)
                    cell5.innerHTML = item.diskon_persentase

                    var cell6 = newRow.insertCell(5)
                    cell6.innerHTML = item.diskon
                }
            }
        }
        xhr.open('GET', './penjualan/sales_order/data_detail-sales-order.php?no=' + noTransaksi, true)
        xhr.send()
    }
</script>