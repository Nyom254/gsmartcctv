<div class="container">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Barang</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="?">Home</a></li>
            <li class="breadcrumb-item active">Barang</li>
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
              <h3 class="card-title">Daftar Barang</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <button class="btn btn-primary mb-2" data-toggle="collapse" data-target="#modalTambahBarang">Tambah</button>
              <div class="card card-outline card-primary mt-2 collapse" id="modalTambahBarang">
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="./master/barang/tambah_action.php" id="formTambahBarang">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nama">Nama Barang:</label>
                      <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Barang">
                    </div>
                    <div class="form-group">
                      <label for="harga">Harga:</label>
                      <input type="number" name="harga" class="form-control" id="harga" placeholder="Harga">
                    </div>
                    <div class="form-group">
                      <label for="satuan">Satuan:</label>
                      <input type="text" name="satuan" class="form-control" id="satuan" placeholder="Satuan">
                    </div>
                    <div class="form-group">
                      <label for="group_barang">Group Barang</label>
                      <select name="group_barang" class="form-control col-md-3" id="group_barang">
                        <?php
                        $dataGroupBarang = mysqli_query($conn, "select * from group_barang where status_aktif = '1'");
                        $cekGroupBarang = $dataGroupBarang->num_rows;

                        if ($cekGroupBarang > 0) {
                          while ($rowGroupBarang = mysqli_fetch_assoc($dataGroupBarang)) { ?>
                            <option value="<?php echo htmlspecialchars($rowGroupBarang['id_group']); ?>"> <?php echo htmlspecialchars($rowGroupBarang['nama_group']); ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="departemen">Departemen</label>
                      <select name="departemen" class="form-control col-md-2" id="departemen">
                        <?php
                        $dataDepartemen = mysqli_query($conn, "select * from departemen where status_aktif = '1'");
                        $cekDepartemen = $dataDepartemen->num_rows;

                        if ($cekDepartemen > 0) {
                          while ($rowDepartemen = mysqli_fetch_assoc($dataDepartemen)) { ?>
                            <option value="<?php echo $rowDepartemen['kode']; ?>"> <?php echo htmlspecialchars($rowDepartemen['nama']); ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="type">Type:</label>
                      <select type="text" name="type" class="form-control col-md-3" id="type">
                        <option value="barang">Barang</option>
                        <option value="jasa">Jasa</option>
                        <option value="non_persediaan">Non Persediaan</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="status">Status Aktif:</label>
                      <select type="text" name="status" class="form-control col-md-2" id="status">
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                      </select>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="reset" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#modalTambahBarang">Cancel</button>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                  </div>
                </form>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Satuan</th>
                    <th>Group Barang</th>
                    <th>Type</th>
                    <th>Departemen</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $dataBarang = mysqli_query($conn, "SELECT * FROM barang LEFT JOIN (SELECT kode, nama AS nama_departemen FROM departemen) AS departemen ON departemen.kode = barang.kode_departemen");
                  $cekBarang = $dataBarang->num_rows;

                  if ($cekBarang > 0) {
                    while ($rowBarang = mysqli_fetch_assoc($dataBarang)) {
                      $dataGroupBarang = mysqli_query($conn, "select * from group_barang where id_group = '" . $rowBarang['group_barang'] . "' ");
                      $rowGroupBarang = mysqli_fetch_assoc($dataGroupBarang);
                  ?>
                      <tr>
                        <td><?php echo htmlspecialchars($rowBarang['nama'])  ?></td>
                        <td><?php echo htmlspecialchars($rowBarang['harga']) ?></td>
                        <td><?php echo htmlspecialchars($rowBarang['satuan']) ?></td>
                        <td><?php echo htmlspecialchars($rowGroupBarang['nama_group']) ?></td>
                        <td><?php echo htmlspecialchars($rowBarang['type']) ?></td>
                        <td><?php echo htmlspecialchars($rowBarang['nama_departemen']) ?></td>
                        <td><?php
                            if ($rowBarang['status_aktif'] == 0) {
                              echo "tidak aktif";
                            } else {
                              echo "aktif";
                            }
                            ?>
                        </td>
                        <td>
                          <button class="btn btn-sm btn-warning" data-toggle="collapse" data-target="#cardEditUser<?php echo htmlspecialchars($rowBarang['id_barang']) ?>"><span class="material-symbols-outlined">edit</span></button>
                          <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapusUser<?php echo htmlspecialchars($rowBarang['id_barang']) ?>"><span class="material-symbols-outlined">delete</span></button>
                        </td>
                        <div class="card card-outline card-warning mt-2 collapse" id="cardEditUser<?php echo htmlspecialchars($rowBarang['id_barang']) ?>">
                          <!-- /.card-header -->
                          <!-- form start -->
                          <form method="post" action="./master/barang/edit_action.php?id_barang=<?php echo htmlspecialchars($rowBarang['id_barang']) ?>">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="nama">Nama Barang:</label>
                                <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Barang" value="<?php echo htmlspecialchars($rowBarang['nama']) ?>">
                              </div>
                              <div class="form-group">
                                <label for="harga">Harga: </label>
                                <input type="number" name="harga" class="form-control" id="harga" placeholder="Harga" value="<?php echo htmlspecialchars($rowBarang['harga']) ?>">
                              </div>
                              <div class="form-group">
                                <label for="satuan">Satuan:</label>
                                <input type="text" name="satuan" class="form-control" id="satuan" placeholder="Satuan" value="<?php echo htmlspecialchars($rowBarang['satuan']) ?>">
                              </div>
                              <div class="form-group ">
                                <label for="group_barang">Group Barang:</label>
                                <select type="text" name="group_barang" class="form-control col-md-3" id="group_barang">
                                  <?php
                                  $dataGroupBarang = mysqli_query($conn, "select * from group_barang where status_aktif = '1'");
                                  $cekGroupBarang = $dataGroupBarang->num_rows;
                                  if ($cekGroupBarang > 0) {
                                    while ($rowGroupBarang = mysqli_fetch_assoc($dataGroupBarang)) { ?>
                                      <option value="<?php echo $rowGroupBarang['id_group']; ?>" <?php if ($rowBarang['group_barang'] == $rowGroupBarang['id_group']) {
                                                                                                    echo "selected";
                                                                                                  } ?>> <?php echo htmlspecialchars($rowGroupBarang['nama_group']); ?></option>
                                  <?php
                                    }
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="departemen">Departemen</label>
                                <select name="departemen" class="form-control col-md-3" id="departemen">
                                  <?php
                                  $dataDepartemen = mysqli_query($conn, "select * from departemen where status_aktif = '1'");
                                  $cekDepartemen = $dataDepartemen->num_rows;

                                  if ($cekDepartemen > 0) {
                                    while ($rowDepartemen = mysqli_fetch_assoc($dataDepartemen)) { ?>
                                      <option value="<?php echo $rowDepartemen['kode']; ?>" <?php if ($rowDepartemen['kode'] == $rowBarang['kode_departemen']) {
                                                                                              echo "selected";
                                                                                            } ?>> <?php echo htmlspecialchars($rowDepartemen['nama']); ?></option>
                                  <?php
                                    }
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="type">Type:</label>
                                <select type="text" name="type" class="form-control col-md-2" id="type">
                                  <option value="barang">Barang</option>
                                  <option value="jasa" <?php if ($rowBarang['type'] == 'jasa') {
                                                          echo "selected";
                                                        } ?>>Jasa</option>
                                  <option value="non_persediaan" <?php if ($rowBarang['type'] == 'non_persediaan') {
                                                                    echo "selected";
                                                                  } ?>>Non Persediaan</option>
                                </select>
                              </div>
                              <div class="form-group ">
                                <label for="status">Status Aktif:</label>
                                <select name="status" class="form-control col-md-2" id="status">
                                  <option value="1" <?php if ($rowBarang['status_aktif'] == '1') {
                                                      echo "selected";
                                                    } ?>>aktif</option>
                                  <option value="0" <?php if ($rowBarang['status_aktif'] == '0') {
                                                      echo "selected";
                                                    } ?>>tidak aktif</option>
                                </select>
                              </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                              <button type="button" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#cardEditUser<?php echo htmlspecialchars($rowBarang['id_barang']) ?>">Cancel</button>
                              <button type="submit" class="btn btn-warning float-right ">Submit</button>
                            </div>
                          </form>
                        </div>
                      </tr>
                      <div class="modal fade" id="modalHapusUser<?php echo htmlspecialchars($rowBarang['id_barang']) ?>">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Hapus Barang</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>Apakah Anda Yakin untuk Menghapus Barang?</p>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-danger" onclick="location.href='./master/barang/delete_action.php?id_barang=<?php echo htmlspecialchars($rowBarang['id_barang']) ?>'">DELETE</button>
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