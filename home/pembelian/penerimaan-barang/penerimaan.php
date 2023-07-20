<section class="content-header">
    <div class="content-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Penerimaan Barang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?">Home</a></li>
                    <li class="breadcrumb-item active">Penerimaan Barang</li>
                </ol>
            </div>
        </div>
    </div>
</section>


<section class="content">
    <div class="conteinter-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Penerimaan</h3>
                    </div>
                    <div class="card-body">
                        <a href="?content=tambah-penerimaan-barang" class="btn btn-primary mb-2">Tambah</a>
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nomor Penerimaan</th>
                                    <th>Tanggal</th>
                                    <th>Nomor PO</th>
                                    <th>Kode Supplier</th>
                                    <th>Keterangan</th>
                                    <th>aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $queryPenerimaan = mysqli_query($conn, "SELECT * FROM penerimaan");

                                if ($queryPenerimaan->num_rows > 0) {
                                    while ($rowPoPenerimaan = mysqli_fetch_assoc($queryPenerimaan)) { ?>
                                        <tr onclick="getDetailPenerimaan('<?php echo htmlspecialchars($rowPoPenerimaan['no_penerimaan']) ?>')">
                                            <td><?php echo htmlspecialchars($rowPoPenerimaan['no_penerimaan']) ?></td>
                                            <td><?php echo htmlspecialchars($rowPoPenerimaan['tgl']) ?></td>
                                            <td><?php echo htmlspecialchars($rowPoPenerimaan['no_po']) ?></td>
                                            <td><?php echo htmlspecialchars($rowPoPenerimaan['kode_supplier']) ?></td>
                                            <td><?php echo htmlspecialchars($rowPoPenerimaan['keterangan']) ?></td>
                                            <td><a href="" data-toggle="collapse" data-target="#cardEditPenerimaan<?php echo htmlspecialchars(str_replace('/', '',$rowPoPenerimaan['no_penerimaan'])) ?>">Edit</a></td>
                                        </tr>
                                        <div class="card card-outline card-warning mt-2 collapse" id="cardEditPenerimaan<?php echo htmlspecialchars(str_replace('/', '',$rowPoPenerimaan['no_penerimaan'])) ?>">
                                            <!-- /.card-header -->
                                            <!-- form start -->
                                            <form method="post" action="./pembelian/penerimaan-barang/edit_action.php?no=<?php echo htmlspecialchars(urlencode($rowPoPenerimaan['no_penerimaan'])); ?>">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="tanggal">Tanggal:</label>
                                                        <input type="date" name="tanggal" class="form-control" id="tanggal" placeholder="tanggal" value="<?php echo htmlspecialchars($rowPoPenerimaan['tgl']) ?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="no_ref">no Ref:</label>
                                                        <input type="text" name="no_ref" class="form-control" id="no_ref" placeholder="no_ref" value="<?php echo htmlspecialchars($rowPoPenerimaan['no_ref']) ?>" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="keterangan">Keterangan:</label>
                                                        <textarea type="text" name="keterangan" class="form-control" id="keterangan" placeholder="keterangan"><?php echo htmlspecialchars($rowPoPenerimaan['keterangan']) ?></textarea>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                                <div class="card-footer">
                                                    <button type="button" class="btn btn-secondary float-right ml-3" data-toggle="collapse" data-target="#cardEditPenerimaan<?php echo htmlspecialchars(str_replace('/', '', $rowPoPenerimaan['no_penerimaan'])) ?>">Cancel</button>
                                                    <button type="submit" class="btn btn-warning float-right">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Penerimaan Barang</h3>
                    </div>
                    <div class="card-body">
                        <table id="tabel-detail-penerimaan" class="table table-responsive-md table-bordered">
                            <thead>
                                <tr>
                                    <th>No Penerimaan</th>
                                    <th>Kode Barang</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function getDetailPenerimaan(noPenerimaan) {

        var xhr = new XMLHttpRequest()
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText)
                const table = document.getElementById("tabel-detail-penerimaan")
                for (var i = 1; i < table.rows.length;) {
                    table.deleteRow(i);
                }
                for (var i = 0; i < response.length; i++) {
                    let item = response[i]
                    var newRow = table.insertRow()
                    var cell1 = newRow.insertCell(0)
                    cell1.innerHTML = item.no_penerimaan

                    var cell2 = newRow.insertCell(1)
                    cell2.innerHTML = item.kode_barang

                    var cell3 = newRow.insertCell(2)
                    cell3.innerHTML = item.quantity
                }
            }
        }
        xhr.open('GET', './pembelian/penerimaan-barang/data_detail-penerimaan.php?no=' + noPenerimaan, true)
        xhr.send()
    }
</script>