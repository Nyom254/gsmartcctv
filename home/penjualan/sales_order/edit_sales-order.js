document.getElementById("jenis_ppn").addEventListener("input", () => {
    if (document.getElementById("jenis_ppn").value == "Non_PKP") {
        document.getElementById("ppn-persen").value = 0
        document.getElementById("container_ppn").style.display = "none"
        console.log("tanpa pajak")
    } else {
        document.getElementById("container_ppn").style.display = "flex"
        document.getElementById("ppn-persen").value = 11
        console.log("pajak")
    }

    getPPN();
})


document.getElementById("form_transaksi").addEventListener("keydown", (event) => {
    if (event.key === 'Enter' || event.keycode === 13) {
        event.preventDefault();
    }
})

function limitNumberInput(inputElement, maxLength) {
    if (inputElement.value.length > maxLength) {
        inputElement.value = inputElement.value.slice(0, maxLength);
    }
}


function getBarang(kodeBarang, hargaBarang, namaBarang) {
    document.getElementById("nama-barang").innerHTML = namaBarang;
    document.getElementById("searchBarang").value = kodeBarang;
    document.getElementById("harga").value = parseInt(hargaBarang);
}


function getDiskonSatuan() {
    const harga = document.getElementById("harga").value;
    const diskonPersentase = document.getElementById("diskon-persen").value / 100;
    const hasilDiskon = harga * diskonPersentase;
    document.getElementById("diskon-satuan").value = hasilDiskon;
    getSubTotal()
}

function getSubTotal() {
    const quantity = document.getElementById("quantity").value;
    const harga = document.getElementById("harga").value;
    const diskon = document.getElementById("diskon-satuan").value;
    const hasilSubTotal = quantity * harga - quantity * diskon;
    document.getElementById("subtotal-satuan").value = hasilSubTotal;
}


function setAttribute(elem) {
    for (var i = 1; i < arguments.length; i += 2) {
        elem.setAttribute(arguments[i], arguments[i + 1]);
    }
}


