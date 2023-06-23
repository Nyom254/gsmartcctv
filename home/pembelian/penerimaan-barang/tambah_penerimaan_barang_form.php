<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Penerimaan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?">Home</a></li>
                    <li class="breadcrumb-item"><a href="?content=penerimaan_barang">Penerimaan</a></li>
                    <li class="breadcrumb-item">Tambah Penerimaan Barang</li>
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
                    <form action="./pembelian/penerimaan-barang/tambah_penerimaan_barang_action.php" id="form_tambah_penerimaan_barang" method="post">
                        <div class="card-body">
                            <div class="modal fade" id="tabelCariPO">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header text-dark">
                                            <h5 class="modal-title">Cari PO</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body text-dark small">
                                            <table id="tabel-po-penerimaan" class="table table-striped table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No Transaksi</th>
                                                        <th>Tanggal</th>
                                                        <th>Supplier</th>
                                                        <th>Keterangan</th>
                                                        <th>Term</th>
                                                        <th>Jatuh Tempo </th>
                                                        <th>Total</th>
                                                        <th>status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $dataPO = mysqli_query($conn, "SELECT * FROM purcahse_order LEFT JOIN po_penerimaan ON po_penerimaan.NO_TRANSAKSI = purcahse_order.NO_TRANSAKSI LEFT JOIN( SELECT po_penerimaan.NO_TRANSAKSI, po_penerimaan.ST, CASE WHEN SUM(po_penerimaan.ST) > 0 AND SUM(po_penerimaan.ST) < COUNT(po_penerimaan.NO_TRANSAKSI) THEN 'partial' WHEN po_penerimaan.stk = 1 THEN 'terpenuhi' ELSE 'baru' END AS `status` FROM purcahse_order LEFT JOIN po_penerimaan ON po_penerimaan.NO_TRANSAKSI = purcahse_order.NO_TRANSAKSI GROUP BY po_penerimaan.NO_TRANSAKSI )AS `status` ON purcahse_order.NO_TRANSAKSI = status.NO_TRANSAKSI WHERE po_penerimaan.stk = 0 GROUP BY purcahse_order.NO_TRANSAKSI;");
                                                    $cekDataPO = $dataPO->num_rows;

                                                    if ($cekDataPO > 0) {
                                                        while ($rowPO = mysqli_fetch_assoc($dataPO)) { ?>
                                                            <tr onclick="getDetailPurchaseOrder('<?php echo $rowPO['NO_TRANSAKSI'] ?>')">
                                                                <td> <a class="a" data-dismiss="modal" onclick="putBarangPO('<?php echo $rowPO['NO_TRANSAKSI'] ?>')" style="cursor:pointer;"><?php echo $rowPO['NO_TRANSAKSI'] ?></a></td>
                                                                <td><?php echo $rowPO['TANGGAL'] ?></td>
                                                                <td><?php
                                                                    $queryNamaSupplier = mysqli_query($conn, "select nama from supplier where id_supplier = '" . $rowPO['KODE_SUPPLIER'] . "' ");
                                                                    $namaSupplier = mysqli_fetch_assoc($queryNamaSupplier);
                                                                    echo $namaSupplier['nama'];
                                                                    ?>
                                                                </td>
                                                                <td class="text-break"><?php echo $rowPO['KETERANGAN']  ?></td>
                                                                <td><?php echo $rowPO['TERM']  ?></td>
                                                                <td><?php echo $rowPO['JATUH_TEMPO']  ?></td>
                                                                <td><?php
                                                                    $jumlahTotal = $rowPO['DPP'] + $rowPO['PPN'];
                                                                    $total = number_format($jumlahTotal, '0', ',', '.');
                                                                    echo $total;
                                                                    ?></td>
                                                                <td><?php echo $rowPO['status'] ?></td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-body small">
                                            <table class="table table-striped table-hover detail-purchase-order" id="info-detail-PO-penerimaan">
                                                <thead>
                                                    <tr>
                                                        <th>No Urut</th>
                                                        <th>Kode Barang</th>
                                                        <th>Quantity</th>
                                                        <th>Quantity Diterima</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group row">
                                        <label for="no_penerimaan" class="col-sm-4 col-form-label col-form-label-sm">No. Penerimaan:</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="no_penerimaan" name="no_penerimaan" class="form-control form-control-sm" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tanggal" class="col-sm-4 col-form-label col-form-label-sm"> Tanggal:</label>
                                        <div class="col-sm-8">
                                            <input type="date" id="tanggal" name="tanggal" class="form-control form-control-sm" oninput="generateNoPenerimaan(this.value)" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="searchPO" class="col-sm-4 col-form-label col-form-label-sm"> No PO:</label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <input type="text" name="no_po" id="searchPO" class="form-control form-control-sm col-9" readonly required>
                                                <button type="button" class="btn btn-sm btn-success col-3" data-toggle="modal" data-target="#tabelCariPO"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-5">
                                    <div class="form-group row">
                                        <label for="kode_vendor" class="col-sm-4 col-form-label col-form-label-sm">Kode Vendor:</label>
                                        <div class="col-sm-8">
                                            <select type="text" name="kode_vendor" id="kode_vendor" class="form-control form-control-sm">
                                                <?php
                                                $dataSupplier = mysqli_query($conn, "select * from supplier where status_aktif = '1'");
                                                $cekSupplier = $dataSupplier->num_rows;
                                                if ($cekSupplier > 0) {
                                                    while ($rowSupplier = mysqli_fetch_assoc($dataSupplier)) { ?>
                                                        <option value="<?php echo $rowSupplier['id_supplier']; ?>"> <?php echo $rowSupplier['nama']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="gudang" class="col-sm-4 col-form-label-sm">Gudang:</label>
                                        <div class="col-sm-8">
                                            <select name="gudang" id="term" class="form-control form-control-sm">
                                                <?php
                                                $dataGudang = mysqli_query($conn, "select * from Gudang where status_aktif = '1'");
                                                $cekGudang = $dataGudang->num_rows;
                                                if ($cekGudang > 0) {
                                                    while ($rowGudang = mysqli_fetch_assoc($dataGudang)) { ?>
                                                        <option value="<?php echo $rowGudang['kode']; ?>"> <?php echo $rowGudang['nama']; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <table id="tambah-detail-penerimaan" class="table table-responsive-md table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Kode Barang</th>
                                            <th scope="col">Nama Barang</th>
                                            <th scope="col">Qty PO</th>
                                            <th scope="col">Qty Terima</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="keterangan">Keterangan:</label>
                                    <textarea name="keterangan" id="keterangan" rows="3" class="form-control"></textarea>
                                </div>
                                <div class="col-2"></div>
                                <div class="form-group row col-4">
                                    <label class="col-sm-6 col-form-label col-form-label-sm"> Total Qty diterima:</label>
                                    <div class="col-sm-6">
                                        <input id="totalQty" class="form-control form-control-sm" readonly>
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
    function generateNoPenerimaan(tanggal) {

        var xhr = new XMLHttpRequest()
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText)
                const dateParts = tanggal.split("-")
                const tahun = dateParts[0].slice(-2)
                const bulan = dateParts[1]
                var noPenerimaan;
                for (i = 0; i < response.length; i++) {
                    let item = response[i]
                    console.log(item)
                    let lastYear = item.no_penerimaan.substr(3, 2)
                    let lastMonth = item.no_penerimaan.substr(5, 2)

                    if (lastYear == tahun && lastMonth == bulan) {
                        var lastSequence = parseInt(item.no_penerimaan.substr(8));
                        var sequence = (lastSequence + 1).toString().padStart(4, '0');
                        //console.log(`PO/${tahun}${bulan}/${sequence}`)
                        noPenerimaan = `PB/${tahun}${bulan}/${sequence}`
                    }
                }

                if (typeof(noPenerimaan) === "string") {
                    document.getElementById("no_penerimaan").value = noPenerimaan
                    return
                } else {
                    document.getElementById("no_penerimaan").value = `PB/${tahun}${bulan}/0001`
                }

            }
        }
        xhr.open('GET', './pembelian/penerimaan-barang/data_no-penerimaan.php', true)
        xhr.send()

    }

    function getDetailPurchaseOrder(noTransaksi) {

        var xhr = new XMLHttpRequest()
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText)
                const table = document.querySelector(".detail-purchase-order")
                for (var i = 1; i < table.rows.length;) {
                    table.deleteRow(i);
                }
                for (var i = 0; i < response.length; i++) {
                    let item = response[i]
                    var newRow = table.insertRow()
                    var cell1 = newRow.insertCell(0)
                    cell1.innerHTML = item.URUTAN

                    var cell2 = newRow.insertCell(1)
                    cell2.innerHTML = item.KODE_BARANG

                    var cell3 = newRow.insertCell(2)
                    cell3.innerHTML = item.QUANTITY

                    var cell4 = newRow.insertCell(3)
                    cell4.innerHTML = item.qty_terima

                }
            }
        }
        xhr.open('GET', './pembelian/penerimaan-barang/data_detail-purchase-order.php?no=' + noTransaksi, true)
        xhr.send()
    }

    function setAttribute(elem) {
        for (var i = 1; i < arguments.length; i += 2) {
            elem.setAttribute(arguments[i], arguments[i + 1]);
        }
    }

    function putBarangPO(noPO) {
        document.getElementById("searchPO").value = noPO
        var xhr = new XMLHttpRequest()
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText)
                const table = document.getElementById("tambah-detail-penerimaan")

                for (var i = 1; i < table.rows.length;) {
                    table.deleteRow(i);
                }
                for (var i = 0; i < response.length; i++) {
                    let item = response[i];
                    console.log(item);
                    var newRow = table.insertRow()
                    var cell1 = newRow.insertCell(0)
                    cell1.innerHTML = i + 1;

                    var cell2 = newRow.insertCell(1)
                    var elemKodeBarang = document.createElement("input")
                    setAttribute(elemKodeBarang,
                        "name", 'kode-barang[]',
                        'value', item.KODE_BARANG,
                        'readonly', '',
                        'style', 'pointer-events:none; background-color:transparent;border:none;'
                    )
                    cell2.appendChild(elemKodeBarang)

                    var cell3 = newRow.insertCell(2)
                    cell3.innerHTML = item.nama

                    var cell4 = newRow.insertCell(3)
                    cell4.innerHTML = parseInt(item.qty_po) - parseInt(item.qty_terima)
                    cell4.style.textAlign = "right"

                    var cell5 = newRow.insertCell(4)
                    var elemQtyTerima = document.createElement("input")
                    setAttribute(elemQtyTerima,
                        "name", 'qty-terima[]',
                        'class', 'form-control form-control-sm',
                        'oninput', 'getTotalQty()',
                        'required',''
                    )
                    cell5.appendChild(elemQtyTerima)

                    var cell6 = newRow.insertCell(5)
                    cell6.innerHTML = item.ST
                }
            }
        }
        xhr.open('GET', './pembelian/penerimaan-barang/data_view_po-penerimaan.php?no=' + noPO, true)
        xhr.send()
    }

    function getTotalQty() {
        const table = document.getElementById("tambah-detail-penerimaan")
        const tr = table.rows
        var totalQty = 0
        for (i = 1; i < tr.length; i++) {
            let td = tr[i].children
            let input = td[4].children[0]
            totalQty += parseInt(input.value)
        }

        document.getElementById("totalQty").value = totalQty
    }

    document.getElementById("form_tambah_penerimaan_barang").addEventListener("keydown", (event) => {
    if (event.key === 'Enter' || event.keycode === 13) {
        event.preventDefault();
    }
})
</script>