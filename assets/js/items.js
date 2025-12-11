let suppliers = []; // Declare a global suppliers array to hold the data

$(document).ready(function () {
    fetchSuppliers();

    $('#searchItem').on('keyup', function () {
        const searchValue = $(this).val().toLowerCase();
        const filteredSuppliers = suppliers.filter(supplier =>
            supplier.item_code.toLowerCase().includes(searchValue) ||
            supplier.item_description.toLowerCase().includes(searchValue)
        );
        renderSuppliers(filteredSuppliers);
    });
});

function clearSupplierForm() {
    $('#supplierId').val('');
    $('#supplierName').val('');
    $('#supplierContact').val('');
}

function fetchSuppliers() {
    $.ajax({
        url: '../api/item.php',
        method: 'GET',
        success: function (data) {
           
            let suppliersData = data;
            if (typeof data === 'string') {
                try {
                    suppliersData = JSON.parse(data);
                } catch (e) {
                    console.error('Error parsing JSON:',e);
                    return;
                }
            }
            suppliers = suppliersData;  // Store the fetched suppliers in the global array
            renderSuppliers(suppliersData);
           
        },
        error: function (xhr, status, error) {
            console.error('Error fetching products:',error);
            console.error('XHR response:',xhr.responseText); // Log the full response text from the server
            console.error('XHR response:',xhr.status); // Log the full response text from the server
            console.error('XHR status:',status);  // Log the status code (e.g., 404, 500)
            console.error('XHR status text:', xhr.statusText);  // Log the status text (e.g., "Not Found")
        }
    });
}

function renderSuppliers(suppliers) {
    const supplierTableBody = $('#itemsTable');
    supplierTableBody.empty(); // Clear the table body

    suppliers.forEach((supplier) => {
        const row = `
             <tr>
                 <td>${supplier.item_id}</td>
                 <td>${supplier.item_code}</td>
                 <td>${supplier.item_description}</td>
                 <td>
                     <button class="btn btn-primary btn-sm" onclick="editSupplier(${supplier.item_id})">Edit</button>
                 </td>
             </tr>
         `;
        supplierTableBody.append(row);
    });
}

function saveSupplier() {
    const supplierData = {
        name: $('#itemCode').val(),
        description: $('#itemDesc').val(),

    };
        createSupplier(supplierData);
}

function createSupplier(supplierData) {
    $.ajax({
        url: '../api/item.php',
        method: 'POST',
        data: JSON.stringify(supplierData),
        contentType: 'application/json',
        success: function (response) {
            console.log("Supplier created successfully:", response.data);
            $('#supplierModal').modal('hide');

            fetchSuppliers();
            alert("Brand created successfully:");
        },
        error: function (xhr, status, error) {
            console.error('Error creating supplier:', error);
            console.error('XHR response:',xhr.responseText); // Log the full response text from the server
            console.error('XHR response:',xhr.status); // Log the full response text from the server
            console.error('XHR status:',status);  // Log the status code (e.g., 404, 500)
            console.error('XHR status text:', xhr.statusText);  // Log the status text (e.g., "Not Found")
        }
    });
}

function updateSupplier(supplierData) {
    $.ajax({
        url: '/inventory-system/api/category.php',
        method: 'PUT',
        data: JSON.stringify(supplierData),
        contentType: 'application/json',
        success: function () {
            $('#supplierModal').modal('hide');
            fetchSuppliers();
            alert("Brand updated successfully:");
        },
        error: function (xhr, status, error) {
            console.error('Error updating supplier:', error);
        }
    });
}

function editSupplier(id) {
    const supplier = suppliers.find(supplier => supplier.category_id == id);
    $('#supplierId').val(supplier.category_id);
    $('#supplierName').val(supplier.category_name);
    $('#supplierContact').val(supplier.description);
    $('#supplierModalLabel').text('Edit Supplier');
    $('#supplierModal').modal('show');
}