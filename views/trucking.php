<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trucking - Warehouse Monitoring System</title>

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
        table th, table td {
            vertical-align: middle !important;
            text-align: center;
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?> <!-- Sidebar -->

<div class="content">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-truck mr-2"></i> Trucking List</span>
            <button class="btn btn-add btn-sm" data-toggle="modal" data-target="#addTruckingModal" onclick="clearSupplierForm()">
                <i class="fas fa-plus"></i> Add Truck
            </button>
        </div>

        <div class="card-body">

            <!-- Search Bar -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" id="searchTrucking" class="form-control" placeholder="Search truck...">
                </div>
            </div>

            <!-- TRUCKING TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Plate No.</th>
                            <th>Trucking Service</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="truckingTable">

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<!-- ADD TRUCKING MODAL -->
<div class="modal fade" id="addTruckingModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Add Truck</h5>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form id="addTruckingForm">
                    <input type="hidden" id="supplierId">
                    <div class="form-group">
                        <label>Plate No.</label>
                        <input type="text" class="form-control" required id ="plateNo">
                    </div>

                    <div class="form-group">
                        <label>Trucking Service</label>
                        <input type="text" class="form-control" required id ="truckingService">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" onclick="saveSupplier()">Save Truck</button>

                </form>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../assets/js/trucking.js"></script>

</body>
</html>
