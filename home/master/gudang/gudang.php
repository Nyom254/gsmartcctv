<div class="container">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gudang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?">Home</a></li>
                        <li class="breadcrumb-item active">Gudang</li>
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
                            <h3 class="card-title">Daftar Gudang</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <button class="btn btn-primary mb-2" data-toggle="collapse" data-target="#modalTambahGudang">Tambah</button>
                            <div class="card card-outline card-primary mt-2 collapse" id="modalTambahGudang">
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form method="post" action="./master/gudang/tambah_gudang.php" id="formTambahGudang">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nama">Nama:</label>
                                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat">Alamat:</label>
                                            <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="penanggung_jawab">Penanggung Jawab</label>
                                            <input type="text" name="penanggung_jawab" class="form-control" id="penanggung_jawab" placeholder="Penanggung jawab" required>
                                        </div>
                                        <div class="form-group col-2">
                                            <label for="status">Status Aktif:</label>
                                            <select name="status" class="form-control" id="status">
                                                <option value="1">aktif</option>
                                                <option value="0">tidak aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="reset" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#modalTambahGudang">Cancel</button>
                                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>kode</th>
                                        <th>nama</th>
                                        <th>alamat</th>
                                        <th>penanggung jawab</th>
                                        <th>status aktif</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $dataGudang = mysqli_query($conn, "select * from Gudang");
                                    $cekGudang = $dataGudang->num_rows;

                                    if ($cekGudang > 0) {
                                        while ($rowGudang = mysqli_fetch_assoc($dataGudang)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $rowGudang['kode'] ?></td>
                                                <td><?php echo $rowGudang['nama']  ?></td>
                                                <td><?php echo $rowGudang['alamat'] ?></td>
                                                <td><?php echo $rowGudang['penanggung_jawab'] ?></td>
                                                <td><?php if($rowGudang['status_aktif'] == 1) { echo 'aktif';} else { echo  'tidak aktif';} ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning" data-toggle="collapse" data-target="#cardEditGudang<?php echo $rowGudang['kode'] ?>"><span class="material-symbols-outlined">edit</span></button>
                                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapusGudang<?php echo $rowGudang['kode'] ?>"><span class="material-symbols-outlined">delete</span></button>
                                                </td>
                                                <div class="card card-outline card-warning mt-2 collapse" id="cardEditGudang<?php echo $rowGudang['kode'] ?>">
                                                    <!-- /.card-header -->
                                                    <!-- form start -->
                                                    <form method="post" action="./master/gudang/edit_gudang.php?kode=<?php echo $rowGudang['kode'] ?>">
                                                        <div class="card-body">
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <label for="nama">Nama:</label>
                                                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" value="<?php echo $rowGudang['nama'] ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="alamat">Alamat:</label>
                                                                    <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat" value="<?php echo $rowGudang['alamat'] ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="penanggung_jawab">Penanggung Jawab</label>
                                                                    <input type="text" name="penanggung_jawab" class="form-control" id="penanggung_jawab" value="<?php echo $rowGudang['penanggung_jawab'] ?>" placeholder="Penanggung jawab" required>
                                                                </div>
                                                                <div class="form-group col-2">
                                                                    <label for="status" class="form-label">Status Aktif:</label>
                                                                    <select name="status" id="status" class="form-control">
                                                                        <option value="1" <?php if ($rowGudang['status_aktif'] == '1') {
                                                                                                echo "selected";
                                                                                            } ?>>aktif</option>
                                                                        <option value="0" <?php if ($rowGudang['status_aktif'] == '0') {
                                                                                                echo "selected";
                                                                                            } ?>>tidak aktif</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                        <div class="card-footer">
                                                            <button type="button" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#cardEditGudang<?php echo $rowGudang['kode'] ?>">Cancel</button>
                                                            <button type="submit" class="btn btn-warning float-right">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </tr>
                                            <div class="modal fade" id="modalHapusGudang<?php echo $rowGudang['kode'] ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Gudang</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda Yakin untuk Menghapus Gudang?</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-danger" onclick="location.href='./master/gudang/delete_gudang.php?kode=<?php echo $rowGudang['kode'] ?>'">DELETE</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Stok</h3>
                        </div>
                        <div class="card-body">
                            
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>