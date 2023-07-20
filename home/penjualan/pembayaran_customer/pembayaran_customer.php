<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pembayaran Customer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?">Home</a></li>
                        <li class="breadcrumb-item">Penjualan</li>
                        <li class="breadcrumb-item active">Pembayaran Customer</li>
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
                            <h3 class="card-title">Pembayaran Customer</h3>
                        </div>
                        <div class="card-body">
                            <a href="?content=tambah_pembayaran_customer" class="btn btn-primary mb-3">Tambah</a>
                            <table id="example1" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No Pembayaran</th>
                                        <th>Tanggal</th>
                                        <th>Customer</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>attachment</th>
                                        <th>Total</th>
                                        <th>Departemen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $queryPembayaranCustomer = mysqli_query($conn, "SELECT A.no_pembayaran, A.tanggal, B.nama AS customer, A.jenis_pembayaran, A.total, C.nama AS departemen, A.attachment from pembayaran_customer AS A LEFT JOIN customer AS B ON A.kode_customer = B.id_customer LEFT JOIN departemen AS C ON C.kode = A.kode_departemen");
                                    if ($queryPembayaranCustomer->num_rows > 0) {
                                        while ($rowPembayaranCustomer = mysqli_fetch_assoc($queryPembayaranCustomer)) { ?>
                                            <tr onclick="showDetailPembayaran('<?php echo htmlspecialchars($rowPembayaranCustomer['no_pembayaran']) ?>')">
                                                <td><?php echo htmlspecialchars($rowPembayaranCustomer['no_pembayaran']) ?></td>
                                                <td><?php echo htmlspecialchars($rowPembayaranCustomer['tanggal']) ?></td>
                                                <td><?php echo htmlspecialchars($rowPembayaranCustomer['customer']) ?></td>
                                                <td><?php echo htmlspecialchars($rowPembayaranCustomer['jenis_pembayaran']) ?></td>
                                                <td>
                                                    <?php
                                                    if ($rowPembayaranCustomer['attachment'] != null) { ?>
                                                        <a href="./penjualan/pembayaran_customer/data_attachment.php?id='<?php echo htmlspecialchars(urlencode($rowPembayaranCustomer['no_pembayaran'])) ?>'" data-toggle="lightbox" data-title="<?php echo htmlspecialchars($rowPembayaranCustomer['no_pembayaran']) ?>" data-type="image">
                                                            <img src="./penjualan/pembayaran_customer/data_attachment.php?id='<?php echo htmlspecialchars(urlencode($rowPembayaranCustomer['no_pembayaran'])) ?>'" width="100px" height="100px" class="img-fluid mb-2" />
                                                        </a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($rowPembayaranCustomer['total']) ?></td>
                                                <td><?php echo htmlspecialchars($rowPembayaranCustomer['departemen']) ?></td>
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
                            <h3 class="card-title">Detail Pembayaran</h3>
                        </div>
                        <div class="card-body">
                            <table id="detail-pembayaran" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td>No. Invoice</td>
                                        <td>Tagihan</td>
                                        <td>Potongan</td>
                                        <td>Bayar</td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    function showDetailPembayaran(noPembayaran) {
        var xhr = new XMLHttpRequest()
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText)
                const table = document.getElementById("detail-pembayaran")
                console.log(table);
                for (var i = 1; i < table.rows.length;) {
                    table.deleteRow(i);
                }
                for (var i = 0; i < response.length; i++) {
                    let item = response[i]
                    var newRow = table.insertRow()
                    
                    const cell1 = newRow.insertCell(0);
                    cell1.innerHTML = item.no_invoice;

                    const cell2 = newRow.insertCell(1);
                    cell2.innerHTML = item.tagihan;
                    const cell3 = newRow.insertCell(2);
                    cell3.innerHTML = item.potongan;
                    const cell4 = newRow.insertCell(3);
                    cell4.innerHTML = item.bayar;
                }
            }
        }
        xhr.open('GET', './penjualan/pembayaran_customer/data_detail-pembayaran.php?no=' + noPembayaran, true)
        xhr.send()
    }
</script>