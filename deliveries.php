<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Receiving - Warehouse Monitoring System</title>

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
                <span><i class="fas fa-truck-loading mr-2"></i> Receiving List</span>
                <button class="btn btn-add btn-sm" data-toggle="modal" data-target="#addReceivingModal">
                    <i class="fas fa-plus"></i> Add Receiving
                </button>
            </div>

            <div class="card-body">

                <!-- Search Bar -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="searchReceiving" class="form-control" placeholder="Search receiving...">
                    </div>
                </div>

                <!-- RECEIVING TABLE -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Item Code</th>
                                <th>Item Description</th>
                                <th>Date Receive</th>
                                <th>Transaction Type</th>
                                <th>Weight Scale</th>
                                <th>Dynamics Qty</th>
                                <th>Truck Scale</th>
                                <th>Five Tonner</th>
                                <th>Num Bag</th>
                                <th>Tonner vs Truck</th>
                                <th>TORD No</th>
                                <th>ATW No</th>
                                <th>Pallet Qty</th>
                                <th>Supplier</th>
                                <th>Plate No</th>
                                <th>Weigh Slip</th>
                                <th>Remarks</th>
                                <th>Status</th>
                                <th>Trucking Service</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="receivingTable">
                            <!-- Example Data -->
                            <tr>
                                <td>1</td>
                                <td>RM2001211</td>
                                <td>YELLOW CORN VIETNAM</td>
                                <td>2025-12-08</td>
                                <td>Transfer in</td>
                                <td>1000.50</td>
                                <td>950.25</td>
                                <td>1050.75</td>
                                <td>500.00</td>
                                <td>50</td>
                                <td>520.25</td>
                                <td>TORD-95011</td>
                                <td>GENSAN202512-2239</td>
                                <td>10</td>
                                <td>ABC Supplier</td>
                                <td>XYZ-123</td>
                                <td>WS-001</td>
                                <td>First batch received</td>
                                <td>Pending</td>
                                <td>Trucking Co.</td>
                                <td>
                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <!-- ADD RECEIVING MODAL -->
    <div class="modal fade" id="addReceivingModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-plus"></i> Add Receiving</h5>
                    <button class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="addReceivingForm">
                        <div class="form-group col-md-3">
                            <label>Item Code</label>
                            <input type="text" class="form-control" required readonly>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Item Description</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Date Receive</label>
                                <input type="date" class="form-control" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Transaction Type</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Weight Scale</label>
                                <input type="number" step="0.01" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Dynamics Qty</label>
                                <input type="number" step="0.01" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Truck Scale</label>
                                <input type="number" step="0.01" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Five Tonner</label>
                                <input type="number" step="0.01" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Num Bag</label>
                                <input type="number" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Tonner vs Truck</label>
                                <input type="number" step="0.01" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>TORD No.</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>ATW No.</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Pallet Qty</label>
                                <input type="number" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Supplier</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Plate No</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Weigh Slip</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Status</label>
                                <select class="form-control">
                                    <option>Pending</option>
                                    <option>Transacted</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Trucking Service</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea class="form-control" rows="2"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Save Receiving
                        </button>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- EDIT RECEIVING MODAL -->
    <div class="modal fade" id="editReceivingModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Receiving</h5>
                    <button class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="editReceivingForm">
                        <!-- The same fields as Add modal -->
                        <!-- Fill them with existing data when editing -->
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Item Code</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Date Receive</label>
                                <input type="date" class="form-control" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Transaction Type</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Weight Scale</label>
                                <input type="number" step="0.01" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Dynamics Qty</label>
                                <input type="number" step="0.01" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Truck Scale</label>
                                <input type="number" step="0.01" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Five Tonner</label>
                                <input type="number" step="0.01" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Num Bag</label>
                                <input type="number" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Tonner vs Truck</label>
                                <input type="number" step="0.01" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>TORD No.</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>ATW No</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Pallet Qty</label>
                                <input type="number" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Supplier</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Plate No</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Weigh Slip</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Status</label>
                                <select class="form-control">
                                    <option>Pending</option>
                                    <option>Approved</option>
                                    <option>Returned</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Trucking Service</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea class="form-control" rows="2"></textarea>
                        </div>

                        <button type="submit" class="btn btn-warning btn-block">
                            Update Receiving
                        </button>

                    </form>
                </div>

            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>