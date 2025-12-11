let suppliers = []; // Declare a global suppliers array to hold the data

$(document).ready(function () {
    fetchSuppliers();

    $('#searchTruck').on('keyup', function () {
        const searchValue = $(this).val().toLowerCase();
        const filteredSuppliers = suppliers.filter(supplier =>
            supplier.plate_no.toLowerCase().includes(searchValue) ||
            supplier.trucking_service.toLowerCase().includes(searchValue)
        );
        renderSuppliers(filteredSuppliers);
    });
});

function clearSupplierForm() {
    $('#supplierId').val('');
    $('#plateNo').val('');
    $('#truckingService').val('');
}

function fetchSuppliers() {
    $.ajax({
        url: '../api/trucking.php',
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
            suppliers = suppliersData;  // Store the fetched suppliers in the global array
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

function renderSuppliers(suppliers) {
    const supplierTableBody = $('#truckingTable');
    supplierTableBody.empty(); // Clear the table body

    suppliers.forEach((supplier) => {
        const row = `
             <tr>
                 <td>${supplier.trucking_id}</td>
                 <td>${supplier.plate_no}</td>
                 <td>${supplier.trucking_service}</td>
                 <td>
                     <button class="btn btn-primary btn-sm" onclick="editSupplier(${supplier.trucking_id})">Edit</button>
                 </td>
             </tr>
         `;
        supplierTableBody.append(row);
    });
}

function saveSupplier() {
    const supplierData = {
        name: $('#plateNo').val(),
        description: $('#truckingService').val(),

    };
    
    if (!supplierData.name || !supplierData.description) {
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
        url: '../api/trucking.php',
        method: 'POST',
        data: JSON.stringify(supplierData),
        contentType: 'application/json',
        success: function (response) {
            console.log("Supplier created successfully:", response.data);
            $('#addTruckingModal').modal('hide');

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
        url: '../api/trucking.php',
        method: 'PUT',
        data: JSON.stringify(supplierData),
        contentType: 'application/json',
        success: function () {
            $('#addTruckingModal').modal('hide');
            fetchSuppliers();
            alert("Item updated successfully:");
        },
        error: function (xhr, status, error) {
            console.error('Error updating supplier:', error);
        }
    });
}

function editSupplier(id) {
    console.log(id);
    const supplier = suppliers.find(supplier => supplier.trucking_id == id);
    $('#supplierId').val(supplier.trucking_id);
    $('#plateNo').val(supplier.plate_no);
    $('#truckingService').val(supplier.trucking_service);
    //$('#supplierModalLabel').text('Edit Supplier');
    $('#addTruckingModal').modal('show');
}