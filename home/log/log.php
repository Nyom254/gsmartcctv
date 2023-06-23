<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h1>Log</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="?">Home</a></li>
          <li class="breadcrumb-item active">Log</li>
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
            <table id="log-data-table" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>no transaksi</th>
                  <th>action</th>
                  <th>keterangan</th>
                  <th>USERID</th>
                  <th>waktu</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $dataLog = mysqli_query($conn, "select * from log_transaksi order by crtime desc");
                $cekLog = $dataLog->num_rows;



                if ($cekLog > 0) {
                  while ($rowLog = mysqli_fetch_assoc($dataLog)) {
                    // Extract date and time components
                    $crtime_datetime = DateTime::createFromFormat("Y-m-d H:i:s", $rowLog['CRTIME']);
                    $crtime_date = $crtime_datetime->format("Y-m-d");
                    $crtime_time = $crtime_datetime->format("H:i:s");

                    // Reconstruct crtime value with hours before the date
                    $reversed_crtime = $crtime_time . " " . $crtime_date;
                ?>
                    <tr>
                      <td><?php echo $rowLog['NO_TRANSAKSI']  ?></td>
                      <td><?php echo $rowLog['ACTION'] ?></td>
                      <td><?php echo $rowLog['KETERANGAN'] ?></td>
                      <td><?php echo $rowLog['USERID'] ?></td>
                      <td><?php echo $reversed_crtime ?></td>
                    </tr>
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