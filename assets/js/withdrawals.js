let withdrawals = []; // Declare a global suppliers array to hold the data

$(document).ready(function () {
    fetchItems();
    fetchWithdrawals();

    $('#searchWithdrawal, #dateFrom, #dateTo').on('input change', function () {
        applyFilters();
    });

    $('#ds , #ns ').on('input', calculate);

});

function applyFilters() {
    const searchValue = $('#searchWithdrawal').val().toLowerCase();
    const dateFrom = $('#dateFrom').val();
    const dateTo = $('#dateTo').val();

    const filteredWithdrawals = withdrawals.filter(withdrawal => {
        // TEXT SEARCH
        const matchesText =
            withdrawal.item_name.toLowerCase().includes(searchValue) ||
            withdrawal.date_withdrawal.toLowerCase().includes(searchValue);

        // DATE FILTERING  
        let matchesDate = true;
        const rowDate = new Date(withdrawal.date_withdrawal);

        if (dateFrom && rowDate < new Date(dateFrom)) matchesDate = false;
        if (dateTo && rowDate > new Date(dateTo)) matchesDate = false;

        // MUST MATCH BOTH
        return matchesText && matchesDate;
    });

    renderSuppliers(filteredWithdrawals);
}

function clearForm() {
    $('#supplierId').val('');
    $('#addWithdrawalForm')[0].reset();
    $('#dateWithdrawal').val(new Date().toISOString().split('T')[0]); // Default to today's date
}

function calculate() {
    const value1 = parseFloat($('#ds').val()) || 0;
    const value2 = parseFloat($('#ns').val()) || 0;
    const difference = value1 + value2;
    $('#totalQty').val(difference);
}

function fetchWithdrawals() {
    $.ajax({
        url: '../api/withdrawal.php',
        method: 'GET',
        success: function (data) {

            let suppliersData = data;
            if (typeof data === 'string') {
                try {
                    suppliersData = JSON.parse(data);
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    return;
                }
            }
            withdrawals = suppliersData;  // Store the fetched suppliers in the global array
            renderSuppliers(suppliersData);

        },
        error: function (xhr, status, error) {
            console.error('Error fetching products:', error);
            console.error('XHR response:', xhr.responseText); // Log the full response text from the server
            console.error('XHR response:', xhr.status); // Log the full response text from the server
            console.error('XHR status:', status);  // Log the status code (e.g., 404, 500)
            console.error('XHR status text:', xhr.statusText);  // Log the status text (e.g., "Not Found")
        }
    });
}


function renderSuppliers(withdrawals) {
    const supplierTableBody = $('#withdrawalTable');
    supplierTableBody.empty(); // Clear the table body

    withdrawals.forEach((withdrawal) => {
        const row = `
<tr>
    <td>${withdrawal.withdrawal_id}</td>
    <td>${withdrawal.item_code}</td>
    <td>${withdrawal.date_withdrawal}</td>
    <td>${withdrawal.item_name}</td>
    <td>${withdrawal.ds}</td>
    <td>${withdrawal.ns}</td>
    <td>${withdrawal.total_qty}</td>
    <td>${withdrawal.remarks}</td>
    <td>
        <button class="btn btn-primary btn-sm" onclick="editDelivery(${withdrawal.withdrawal_id})">
            Edit
        </button>
    </td>
</tr>
         `;
        supplierTableBody.append(row);
    });
}

function fetchItems() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '../api/item.php',
            method: 'GET',
            success: function (data) {
                const suppliers = typeof data === 'string' ? JSON.parse(data) : data;
                const supplierDropdown = $('#itemDesc');
                supplierDropdown.empty();
                suppliers.forEach(supplier => {
                    supplierDropdown.append(`<option value="${supplier.item_id}">${supplier.item_description}</option>`);
                });
                resolve(); // Resolve the Promise once data is populated
            },
            error: function (xhr, status, error) {
                console.error('Error fetching suppliers:', error);
                reject(error); // Reject the Promise in case of an error
            }
        });
    });
}

function saveWithdrawal() {
    const supplierData = {
        date_withdrawal: $('#dateWithdrawal').val(),
        item_description: $('#itemDesc').val(),
        ds: $('#ds').val(),
        ns: $('#ns').val(),
        total_qty: $('#totalQty').val(),
        remarks: $('#remarks').val(),
    };

    if (!supplierData.date_withdrawal || !supplierData.item_description) {
        alert('Please fill all fields');
        return;
    }

    const id = $('#supplierId').val();
    if (id) {
        supplierData.id = id;
        updateSupplier(supplierData);
    } else {
        createSupplier(supplierData);
    }
}

function createSupplier(supplierData) {
    $.ajax({
        url: '../api/withdrawal.php',
        method: 'POST',
        data: JSON.stringify(supplierData),
        contentType: 'application/json',
        success: function (response) {
            console.log("Supplier created successfully:", response.data);
            $('#addWithdrawalModal').modal('hide');

            fetchWithdrawals();
            alert("Withrawal created successfully:");
        },
        error: function (xhr, status, error) {
            console.error('Error creating supplier:', error);
            console.error('XHR response:', xhr.responseText); // Log the full response text from the server
            console.error('XHR response:', xhr.status); // Log the full response text from the server
            console.error('XHR status:', status);  // Log the status code (e.g., 404, 500)
            console.error('XHR status text:', xhr.statusText);  // Log the status text (e.g., "Not Found")
        }
    });
}

