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
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $queryPenerimaan = mysqli_query($conn, "SELECT * FROM penerimaan");

                                if ($queryPenerimaan->num_rows > 0) {
                                    while ($rowPoPenerimaan = mysqli_fetch_assoc($queryPenerimaan)) { ?>
                                        <tr onclick="getDetailPenerimaan('<?php echo $rowPoPenerimaan['no_penerimaan'] ?>')">
                                            <td><?php echo $rowPoPenerimaan['no_penerimaan'] ?></td>
                                            <td><?php echo $rowPoPenerimaan['tgl'] ?></td>
                                            <td><?php echo $rowPoPenerimaan['no_po'] ?></td>
                                            <td><?php echo $rowPoPenerimaan['kode_supplier'] ?></td>
                                            <td><?php echo $rowPoPenerimaan['keterangan'] ?></td>
                                        </tr>
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