<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Invoice Penjualan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?">Home</a></li>
                    <li class="breadcrumb-item"><a href="?content=invoice_penjualan">Invoice Penjualan</a></li>
                    <li class="breadcrumb-item">Tambah Invoice Penjualan</li>
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
                <div class="card">
                    <form action="./penjualan/invoice_penjualan/tambah_invoice-penjualan_action.php" id="formTambahInvoicePenjualan" method="post">
                        <div class="card-body">
                            <div class="modal fade" id="tabelCariSO">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header text-dark">
                                            <h5 class="modal-title">Cari SO</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark small">
                                            <table id="example1" class="table table-striped table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No Transaksi</th>
                                                        <th>Tanggal</th>
                                                        <th>Customer</th>
                                                        <th>Pengirim</th>
                                                        <th>Keterangan</th>
                                                        <th>Jatuh Tempo</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $dataSO = mysqli_query($conn, "SELECT * FROM sales_order LEFT JOIN (SELECT no_transaksi AS no_invoice , no_so FROM invoice_penjualan)AS invoice_penjualan ON sales_order.no_transaksi = invoice_penjualan.no_so INNER JOIN (SELECT id_customer, nama from customer) as cust on sales_order.kode_customer = cust.id_customer WHERE invoice_penjualan.no_invoice IS null");
                                                    $cekDataSO = $dataSO->num_rows;

                                                    if ($cekDataSO > 0) {
                                                        while ($rowSO = mysqli_fetch_assoc($dataSO)) { ?>
                                                            <tr onclick="getDetailSalesOrder('<?php echo $rowSO['no_transaksi'] ?>')">
                                                                <td> <a class="a" data-dismiss="modal" onclick="putSOValue('<?php echo $rowSO['no_transaksi'] ?>')" style="cursor:pointer;"><?php echo $rowSO['no_transaksi'] ?></a></td>
                                                                <td><?php echo $rowSO['tanggal'] ?></td>
                                                                <td><?php echo $rowSO['nama'] ?></td>
                                                                <td><?php echo $rowSO['pengirim'] ?></td>
                                                                <td class="text-break"><?php echo $rowSO['keterangan']  ?></td>
                                                                <td><?php echo $rowSO['jatuh_tempo']  ?></td>
                                                                <td><?php
                                                                    $jumlahTotal = $rowSO['dpp'] + $rowSO['ppn'];
                                                                    $total = number_format($jumlahTotal, '2', ',', '.');
                                                                    echo $total;
                                                                    ?></td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-body small">
                                            <table class="table table-striped table-hover" id="tabel-detail-sales-order">
                                                <thead>
                                                    <tr>
                                                        <th>No Urut</th>
                                                        <th>Kode Barang</th>
                                                        <th>Harga</th>
                                                        <th>Diskon</th>
                                                        <th>Quantity</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="no_transaksi" class="col-sm-4 col-form-label col-form-label-sm">No. Transaksi:</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="no_transaksi" name="no_transaksi" class="form-control form-control-sm" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tanggal" class="col-sm-4 col-form-label col-form-label-sm"> Tanggal:</label>
                                        <div class="col-sm-8">
                                            <input type="date" id="tanggal" name="tanggal" class="form-control form-control-sm" oninput="generateNoTransaksi()" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="departemen" class="col-sm-4 col-form-label col-form-label-sm">Departemen:</label>
                                        <div class="col-sm-8">
                                            <select name="departemen" class="form-control form-control-sm" id="departemen" readonly>
                                                <?php
                                                $dataDepartemen = mysqli_query($conn, "select * from departemen where status_aktif = '1'");
                                                $cekDepartemen = $dataDepartemen->num_rows;
                                                if ($cekDepartemen > 0) {
                                                    while ($rowDepartemen = mysqli_fetch_assoc($dataDepartemen)) { ?>
                                                        <option value="<?php echo $rowDepartemen['kode']; ?>"> <?php echo $rowDepartemen['inisial']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="searchSO" class="col-sm-4 col-form-label col-form-label-sm"> No SO:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <input type="text" name="no_so" id="searchSO" class="form-control form-control-sm col-9" readonly required>
                                                <button type="button" class="btn btn-sm btn-success col-3" data-toggle="modal" data-target="#tabelCariSO"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="customer" class="col-sm-4 col-form-label col-form-label-sm">Customer:</label>
                                        <div class="col-sm-8">
                                            <select name="customer" class="form-control form-control-sm" id="customer" readonly>
                                                <?php
                                                $dataCustomer = mysqli_query($conn, "select * from customer where status_aktif = '1'");
                                                $cekCustomer = $dataCustomer->num_rows;
                                                if ($cekCustomer > 0) {
                                                    while ($rowCustomer = mysqli_fetch_assoc($dataCustomer)) { ?>
                                                        <option value="<?php echo $rowCustomer['id_customer']; ?>"> <?php echo $rowCustomer['nama']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jatuh_tempo" class="col-sm-4 col-form-label col-form-label-sm">Jatuh Tempo:</label>
                                        <div class="col-sm-8">
                                            <input type="date" name="jatuh_tempo" id="jatuh_tempo" class="form-control form-control-sm" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pengirim" class="col-sm-4 col-form-label col-form-label-sm"> Pengirim:</label>
                                        <div class="col-sm-8">
                                            <select type="" id="pengirim" name="pengirim" class="form-control form-control-sm" readonly>
                                                <?php
                                                $dataUser = mysqli_query($conn, "select * from user where status_aktif = 1");
                                                $cekUser = $dataUser->num_rows;
                                                if ($cekUser > 0) {
                                                    while ($rowUser = mysqli_fetch_assoc($dataUser)) { ?>
                                                        <option value="<?php echo $rowUser['nama'] ?>"><?php echo $rowUser['nama'] ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="no_ref" class="col-sm-4 col-form-label col-form-label-sm">No. Ref:</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="no_ref" id="no_ref" class="form-control form-control-sm" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="term" class="col-sm-4 col-form-label-sm">Term:</label>
                                        <div class="col-sm-8">
                                            <input type="number" name="term" id="term" class="form-control form-control-sm" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jenis_ppn" class="col-sm-4 col-form-label-sm">Jenis PPN:</label>
                                        <div class="col-sm-8">
                                            <select name="jenis_ppn" class="form-control form-control-sm" id="jenis_ppn" readonly>
                                                <option value="PKP">PKP</option>
                                                <option value="Non_PKP">Non PKP</option>
                                                <option value="Include">Include</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="keterangan">Keterangan:</label>
                                    <textarea name="keterangan" id="keterangan" rows="3" class="form-control"></textarea>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row float-right col-9">
                                        <label for="subtotal" class="col-sm-4 col-form-label-sm">Subtotal:</label>
                                        <div class="col-sm-7 ">
                                            <input type="number" name="subtotal" class="form-control form-control-sm" id="subtotal" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row float-right col-9">
                                        <label for="diskon" class="col-sm-4 col-form-label-sm">Diskon:</label>
                                        <div class="col-sm-7">
                                            <input type="number" name="diskon" id="diskon-keseluruhan" class="form-control form-control-sm" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row float-right col-9">
                                        <label for="DPP" class="col-sm-4 col-form-label-sm">DPP:</label>
                                        <div class="col-sm-7 ">
                                            <input type="number" name="dpp" class="form-control form-control-sm" id="dpp" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row float-right col-9" id="container_ppn">
                                        <label for="ppn" class="col-sm-4 col-form-label-sm">PPN:</label>
                                        <div class="col-sm-3 d-flex">
                                            <input type="number" name="ppn-persen" id="ppn-persen" class="form-control form-control-sm" value="11" readonly>
                                            <p class="ml-1">%</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="number" name="ppn" class="form-control form-control-sm" id="ppn" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row float-right col-9">
                                        <label for="grandtotal" class="col-sm-4 col-form-label-sm">Grand Total:</label>
                                        <div class="col-sm-7">
                                            <input type="number" id="grandtotal" name="grandtotal" class="form-control form-control-sm" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary float-right">Save</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .error {
        text-align: center;
    }
</style>
<script>
    function getDetailSalesOrder(noSO) {
        var xhr = new XMLHttpRequest()
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                const table = document.getElementById("tabel-detail-sales-order");
                for (var i = 1; i < table.rows.length; i++) {
                    table.deleteRow(i);
                }
                for (var i = 0; i < response.length; i++) {
                    let item = response[i];
                    var newRow = table.insertRow();
                    var cell1 = newRow.insertCell(0);
                    cell1.innerHTML = item.urutan;

                    var cell2 = newRow.insertCell(1);
                    cell2.innerHTML = item.kode_barang;

                    var cell3 = newRow.insertCell(2);
                    cell3.innerHTML = item.harga;

                    var cell4 = newRow.insertCell(3);
                    cell4.innerHTML = item.diskon;

                    var cell5 = newRow.insertCell(4);
                    cell5.innerHTML = item.quantity;

                }
            }
        }
        xhr.open('GET', './penjualan/invoice_penjualan/data_detail-SO.php?no=' + noSO, true)
        xhr.send()
    }

    function putSOValue(noSO) {
        var xhr = new XMLHttpRequest()
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                const item = response[0];
                document.getElementById("searchSO").value = item.no_transaksi;
                document.getElementById("departemen").value = item.kode_departemen;
                document.getElementById("customer").value = item.kode_customer;
                document.getElementById("pengirim").value = item.pengirim;
                document.getElementById("no_ref").value = item.no_ref;
                document.getElementById("jatuh_tempo").value = item.jatuh_tempo;
                document.getElementById("term").value = item.term;
                document.getElementById("jenis_ppn").value = item.jenis_ppn;
                document.getElementById("keterangan").value = item.keterangan;
                document.getElementById("subtotal").value = item.subtotal;
                document.getElementById("diskon-keseluruhan").value = item.diskon;
                document.getElementById("dpp").value = item.dpp;
                document.getElementById("ppn").value = item.ppn;
                document.getElementById("ppn-persen").value = item.ppn;
                document.getElementById("grandtotal").value = parseInt(item.dpp) + parseFloat(item.ppn);
            }
        }
        xhr.open('GET', './penjualan/invoice_penjualan/data_SO.php?no=' + noSO, true)
        xhr.send()
        generateNoTransaksi();
    }

    function generateNoTransaksi() {
        var xhr = new XMLHttpRequest()
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText)
                const dateParts = document.getElementById("tanggal").value.split("-")
                const tahun = dateParts[0].slice(-2)
                const bulan = dateParts[1]
                var noTransaksi;
                const departemen = document.getElementById("departemen");
                const inisial = departemen.options[departemen.selectedIndex].text;
                for (i = 0; i < response.length; i++) {
                    let item = response[i];
                    let lastYear = item.no_transaksi.substr(8, 2);
                    let lastMonth = item.no_transaksi.substr(10, 2);
                    let lastInisial = item.no_transaksi.substr(3, 4);

                    if (lastYear == tahun && lastMonth == bulan && lastInisial == inisial) {
                        var lastSequence = parseInt(item.no_transaksi.substr(13));
                        var sequence = (lastSequence + 1).toString().padStart(4, '0');
                        //console.log(`PO/${tahun}${bulan}/${sequence}`)
                        noTransaksi = `PJ/${inisial}/${tahun}${bulan}/${sequence}`
                    }
                }
                if (typeof(noTransaksi) === "string") {
                    document.getElementById("no_transaksi").value = noTransaksi
                    return
                } else {
                    document.getElementById("no_transaksi").value = `PJ/${inisial}/${tahun}${bulan}/0001`
                }

            }
        }
        xhr.open('GET', './penjualan/invoice_penjualan/data_no-transaksi.php', true)
        xhr.send()
    }
</script>