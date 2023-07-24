<div class="container">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pemakaian Kertas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?">Home</a></li>
                        <li class="breadcrumb-item active">pemakaian kertas</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pemakaian Kertas</h3>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary mb-2" data-toggle="collapse" data-target="#cardTambahKertas">Tambah</button>
                            <div class="card card-outline card-primary collapse" id="cardTambahKertas">
                                <form method="post" action="./pemakaian_kertas/tambah_action.php" id="formPemakaianKertas">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="no_kertas" class="col-6 col-form-label">No Kertas</label>
                                            <div class="col-6">
                                                <input type="text" name="no_kertas" class="form-control" id="no_kertas" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tanggal" class="col-6 col-form-label">Tanggal</label>
                                            <div class="col-6">
                                                <input type="date" name="tanggal" class="form-control" id="tanggal" oninput="generateNoKertas()">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jenis" class="col-6 col-form-label">Jenis</label>
                                            <div class="col-6">
                                                <select name="jenis" class="form-control" id="jenis">
                                                    <option value="masuk">masuk</option>
                                                    <option value="keluar">keluar</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="quantity" class="col-6 col-form-label">Quantity</label>
                                            <div class="col-6">
                                                <input type="number" name="quantity" class="form-control" id="quantity">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pemakai" class="col-6 col-form-label">Pemakai</label>
                                            <div class="col-6">
                                                <select name="kode_user" class="form-control" id="pemakai">
                                                    <?php
                                                    $queryUser = mysqli_query($conn, "select id_user, nama from user where status_aktif = 1");
                                                    if ($queryUser->num_rows > 0) {
                                                        while ($rowKertas = mysqli_fetch_assoc($queryUser)) { ?>
                                                            <option value="<?php echo $rowKertas['id_user'] ?>"><?php echo $rowKertas['nama'] ?></option>
                                                    <?php
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="barang" class="col-6 col-form-label">Barang</label>
                                            <div class="col-6">
                                                <select name="kode_barang" class="form-control" id="barang">
                                                    <?php
                                                    $queryBarang = mysqli_query($conn, "select id_barang, nama from barang where status_aktif = 1 and type = 'non_persediaan'");
                                                    if ($queryBarang->num_rows > 0) {
                                                        while ($rowBarang = mysqli_fetch_assoc($queryBarang)) { ?>
                                                            <option value="<?php echo $rowBarang['id_barang'] ?>"><?php echo $rowBarang['nama'] ?></option>
                                                    <?php
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="keterangan" class="col-6 col-form-label">Keterangan</label>
                                            <div class="col-6">
                                                <textarea name="keterangan" class="form-control" id="keterangan"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="reset" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#cardTambahKertas">Cancel</button>
                                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                                    </div>
                                </form>

                            </div>
                            <div class="table-responsive">
                                <table id="pemakaian_kertas" class="table table-bordered table-striped small">
                                    <thead>
                                        <tr>
                                            <th>no kertas</th>
                                            <th>tanggal</th>
                                            <th>pemakai</th>
                                            <th>barang</th>
                                            <th>jenis</th>
                                            <th>keterangan</th>
                                            <th>Qty</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $dataKertas = mysqli_query($conn, "SELECT * FROM `KERTAS` LEFT JOIN user ON user.id_user = KERTAS.kode_user LEFT JOIN barang ON barang.id_barang = KERTAS.kode_barang;");
                                        $cekKertas = $dataKertas->num_rows;

                                        if ($cekKertas > 0) {
                                            while ($rowKertas = mysqli_fetch_assoc($dataKertas)) {
                                        ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($rowKertas['no_kertas'])  ?></td>
                                                    <td><?php echo  date('d-m-Y', strtotime($rowKertas['tgl'])) ?></td>
                                                    <td><?php echo htmlspecialchars($rowKertas['username']) ?></td>
                                                    <td><?php echo htmlspecialchars($rowKertas['nama']) ?></td>
                                                    <td><?php echo htmlspecialchars($rowKertas['jenis']) ?></td>
                                                    <td><?php echo htmlspecialchars($rowKertas['keterangan']) ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($rowKertas['qty']) ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-warning" data-toggle="collapse" data-target="#cardEditKertas<?php
                                                                                                                                                    $sequence = substr($rowKertas['no_kertas'], 7);
                                                                                                                                                    $date = substr($rowKertas['no_kertas'], 2, 4);
                                                                                                                                                    echo "$date$sequence"
                                                                                                                                                    ?>"><span class="material-symbols-outlined">edit</span></button>
                                                        <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapusKertas<?php
                                                                                                                                                $sequence = substr($rowKertas['no_kertas'], 7);
                                                                                                                                                $date = substr($rowKertas['no_kertas'], 2, 4);
                                                                                                                                                echo "$date$sequence"
                                                                                                                                                ?>"><span class="material-symbols-outlined">delete</span></button>
                                                    </td>
                                                    <div class="card card-outline card-warning mt-2 collapse" id="cardEditKertas<?php
                                                                                                                                $sequence = substr($rowKertas['no_kertas'], 7);
                                                                                                                                $date = substr($rowKertas['no_kertas'], 2, 4);
                                                                                                                                echo "$date$sequence"
                                                                                                                                ?>">
                                                        <!-- /.card-header -->
                                                        <!-- form start -->
                                                        <form method="post" action="./pemakaian_kertas/edit_action.php" id="formPemakaianKertas">
                                                            <div class="card-body">
                                                                <div class="form-group row">
                                                                    <label for="no_kertas" class="col-6 col-form-label">No Kertas</label>
                                                                    <div class="col-6">
                                                                        <input type="text" name="no_kertas" class="form-control" id="no_kertas" value="<?php echo $rowKertas['no_kertas'] ?>" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="tanggal" class="col-6 col-form-label">Tanggal</label>
                                                                    <div class="col-6">
                                                                        <input type="date" name="tanggal" class="form-control" id="tanggal" value="<?php echo $rowKertas['tgl'] ?>" oninput="generateNoKertas()">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="jenis" class="col-6 col-form-label">Jenis</label>
                                                                    <div class="col-6">
                                                                        <select name="jenis" class="form-control" id="jenis">
                                                                            <option value="masuk">masuk</option>
                                                                            <option value="keluar" <?php if ($rowKertas['jenis'] == 'keluar') {
                                                                                                        echo 'selected';
                                                                                                    } ?>>keluar</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="quantity" class="col-6 col-form-label">Quantity</label>
                                                                    <div class="col-6">
                                                                        <input type="number" name="quantity" class="form-control" id="quantity" value="<?php echo $rowKertas['qty'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="pengguna" class="col-6 col-form-label">Pengguna</label>
                                                                    <div class="col-6">
                                                                        <select name="kode_user" class="form-control" id="pengguna">
                                                                            <?php
                                                                            $queryUser = mysqli_query($conn, "select id_user, nama from user where status_aktif = 1");
                                                                            if ($queryUser->num_rows > 0) {
                                                                                while ($rowUser = mysqli_fetch_assoc($queryUser)) { ?>
                                                                                    <option value="<?php echo $rowUser['id_user'] ?>" <?php if ($rowKertas['kode_user'] == $rowUser['id_user']) {
                                                                                                                                            echo 'selected';
                                                                                                                                        } ?>><?php echo $rowUser['nama'] ?></option>
                                                                            <?php
                                                                                }
                                                                            }

                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="barang" class="col-6 col-form-label">Barang</label>
                                                                    <div class="col-6">
                                                                        <select name="kode_barang" class="form-control" id="barang">
                                                                            <?php
                                                                            $queryBarang = mysqli_query($conn, "select id_barang, nama from barang where status_aktif = 1 and type = 'non_persediaan'");
                                                                            if ($queryBarang->num_rows > 0) {
                                                                                while ($rowBarang = mysqli_fetch_assoc($queryBarang)) { ?>
                                                                                    <option value="<?php echo $rowBarang['id_barang'] ?>" <?php if ($rowKertas['kode_user'] == $rowBarang['id_barang']) {
                                                                                                                                                echo 'selected';
                                                                                                                                            } ?>><?php echo $rowBarang['nama'] ?></option>
                                                                            <?php
                                                                                }
                                                                            }

                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label for="keterangan" class="col-6 col-form-label">Keterangan</label>
                                                                    <div class="col-6">
                                                                        <textarea name="keterangan" class="form-control" id="keterangan"><?php echo htmlspecialchars($rowKertas['keterangan']) ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer">
                                                                <button type="reset" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#cardEditKertas<?php echo substr($rowKertas['no_kertas'], 7) ?>">Cancel</button>
                                                                <button type="submit" class="btn btn-warning float-right">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </tr>
                                                <div class="modal fade" id="modalHapusKertas<?php
                                                                                            $sequence = substr($rowKertas['no_kertas'], 7);
                                                                                            $date = substr($rowKertas['no_kertas'], 2, 4);
                                                                                            echo "$date$sequence"
                                                                                            ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Hapus Pemakaian Kertas</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah Anda Yakin untuk Menghapus Pemakaian Kertas?</p>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-danger" onclick="location.href='./pemakaian_kertas/delete_action.php?no_kertas=<?php echo $rowKertas['no_kertas'] ?>'">DELETE</button>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->
                                            <?php
                                            }
                                            ?>

                                        <?php
                                        }
                                        ?>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><b>Total:</b></td>
                                            <td><b><?php
                                                    $sql = "SELECT (IFNULL(masuk.total_masuk, 0) - IFNULL(keluar.total_keluar, 0)) AS total FROM ( SELECT SUM(qty) AS total_masuk FROM `KERTAS` WHERE jenis = 'masuk' ) AS masuk JOIN ( SELECT SUM(qty) AS total_keluar FROM `KERTAS` WHERE jenis = 'keluar' ) AS keluar;";
                                                    $queryTotalKertas = mysqli_query($conn, $sql);
                                                    $total = mysqli_fetch_assoc($queryTotalKertas);
                                                    echo $total['total']
                                                    ?></b>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<style>
    .error {
        text-align: end;
    }
</style>
<script>
    function generateNoKertas() {
        var xhr = new XMLHttpRequest()
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText)
                const dateParts = document.getElementById("tanggal").value.split("-")
                const tahun = dateParts[0].slice(-2)
                const bulan = dateParts[1]
                var noKertas;
                for (i = 0; i < response.length; i++) {
                    let item = response[i]
                    let lastYear = item.no_kertas.substr(2, 2)
                    let lastMonth = item.no_kertas.substr(4, 2)

                    if (lastYear == tahun && lastMonth == bulan) {
                        var lastSequence = parseInt(item.no_kertas.substr(8));
                        var sequence = (lastSequence + 1).toString().padStart(4, '0');
                        //console.log(`PO/${tahun}${bulan}/${sequence}`)
                        noKertas = `K/${tahun}${bulan}/${sequence}`
                    }
                }

                if (typeof(noKertas) === "string") {
                    document.getElementById("no_kertas").value = noKertas
                    return
                } else {
                    document.getElementById("no_kertas").value = `K/${tahun}${bulan}/0001`
                }

            }
        }
        xhr.open('GET', './pemakaian_kertas/data_no_kertas.php', true)
        xhr.send()
    }
</script>