let deliveries = []; // Declare a global suppliers array to hold the data

$(document).ready(function () {
    fetchItems();
    fetchDeliveries();
    fetchPlateNo();

    $('#searchDeliveries, #dateFrom, #dateTo').on('input change', function () {
        applyFilters();
    });


    $('#plateNo').on('change', function () {
        var plateNo = $(this).val();

        if (plateNo) {
            $.ajax({
                url: '../api/trucking.php',
                type: 'GET',
                data: { plate_no: plateNo },
                dataType: 'json',
                success: function (data) {
                    $('#truckingService').val(data.trucking_service || '');
                },
                error: function (err) {
                    console.error('Error fetching trucking service:', err);
                    $('#truckingService').val('');
                }
            });
        } else {
            $('#truckingService').val('');
        }
    });

    $('#weightScale , #fiveTonner ').on('input', calculate);

    $('#weightScale , #dynamicsQty ').on('input', calculateTruckScaleVsDynamics);
});

function applyFilters() {
    const searchValue = $('#searchDeliveries').val().toLowerCase();
    const dateFrom = $('#dateFrom').val();
    const dateTo = $('#dateTo').val();

    const filteredWithdrawals = deliveries.filter(delivery => {
        // TEXT SEARCH
        const matchesText =
            delivery.item_name.toLowerCase().includes(searchValue) ||
            delivery.date_receive.toLowerCase().includes(searchValue);

        // DATE FILTERING  
        let matchesDate = true;
        const rowDate = new Date(delivery.date_receive);

        if (dateFrom && rowDate < new Date(dateFrom)) matchesDate = false;
        if (dateTo && rowDate > new Date(dateTo)) matchesDate = false;

        // MUST MATCH BOTH
        return matchesText && matchesDate;
    });

    renderSuppliers(filteredWithdrawals);
}

function clearForm() {
    $('#supplierId').val('');
    $('#addReceivingForm')[0].reset();
    $('#dateReceive').val(new Date().toISOString().split('T')[0]); // Default to today's date
}

function calculate() {
    const value1 = parseFloat($('#weightScale').val()) || 0;
    const value2 = parseFloat($('#fiveTonner').val()) || 0;
    const difference = value1 - value2;
    $('#tonnerTruck').val(difference);
}


function calculateTruckScaleVsDynamics() {
    const value1 = parseFloat($('#weightScale').val()) || 0;
    const value2 = parseFloat($('#dynamicsQty').val()) || 0;
    const difference = value1 - value2;
    $('#truckScaleVsDynamics').val(difference);
}