function updateSupplier(supplierData) {
    $.ajax({
        url: '../api/withdrawal.php',
        method: 'PUT',
        data: JSON.stringify(supplierData),
        contentType: 'application/json',
        success: function () {
            $('#addWithdrawalModal').modal('hide');
            alert("Withdrawal updated successfully:");
            fetchWithdrawals();
        },
        error: function (xhr, status, error) {
            console.error('Error updating supplier:', error);
        }
    });
}

function editDelivery(id) {
    console.log(id);
    const delivery = withdrawals.find(delivery => delivery.withdrawal_id == id);
    $('#supplierId').val(delivery.withdrawal_id);
    $('#dateWithdrawal').val(delivery.date_withdrawal);
    $('#itemDesc').val(delivery.item_description);
    $('#ds').val(delivery.ds);
    $('#ns').val(delivery.ns);
    $('#totalQty').val(delivery.total_qty);
    $('#remarks').val(delivery.remarks);
    $('#addWithdrawalModal').modal('show');
}

function exportExcel() {
    // Make sure you're using xlsx.full.min.js (full build)
    // <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    // 1) Clone the table so we can remove columns safely without affecting page
    const origTable = document.querySelector("table");
    const clone = origTable.cloneNode(true);

    // Remove ID column (first column) and Action column (last column) from clone
    // Adjust indices if ID/Action are in different positions
    const removeColIndices = [0]; // remove first column (ID)
    const headerCols = clone.querySelectorAll("thead tr th");
    if (headerCols.length > 1) {
        removeColIndices.push(headerCols.length - 1); // remove last column (Action)
    }

    // Remove columns from every row in the clone (iterate descending to keep indexes valid)
    removeColIndices.sort((a,b)=>b-a).forEach(colIndex => {
        clone.querySelectorAll("tr").forEach(tr => {
            const cell = tr.children[colIndex];
            if (cell) tr.removeChild(cell);
        });
    });

    // 2) Convert cloned table to worksheet
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.table_to_sheet(clone);

    // 3) Apply header styles (first row)
    const range = XLSX.utils.decode_range(ws['!ref']);
    const headerRow = range.s.r; // usually 0

    for (let C = range.s.c; C <= range.e.c; ++C) {
        const addr = XLSX.utils.encode_cell({ r: headerRow, c: C });
        if (!ws[addr]) continue;

        // Use ARGB (prefix FF) and patternType solid
        ws[addr].s = {
            font: { name: "Calibri", sz: 11, bold: true, color: { rgb: "FFFFFFFF" } }, // white text
            fill: { patternType: "solid", fgColor: { rgb: "FF1D3557" } }, // dark blue with FF prefix
            alignment: { horizontal: "center", vertical: "center", wrapText: true },
        };
    }

    // 4) Auto-fit column widths (based on content length)
    const colWidths = [];
    for (let C = range.s.c; C <= range.e.c; ++C) {
        let maxLength = 8; // minimal width
        for (let R = range.s.r; R <= range.e.r; ++R) {
            const cellAddr = XLSX.utils.encode_cell({ r: R, c: C });
            const cell = ws[cellAddr];
            if (cell && cell.v != null) {
                const val = cell.v.toString();
                // approximate width: count of characters (you can tune multiplier)
                const len = val.length;
                if (len > maxLength) maxLength = len;
            }
        }
        colWidths.push({ wch: maxLength + 2 });
    }
    ws['!cols'] = colWidths;

    // 5) Append sheet and write workbook with cellStyles true
    XLSX.utils.book_append_sheet(wb, ws, "Withdrawals");
    // Important: pass cellStyles: true so style objects are preserved
    XLSX.writeFile(wb, "withdrawal_list.xlsx", { bookType: "xlsx", cellStyles: true });
}




async function exportPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4');

    doc.setFontSize(14);
    doc.text("Withdrawals", 14, 10);

    const rows = [];
    $("#withdrawalTable tr").each(function () {
        const row = [];
        $(this).find("td").each(function (index) {

            // keep columns 1–17 (excluding ID, trucking, remarks)
            if (index > 0 && index <= 7) {
                row.push($(this).text().trim());
            }
        });

        if (row.length > 0) rows.push(row);
    });

    const headers = [
        "Item Code", "Item Description", "D/S", "N/S",
        "Total Qty", "Remarks"
    ];

    doc.autoTable({
        head: [headers],
        body: rows,
        startY: 15,
        theme: 'grid',
        tableWidth: 'auto',
        styles: {
            fontSize: 12,
            cellPadding: 1,
            cellWidth: 'auto',
            overflow: 'linebreak'
        },
        headStyles: {
            fillColor: [29, 53, 87],
            textColor: 255,
            halign: "center"
        },
        bodyStyles: {
            textColor: [0, 0, 0] // make table data black
        }
    });

    doc.save("withdrawal.pdf");
}

