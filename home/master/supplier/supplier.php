<div class="container">


  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Supplier</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="?">Home</a></li>
            <li class="breadcrumb-item active">Supplier</li>
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
              <h3 class="card-title">Daftar Supplier</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <button class="btn btn-primary mb-2" data-toggle="collapse" data-target="#modalTambahSupplier">Tambah</button>
              <div class="card card-outline card-primary mt-2 collapse" id="modalTambahSupplier">
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="./master/supplier/tambah_action.php" id="formTambahSupplier">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nama">Nama:</label>
                      <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama">
                    </div>
                    <div class="form-group">
                      <label for="alamat">Alamat:</label>
                      <input type="text" name="alamat" class="form-control" id="alamat" placeholder="alamat">
                    </div>
                    <div class="form-group">
                      <label for="kota">Kota:</label>
                      <input type="text" name="kota" class="form-control" id="kota" placeholder="kota">
                    </div>
                    <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="email" name="email" class="form-control" id="email" placeholder="email">
                    </div>
                    <div class="form-group">
                      <label for="contact">Contact Person:</label>
                      <input type="number" name="contact" class="form-control" id="contact" placeholder="contact person">
                    </div>
                    <div class="form-group">
                      <label for="keterangan">Keterangan:</label>
                      <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="keterangan">
                    </div>
                    <div class="col-2">
                      <div class="form-group ">
                        <label for="status">Status:</label>
                        <select type="text" name="status" class="form-control" id="status">
                          <option value="1">aktif</option>
                          <option value="0">tidak aktif</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="reset" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#modalTambahSupplier">Cancel</button>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                  </div>
                </form>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>nama</th>
                    <th>alamat</th>
                    <th>kota</th>
                    <th>email</th>
                    <th>contact</th>
                    <th>keterangan</th>
                    <th>status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $dataSupplier = mysqli_query($conn, "select * from supplier");
                  $cekSupplier = $dataSupplier->num_rows;

                  if ($cekSupplier > 0) {
                    while ($rowSupplier = mysqli_fetch_assoc($dataSupplier)) {
                  ?>
                      <tr>
                        <td><?php echo $rowSupplier['nama']  ?></td>
                        <td><?php echo $rowSupplier['alamat'] ?></td>
                        <td><?php echo $rowSupplier['kota'] ?></td>
                        <td><?php echo $rowSupplier['email'] ?></td>
                        <td><?php echo $rowSupplier['contact'] ?></td>
                        <td><?php echo $rowSupplier['keterangan'] ?></td>
                        <td><?php
                            if ($rowSupplier['status_aktif'] == 0) {
                              echo "tidak aktif";
                            } else {
                              echo "aktif";
                            }
                            ?>
                        </td>
                        <td>
                          <button class="btn btn-sm btn-warning" data-toggle="collapse" data-target="#cardEditSupplier<?php echo $rowSupplier['id_supplier'] ?>"><span class="material-symbols-outlined">edit</span></button>
                          <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapusSupplier<?php echo $rowSupplier['id_supplier'] ?>"><span class="material-symbols-outlined">delete</span></button>
                        </td>
                        <div class="card card-outline card-warning mt-2 collapse" id="cardEditSupplier<?php echo $rowSupplier['id_supplier'] ?>">
                          <!-- /.card-header -->
                          <!-- form start -->
                          <form method="post" action="./master/supplier/edit_action.php?id_supplier=<?php echo $rowSupplier['id_supplier'] ?>">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="nama">Nama:</label>
                                <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" value="<?php echo $rowSupplier['nama'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="alamat">Alamat:</label>
                                <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat" value="<?php echo $rowSupplier['alamat'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="kota">Kota:</label>
                                <input type="text" name="kota" class="form-control" id="kota" placeholder="Kota" value="<?php echo $rowSupplier['kota'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo $rowSupplier['email'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="contact">Contact Person:</label>
                                <input type="number" name="contact" class="form-control" id="contact" placeholder="contact person" value="<?php echo $rowSupplier['contact'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="keterangan">keterangan:</label>
                                <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan" value="<?php echo $rowSupplier['keterangan'] ?>">
                              </div>
                              <div class="col-2">
                                <div class="form-group ">
                                  <label for="status" class="form-label">status</label>
                                  <select type="text" name="status" class="form-control" id="status">
                                    <option value="1" <?php if ($rowSupplier['status_aktif'] == '1') {
                                                        echo "selected";
                                                      } ?>>aktif</option>
                                    <option value="0" <?php if ($rowSupplier['status_aktif'] == '0') {
                                                        echo "selected";
                                                      } ?>>tidak aktif</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                              <button type="button" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#cardEditSupplier<?php echo $rowSupplier['id_supplier'] ?>">Cancel</button>
                              <button type="submit" class="btn btn-warning float-right">Submit</button>
                            </div>
                          </form>
                        </div>
                      </tr>
                      <div class="modal fade" id="modalHapusSupplier<?php echo $rowSupplier['id_supplier'] ?>">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Hapus Supplier</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>Apakah Anda Yakin untuk Menghapus Supplier?</p>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-danger" onclick="location.href='./master/supplier/delete_action.php?id_supplier=<?php echo $rowSupplier['id_supplier'] ?>'">DELETE</button>
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
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
</div>
