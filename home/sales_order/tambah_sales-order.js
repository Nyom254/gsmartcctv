const inputTanggal = document.getElementById("tanggal");
const term = document.getElementById("term");

[tanggal, term].forEach((Element) => {
    Element.addEventListener("input", () => {

        var tanggal = new Date(inputTanggal.value)

        tanggal.setDate(tanggal.getDate() + parseInt(term.value));

        var year = tanggal.getFullYear();
        var month = String(tanggal.getMonth() + 1).padStart(2, '0');
        var day = String(tanggal.getDate()).padStart(2, '0');
        var tanggalJatuhTempo = year + "-" + month + "-" + day;

        document.getElementById("jatuh_tempo").value = tanggalJatuhTempo
    })
})

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


function getBarang(kodeBarang, hargaBarang) {
    document.getElementById("searchBarang").value = kodeBarang
    document.getElementById("harga").value = parseInt(hargaBarang)
}

function getDiskonSatuan() {
    const harga = document.getElementById("harga").value
    const diskonPersentase = document.getElementById("diskon-persen").value / 100
    const hasilDiskon = harga * diskonPersentase
    document.getElementById("diskon-satuan").value = hasilDiskon
    getTotalSatuan()
}

function getTotalSatuan() {
    const quantity = document.getElementById("quantity").value
    const harga = document.getElementById("harga").value
    const diskon = document.getElementById("diskon-satuan").value
    var hasilTotal = quantity * harga - quantity * diskon
    document.getElementById("total-satuan").value = hasilTotal

}


function setAttribute(elem) {
    for (var i = 1; i < arguments.length; i += 2) {
        elem.setAttribute(arguments[i], arguments[i + 1]);
    }
}


