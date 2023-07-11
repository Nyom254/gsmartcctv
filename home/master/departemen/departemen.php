<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Departemen</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?">Home</a></li>
                        <li class="breadcrumb-item active">departemen</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Departemen</h3>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary mb-2" data-toggle="collapse" data-target="#cardTambahDepartemen">Tambah</button>
                            <div class="card card-outline card-primary collapse" id="cardTambahDepartemen">
                                <form method="post" action="./master/departemen/tambah_action.php" id="formTambahDepartemen">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nama">Nama:</label>
                                            <input type="text" name="nama" class="form-control" placeholder="nama">
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan:</label>
                                            <textarea class="form-control" name="keterangan"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="inisial">Inisial:</label>
                                            <input type="text" class="form-control" name="inisial" placeholder="inisial">
                                        </div>
                                        <div class="form-group">
                                            <label for="status">status aktif:</label>
                                            <select name="status" id="status" class="form-control col-md-2">
                                                <option value="1">aktif</option>
                                                <option value="0">tidak aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="reset" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#cardTambahDepartemen">Cancel</button>
                                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th>inisial</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $queryDepartemen = mysqli_query($conn, "select * from departemen");
                                    if ($queryDepartemen->num_rows > 0) {
                                        while ($rowDepartemen = mysqli_fetch_assoc($queryDepartemen)) { ?>
                                            <tr>
                                                <td><?php echo $rowDepartemen['kode'] ?></td>
                                                <td><?php echo $rowDepartemen['nama'] ?></td>
                                                <td><?php echo $rowDepartemen['keterangan'] ?></td>
                                                <td><?php echo $rowDepartemen['inisial'] ?></td>
                                                <td><?php
                                                    if ($rowDepartemen['status_aktif'] == 1) {
                                                        echo "aktif";
                                                    } else {
                                                        echo "tidak aktif";
                                                    } ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning" data-toggle="collapse" data-target="#cardEditDepartemen<?php echo $rowDepartemen['kode'] ?>"><span class="material-symbols-outlined">edit</span></button>
                                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapusDepartemen<?php echo $rowDepartemen['kode'] ?>"><span class="material-symbols-outlined">delete</span></button>
                                                </td>
                                            </tr>

                                            <div class="card card-outline card-warning collapse" id="cardEditDepartemen<?php echo $rowDepartemen['kode'] ?>">
                                                <form method="post" action="./master/departemen/edit_action.php?kode=<?php echo $rowDepartemen['kode'] ?>">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="nama">Nama:</label>
                                                            <input type="text" name="nama" class="form-control" placeholder="nama" value="<?php echo $rowDepartemen['nama'] ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="keterangan">Keterangan:</label>
                                                            <textarea class="form-control" name="keterangan"><?php echo $rowDepartemen['keterangan'] ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inisial">Inisial:</label>
                                                            <input type="text" class="form-control" value="<?php echo $rowDepartemen['inisial'] ?>" name="inisial">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="status">status aktif:</label>
                                                            <select name="status" id="status" class="form-control col-md-2">
                                                                <option value="1" <?php if ($rowDepartemen['status_aktif'] == 1) {
                                                                                        echo "selected";
                                                                                    } ?>>aktif</option>
                                                                <option value="0" <?php if ($rowDepartemen['status_aktif'] == 0) {
                                                                                        echo "selected";
                                                                                    } ?>>tidak aktif</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="reset" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#cardEditDepartemencardEditDepartemen<?php echo $rowDepartemen['kode'] ?>">Cancel</button>
                                                        <button type="submit" class="btn btn-warning float-right">Submit</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="modal fade" id="modalHapusDepartemen<?php echo $rowDepartemen['kode'] ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Departemen</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda Yakin untuk Menghapus Departemen?</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-danger" onclick="location.href='./master/departemen/delete_action.php?kode=<?php echo $rowDepartemen['kode'] ?>'">DELETE</button>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>