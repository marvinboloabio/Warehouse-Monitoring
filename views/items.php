<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Items - Warehouse Monitoring System</title>

    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background: #f5f6fa;
        }
        .content {
            margin-left: 250px;
            padding: 25px;
        }
        .card-header {
            background: #1d3557;
            color: #fff;
            font-weight: 600;
        }
        .btn-add {
            background: #1d3557;
            color: #fff;
        }
        .btn-add:hover {
            background: #16324f;
        }
    </style>
</head>

<body>

<?php include 'sidebar.php'; ?> <!-- Your existing sidebar -->

<div class="content">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-box-open mr-2"></i> Item List</span>
            <button class="btn btn-add btn-sm" data-toggle="modal" data-target="#addItemModal">
                <i class="fas fa-plus"></i> Add Item
            </button>
        </div>

        <div class="card-body">

            <!-- Search Bar -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" id="searchItem" class="form-control" placeholder="Search item...">
                </div>
            </div>

            <!-- ITEMS TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th width="80">ID</th>
                            <th>Item Code</th>
                            <th>Item Description</th>
                            <th width="120">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="itemsTable">

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<!-- ADD ITEM MODAL -->
<div class="modal fade" id="addItemModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Add Item</h5>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="addItemForm">

                    <div class="form-group">
                        <label>Item Code</label>
                        <input type="text" class="form-control" required id ="itemCode">
                    </div>

                    <div class="form-group">
                        <label>Item Description</label>
                        <input type="text" class="form-control" required id ="itemDesc">
                    </div>

                    <button type="submit" onclick="saveSupplier()" class="btn btn-primary btn-block">
                        Save Item
                    </button>

                </form>
            </div>

        </div>
    </div>
</div>

<!-- EDIT ITEM MODAL -->
<div class="modal fade" id="editItemModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Item</h5>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="editItemForm">

                    <div class="form-group">
                        <label>Item Name</label>
                        <input type="text" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Unit</label>
                        <input type="text" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Current Stock</label>
                        <input type="number" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-warning btn-block">
                        Update Item
                    </button>

                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../assets/js/items.js"></script>

</body>
</html>