function fetchDeliveries() {
    $.ajax({
        url: '../api/deliveries.php',
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
            deliveries = suppliersData;  // Store the fetched suppliers in the global array
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
    const supplierTableBody = $('#deliveriesTable');
    supplierTableBody.empty(); // Clear the table body

    deliveries.forEach((delivery) => {
        const row = `
<tr>
    <td>${delivery.delivery_id}</td>
    <td>${delivery.item_code}</td>
    <td>${delivery.item_name}</td>
    <td>${delivery.date_receive}</td>
    <td>${delivery.transaction_type}</td>
    <td>${delivery.weight_scale}</td>
    <td>${delivery.dynamics_qty}</td>
    <td>${delivery.truckscale_vs_dynamics}</td>
    <td>${delivery.five_tonner}</td>
    <td>${delivery.num_bag}</td>
    <td>${delivery.tonner_vs_truck}</td>
    <td>${delivery.tord_no}</td>
    <td>${delivery.atw_no}</td>
    <td>${delivery.pallet_qty}</td>
    <td>${delivery.supplier}</td>
    <td>${delivery.plate_no}</td>
    <td>${delivery.weigh_slip}</td>
    <td>${delivery.status}</td>
    <td>${delivery.trucking_service}</td>
    <td>${delivery.remarks}</td>

    <td>
        <button class="btn btn-primary btn-sm" onclick="editDelivery(${delivery.delivery_id})">
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

function fetchPlateNo() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '../api/trucking.php',
            method: 'GET',
            success: function (data) {
                const suppliers = typeof data === 'string' ? JSON.parse(data) : data;
                const supplierDropdown = $('#plateNo');
                supplierDropdown.empty();
                suppliers.forEach(supplier => {
                    supplierDropdown.append(`<option value="${supplier.plate_no}">${supplier.plate_no}</option>`);
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

function saveDeliveries() {
    const supplierData = {
        item_description: $('#itemDesc').val(),
        date_receive: $('#dateReceive').val(),
        transaction_type: $('#transactionType').val(),
        weight_scale: $('#weightScale').val(),
        dynamics_qty: $('#dynamicsQty').val(),
        truckscale_vs_dynamics: $('#truckScaleVsDynamics').val(),
        five_tonner: $('#fiveTonner').val(),
        num_bag: $('#numBag').val(),
        tonner_vs_truck: $('#tonnerTruck').val(),
        tord_no: $('#tordNo').val(),
        atw_no: $('#atwNo').val(),
        pallet_qty: $('#palletQty').val(),
        supplier: $('#supplier').val(),
        plate_no: $('#plateNo').val(),
        weigh_slip: $('#weighSlip').val(),
        status: $('#status').val(),
        trucking_service: $('#truckingService').val(),
        remarks: $('#remarks').val(),
    };

    if (!supplierData.item_description || !supplierData.date_receive) {
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
        url: '../api/deliveries.php',
        method: 'POST',
        data: JSON.stringify(supplierData),
        contentType: 'application/json',
        success: function (response) {
            console.log("Supplier created successfully:", response.data);
            $('#addReceivingModal').modal('hide');

            fetchSuppliers();
            alert("Brand created successfully:");
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
        url: '../api/deliveries.php',
        method: 'PUT',
        data: JSON.stringify(supplierData),
        contentType: 'application/json',
        success: function () {
            $('#addReceivingModal').modal('hide');
            fetchDeliveries();
            alert("Item updated successfully:");
        },
        error: function (xhr, status, error) {
            console.error('Error updating supplier:', error);
        }
    });
}

function editDelivery(id) {
    console.log(id);
    const delivery = deliveries.find(delivery => delivery.delivery_id == id);
    $('#supplierId').val(delivery.delivery_id);
    $('#itemDesc').val(delivery.item_description);
    $('#dateReceive').val(delivery.date_receive);
    $('#transactionType').val(delivery.transaction_type);
    $('#weightScale').val(delivery.weight_scale);
    $('#dynamicsQty').val(delivery.dynamics_qty);
    $('#truckScaleVsDynamics').val(delivery.truckscale_vs_dynamics);
    $('#fiveTonner').val(delivery.five_tonner);
    $('#numBag').val(delivery.num_bag);
    $('#tonnerTruck').val(delivery.tonner_vs_truck);
    $('#tordNo').val(delivery.tord_no);
    $('#atwNo').val(delivery.atw_no);
    $('#palletQty').val(delivery.pallet_qty);
    $('#supplier').val(delivery.supplier);
    $('#plateNo').val(delivery.plate_no);
    $('#weighSlip').val(delivery.weigh_slip);
    $('#status').val(delivery.status);
    $('#truckingService').val(delivery.trucking_service);
    $('#remarks').val(delivery.remarks);
    //$('#supplierModalLabel').text('Edit Supplier');
    $('#addReceivingModal').modal('show');
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
    doc.text("Deliveries/Transfer-in", 14, 10);

    const rows = [];
    $("#deliveriesTable tr").each(function () {
        const row = [];
        $(this).find("td").each(function (index) {

            // keep columns 1–17 (excluding ID, trucking, remarks)
            if (index > 0 && index <= 17) {
                row.push($(this).text().trim());
            }
        });

        if (row.length > 0) rows.push(row);
    });

    const headers = [
        "Item Code", "Item Desc", "Date", "Type",
        "Weight", "Dynamics", "Diff", "Tonner", "Bags",
        "Ton vs Truck", "TORD", "ATW", "Pallet",
        "Supplier", "Plate", "Slip", "Status"
    ];

    doc.autoTable({
        head: [headers],
        body: rows,
        startY: 15,
        theme: 'grid',
        tableWidth: 'auto',
        styles: {
            fontSize: 8,
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

    doc.save("receiving_list.pdf");
}


