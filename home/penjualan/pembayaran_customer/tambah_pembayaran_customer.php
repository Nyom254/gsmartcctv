<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Pembayaran Customer</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?">Home</a></li>
                    <li class="breadcrumb-item"><a href="?content=pembayaran_customer">Pembayaran Customer</a></li>
                    <li class="breadcrumb-item active">Tambah Pembayaran Customer</li>
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
                    <form action="./penjualan/pembayaran_customer/tambah_pembayaran_customer_action.php" id="form_transaksi" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group row">
                                        <label for="no_pembayaran" class="col-sm-4 col-form-label col-form-label-sm">No. Pembayaran:</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="no_pembayaran" name="no_pembayaran" class="form-control form-control-sm" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tanggal" class="col-sm-4 col-form-label col-form-label-sm"> Tanggal:</label>
                                        <div class="col-sm-8">
                                            <input type="date" id="tanggal" name="tanggal" class="form-control form-control-sm" oninput="generateNoTransaksi()" value="<?php echo date('Y-m-d'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2"></div>
                                <div class="col-sm-5">
                                    <div class="form-group row">
                                        <label for="customer" class="col-sm-4 col-form-label col-form-label-sm">Customer:</label>
                                        <div class="col-sm-8">
                                            <select name="customer" class="form-control form-control-sm select2" id="customer">
                                                <?php
                                                $dataCustomer = mysqli_query($conn, "select id_customer, nama from customer where status_aktif = '1'");
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
                                        <label for="departemen" class="col-sm-4 col-form-label col-form-label-sm">Departemen:</label>
                                        <div class="col-sm-8">
                                            <select name="departemen" class="form-control form-control-sm" id="departemen" oninput="generateNoTransaksi()">
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
                                </div>
                            </div>
                            <div class="row">
                                <table id="detail-purchase-order" class="table table-responsive table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">No Invoice</th>
                                            <th scope="col">Tagihan</th>
                                            <th scope="col">Potongan</th>
                                            <th scope="col">Bayar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-primary">
                                            <th scope="row"></th>
                                            <td class="col-3">
                                                <div class="row">
                                                    <input type="text" id="searchInvoice" class="form-control form-control-sm col-md-9" readonly>
                                                    <button type="button" class="btn btn-sm btn-success col-md-3" data-toggle="modal" data-target="#tabelCariInvoice" onclick="filterInvoiceBerdasarkanDepartemenDanCustomer()"><i class="fas fa-search"></i></button>
                                                </div>
                                                <div class="modal fade" id="tabelCariInvoice">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header text-dark">
                                                                <h4 class="modal-title">Cari Invoice</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body text-dark ">
                                                                <div class="table-responsive">
                                                                    <table id="example1" class="table table-bordered table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No Invocie</th>
                                                                                <th>Tangal</th>
                                                                                <th>Jatuh Tempo</th>
                                                                                <th>Keterangan</th>
                                                                                <th>Total</th>
                                                                                <th>Departemen</th>
                                                                                <th>Customer</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $dataInvoice = mysqli_query($conn, "SELECT A.no_transaksi AS no_invoice, A.tanggal AS tanggal, A.jatuh_tempo AS jatuh_tempo, A.keterangan AS keterangan, (A.dpp + A.ppn) AS total, B.inisial as departemen, C.nama as customer FROM invoice_penjualan AS A LEFT JOIN departemen AS B ON A.kode_departemen = B.kode LEFT JOIN customer C ON C.id_customer = A.kode_customer where A.status = 0 and A.batal = 0");
                                                                            $cekInvoice =  $dataInvoice->num_rows;

                                                                            if ($cekInvoice > 0) {
                                                                                while ($rowInvoice = mysqli_fetch_assoc($dataInvoice)) { ?>
                                                                                    <tr>
                                                                                        <td><a class="a" data-dismiss="modal" style="cursor: pointer;" onclick="putInvoice('<?php echo $rowInvoice['no_invoice'] . '\',\'' . $rowInvoice['total'] ?>')"><?php echo $rowInvoice['no_invoice'] ?></a></td>
                                                                                        <td><?php echo $rowInvoice['tanggal'] ?></td>
                                                                                        <td><?php echo $rowInvoice['jatuh_tempo'] ?></td>
                                                                                        <td><?php echo $rowInvoice['keterangan'] ?></td>
                                                                                        <td><?php echo $rowInvoice['total'] ?></td>
                                                                                        <td><?php echo $rowInvoice['departemen'] ?></td>
                                                                                        <td><?php echo $rowInvoice['customer'] ?></td>
                                                                                    </tr>
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
                                            </td>
                                            <td><input type="number" class="form-control form-control-sm" id="tagihan" readonly></td>
                                            <td><input type="number" class="form-control form-control-sm" id="potongan" oninput="getBayar()"></td>
                                            <td><input type="number" class="form-control form-control-sm" id="bayar" readonly></td>
                                            <td><i class="fas fa-plus" style="cursor:pointer" onclick="addInvoiceRowTable()"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-7 form-group">
                                    <div class="row">
                                        <div class="col-5 custom-control custom-radio">
                                            <input type="radio" name="jenis_pembayaran" class="custom-control-input" value="tunai" id="tunai" checked="checked">
                                            <label for="tunai" class="custom-control-label">Tunai</label>
                                        </div>
                                        <div class="col-7 custom-control custom-radio">
                                            <input type="radio" name="jenis_pembayaran" class="custom-control-input" value="transfer" id="transfer">
                                            <label for="transfer" class="custom-control-label">Transfer</label>
                                        </div>
                                    </div>
                                    <div class="mt-4 d-none" id="keterangan_bank">
                                        <div class="form-group row mb-0">
                                            <label for="nama_bank" class="col-sm-4 col-form-label-sm">Nama Bank:</label>
                                            <div class="col-sm-7 ">
                                                <input type="text" name="nama_bank" class="form-control form-control-sm" id="nama_bank" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label-sm col-sm-4">Attachment:</label>
                                            <div class="input-group col-sm-7">
                                                <div class="custom-file">
                                                    <input type="file" accept="image/*" name="attachment" class="custom-file-input custom-file-input-sm" id="inputFileTambah" aria-describedby="inputGroupFileAddon01" required>
                                                    <label class="custom-file-label" for="inputFileTambah" id="labelFileTambah">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="total" class="col-sm-4 col-form-label-sm">Total:</label>
                                        <div class="col-sm-8 ">
                                            <input type="number" name="total" class="form-control form-control-sm" id="total" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="totalBayar" class="col-sm-4 col-form-label-sm">Bayar:</label>
                                        <div class="col-sm-8">
                                            <input type="number" name="totalBayar" id="totalBayar" class="form-control form-control-sm" value="0" oninput="getSelisih()">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="selisih" class="col-sm-4 col-form-label-sm">Selisih:</label>
                                        <div class="col-sm-8 ">
                                            <input type="number" name="selisih" class="form-control form-control-sm" id="selisih" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
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
<script type="text/javascript">
    document.getElementById("form_transaksi").addEventListener("keydown", (e) => {
        if (e.key === 'Enter' || e.keycode === 13) {
            e.preventDefault();
        }
    });

    function getBayar() {
        const tagihan = document.getElementById("tagihan");
        const potongan = document.getElementById("potongan");
        document.getElementById("bayar").value = tagihan.value - potongan.value;
    }

    function generateNoTransaksi() {
        const tanggal = document.getElementById("tanggal")
        const departemen = document.getElementById("departemen")
    }

    function filterInvoiceBerdasarkanDepartemenDanCustomer() {
        const departemen = String(document.getElementById("departemen").selectedOptions[0].label);
        const customer = String(document.getElementById("customer").selectedOptions[0].label);
        var rows = document.querySelectorAll("#example1 tbody tr");
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            var rowDepartemen = String(row.querySelector("td:nth-child(6)").textContent);
            var rowCustomer = String(row.querySelector("td:nth-child(7)").textContent);
            if (rowDepartemen === departemen && rowCustomer === customer) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    }

    function putInvoice(noInvoice, tagihan) {
        document.getElementById('tagihan').value = tagihan;
        document.getElementById('bayar').value = tagihan;
        document.getElementById('searchInvoice').value = noInvoice;
    }

    function setAttribute(elem) {
        for (var i = 1; i < arguments.length; i += 2) {
            elem.setAttribute(arguments[i], arguments[i + 1]);
        }
    }

    function addInvoiceRowTable() {
        var table = document.getElementById("detail-purchase-order");
        var noInvoice = document.getElementById("searchInvoice").value;
        var tagihan = document.getElementById("tagihan").value;
        var potongan = document.getElementById("potongan").value;
        var bayar = document.getElementById("bayar").value;
        var noUrut = table.rows.length - 1;

        if (!potongan) {
            potongan = 0;
        }
        var newRow = table.insertRow()

        newRow.classList.add("small");
        if (tagihan) {
            var cell1 = newRow.insertCell(0);
            var elemUrutan = document.createElement("input")
            setAttribute(elemUrutan,
                'value', noUrut,
                'style', 'pointer-events:none; background-color:transparent;border:none;width:100%;text-align:right;'
            )
            cell1.appendChild(elemUrutan)


            var cell2 = newRow.insertCell(1)
            var elemNoInvoice = document.createElement("input")
            setAttribute(elemNoInvoice,
                "name", 'no-invoice[]',
                'value', noInvoice,
                'readonly', '',
                'style', 'pointer-events:none; background-color:transparent;border:none;width:100%'
            )
            cell2.appendChild(elemNoInvoice);

            var cell3 = newRow.insertCell(2)
            var elemTagihan = document.createElement("input")
            setAttribute(elemTagihan,
                "name", 'tagihan[]',
                'value', tagihan,
                'readonly', '',
                'style', 'pointer-events:none; background-color:transparent;border:none;width:100%',
                'type', 'number',
            )
            cell3.appendChild(elemTagihan)

            var cell4 = newRow.insertCell(3)
            var elemPotongan = document.createElement("input")
            setAttribute(elemPotongan,
                "name", 'potongan[]',
                'value', potongan,
                'style', 'pointer-events:none; background-color:transparent;border:none;width:100%;text-align:left;',
                'type', 'number',
            )
            elemPotongan.addEventListener("input", () => {
                hasilRowBayar(elemPotongan);
            })
            elemPotongan.addEventListener("keydown", (e) => {
                if (e.code == 'Enter') {
                    editDone(elemPotongan)
                }
            })
            cell4.appendChild(elemPotongan)

            var cell5 = newRow.insertCell(4)
            var elemBayar = document.createElement("input")
            setAttribute(elemBayar,
                "name", 'bayar[]',
                'value', bayar,
                'style', 'pointer-events:none; background-color:transparent;border:none;width:100%;text-align:right;',
                'type', 'number'
            )
            cell5.appendChild(elemBayar)

            var cell6 = newRow.insertCell(5)
            var editButton = document.createElement("span")
            editButton.textContent = "edit"
            setAttribute(editButton,
                'class', 'material-symbols-outlined',
                'style', 'color:#26abff;cursor:pointer;font-size:18px;'
            )
            editButton.addEventListener("click", () => {
                editRow(editButton)
            })


            var deleteButton = document.createElement("span")
            deleteButton.textContent = "delete"
            setAttribute(deleteButton,
                'class', 'material-symbols-outlined',
                'style', 'color:#ff4122;cursor:pointer;font-size:18px'
            )
            deleteButton.addEventListener("click", () => {
                deleteRow(deleteButton)
            })

            cell6.appendChild(editButton);
            cell6.appendChild(deleteButton);

            document.getElementById("searchInvoice").value = '';
            document.getElementById("tagihan").value = '';
            document.getElementById("potongan").value = '';
            document.getElementById("bayar").value = '';

            getTotalTagihan();

        } else {
            $(function() {
                var Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                $(() => {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Mohon Isi info Barang dengan Lengkap'
                    })
                })
            })
        }
    }

    function editRow(button) {
        var row = button.parentNode.parentNode;
        var td = row.children;
        var tdPotongan = td[3];
        potongan = tdPotongan.children[0];
        if (potongan.style.pointerEvents == 'none') {
            setAttribute(potongan, 'style', 'pointer-events:fill;width:100%')

        } else {
            setAttribute(potongan, 'style', 'pointer-events:none;background-color:transparent;border:none;width:100%;text-align:right')
        }
    }

    function editDone(button) {
        var row = button.parentNode.parentNode;
        var td = row.children;
        var tdPotongan = td[3];
        potongan = tdPotongan.children[0];
        setAttribute(potongan, 'style', 'pointer-events:none;background-color:transparent;border:none;width:100%;text-align:right')
        potongan.blur();
    }

    function deleteRow(button) {
        var row = button.parentNode.parentNode
        row.parentNode.removeChild(row);
        getTotalTagihan();
    }

    function hasilRowBayar(e) {
        var row = e.parentNode.parentNode;
        var td = row.children;
        const bayar = td[4].children[0];
        const tagihan = td[2].children[0];
        bayar.value = tagihan.value - e.value;
        getTotalTagihan();
    }

    function getTotalTagihan() {
        const table = document.getElementById("detail-purchase-order");
        const tr = table.rows;
        var totalTagihan = 0;
        for (i = 2; i < tr.length; i++) {
            let td = tr[i].children;
            let inputTagihan = td[2].children[0];
            totalTagihan += parseInt(inputTagihan.value)
        }

        document.getElementById("total").value = totalTagihan;
        getTotalBayar();
    }

    function getTotalBayar() {
        const table = document.getElementById("detail-purchase-order");
        const tr = table.rows;
        var totalBayar = 0;
        for (i = 2; i < tr.length; i++) {
            let td = tr[i].children;
            let inputBayar = td[4].children[0];
            totalBayar += parseInt(inputBayar.value)
        }

        document.getElementById("totalBayar").value = totalBayar;
        getTotalSelisih();
    }

    function getTotalSelisih() {
        const totalTagihan = document.getElementById("total").value;
        const totalBayar = document.getElementById("totalBayar").value;
        document.getElementById("selisih").value = parseInt(totalTagihan) - parseInt(totalBayar);
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
                    let item = response[i]
                    let lastYear = item.no_pembayaran.substr(8, 2)
                    let lastMonth = item.no_pembayaran.substr(10, 2)
                    let lastInisial = item.no_pembayaran.substr(3, 4);

                    if (lastYear == tahun && lastMonth == bulan && lastInisial == inisial) {
                        var lastSequence = parseInt(item.no_pembayaran.substr(13));
                        var sequence = (lastSequence + 1).toString().padStart(4, '0');
                        //console.log(`PO/${tahun}${bulan}/${sequence}`)
                        noTransaksi = `PC/${inisial}/${tahun}${bulan}/${sequence}`
                    }
                }
                if (typeof(noTransaksi) === "string") {
                    document.getElementById("no_pembayaran").value = noTransaksi
                    return
                } else {
                    document.getElementById("no_pembayaran").value = `PC/${inisial}/${tahun}${bulan}/0001`
                }

            }
        }
        xhr.open('GET', './penjualan/pembayaran_customer/data_no-pembayaran.php', true)
        xhr.send()
    }

    generateNoTransaksi();


    const radioJenisPembayaran = document.querySelectorAll('input[name="jenis_pembayaran"]');
    radioJenisPembayaran.forEach(radio => radio.addEventListener('change', (e) => {
        if (e.target.value === 'transfer') {
            document.getElementById("keterangan_bank").classList.remove("d-none");
        } else {
            document.getElementById("keterangan_bank").classList.add("d-none");
        }
    }));
</script>