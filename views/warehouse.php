<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Warehouse - Warehouse Monitoring System</title>

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
                <span><i class="fas fa-truck-loading mr-2"></i> Movement Summary</span>

                <div>
                    <button class="btn btn-success btn-sm mr-2" onclick="exportExcel()">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>

                    <button class="btn btn-danger btn-sm mr-2" onclick="exportPDF()">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>

                    <button class="btn btn-add btn-sm" data-toggle="modal" data-target="#addwarehouseModal" onclick="clearForm()">
                        <i class="fas fa-plus"></i> Add Receiving
                    </button>
                </div>
            </div>

            <div class="card-body">

                <!-- Search Bar -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="searchWarehouse" class="form-control" placeholder="Search...">
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
                                <th>Beggining Balance</th>
                                <th>Deliveries</th>
                                <th>Total Reciept</th>
                                <th>Withdrawal</th>
                                <th>Theoritical Balance</th>
                                <th>Actual on Floor</th>
                                <th>Diff</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="warehouseTable">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ADD RECEIVING MODAL -->
    <div class="modal fade" id="addwarehouseModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-plus"></i> Add Receiving</h5>
                    <button class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="addwarehouseForm">
                        <div class="form-row">
                            <input type="hidden" id="supplierId">
                            <div class="form-group col-md-3">
                                <label for="itemDesc">Item Description</label>
                                <select id="itemDesc" class="form-control">
                                    <option value="">Loading...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Beggining Bal.</label>
                                <input type="number" class="form-control" required id="begBal">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Deliveries</label>
                                <input type="number" class="form-control" value="0" required id="totalDeliveries" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Withdrawals</label>
                                <input type="number" step="0.01" value="0" class="form-control" id="totalWithdrawals" readonly>
                            </div>
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea class="form-control" id="remarks" rows="2"></textarea>
                            </div>

                        </div>
                        <button type="button" class="btn btn-primary btn-block" onclick="saveWarehouse()">
                            Save Record
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- XLSX / SheetJS -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    <!-- jsPDF -->
    <script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>

    <!-- jsPDF AutoTable -->
    <script src="https://cdn.jsdelivr.net/npm/jspdf-autotable@3.5.28/dist/jspdf.plugin.autotable.min.js"></script>
    <script src="../assets/js/warehouse.js"></script>
</body>

</html>