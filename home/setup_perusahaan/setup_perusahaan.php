<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Setup Perusahaan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?">Home</a></li>
                    <li class="breadcrumb-item active">Setup Perusahaan</li>
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
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabelSetupPerusahaan" class="table table-bordered table-striped small">
                            <thead>
                                <tr>
                                    <th>Inisial</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Kota</th>
                                    <th>Provinsi</th>
                                    <th>Kode Pos</th>
                                    <th>No Telp</th>
                                    <th>No rek</th>
                                    <th>Logo Perusahaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dataPerusahaan = mysqli_query($conn, "select * from setup_perusahaan");
                                $cekPerusahaan = $dataPerusahaan->num_rows;
                                $rowPerusahaan = mysqli_fetch_assoc($dataPerusahaan);
                                ?>

                                <tr>
                                    <td><?php echo $rowPerusahaan['inisial']  ?></td>
                                    <td><?php echo $rowPerusahaan['nama'] ?></td>
                                    <td><?php echo $rowPerusahaan['alamat'] ?></td>
                                    <td><?php echo $rowPerusahaan['kota'] ?></td>
                                    <td><?php echo $rowPerusahaan['provinsi'] ?></td>
                                    <td><?php echo $rowPerusahaan['kode_pos'] ?></td>
                                    <td><?php echo $rowPerusahaan['no_telp'] ?></td>
                                    <td><?php echo $rowPerusahaan['no_rek'] ?></td>
                                    <td>
                                        <p id="loading">Loading ....</p>
                                        <a href="data:image/png;base64,<?php echo base64_encode($rowPerusahaan['logo_perusahaan']) ?>" data-toggle="lightbox" data-title="setup perusahaan">
                                            <img decoding="async" src="data:image/png;base64,<?php echo base64_encode($rowPerusahaan['logo_perusahaan']) ?>" width="70px" height="70px" onload="document.getElementById('loading').style.display = 'none'" class="img-fluid mb-2" alt="setup perusahaan" >
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="card card-outline card-primary mt-2 collapse" id="cardEditSetupPerusahaan">
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" action="./setup_perusahaan/edit_setup_perusahaan.php" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="inisial">Inisial:</label>
                                        <input type="text" name="inisial" class="form-control" id="inisial" placeholder="Inisial Perusahaan" value="<?php echo $rowPerusahaan['inisial'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama: </label>
                                        <input type="text" name="nama" class="form-control" id="nama" placeholder="nama perusahaan" value="<?php echo $rowPerusahaan['nama'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat:</label>
                                        <input type="text" name="alamat" class="form-control" id="alamat" placeholder="alamat perusahaan" value="<?php echo $rowPerusahaan['alamat'] ?>">
                                    </div>
                                    <div class="form-group ">
                                        <label for="kota">Kota:</label>
                                        <input type="text" name="kota" placeholder="kota perusahaan" id="kota" class="form-control" value="<?php echo $rowPerusahaan['kota'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="provinsi">Provinsi:</label>
                                        <input type="text" name="provinsi" placeholder="kota perusahaan" id="provinsi" class="form-control" value="<?php echo $rowPerusahaan['provinsi'] ?>">
                                    </div>
                                    <div class="form-group ">
                                        <label for="kode_pos">Kode Pos:</label>
                                        <input type="number" name="kode_pos" id="kode_pos" placeholder="kode pos perusahaan" class="form-control" value="<?php echo $rowPerusahaan['kode_pos'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="no_telp">No Telp:</label>
                                        <input type="number" name="no_telp" class="form-control" id="no_telp" placeholder="nomor telepon perusahaan" value="<?php echo $rowPerusahaan['no_telp'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="no_rek">No Rekening:</label>
                                        <input type="text" name="no_rek" class="form-control" id="no_rek" placeholder="nomor rekening perusahaan" value="<?php echo $rowPerusahaan['no_rek'] ?>">
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" name="logo_perusahaan" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="button" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#cardEditSetupPerusahaan">Cancel</button>
                                    <button type="submit" class="btn btn-primary float-right ">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="collapse" data-target="#cardEditSetupPerusahaan">edit</button>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>