<div class="container">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Group Barang</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="?">Home</a></li>
            <li class="breadcrumb-item active">Group Barang</li>
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
              <h3 class="card-title">Daftar Group Barang</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <button class="btn btn-primary mb-2" data-toggle="collapse" data-target="#modalTambahGroupBarang">Tambah</button>
              <div class="card card-outline card-primary mt-2 collapse" id="modalTambahGroupBarang">
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="./master/group_barang/tambah_action.php" id="formTambahGroupBarang">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nama_group">Nama Group:</label>
                      <input type="text" name="nama_group" class="form-control" id="nama_group" placeholder="Nama Group">
                    </div>
                    <div class="col-2">
                      <div class="form-group ">
                        <label for="status">Status:</label>
                        <select type="text" name="status" class="form-control select2" id="status">
                          <option value="1">aktif</option>
                          <option value="0">tidak aktif</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="reset" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#modalTambahGroupBarang">Close</button>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                  </div>
                </form>
              </div>
              <table id="example1" class="table table-bordered table-striped col-12">
                <thead>
                  <tr>
                    <th>Nama Group</th>
                    <th>status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $dataGroupBarang = mysqli_query($conn, "select * from group_barang");
                  $cekGroupBarang = $dataGroupBarang->num_rows;

                  if ($cekGroupBarang > 0) {
                    while ($rowGroupBarang = mysqli_fetch_assoc($dataGroupBarang)) {
                  ?>
                      <tr>
                        <td class="col-6"><?php echo $rowGroupBarang['nama_group']  ?></td>
                        <td class="col-4"><?php
                            if ($rowGroupBarang['status_aktif'] == 0) {
                              echo "tidak aktif";
                            } else {
                              echo "aktif";
                            }
                            ?>
                        </td>
                        <td class="col2">
                          <button class="btn btn-sm btn-warning" data-toggle="collapse" data-target="#cardEditGroupBarang<?php echo $rowGroupBarang['id_group'] ?>"><span class="material-symbols-outlined">edit</span></button>
                          <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapusGroupBarang<?php echo $rowGroupBarang['id_group'] ?>"><span class="material-symbols-outlined">delete</span></button>
                        </td>
                        <div class="card card-outline card-warning mt-2 collapse" id="cardEditGroupBarang<?php echo $rowGroupBarang['id_group'] ?>">
                          <!-- /.card-header -->
                          <!-- form start -->
                          <form method="post" action="./master/group_barang/edit_action.php?id_group=<?php echo $rowGroupBarang['id_group'] ?>">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="nama_grou">Nama Group</label>
                                <input type="text" name="nama_group" class="form-control" id="nama_group" placeholder="Nama Group" value="<?php echo $rowGroupBarang['nama_group'] ?>">
                              </div>
                              <div class="col-2">
                                <div class="form-group ">
                                  <label for="status">status aktif</label>
                                  <select type="text" name="status" class="form-control select2" id="status">
                                    <option value="1" <?php if ($rowGroupBarang['status_aktif'] == '1') {echo "selected";} ?>>aktif</option>
                                    <option value="0" <?php if ($rowGroupBarang['status_aktif'] == '0') {echo "selected";} ?>>tidak aktif</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                              <button type="button" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#cardEditGroupBarang<?php echo $rowGroupBarang['id_group'] ?>">Cancel</button>
                              <button type="submit" class="btn btn-warning float-right ml-3">Submit</button>
                            </div>
                          </form>
                        </div>
                      </tr>
                      <div class="modal fade" id="modalHapusGroupBarang<?php echo $rowGroupBarang['id_group'] ?>">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Hapus Group Barang</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>Apakah Anda Yakin untuk Menghapus Group Barang?</p>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-danger" onclick="location.href='./master/group_barang/delete_action.php?id_group=<?php echo $rowGroupBarang['id_group'] ?>'">DELETE</button>
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
