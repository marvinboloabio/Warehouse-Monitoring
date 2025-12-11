let deliveries = []; // Declare a global suppliers array to hold the data

$(document).ready(function () {
    fetchItems();
    fetchDeliveries();

    $('#searchDeliveries').on('keyup', function () {
        const searchValue = $(this).val().toLowerCase();
        const filteredSuppliers = deliveries.filter(delivery =>
            delivery.item_description.toLowerCase().includes(searchValue) ||
            delivery.date_receive.toLowerCase().includes(searchValue) ||
            delivery.transaction_type.toLowerCase().includes(searchValue)
        );
        renderSuppliers(filteredSuppliers);
    });

    $('#weightScale , #fiveTonner ').on('input', calculate);

    $('#weightScale , #dynamicsQty ').on('input', calculateTruckScaleVsDynamics);
});

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
    $('#truckingService').val(delivery.truckingService);
    $('#remarks').val(delivery.remarks);
    //$('#supplierModalLabel').text('Edit Supplier');
    $('#addReceivingModal').modal('show');
}
