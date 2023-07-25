<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Invoice Penjualan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?">Home</a></li>
                    <li class="breadcrumb-item">Invoice Penjualan</li>
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
                        <a href="?content=tambah-invoice-penjualan" class="btn btn-primary mb-2">Tambah Invoice Penjualan</a>
                        <table id="example1" class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Jatuh Tempo </th>
                                    <th>No SO</th>
                                    <th>Pengirim</th>
                                    <th>Customer</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Lama Pembayaran</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dataSO = mysqli_query($conn, "SELECT * FROM invoice_penjualan INNER JOIN (SELECT id_customer, nama FROM customer)AS cust ON invoice_penjualan.kode_customer = cust.id_customer;");
                                $cekDataSO = $dataSO->num_rows;

                                if ($cekDataSO > 0) {
                                    while ($rowSO = mysqli_fetch_assoc($dataSO)) { ?>
                                        <tr onclick="getDetailInvoicePenjualan('<?php echo htmlspecialchars($rowSO['no_transaksi']) ?>')">
                                            <td><?php echo htmlspecialchars($rowSO['no_transaksi'])  ?></td>
                                            <td><?php echo htmlspecialchars($rowSO['tanggal']) ?></td>
                                            <td><?php echo htmlspecialchars($rowSO['jatuh_tempo']) ?></td>
                                            <td><?php echo htmlspecialchars($rowSO['no_so']) ?></td>
                                            <td><?php echo htmlspecialchars($rowSO['pengirim']) ?></td>
                                            <td><?php echo htmlspecialchars($rowSO['nama']) ?></td>
                                            <td class="text-break"><?php echo htmlspecialchars($rowSO['keterangan']) ?></td>
                                            <td><?php  echo $rowSO['status'] == 1 ?  "lunas" :  "belum lunas" ?></td>
                                            <td><?php echo $rowSO['lama_pembayaran'] !== null ? htmlspecialchars($rowSO['lama_pembayaran']) . " hari" : ' ' ?></td>
                                            <td><?php
                                                $jumlahTotal = $rowSO['dpp'] + $rowSO['ppn'];
                                                $total = number_format($jumlahTotal, '2', ",", ".");
                                                echo htmlspecialchars($total);
                                                ?></td>
                                            <td class="small">
                                                <a class="a" href="./penjualan/invoice_penjualan/cetak_invoice.php?no=<?php echo htmlspecialchars($rowSO['no_transaksi']) ?>" target="_blank" style="cursor: pointer;">Cetak Invoice</a> |
                                                <a class="a" href="./penjualan/invoice_penjualan/cetak_surat_jalan.php?no=<?php echo htmlspecialchars($rowSO['no_transaksi']) ?>" target="_blank" style="cursor: pointer;">Cetak Surat Jalan</a> |
                                                <a class="a" href="?content=edit-invoice-penjualan&no=<?php echo htmlspecialchars($rowSO['no_transaksi']) ?>" style="cursor: pointer;">Edit</a>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="detail-invoice-penjualan" class="table  table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No Transaksi</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Quantity</th>
                                        <th>Harga</th>
                                        <th>Diskon Persentase</th>
                                        <th>Diskon</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function getDetailInvoicePenjualan(noInvoice) {
        var xhr = new XMLHttpRequest()
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText)
                const table = document.getElementById("detail-invoice-penjualan")
                for (var i = 1; i < table.rows.length;) {
                    table.deleteRow(i);
                }
                for (var i = 0; i < response.length; i++) {
                    let item = response[i]
                    var newRow = table.insertRow()
                    var cell1 = newRow.insertCell(0)
                    cell1.innerHTML = item.no_transaksi

                    var cell2 = newRow.insertCell(1)
                    cell2.innerHTML = item.kode_barang

                    var cell3 = newRow.insertCell(2)
                    cell3.innerHTML = item.nama

                    var cell4 = newRow.insertCell(3)
                    cell4.innerHTML = item.quantity

                    var cell5 = newRow.insertCell(4)
                    const harga = parseInt(item.harga)
                    cell5.innerHTML = harga.toLocaleString('en-IE', {
                        useGrouping: true
                    })

                    var cell6 = newRow.insertCell(5)
                    cell6.innerHTML = item.diskon_persentase

                    var cell7 = newRow.insertCell(6)
                    cell7.innerHTML = item.diskon
                }
            }
        }
        xhr.open('GET', './penjualan/invoice_penjualan/data_detail-invoice-penjualan.php?no=' + noInvoice, true)
        xhr.send()
    }
</script>