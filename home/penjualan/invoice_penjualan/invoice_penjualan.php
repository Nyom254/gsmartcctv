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
                                    <th>No SO</th>
                                    <th>Pengirim</th>
                                    <th>Customer</th>
                                    <th>Keterangan</th>
                                    <th>Jatuh Tempo </th>
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
                                        <tr>
                                            <td><?php echo $rowSO['no_transaksi']  ?></td>
                                            <td><?php echo $rowSO['tanggal'] ?></td>
                                            <td><?php echo $rowSO['no_so'] ?></td>
                                            <td><?php echo $rowSO['pengirim'] ?></td>
                                            <td><?php echo $rowSO['nama'] ?></td>
                                            <td class="text-break"><?php echo $rowSO['keterangan']  ?></td>
                                            <td><?php echo $rowSO['jatuh_tempo']  ?></td>
                                            <td><?php
                                                $jumlahTotal = $rowSO['dpp'] + $rowSO['ppn'];
                                                $total = number_format($jumlahTotal, '2', ",", ".");
                                                echo $total;
                                                ?></td>
                                            <td class="small">
                                                <a class="a" href="./penjualan/invoice_penjualan/cetak_invoice.php?no=<?php echo $rowSO['no_transaksi'] ?>" target="_blank" style="cursor: pointer;">Cetak Invoice</a> |
                                                <a class="a" href="./penjualan/invoice_penjualan/cetak_surat_jalan.php?no=<?php echo $rowSO['no_transaksi'] ?>" target="_blank" style="cursor: pointer;">Cetak Surat Jalan</a>
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
    </div>
</section>