function addBarangRowTable() {
    var table = document.getElementById("detail-purchase-order")
    var kodeBarang = document.getElementById("searchBarang").value
    var quantity = document.getElementById("quantity").value
    var harga = document.getElementById("harga").value
    var diskonPersentase = document.getElementById("diskon-persen").value
    if (diskonPersentase == 0) {
        diskonPersentase = 0
    }
    var diskon = document.getElementById("diskon-satuan").value
    if (diskon == 0) {
        diskon = 0
    }
    var total = document.getElementById("total-satuan").value
    var noUrut = table.rows.length - 1;

    if (quantity != 0 && kodeBarang != "" && harga != "") {

        var newRow = table.insertRow()

        var cell1 = newRow.insertCell(0)
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

        var cell3 = newRow.insertCell(2)
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
        cell3.appendChild(elemQuantity)

        var cell4 = newRow.insertCell(3)
        elemHarga = document.createElement("input")
        setAttribute(elemHarga,
            "name", 'harga[]',
            'value', harga,
            'readonly', '',
            'style', 'pointer-events:none; background-color:transparent;border:none;width:100%;text-align:right;',
        )
        cell4.appendChild(elemHarga)

        var cell5 = newRow.insertCell(4)
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
        cell5.appendChild(elemDiskonPersentase)

        var cell6 = newRow.insertCell(5)
        elemDiskon = document.createElement("input")
        setAttribute(elemDiskon,
            "name", 'diskon-barang[]',
            'value', diskon,
            'readonly', '',
            'style', 'pointer-events:none; background-color:transparent;border:none;width:100%;text-align:right;'
        )
        cell6.appendChild(elemDiskon)

        var cell7 = newRow.insertCell(6)
        rowTotal = document.createElement("p")
        rowTotal.innerHTML = total
        cell7.appendChild(rowTotal)
        cell7.style.textAlign = "right"

        var cell8 = newRow.insertCell(7)

        var editButton = document.createElement("span")
        editButton.textContent = "edit"
        setAttribute(editButton,
            'class', 'material-symbols-outlined',
            'style', 'color:#26abff;cursor:pointer'
        )
        editButton.addEventListener("click", () => {
            editRow(editButton, total)
        })


        var deleteButton = document.createElement("span")
        deleteButton.textContent = "delete"
        setAttribute(deleteButton,
            'class', 'material-symbols-outlined',
            'style', 'color:#ff4122;cursor:pointer'
        )
        deleteButton.addEventListener("click", () => {
            deleteRow(deleteButton, total)
        })

        cell8.appendChild(editButton)
        cell8.appendChild(deleteButton)



        const diskonTotal = parseInt(diskon) * parseInt(quantity)
        if (document.getElementById("subtotal").value != 0) {

            document.getElementById("subtotal").value = parseInt(document.getElementById("subtotal").value) + parseInt(total)
        } else {
            document.getElementById("subtotal").value = total
        }


        document.getElementById("searchBarang").value = ""
        document.getElementById("quantity").value = ""
        document.getElementById("harga").value = ""
        document.getElementById("diskon-persen").value = ""
        document.getElementById("diskon-satuan").value = ""
        document.getElementById("total-satuan").value = ""


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
    var row = button.parentNode.parentNode
    var td = row.children
    var tdQty = td[2]
    var tdDiskonPersen = td[4]
    qty = tdQty.children[0]
    diskonPersen = tdDiskonPersen.children[0]
    if (qty.style.pointerEvents == 'none') {
        setAttribute(qty, 'style', 'pointer-events:fill;width:100%')
        setAttribute(diskonPersen, 'style', 'pointer-events:fill;width:100%')
    } else {
        setAttribute(qty, 'style', 'pointer-events:none;background-color:transparent;border:none;width:100%')
        setAttribute(diskonPersen, 'style', 'pointer-events:none;background-color:transparent;border:none;width:100%')
    }
    totalRowLama = total
}

function editDone(button) {
    var row = button.parentNode.parentNode
    var td = row.children
    var tdQty = td[2]
    var tdDiskonPersen = td[4]
    qty = tdQty.children[0]
    diskonPersen = tdDiskonPersen.children[0]
    setAttribute(qty, 'style', 'pointer-events:none;background-color:transparent;border:none;width:100%')
    setAttribute(diskonPersen, 'style', 'pointer-events:none;background-color:transparent;border:none;width:100%')
    qty.blur()
    diskonPersen.blur()

    hasilSubTotal()

}

function hasilTotalRow(e) {
    var row = e.parentNode.parentNode
    var td = row.children

    td[5].children[0].value = td[4].children[0].value / 100 * td[3].children[0].value
    td[6].children[0].innerHTML = td[3].children[0].value * td[2].children[0].value - td[5].children[0].value * td[2].children[0].value
    hasilSubTotal()
}

function deleteRow(button) {
    var row = button.parentNode.parentNode
    let rowTotal = parseInt(row.children[6].children[0].innerHTML)
    let rowDiskonTotal = parseInt(row.children[5].children[0].value) * parseInt(row.children[2].children[0].value)
    row.parentNode.removeChild(row)
    document.getElementById("subtotal").value -= rowTotal
    getDPP()
}

function hasilSubTotal() {
    const table = document.getElementById("detail-purchase-order")
    const tr = table.rows
    var subtotal = 0
    for (i = 2; i < tr.length; i++) {
        let td = tr[i].children
        let p = td[6].children[0]
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

    const grandTotal = parseInt(dpp) + parseInt(ppn)
    document.getElementById("grandtotal").value = grandTotal
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
                let lastYear = item.no_transaksi.substr(8, 2)
                let lastMonth = item.no_transaksi.substr(10, 2)
                let lastInisial = item.no_transaksi.substr(3, 4);

                if (lastYear == tahun && lastMonth == bulan && lastInisial == inisial ) {
                    var lastSequence = parseInt(item.no_transaksi.substr(13));
                    var sequence = (lastSequence + 1).toString().padStart(4, '0');
                    //console.log(`PO/${tahun}${bulan}/${sequence}`)
                    noTransaksi = `SO/${inisial}/${tahun}${bulan}/${sequence}`
                }
            }
            if (typeof (noTransaksi) === "string") {
                document.getElementById("no_transaksi").value = noTransaksi
                return
            } else {
                document.getElementById("no_transaksi").value = `SO/${inisial}/${tahun}${bulan}/0001`
            }

        }
    }
    xhr.open('GET', './sales_order/data_no-transaksi.php', true)
    xhr.send()
}

