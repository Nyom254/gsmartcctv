<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Purchase Order</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?">Home</a></li>
                    <li class="breadcrumb-item">Purchase Order</li>
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
                        <a href="?content=tambah-purchase-order" class="btn btn-primary mb-2">Tambah PO</a>
                        <table id="tabel-purchase-order" class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Supplier</th>
                                    <th>Keterangan</th>
                                    <th>Term</th>
                                    <th>Jatuh Tempo </th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dataPO = mysqli_query($conn, "SELECT * FROM purcahse_order LEFT JOIN po_penerimaan ON po_penerimaan.NO_TRANSAKSI = purcahse_order.NO_TRANSAKSI LEFT JOIN( SELECT po_penerimaan.NO_TRANSAKSI, po_penerimaan.ST, CASE WHEN SUM(po_penerimaan.ST) > 0 AND SUM(po_penerimaan.ST) < COUNT(po_penerimaan.NO_TRANSAKSI) THEN 'partial' WHEN po_penerimaan.stk = 1 THEN 'terpenuhi' ELSE 'baru' END AS `status` FROM purcahse_order LEFT JOIN po_penerimaan ON po_penerimaan.NO_TRANSAKSI = purcahse_order.NO_TRANSAKSI GROUP BY po_penerimaan.NO_TRANSAKSI )AS `status` ON purcahse_order.NO_TRANSAKSI = status.NO_TRANSAKSI GROUP BY purcahse_order.NO_TRANSAKSI;");
                                $cekDataPO = $dataPO->num_rows;

                                if ($cekDataPO > 0) {
                                    while ($rowPO = mysqli_fetch_assoc($dataPO)) { ?>
                                        <tr onclick="getDetailPurchaseOrder('<?php echo $rowPO['NO_TRANSAKSI'] ?>')">
                                            <td><?php echo $rowPO['NO_TRANSAKSI']  ?></td>
                                            <td><?php echo $rowPO['TANGGAL'] ?></td>
                                            <td><?php
                                                $queryNamaSupplier = mysqli_query($conn, "select nama from supplier where id_supplier = '" . $rowPO['KODE_SUPPLIER'] . "' ");
                                                $namaSupplier = mysqli_fetch_assoc($queryNamaSupplier);
                                                echo $namaSupplier['nama'];
                                                ?>
                                            </td>
                                            <td class="text-break"><?php echo $rowPO['KETERANGAN']  ?></td>
                                            <td><?php echo $rowPO['TERM']  ?></td>
                                            <td><?php echo $rowPO['JATUH_TEMPO']  ?></td>
                                            <td><?php
                                                $jumlahTotal = $rowPO['DPP'] + $rowPO['PPN'] ;
                                                $total = number_format($jumlahTotal, '2', ",", ".");
                                                echo $total;
                                                ?></td>
                                            <td><?php echo $rowPO['status']  ?></td>
                                            <td class="small">
                                                <a class="a" href="./pembelian/purchase-order/cetak_po.php?no=<?php echo $rowPO['NO_TRANSAKSI'] ?>" target="_blank" style="cursor: pointer;">Cetak PO</a>
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
    function getDetailPurchaseOrder(noTransaksi) {

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
                    cell1.innerHTML = item.URUTAN

                    var cell2 = newRow.insertCell(1)
                    cell2.innerHTML = item.KODE_BARANG

                    var cell3 = newRow.insertCell(2)
                    cell3.innerHTML = item.QUANTITY

                    var cell4 = newRow.insertCell(3)
                    const harga = parseInt(item.HARGA)
                    cell4.innerHTML = harga.toLocaleString('en-IE', {useGrouping: true})

                    var cell5 = newRow.insertCell(4)
                    cell5.innerHTML = item.DISKON_PERSENTASE

                    var cell6 = newRow.insertCell(5)
                    cell6.innerHTML = item.DISKON
                }
            }
        }
        xhr.open('GET', './pembelian/purchase-order/data_detail-purchase-order.php?no=' + noTransaksi, true)
        xhr.send()
    }
</script>