function addBarangRowTable() {
    var table = document.getElementById("detail-sales-order");
    var kodeBarang = document.getElementById("searchBarang").value;
    var namaBarang = document.getElementById("nama-barang").innerHTML;
    var keteranganDetail = document.getElementById("keterangan-detail").value;
    var quantity = document.getElementById("quantity").value;
    var harga = document.getElementById("harga").value;
    var diskonPersentase = document.getElementById("diskon-persen").value;
    if (diskonPersentase == 0) {
        diskonPersentase = 0
    }
    var diskon = document.getElementById("diskon-satuan").value
    if (diskon == 0) {
        diskon = 0
    }
    var total = document.getElementById("subtotal-satuan").value;
    var noUrut = table.rows.length - 1;

    if (quantity != 0 && kodeBarang != "" && harga != "") {

        var newRow = table.insertRow()

        newRow.classList.add("small");

        var cell1 = newRow.insertCell(0);
        var elemUrutan = document.createElement("input")
        setAttribute(elemUrutan,
            "name", 'no-urut[]',
            'value', noUrut,
            'readonly', '',
            'style', 'pointer-events:none; background-color:transparent;border:none;width:100%;text-align:right;'
        )
        cell1.appendChild(elemUrutan)


        var cell2 = newRow.insertCell(1)
        var elemKodeBarang = document.createElement("input")
        setAttribute(elemKodeBarang,
            "name", 'kode-barang[]',
            'value', kodeBarang,
            'readonly', '',
            'style', 'pointer-events:none; background-color:transparent;border:none;width:100%'
        )
        cell2.appendChild(elemKodeBarang)
        //cell2.innerHTML = kodeBarang

        var cell3 = newRow.insertCell(2);
        elemNamaBarang = document.createElement("p");
        elemNamaBarang.innerHTML = namaBarang;
        cell3.appendChild(elemNamaBarang);

        var cell4 = newRow.insertCell(3)
        var elemKeterangan = document.createElement("input")
        setAttribute(elemKeterangan,
            "name", 'keterangan-detail[]',
            'value', keteranganDetail,
            'style', 'pointer-events:none; background-color:transparent;border:none;width:100%;text-align:left;'
        )
        elemKeterangan.addEventListener("keydown", (e) => {
            if (e.code == 'Enter') {
                editDone(elemKeterangan)
            }
        })
        cell4.appendChild(elemKeterangan)

        var cell5 = newRow.insertCell(4)
        var elemQuantity = document.createElement("input")
        setAttribute(elemQuantity,
            "name", 'quantity[]',
            'value', quantity,
            'style', 'pointer-events:none; background-color:transparent;border:none;width:100%;text-align:right;',
            'type', 'number'
        )
        elemQuantity.addEventListener("input", () => {
            hasilTotalRow(elemQuantity)
        })
        elemQuantity.addEventListener("keydown", (e) => {
            if (e.code == 'Enter') {
                editDone(elemQuantity)
            }
        })
        cell5.appendChild(elemQuantity)

        var cell6 = newRow.insertCell(5)
        elemHarga = document.createElement("input")
        setAttribute(elemHarga,
            "name", 'harga[]',
            'value', harga,
            'style', 'pointer-events:none; background-color:transparent;border:none;width:100%;text-align:right;',
        )
        cell6.appendChild(elemHarga)


        var cell7 = newRow.insertCell(6)
        var elemDiskonPersentase = document.createElement("input")
        setAttribute(elemDiskonPersentase,
            "name", 'diskon-persentase[]',
            'value', diskonPersentase,
            'style', 'pointer-events:none; background-color:transparent;border:none;width:100%;text-align:right;',
            'type', 'number'
        )
        elemDiskonPersentase.addEventListener("input", () => {
            hasilTotalRow(elemDiskonPersentase)
        })
        elemDiskonPersentase.addEventListener("keydown", (e) => {
            if (e.code == 'Enter') {
                editDone(elemDiskonPersentase)
            }
        })
        cell7.appendChild(elemDiskonPersentase)

        var cell8 = newRow.insertCell(7)
        elemDiskon = document.createElement("input")
        setAttribute(elemDiskon,
            "name", 'diskon-barang[]',
            'value', diskon,
            'readonly', '',
            'style', 'pointer-events:none; background-color:transparent;border:none;width:100%;text-align:right;'
        )
        cell8.appendChild(elemDiskon)

        var cell9 = newRow.insertCell(8);
        rowTotal = document.createElement("p");
        rowTotal.innerHTML = total;
        cell9.appendChild(rowTotal);
        cell9.style.textAlign = "right";


        var cell10 = newRow.insertCell(9)
        var editButton = document.createElement("span")
        editButton.textContent = "edit"
        setAttribute(editButton,
            'class', 'material-symbols-outlined',
            'style', 'color:#26abff;cursor:pointer;font-size:18px;'
        )
        editButton.addEventListener("click", () => {
            editRow(editButton, total)
        })


        var deleteButton = document.createElement("span")
        deleteButton.textContent = "delete"
        setAttribute(deleteButton,
            'class', 'material-symbols-outlined',
            'style', 'color:#ff4122;cursor:pointer;font-size:18px'
        )
        deleteButton.addEventListener("click", () => {
            deleteRow(deleteButton, total)
        })

        cell10.appendChild(editButton);
        cell10.appendChild(deleteButton);


        if (document.getElementById("subtotal").value != 0) {
            document.getElementById("subtotal").value = parseInt(document.getElementById("subtotal").value) + parseInt(total)
        } else {
            document.getElementById("subtotal").value = total
        }

        document.getElementById("searchBarang").value = "";
        document.getElementById("nama-barang").innerHTML = "";
        document.getElementById("keterangan-detail").value = "";
        document.getElementById("quantity").value = "";
        document.getElementById("harga").value = "";
        document.getElementById("diskon-persen").value = "";
        document.getElementById("diskon-satuan").value = "";
        document.getElementById("subtotal-satuan").value = "";

    } else {
        $(function () {
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
    getDPP()

}
var totalRowLama

function editRow(button, total) {
    var row = button.parentNode.parentNode;
    var td = row.children;
    var tdKeterangan = td[3];
    var tdQty = td[4];
    var tdDiskonPersen = td[6];
    keterangan = tdKeterangan.children[0];
    qty = tdQty.children[0];
    diskonPersen = tdDiskonPersen.children[0];
    if (qty.style.pointerEvents == 'none') {
        setAttribute(qty, 'style', 'pointer-events:fill;width:100%')
        setAttribute(keterangan, 'style', 'pointer-events:fill;width:100%')
        setAttribute(diskonPersen, 'style', 'pointer-events:fill;width:100%')

    } else {
        setAttribute(qty, 'style', 'pointer-events:none;background-color:transparent;border:none;width:100%;text-align:right')
        setAttribute(keterangan, 'style', 'pointer-events:none;background-color:transparent;border:none;width:100%;text-align:left')
        setAttribute(diskonPersen, 'style', 'pointer-events:none;background-color:transparent;border:none;width:100%;text-align:right')
    }
    totalRowLama = total;
}

function editDone(button) {
    var row = button.parentNode.parentNode;
    var td = row.children;
    var tdQty = td[4];
    var tdKeterangan = td[3];
    var tdDiskonPersen = td[6];
    keterangan = tdKeterangan.children[0];
    qty = tdQty.children[0];
    diskonPersen = tdDiskonPersen.children[0];
    setAttribute(qty, 'style', 'pointer-events:none;background-color:transparent;border:none;width:100%;text-align:right');
    setAttribute(keterangan, 'style', 'pointer-events:none;background-color:transparent;border:none;width:100%;text-align:left')
    setAttribute(diskonPersen, 'style', 'pointer-events:none;background-color:transparent;border:none;width:100%;text-align:right');
    qty.blur();
    diskonPersen.blur();
    keterangan.blur();

    hasilSubTotal();
}

function hasilTotalRow(e) {
    var row = e.parentNode.parentNode
    var td = row.children
    td[7].children[0].value = td[6].children[0].value / 100 * td[5].children[0].value; // diskon satuan
    td[8].children[0].innerHTML = td[4].children[0].value * td[5].children[0].value - td[7].children[0].value * td[4].children[0].value // subtotal
    hasilSubTotal()
}

function deleteRow(button) {
    var row = button.parentNode.parentNode
    row.parentNode.removeChild(row)
    hasilSubTotal();
    getDPP()
}

function hasilSubTotal() {
    const table = document.getElementById("detail-sales-order")
    const tr = table.rows
    var subtotal = 0
    for (i = 2; i < tr.length; i++) {
        let td = tr[i].children;
        let p = td[8].children[0];
        subtotal += parseInt(p.innerHTML)
    }

    document.getElementById("subtotal").value = subtotal
    getDPP()
}

function getDPP() {
    const subtotal = parseInt(document.getElementById("subtotal").value)
    const diskon = parseInt(document.getElementById("diskon-keseluruhan").value)
    const dpp = document.getElementById("dpp")
    if (isNaN(diskon)) {
        diskon = 0
    }
    dpp.value = subtotal - diskon

    getPPN()
}

function getPPN() {
    const ppnPersen = document.getElementById("ppn-persen").value / 100
    const dpp = document.getElementById("dpp").value
    const ppn = dpp * ppnPersen
    document.getElementById("ppn").value = ppn
    getGrandTotal()
}

function getGrandTotal() {
    const dpp = document.getElementById("dpp").value;
    const ppn = document.getElementById("ppn").value;

    const grandTotal = parseInt(dpp) + parseInt(ppn);
    document.getElementById("grandtotal").value = grandTotal;

}


setTimeout(() => {
    hasilSubTotal()
}, 100);
