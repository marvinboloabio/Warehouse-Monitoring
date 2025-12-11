let withdrawals = []; // Declare a global suppliers array to hold the data

$(document).ready(function () {
    fetchItems();
    fetchWithdrawals();

    $('#searchWithdrawals').on('keyup', function () {
        const searchValue = $(this).val().toLowerCase();
        const filteredSuppliers = withdrawals.filter(delivery =>
            delivery.item_name.toLowerCase().includes(searchValue) ||
            delivery.date_receive.toLowerCase().includes(searchValue) ||
            delivery.transaction_type.toLowerCase().includes(searchValue)
        );
        renderSuppliers(filteredSuppliers);
    });

    $('#ds , #ns ').on('input', calculate);

});

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
            fetchWithdrawals();
            alert("Withdrawal updated successfully:");
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
