<div class="container">


  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Users</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="?">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
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
              <h3 class="card-title">Daftar User</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <button class="btn btn-primary mb-2" data-toggle="collapse" data-target="#modalTambahUser">Tambah</button>
              <div class="card card-outline card-primary mt-2 collapse" id="modalTambahUser">
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="./master/users/tambah_action.php" id="formTambahUser">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="nama">Nama</label>
                      <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" required>
                    </div>
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Password</label>
                      <input type="password" name="password" class="form-control" id="Password" placeholder="Password" required>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group ">
                        <label for="level">level</label>
                        <select type="text" name="level" class="form-control" id="level" required>
                          <option value="0">user</option>
                          <option value="1">admin</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group ">
                        <label for="status">status aktif:</label>
                        <select name="status" class="form-control" id="status" required>
                          <option value="1">aktif</option>
                          <option value="0">tidak aktif</option>
                        </select>
                      </div>
                    </div>

                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="reset" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#modalTambahUser">Cancel</button>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                  </div>
                </form>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>nama</th>
                    <th>username</th>
                    <th>level</th>
                    <th>status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $dataUser = mysqli_query($conn, "select * from user");
                  $cekUser = $dataUser->num_rows;

                  if ($cekUser > 0) {
                    while ($rowUser = mysqli_fetch_assoc($dataUser)) {
                  ?>
                      <tr>
                        <td><?php echo htmlspecialchars($rowUser['nama'])  ?></td>
                        <td><?php echo htmlspecialchars($rowUser['username']) ?></td>
                        <td><?php
                            if ($rowUser['level'] == 0) {
                              echo "user";
                            } else {
                              echo "admin";
                            }
                            ?>
                        </td>
                        <td><?php
                            if ($rowUser['status_aktif'] == 0) {
                              echo "tidak aktif";
                            } else {
                              echo "aktif";
                            }
                            ?>
                        </td>
                        <td>
                          <button class="btn btn-sm btn-warning" data-toggle="collapse" data-target="#cardEditUser<?php echo htmlspecialchars($rowUser['id_user']) ?>"><span class="material-symbols-outlined">edit</span></button>
                          <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapusUser<?php echo htmlspecialchars($rowUser['id_user']) ?>"><span class="material-symbols-outlined">delete</span></button>
                        </td>
                        <div class="card card-outline card-warning mt-2 collapse" id="cardEditUser<?php echo htmlspecialchars($rowUser['id_user']) ?>">
                          <!-- /.card-header -->
                          <!-- form start -->
                          <form method="post" action="./master/users/edit_action.php?id_user=<?php echo htmlspecialchars($rowUser['id_user']) ?>">
                            <div class="card-body">
                              <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" value="<?php echo htmlspecialchars($rowUser['nama']) ?>" required>
                              </div>
                              <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Username" value="<?php echo htmlspecialchars($rowUser['username']) ?>" required>
                              </div>
                              <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" name="password" class="form-control" id="password" placeholder="Password" >
                              </div>
                              <div class="col-md-2">
                                <div class="form-group ">
                                  <label for="level">level</label>
                                  <select type="text" name="level" class="form-control" id="level" placeholder="Username">
                                    <option value="1" <?php if ($rowUser['level'] == '1') {
                                                        echo "selected";
                                                      } ?>>admin</option>
                                    <option value="0" <?php if ($rowUser['level'] == '0') {
                                                        echo "selected";
                                                      } ?>>user</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group ">
                                  <label for="status">status aktif:</label>
                                  <select name="status" class="form-control" id="status" required>
                                    <option value="1" >aktif</option>
                                    <option value="0" <?php if ($rowUser['status_aktif'] == '0') {
                                                        echo "selected";
                                                      } ?>>tidak aktif</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                              <button type="button" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#cardEditUser<?php echo htmlspecialchars($rowUser['id_user']) ?>">Cancel</button>
                              <button type="submit" class="btn btn-warning float-right">Submit</button>
                            </div>
                          </form>
                        </div>
                      </tr>
                      <div class="modal fade" id="modalHapusUser<?php echo htmlspecialchars($rowUser['id_user']) ?>">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Hapus User</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>Apakah Anda Yakin untuk Menghapus User?</p>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-danger" onclick="location.href='./master/users/delete_action.php?id_user=<?php echo $rowUser['id_user'] ?>'">DELETE</button>
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