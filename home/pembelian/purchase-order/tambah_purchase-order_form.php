<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1>Transaksi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?">Home</a></li>
                    <li class="breadcrumb-item"><a href="?content=purchase-order">Purchase Order</a></li>
                    <li class="breadcrumb-item">Tambah Purchase Order</li>
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
                    <form action="./pembelian/purchase-order/tambah_purchase-order_action.php" id="form_transaksi" method="post">
                        <div class="card-body">
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
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="supplier" class="col-sm-4 col-form-label col-form-label-sm">Supplier:</label>
                                        <div class="col-sm-8">
                                            <select name="supplier" class="form-control form-control-sm select2" id="supplier">
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
                                        <label for="jatuh_tempo" class="col-sm-4 col-form-label col-form-label-sm">Jatuh Tempo:</label>
                                        <div class="col-sm-8">
                                            <input type="date" name="jatuh_tempo" id="jatuh_tempo" class="form-control form-control-sm" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pengambil" class="col-sm-4 col-form-label col-form-label-sm"> Pengambil:</label>
                                        <div class="col-sm-8">
                                            <select type="" id="pengambil" name="pengambil" class="form-control form-control-sm select2">
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
                                            <input type="text" name="no_ref" id="no_ref" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="term" class="col-sm-4 col-form-label-sm">Term:</label>
                                        <div class="col-sm-8">
                                            <input type="number" name="term" id="term" class="form-control form-control-sm" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jenis_ppn" class="col-sm-4 col-form-label-sm">Jenis PPN:</label>
                                        <div class="col-sm-8">
                                            <select name="jenis_ppn" class="form-control form-control-sm" id="jenis_ppn">
                                                <option value="PKP">PKP</option>
                                                <option value="Non_PKP">Non PKP</option>
                                                <option value="Include">Include</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <table id="detail-purchase-order" class="table table-responsive table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">No urut</th>
                                            <th scope="col">Kode Barang</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Diskon(%)</th>
                                            <th scope="col">Diskon Satuan</th>
                                            <th scope="col">Total</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-primary">
                                            <th scope="row"></th>
                                            <td class="col-3">
                                                <div class="row">
                                                    <input type="text" id="searchBarang" class="form-control form-control-sm col-md-9" readonly>
                                                    <button type="button" class="btn btn-sm btn-success col-md-3" data-toggle="modal" data-target="#tabelCariBarang"><i class="fas fa-search"></i></button>
                                                </div>
                                                <div class="modal fade" id="tabelCariBarang">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header text-dark">
                                                                <h4 class="modal-title">Cari item</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body text-dark">
                                                                <table id="example1" class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Kode Barang</th>
                                                                            <th>Nama Barang</th>
                                                                            <th>Harga</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $dataBarang = mysqli_query($conn, "select * from barang where status_aktif = 1");
                                                                        $cekBarang =  $dataBarang->num_rows;

                                                                        if ($cekBarang > 0) {
                                                                            while ($rowBarang = mysqli_fetch_assoc($dataBarang)) { ?>
                                                                                <tr>
                                                                                    <td><a class="a" data-dismiss="modal" style="cursor: pointer;" onclick="getBarang('<?php echo $rowBarang['id_barang'] ?>',' <?php echo $rowBarang['harga'] ?>'), getTotalSatuan()"><?php echo $rowBarang['id_barang'] ?></a></td>
                                                                                    <td> <?php echo $rowBarang['nama'] ?></td>
                                                                                    <td> <?php echo $rowBarang['harga'] ?></td>
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
                                            </td>
                                            <td class="col-1"><input type="number" class="form-control form-control-sm" id="quantity" oninput="getTotalSatuan()"></td>
                                            <td class="col-2"> <input type="number" class="form-control form-control-sm" id="harga" oninput="getDiskonSatuan(),getTotalSatuan()" readonly></td>
                                            <td class="col-1"><input type="number" class="form-control form-control-sm" id="diskon-persen" oninput="getDiskonSatuan()"></td>
                                            <td class="col-2"><input type="number" class="form-control form-control-sm" id="diskon-satuan" readonly></td>
                                            <td class="col-2"> <input type="number" class="form-control form-control-sm" id="total-satuan" readonly></td>
                                            <td><i class="fas fa-plus" style="cursor:pointer" onclick="addBarangRowTable()"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                            <input type="number" name="subtotal" class="form-control form-control-sm" id="subtotal" onformchange="getDPP()" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row float-right col-9">
                                        <label for="diskon" class="col-sm-4 col-form-label-sm">Diskon:</label>
                                        <div class="col-sm-7">
                                            <input type="number" name="diskon" id="diskon-keseluruhan" class="form-control form-control-sm" value="0" oninput="getDPP()">
                                        </div>
                                    </div>
                                    <div class="form-group row float-right col-9">
                                        <label for="DPP" class="col-sm-4 col-form-label-sm">DPP:</label>
                                        <div class="col-sm-7 ">
                                            <input type="number" name="dpp" class="form-control form-control-sm" id="dpp" onchange="getGrandTotal()" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row float-right col-9" id="container_ppn">
                                        <label for="ppn" class="col-sm-4 col-form-label-sm">PPN:</label>
                                        <div class="col-sm-3 d-flex">
                                            <input type="number" name="ppn-persen" id="ppn-persen" class="form-control form-control-sm" oninput="limitNumberInput(this,3), getPPN()" value="11">
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
<script src="./pembelian/purchase-order/tambah_purchase-order.js"></script>