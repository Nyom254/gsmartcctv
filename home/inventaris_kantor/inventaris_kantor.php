<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inventaris Kantor</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?">Home</a></li>
                        <li class="breadcrumb-item active">inventaris kantor</li>
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
                            <h3 class="card-title">Inventaris Kantor</h3>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary mb-2" data-toggle="collapse" data-target="#cardTambahInventarisKantor">Tambah</button>
                            <div class="card card-outline card-primary collapse" id="cardTambahInventarisKantor">
                                <form method="post" action="./inventaris_kantor/tambah_action.php" id="tambahFormInventarisKantor" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                    <label for="no_inventaris" class="col-6 col-form-label">No Inventaris</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="no_inventaris" class="form-control" id="no_inventaris" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tanggal" class="col-sm-6 col-form-label">Tanggal</label>
                                                    <div class="col-sm-6">
                                                        <input type="date" name="tanggal" class="form-control" id="tanggal" oninput="generateNoInventaris()">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="barang" class="col-sm-6 col-form-label">Barang</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="nama_barang">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="posisi" class="col-sm-6 col-form-label">Posisi</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="posisi" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="quantity" class="col-sm-6 col-form-label">Quantity</label>
                                                    <div class="col-sm-6">
                                                        <input type="number" name="quantity" class="form-control" id="quantity">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="keterangan" class="col-sm-6 col-form-label">Keterangan</label>
                                                    <div class="col-sm-6">
                                                        <textarea name="keterangan" class="form-control" id="keterangan"> </textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-6 col-form-label">Attachment</label>
                                                    <div class="input-group col-sm-6">
                                                        <div class="custom-file">
                                                            <input type="file" accept="image/*;capture=camera" name="gambar" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer col-12">
                                                <button type="reset" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#cardTambahInventarisKantor">Cancel</button>
                                                <button type="submit" class="btn btn-primary float-right">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>no inventaris</th>
                                        <th>tanggal</th>
                                        <th>nama barang</th>
                                        <th>posisi</th>
                                        <th>keterangan</th>
                                        <th>qty</th>
                                        <th>attachment</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $queryInventarisKantor = mysqli_query($conn, "select * from inventaris_kantor");
                                    if ($queryInventarisKantor->num_rows > 0) {
                                        while ($rowInvetarisKantor = mysqli_fetch_assoc($queryInventarisKantor)) { ?>

                                            <tr>
                                                <td><?php echo $rowInvetarisKantor['no_inventaris'] ?></td>
                                                <td><?php echo $rowInvetarisKantor['tgl'] ?></td>
                                                <td><?php echo $rowInvetarisKantor['nama_barang'] ?></td>
                                                <td><?php echo $rowInvetarisKantor['posisi'] ?></td>
                                                <td><?php echo $rowInvetarisKantor['keterangan'] ?></td>
                                                <td><?php echo $rowInvetarisKantor['qty'] ?></td>
                                                <td>
                                                    <p id="loading<?php echo $rowInvetarisKantor['no_inventaris'] ?>">Loading ....</p>
                                                    <a href="data:image/*;base64,<?php echo base64_encode($rowInvetarisKantor['attachment']) ?>" data-toggle="lightbox" data-title="<?php echo $rowInvetarisKantor['no_inventaris'] ?>">
                                                        <img decoding="async" src="data:image/*;base64,<?php echo base64_encode($rowInvetarisKantor['attachment']) ?>" width="100px" height="100px" onload="document.getElementById('loading<?php echo $rowInvetarisKantor['no_inventaris'] ?>').style.display = 'none'" class="img-fluid mb-2" alt="<?php echo $rowInvetarisKantor['no_inventaris'] ?>" />
                                                    </a>
                                                </td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm" data-toggle="collapse" data-target="#cardEditInventarisKantor<?php
                                                                                                                                                        $sequence = substr($rowInvetarisKantor['no_inventaris'], 0, 4);
                                                                                                                                                        $bulan = substr($rowInvetarisKantor['no_inventaris'], 9, 2);
                                                                                                                                                        $tahun = substr($rowInvetarisKantor['no_inventaris'], 12, 4);
                                                                                                                                                        echo "$bulan$tahun$sequence";
                                                                                                                                                        ?>"><span class="material-symbols-outlined">edit</span></button>
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapusInventaris<?php
                                                                                                                                                $sequence = substr($rowInvetarisKantor['no_inventaris'], 0, 4);
                                                                                                                                                $bulan = substr($rowInvetarisKantor['no_inventaris'], 9, 2);
                                                                                                                                                $tahun = substr($rowInvetarisKantor['no_inventaris'], 12, 4);
                                                                                                                                                echo "$bulan$tahun$sequence" ?>"><span class="material-symbols-outlined">delete</span></button>
                                                </td>
                                            </tr>
                                            <div class="card card-outline card-warning mt-2 collapse" id="cardEditInventarisKantor<?php
                                                                                                                                    $sequence = substr($rowInvetarisKantor['no_inventaris'], 0, 4);
                                                                                                                                    $bulan = substr($rowInvetarisKantor['no_inventaris'], 9, 2);
                                                                                                                                    $tahun = substr($rowInvetarisKantor['no_inventaris'], 12, 4);
                                                                                                                                    echo "$bulan$tahun$sequence";
                                                                                                                                    ?>">
                                                <!-- /.card-header -->
                                                <!-- form start -->
                                                <form method="post" action="./inventaris_kantor/edit_action.php" id="editFormInventarisKantor" enctype="multipart/form-data">
                                                    <div class="card-body">
                                                        <div class="form-group row">
                                                            <label for="no_inventaris" class="col-sm-6 col-form-label">No Inventaris</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="no_inventaris" class="form-control" id="no_inventaris" value="<?php echo $rowInvetarisKantor['no_inventaris'] ?>" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="tanggal" class="col-sm-6 col-form-label">Tanggal</label>
                                                            <div class="col-sm-6">
                                                                <input type="date" name="tanggal" class="form-control" id="tanggal" value="<?php echo $rowInvetarisKantor['tgl'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="barang" class="col-sm-6 col-form-label">Barang</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="nama_barang" class="form-control" value="<?php echo $rowInvetarisKantor['nama_barang'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="posisi" class="col-sm-6 col-form-label">Posisi</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" name="posisi" class="form-control" value="<?php echo $rowInvetarisKantor['posisi'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="quantity" class="col-sm-6 col-form-label">Quantity</label>
                                                            <div class="col-sm-6">
                                                                <input type="number" name="quantity" class="form-control" id="quantity" value="<?php echo $rowInvetarisKantor['qty'] ?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="keterangan" class="col-sm-6 col-form-label">Keterangan</label>
                                                            <div class="col-sm-6">
                                                                <textarea name="keterangan" class="form-control" id="keterangan"><?php echo $rowInvetarisKantor['keterangan'] ?> </textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-6 col-form-label">Attachment</label>
                                                            <div class="input-group col-sm-6">
                                                                <div class="custom-file">
                                                                    <input type="file" name="gambar" accept="image/;capture=camera" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="reset" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#cardEditInventarisKantor<?php
                                                                                                                                                                                        $sequence = substr($rowInvetarisKantor['no_inventaris'], 0, 4);
                                                                                                                                                                                        $bulan = substr($rowInvetarisKantor['no_inventaris'], 9, 2);
                                                                                                                                                                                        $tahun = substr($rowInvetarisKantor['no_inventaris'], 12, 4);
                                                                                                                                                                                        echo "$bulan$tahun$sequence";
                                                                                                                                                                                        ?>">Cancel</button>
                                                        <button type="submit" class="btn btn-warning float-right">Submit</button>
                                                    </div>
                                                </form>
                                            </div>


                                            <div class="modal fade" id="modalHapusInventaris<?php
                                                                                            $sequence = substr($rowInvetarisKantor['no_inventaris'], 0, 4);
                                                                                            $bulan = substr($rowInvetarisKantor['no_inventaris'], 9, 2);
                                                                                            $tahun = substr($rowInvetarisKantor['no_inventaris'], 12, 4);
                                                                                            echo "$bulan$tahun$sequence" ?>">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Inventaris Kantor</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah Anda Yakin untuk Menghapus Inventaris Kantor?</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-danger" onclick="location.href='./inventaris_kantor/delete_action.php?no_inventaris=<?php echo $rowInvetarisKantor['no_inventaris'] ?>'">DELETE</button>
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

<style>
    .error {
        text-align: right;
    }
</style>

<script>
    function generateNoInventaris() {
        var xhr = new XMLHttpRequest()
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText)
                const romanNumerals = [
                    "", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"
                ];
                const dateParts = document.getElementById("tanggal").value.split("-")
                const tahun = dateParts[0]
                const monthString = dateParts[1].toString().replace(/^0+/, '');
                const bulan = romanNumerals[monthString];
                var noInventaris;
                for (i = 0; i < response.length; i++) {
                    let item = response[i]
                    let lastYear = item.no_inventaris.substr(12, 4)
                    let lastMonth = item.no_inventaris.substr(9, 2)
                    if (lastYear == tahun && lastMonth == bulan) {
                        var lastSequence = parseInt(item.no_inventaris.substr(0, 4));
                        var sequence = (lastSequence + 1).toString().padStart(4, '0');
                        noInventaris = `${sequence}/HRD/${bulan}/${tahun}`;
                    }
                }

                if (typeof(noInventaris) === "string") {
                    document.getElementById("no_inventaris").value = noInventaris
                    return
                } else {
                    document.getElementById("no_inventaris").value = `0001/HRD/${bulan}/${tahun}`;
                }

            }
        }
        xhr.open('GET', './inventaris_kantor/data_no_inventaris_kantor.php', true)
        xhr.send()
    }
</script>