<div class="container">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Monitoring Stok</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?">Home</a></li>
                        <li class="breadcrumb-item active">Monitoring Stok</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Stok</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Gudang</th>
                                        <th>Barang</th>
                                        <th>Stok</th>
                                        <th>Satuan</th>
                                        <th>Status</th>
                                        <th>Departemen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $dataStok = mysqli_query($conn, "SELECT B.nama AS gudang, C.nama AS nama_barang, SUM(A.qty) AS stok, A.satuan, CASE WHEN A.status_stok = 1 THEN 'persediaan' ELSE 'non persediaan' END AS status, D.nama AS departemen FROM `saldo_stok` AS A LEFT JOIN Gudang AS B ON B.kode = A.gudang LEFT JOIN barang AS C ON C.id_barang = A.kode_barang LEFT JOIN departemen AS D ON D.kode = A.kode_departmen GROUP BY A.gudang, A.kode_barang;");
                                    $cekStok = $dataStok->num_rows;

                                    if ($cekStok > 0) {
                                        while ($rowStok = mysqli_fetch_assoc($dataStok)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $rowStok['gudang'] ?></td>
                                                <td><?php echo $rowStok['nama_barang']  ?></td>
                                                <td><?php echo $rowStok['stok'] ?></td>
                                                <td><?php echo $rowStok['satuan'] ?></td>
                                                <td><?php echo $rowStok['status'] ?></td>
                                                <td><?php echo $rowStok['departemen'] ?></td>
                                        <?php
                                        }
                                    }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>