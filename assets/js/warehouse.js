let warehouses = []; // Declare a global suppliers array to hold the data

$(document).ready(function () {
    fetchItems();
    fetchWarehouse();
    
    $(document).on('input', '.actual-on-floor', function () {

        const row = $(this).closest('tr');

        const theoretical = parseFloat(
            row.find('.theoretical-balance').data('theoretical')
        ) || 0;

        const actual = parseFloat($(this).val()) || 0;

        const diff = actual - theoretical;

        row.find('.diff').text(diff);
    });


    $('#searchWarehouse').on('keyup', function () {
        const searchValue = $(this).val().toLowerCase();
        const filteredSuppliers = warehouses.filter(delivery =>
            delivery.item_name.toLowerCase().includes(searchValue)
        );
        renderSuppliers(filteredSuppliers);
    });

});

function clearForm() {
    $('#supplierId').val('');
    $('#addwarehouseForm')[0].reset();
}


function fetchWarehouse() {
    $.ajax({
        url: '../api/warehouse.php',
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
            warehouses = suppliersData;  // Store the fetched suppliers in the global array
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


function renderSuppliers(deliveries) {
    const supplierTableBody = $('#warehouseTable');
    supplierTableBody.empty(); // Clear the table body

    deliveries.forEach((delivery) => {
        const row = `
<tr>
<td>${delivery.warehouse_id}</td>
<td>${delivery.item_code}</td>
<td>${delivery.item_name}</td>
<td>${delivery.beg_bal}</td>
<td>${delivery.total_deliveries}</td>
<td>${delivery.total_receipt}</td>
<td>${delivery.total_withdrawals}</td>

<!-- Theoretical Balance (store value in data attribute) -->
<td class="theoretical-balance" data-theoretical="${delivery.theoretical_balance}">
    ${delivery.theoretical_balance}
</td>

<!-- Actual On Floor (editable) -->
<td>
    <input 
        type="number" 
        class="form-control form-control-sm actual-on-floor" 
        value="${delivery.actual_on_floor ?? ''}"
    >
</td>

<!-- Difference -->
<td class="diff">0</td>

<td>${delivery.remarks}</td>
    <td>
        <button class="btn btn-primary btn-sm" onclick="editDelivery(${delivery.warehouse_id})">
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

function saveWarehouse() {
    const supplierData = {
        item_description: $('#itemDesc').val(),
        beg_bal: $('#begBal').val(),
        total_deliveries: $('#totalDeliveries').val(),
        total_withdrawals: $('#totalWithdrawals').val(),
        remarks: $('#remarks').val(),
    };

    if (!supplierData.item_description || !supplierData.beg_bal) {
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
        url: '../api/warehouse.php',
        method: 'POST',
        data: JSON.stringify(supplierData),
        contentType: 'application/json',
        success: function (response) {
            console.log("Supplier created successfully:", response.data);
            $('#addwarehouseModal').modal('hide');

            fetchWarehouse();
            alert("Record created successfully:");
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
        url: '../api/warehouse.php',
        method: 'PUT',
        data: JSON.stringify(supplierData),
        contentType: 'application/json',
        success: function () {
            $('#addwarehouseModal').modal('hide');
            alert("Item updated successfully:");
            fetchWarehouse();
        },
        error: function (xhr, status, error) {
             console.error('Error updating supplier:', error);
            console.error('XHR response:', xhr.responseText); // Log the full response text from the server
            console.error('XHR response:', xhr.status); // Log the full response text from the server
            console.error('XHR status:', status);  // Log the status code (e.g., 404, 500)
            console.error('XHR status text:', xhr.statusText);  // Log the status text (e.g., "Not Found")
        }
    });
}

function editDelivery(id) {
    console.log(id);
    const delivery = warehouses.find(delivery => delivery.warehouse_id == id);
    $('#supplierId').val(delivery.warehouse_id);
    $('#itemDesc').val(delivery.item_id);
    console.log(delivery.item_id);
    $('#begBal').val(delivery.beg_bal);
    $('#totalDeliveries').val(delivery.total_deliveries);
    $('#totalWithdrawals').val(delivery.total_withdrawals);
       $('#remarks').val(delivery.remarks);
    $('#addwarehouseModal').modal('show');
}

function exportExcel() {
    const table = document.querySelector("table");
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.table_to_sheet(table);

    // Get table range
    const range = XLSX.utils.decode_range(ws['!ref']);

    // Apply header styles: background color, bold, wrap text
    for (let C = range.s.c; C <= range.e.c; ++C) {
        const cell_address = XLSX.utils.encode_cell({ r: 0, c: C }); // first row = header
        if (!ws[cell_address]) continue;
        ws[cell_address].s = {
            fill: { fgColor: { rgb: "1D3557" } }, // dark blue background
            font: { color: { rgb: "FFFFFF" }, bold: true }, // white bold text
            alignment: { horizontal: "center", vertical: "center", wrapText: true } // wrap text
        };
    }

    // Auto-fit column widths based on data length
    const colWidths = [];
    for (let C = range.s.c; C <= range.e.c; ++C) {
        let maxLength = 10;
        for (let R = range.s.r; R <= range.e.r; ++R) {
            const cell_address = XLSX.utils.encode_cell({ r: R, c: C });
            const cell = ws[cell_address];
            if (cell && cell.v) {
                const cellLength = cell.v.toString().length;
                if (cellLength > maxLength) maxLength = cellLength;
            }
        }
        colWidths.push({ wch: maxLength + 2 });
    }
    ws['!cols'] = colWidths;

    XLSX.utils.book_append_sheet(wb, ws, "Receiving");
    XLSX.writeFile(wb, "receiving_list.xlsx");
}


async function exportPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4');

    doc.setFontSize(14);
    doc.text("Movement Summary", 14, 10);

    const rows = [];

    $("#warehouseTable tr").each(function () {
        const row = [];

        $(this).find("td").each(function (index) {

            /*
              COLUMN INDEX MAP (0-based)
              0  = ID (skip)
              1  = Item Code
              2  = Item Description
              3  = Beginning Balance
              4  = Deliveries
              5  = Total Receipt
              6  = Withdrawal
              7  = Theoretical Balance
              8  = Actual on Floor (INPUT)
              9  = Diff
              10 = Remarks
              11 = Actions (skip)
            */

            // KEEP columns 1–10 only
            if (index >= 1 && index <= 10) {

                const input = $(this).find("input");

                if (input.length > 0) {
                    // ✅ Read input value (Actual on Floor)
                    row.push(input.val().trim());
                } else {
                    // Normal text cell
                    row.push($(this).text().trim());
                }
            }
        });

        if (row.length > 0) {
            rows.push(row);
        }
    });

    const headers = [
        "Item Code",
        "Item Description",
        "Beginning Balance",
        "Deliveries",
        "Total Receipt",
        "Withdrawal",
        "Theoretical Balance",
        "Actual on Floor",
        "Diff",
        "Remarks"
    ];

    doc.autoTable({
        head: [headers],
        body: rows,
        startY: 15,
        theme: 'grid',
        styles: {
            fontSize: 8,
            cellPadding: 2,
            overflow: 'linebreak',
            halign: 'center'
        },
        headStyles: {
            fillColor: [29, 53, 87],
            textColor: 255,
            halign: 'center'
        },
        columnStyles: {
            1: { halign: 'left' },   // Item Description
            9: { halign: 'left' }    // Remarks
        }
    });

    doc.save("movement_summary.pdf");
}



