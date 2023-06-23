<div class="container">


  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Customer</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="?">Home</a></li>
            <li class="breadcrumb-item active">Customer</li>
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
              <h3 class="card-title">Daftar Customer</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <button class="btn btn-primary mb-2" data-toggle="collapse" data-target="#modalTambahCustomer">Tambah</button>
              <div class="card card-outline card-primary mt-2 collapse" id="modalTambahCustomer">
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="./master/customer/tambah_action.php" id="formTambahCustomer">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nama">Nama:</label>
                      <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama">
                    </div>
                    <div class="form-group">
                      <label for="alamat">Alamat:</label>
                      <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat">
                    </div>
                    <div class="form-group">
                      <label for="telp">no. Telp: </label>
                      <input type="number" name="no_telp" class="form-control" id="telp" placeholder="no. Telp">
                    </div>
                    <div class="form-group">
                      <label for="kota">Kota:</label>
                      <input type="text" name="kota" class="form-control" id="kote" placeholder="Kota">
                    </div>
                    <div class="form-group">
                      <label for="provinsi">Provinsi: </label>
                      <input type="text" name="provinsi" class="form-control" id="provinsi" placeholder="provinsi">
                    </div>
                    <div class="form-group">
                      <label for="keterangan">Keterangan: </label>
                      <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="keterangan">
                    </div>
                    <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <label for="status">status</label>
                        <select type="text" name="status" class="form-control" id="status">
                          <option value="maintenance">maintenance</option>
                          <option value="beli_komputer">beli komputer</option>
                          <option value="beli_cctv">beli cctv</option>
                          <option value="prospect">prospect</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-2">
                      <div class="form-group ">
                        <label for="status_aktif">status aktif</label>
                        <select type="text" name="status_aktif" class="form-control" id="status_aktif">
                          <option value="1">aktif</option>
                          <option value="0">tidak aktif</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="reset" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#modalTambahCustomer">Cancel</button>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                  </div>
                </form>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>nama</th>
                    <th>alamat</th>
                    <th>no .telp</th>
                    <th>kota</th>
                    <th>provinsi</th>
                    <th>keterangan</th>
                    <th>email</th>
                    <th>status</th>
                    <th>status aktif: </th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $dataCustomer = mysqli_query($conn, "select * from customer");
                  $cekCustomer = $dataCustomer->num_rows;

                  if ($cekCustomer > 0) {
                    while ($rowCustomer = mysqli_fetch_assoc($dataCustomer)) {
                  ?>
                      <tr>
                        <td><?php echo $rowCustomer['nama']  ?></td>
                        <td><?php echo $rowCustomer['alamat'] ?></td>
                        <td><?php echo $rowCustomer['telp'] ?></td>
                        <td><?php echo $rowCustomer['kota'] ?></td>
                        <td><?php echo $rowCustomer['provinsi'] ?></td>
                        <td><?php echo $rowCustomer['keterangan'] ?></td>
                        <td><?php echo $rowCustomer['email'] ?></td>
                        <td><?php echo $rowCustomer['status'] ?></td>
                        <td><?php
                            if ($rowCustomer['status_aktif'] == 0) {
                              echo "tidak aktif";
                            } else {
                              echo "aktif";
                            }
                            ?>
                        </td>
                        <td>
                          <button class="btn btn-sm btn-warning" data-toggle="collapse" data-target="#cardEditCustomer<?php echo $rowCustomer['id_customer'] ?>"><span class="material-symbols-outlined">edit</span></button>
                          <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapusCustomer<?php echo $rowCustomer['id_customer'] ?>"><span class="material-symbols-outlined">delete</span></button>
                        </td>
                        <div class="card card-outline card-warning mt-2 collapse" id="cardEditCustomer<?php echo $rowCustomer['id_customer'] ?>">
                          <!-- /.card-header -->
                          <!-- form start -->
                          <form method="post" action="./master/customer/edit_action.php?id_customer=<?php echo $rowCustomer['id_customer'] ?>">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" value="<?php echo $rowCustomer['nama'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="alamat">Alamat:</label>
                                <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat" value="<?php echo $rowCustomer['alamat'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="telp">no .Telp</label>
                                <input type="number" name="no_telp" class="form-control" id="telp" placeholder="no. Telp" value="<?php echo $rowCustomer['telp'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="kota">Kota:</label>
                                <input type="text" name="kota" class="form-control" id="kota" placeholder="Kota" value="<?php echo $rowCustomer['kota'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="provinsi">Provinsi:</label>
                                <input type="text" name="provinsi" class="form-control" id="provinsi" placeholder="Provinsi" value="<?php echo $rowCustomer['provinsi'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="keterangan">Keterangan:</label>
                                <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan" value="<?php echo $rowCustomer['keterangan'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo $rowCustomer['email'] ?>">
                              </div>
                              <div class="col-3">
                                <div class="form-group ">
                                  <label for="status">Status:</label>
                                  <select type="text" name="status" class="form-control" id="status">
                                    <option value="maintenance" <?php if ($rowCustomer['status'] == 'maintenance') {
                                                                  echo "selected";
                                                                } ?>>maintenance</option>
                                    <option value="beli_komputer" <?php if ($rowCustomer['status'] == 'beli_komputer') {
                                                                    echo "selected";
                                                                  } ?>>beli komputer</option>
                                    <option value="beli_cctv" <?php if ($rowCustomer['status'] == 'beli_cctv') {
                                                                echo "selected";
                                                              } ?>>beli cctv</option>
                                    <option value="prospect" <?php if ($rowCustomer['status'] == 'prospect') {
                                                                echo "selected";
                                                              } ?>>prospect</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-2">
                                <div class="form-group ">
                                  <label for="status_aktif">Status Aktif: </label>
                                  <select name="status_aktif" class="form-control" id="status_aktif">
                                    <option value="1" <?php if ($rowCustomer['status_aktif'] == '1') {
                                                        echo "selected";
                                                      } ?>>aktif</option>
                                    <option value="0" <?php if ($rowCustomer['status_aktif'] == '0') {
                                                        echo "selected";
                                                      } ?>>tidak aktif</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                              <button type="button" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#cardEditCustomer<?php echo $rowCustomer['id_customer'] ?>">Cancel</button>
                              <button type="submit" class="btn btn-warning float-right">Submit</button>
                            </div>
                          </form>
                        </div>
                      </tr>
                      <div class="modal fade" id="modalHapusCustomer<?php echo $rowCustomer['id_customer'] ?>">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Hapus Customer</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>Apakah Anda Yakin untuk Menghapus Customer?</p>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-danger" onclick="location.href='./master/customer/delete_action.php?id_customer=<?php echo $rowCustomer['id_customer'] ?>'">DELETE</button>
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