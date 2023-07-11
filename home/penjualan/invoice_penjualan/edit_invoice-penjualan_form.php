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

<?php
$noInvoice = $_GET['no'];
$queryInvoicePenjualan = mysqli_query($conn, "select * from invoice_penjualan where no_transaksi = '$noInvoice'");
$dataInvoicePenjualan = mysqli_fetch_assoc($queryInvoicePenjualan);

?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="./penjualan/invoice_penjualan/edit_invoice-penjualan_action.php" id="formTambahInvoicePenjualan" method="post" onkeydown="return event.key != 'Enter';">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="no_transaksi" class="col-sm-4 col-form-label col-form-label-sm">No. Transaksi:</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="no_transaksi" name="no_transaksi" class="form-control form-control-sm" value="<?php echo $dataInvoicePenjualan['no_transaksi'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tanggal" class="col-sm-4 col-form-label col-form-label-sm"> Tanggal:</label>
                                        <div class="col-sm-8">
                                            <input type="date" id="tanggal" name="tanggal" class="form-control form-control-sm" value="<?php echo $dataInvoicePenjualan['tanggal'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="departemen" class="col-sm-4 col-form-label col-form-label-sm">Departemen:</label>
                                        <div class="col-sm-8">
                                            <select name="departemen" class="form-control form-control-sm" id="departemen">
                                                <?php
                                                $dataDepartemen = mysqli_query($conn, "select * from departemen where status_aktif = '1'");
                                                $cekDepartemen = $dataDepartemen->num_rows;
                                                if ($cekDepartemen > 0) {
                                                    while ($rowDepartemen = mysqli_fetch_assoc($dataDepartemen)) { ?>
                                                        <option value="<?php echo $rowDepartemen['kode']; ?>" <?php if ($rowDepartemen['kode'] == $dataInvoicePenjualan['kode_departemen']) {
                                                                                                                    echo 'selected';
                                                                                                                } ?>> <?php echo $rowDepartemen['inisial']; ?></option>
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
                                                <input type="text" name="no_so" id="searchSO" class="form-control form-control-sm col-9" value="<?php echo $dataInvoicePenjualan['no_so'] ?>" readonly required>
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
                                                        <option value="<?php echo $rowCustomer['id_customer']; ?>" <?php if ($rowCustomer['id_customer'] == $dataInvoicePenjualan['kode_customer']) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?>> <?php echo $rowCustomer['nama']; ?></option>
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
                                            <input type="date" name="jatuh_tempo" id="jatuh_tempo" class="form-control form-control-sm" value="<?php echo $dataInvoicePenjualan['jatuh_tempo'] ?>">
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
                                                        <option value="<?php echo $rowUser['nama'] ?>" <?php if ($rowUser['nama'] == $dataInvoicePenjualan['pengirim']) {
                                                                                                            echo 'selected';
                                                                                                        } ?>><?php echo $rowUser['nama'] ?></option>
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
                                            <input type="text" name="no_ref" id="no_ref" class="form-control form-control-sm" value="<?php echo $dataInvoicePenjualan['no_ref'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jenis_ppn" class="col-sm-4 col-form-label-sm">Jenis PPN:</label>
                                        <div class="col-sm-8">
                                            <select name="jenis_ppn" class="form-control form-control-sm" id="jenis_ppn" readonly>
                                                <option value="Non_PKP">Non PKP</option>
                                                <option value="PKP">PKP</option>
                                                <option value="Include">Include</option>
                                            </select>
                                            <script>
                                                document.getElementById('jenis_ppn').value = '<?php echo $dataInvoicePenjualan['jenis_ppn'] ?>'
                                            </script>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="gudang" class="col-sm-4 col-form-label col-form-label-sm"> Gudang:</label>
                                        <div class="col-sm-8">
                                            <select id="gudang" name="gudang" class="form-control form-control-sm">
                                                <?php
                                                $dataGudang = mysqli_query($conn, "SELECT * from Gudang where status_aktif = 1");
                                                $cekGudang = $dataGudang->num_rows;

                                                $querySaldoStok = mysqli_query($conn, "select gudang from saldo_stok where no_transaksi = '$noInvoice'");
                                                $dataGudangSaldoStok = mysqli_fetch_assoc($querySaldoStok);
                                                if ($cekGudang > 0) {
                                                    while ($rowGudang = mysqli_fetch_assoc($dataGudang)) { ?>
                                                        <option value="<?php echo $rowGudang['kode'] ?>" <?php
                                                                                                            if (isset($dataGudangSaldoStok['gudang'])) {
                                                                                                                if ($rowGudang['kode'] == $dataGudangSaldoStok['gudang']) {
                                                                                                                    echo 'selected';
                                                                                                                }
                                                                                                            }
                                                                                                            ?>><?php echo $rowGudang['nama'] ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row table-responsive-xl" style="overflow: scroll; position: relative; height: 325px; width: 100%;">
                                <div>
                                    <table id="detail-invoice-penjualan" class="table small table-small table-bordered table-hover table-striped" style="width: 1000px;">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Kode Barang</th>
                                                <th scope="col">Nama Barang</th>
                                                <th scope="col">Keterangan</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Qty Terjual</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Diskon(%)</th>
                                                <th scope="col">Diskon Satuan</th>
                                                <th scope="col">SubTotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $noSO = $dataInvoicePenjualan['no_so'];
                                            $queryDetailInvoicePenjualan = mysqli_query($conn, "SELECT A.urutan AS no, A.no_transaksi,A.kode_barang, E.nama AS nama_barang, IFNULL(D.keterangan, '') AS keterangan, A.quantity, IFNULL(D.quantity, 0) AS quantity_terjual, A.harga, A.diskon_persentase, A.diskon FROM `detail_sales_order` AS A LEFT JOIN sales_order AS B ON B.no_transaksi = A.no_transaksi LEFT JOIN invoice_penjualan AS C ON C.no_so = B.no_transaksi LEFT JOIN detail_invoice_penjualan AS D ON D.no_transaksi = C.no_transaksi AND D.kode_barang = A.kode_barang LEFT JOIN barang AS E ON E.id_barang = A.kode_barang WHERE A.no_transaksi = '$noSO' order by no asc");

                                            if ($queryDetailInvoicePenjualan->num_rows > 0) {
                                                while ($rowDetailInvoicePenjualan = mysqli_fetch_assoc($queryDetailInvoicePenjualan)) { ?>
                                                    <tr>
                                                        <td><?php echo $rowDetailInvoicePenjualan['no'] ?></td>
                                                        <td><input type="hidden" name="kode-barang[]" value="<?php echo $rowDetailInvoicePenjualan['kode_barang'] ?>"><?php echo $rowDetailInvoicePenjualan['kode_barang'] ?></td>
                                                        <td><?php echo $rowDetailInvoicePenjualan['nama_barang'] ?></td>
                                                        <td><input type="text" name="keterangan-detail[]" value="<?php echo $rowDetailInvoicePenjualan['keterangan'] ?>" class="form-control form-control-sm"></td>
                                                        <td><?php echo $rowDetailInvoicePenjualan['quantity'] ?></td>
                                                        <td><input type="number" name="qty-terjual[]" value="<?php echo $rowDetailInvoicePenjualan['quantity_terjual'] ?>" class="form-control form-control-sm" oninput="putTotalPrices(this)"></td>
                                                        <td><input type="hidden" name="harga[]"><?php echo $rowDetailInvoicePenjualan['harga'] ?></td>
                                                        <td><input type="hidden" name="diskon-persentase[]"><?php echo $rowDetailInvoicePenjualan['diskon_persentase'] ?></td>
                                                        <td><input type="hidden" name="diskon-satuan[]"><?php echo $rowDetailInvoicePenjualan['diskon'] ?></td>
                                                        <td><?php echo $rowDetailInvoicePenjualan['quantity_terjual'] * $rowDetailInvoicePenjualan['harga'] - $rowDetailInvoicePenjualan['quantity_terjual'] * $rowDetailInvoicePenjualan['diskon'] ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
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
                                            <input type="number" name="subtotal" class="form-control form-control-sm" id="subtotal" value="<?php echo $dataInvoicePenjualan['subtotal'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row float-right col-9">
                                        <label for="diskon" class="col-sm-4 col-form-label-sm">Diskon:</label>
                                        <div class="col-sm-7">
                                            <input type="number" name="diskon" id="diskon-keseluruhan" class="form-control form-control-sm" oninput="putDPP()" value="<?php echo $dataInvoicePenjualan['diskon'] ?>" value="0">
                                        </div>
                                    </div>
                                    <div class="form-group row float-right col-9">
                                        <label for="DPP" class="col-sm-4 col-form-label-sm">DPP:</label>
                                        <div class="col-sm-7 ">
                                            <input type="number" name="dpp" class="form-control form-control-sm" id="dpp" value="<?php echo $dataInvoicePenjualan['dpp'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row float-right col-9" id="container_ppn" style="display: none;">
                                        <label for="ppn" class="col-sm-4 col-form-label-sm">PPN:</label>
                                        <div class="col-sm-3 d-flex">
                                            <input type="number" name="ppn-persen" id="ppn-persen" class="form-control form-control-sm" value="<?php echo $dataInvoicePenjualan['ppn_persentase'] ?>" readonly>
                                            <p class="ml-1">%</p>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="number" name="ppn" class="form-control form-control-sm" id="ppn" value="<?php echo $dataInvoicePenjualan['ppn'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row float-right col-9">
                                        <label for="grandtotal" class="col-sm-4 col-form-label-sm">Grand Total:</label>
                                        <div class="col-sm-7">
                                            <input type="number" id="grandtotal" name="grandtotal" class="form-control form-control-sm" value="<?php echo $dataInvoicePenjualan['dpp'] + $dataInvoicePenjualan['ppn'] ?>" readonly>
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
    if (document.getElementById("jenis_ppn").value == "Non_PKP") {
        document.getElementById("ppn-persen").value = 0;
        document.getElementById("container_ppn").style.display = "none";
    } else {
        document.getElementById("container_ppn").style.display = "flex";
        document.getElementById("ppn-persen").value = 11;
        putPPN();
    }

    function putTotalPrices(input) {
        var row = input.parentNode.parentNode;
        var td = row.children;
        var qtyTerjual = input;
        var harga = td[6];
        var diskon = td[8];
        var subTotalSatuan = td[9];
        const subTotalKeseluruhan = document.getElementById("subtotal");
        const dpp = document.getElementById("dpp");
        const ppnPersen = document.getElementById("ppn-persen");
        const ppnHarga = document.getElementById("ppn");
        const grandtotal = document.getElementById("grandtotal");
        subTotalSatuan.innerHTML = (parseInt(qtyTerjual.value) * parseInt(harga.innerText)) - (parseInt(qtyTerjual.value) * parseInt(diskon.innerText));
        if (subTotalSatuan.innerHTML === 'NaN') {
            subTotalSatuan.innerHTML = 0;
        }
        subTotalKeseluruhan.value = getSubTotalKeseluruhan();
        putDPP();
    }

    function getSubTotalKeseluruhan() {
        const table = document.getElementById("detail-invoice-penjualan");
        var subTotalKeseluruhan = 0;
        for (i = 1; i <= table.rows.length - 1;) {
            const row = table.rows[i];
            const td = row.children;
            subTotalKeseluruhan += parseInt(td[9].innerHTML);
            i++
        }

        return subTotalKeseluruhan;
    }

    function putDPP() {
        const subtotal = document.getElementById("subtotal");
        const diskon = document.getElementById("diskon-keseluruhan");

        if (diskon.value === '') {
            document.getElementById("dpp").value = subtotal.value;
        } else {
            document.getElementById("dpp").value = parseInt(subtotal.value) - parseInt(diskon.value);
        }
        putGrandTotal();
    }

    function putGrandTotal() {
        putPPN();
        const dpp = document.getElementById("dpp");
        const ppn = document.getElementById("ppn");
        if (!ppn.value) {
            document.getElementById("grandtotal").value = parseInt(dpp.value);
        } else {
            document.getElementById("grandtotal").value = parseInt(dpp.value) + parseInt(ppn.value);
        }
    }

    function putPPN() {
        const ppnPersen = document.getElementById("ppn-persen");
        const dpp = document.getElementById("dpp");
        document.getElementById("ppn").value = parseInt(ppnPersen.value) / 100 * parseInt(dpp.value);
    }


    function filterSOBerdasarkanDepartemen() {
        const departemen = document.getElementById("departemen").selectedOptions[0].label;

        var rows = document.querySelectorAll("#example1 tbody tr");

        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            var noSO = row.querySelector("td:nth-child(1)").textContent;
            var rowDepartemen = noSO.substring(4, 8);
            console.log(rowDepartemen);
            if (rowDepartemen === departemen) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    }
</script>