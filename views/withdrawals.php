<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Withdrawals - Warehouse Monitoring System</title>

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

        table th,
        table td {
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
                <span><i class="fas fa-file-alt mr-2"></i> Withdrawals List</span>
                <button class="btn btn-add btn-sm" data-toggle="modal" data-target="#addWithdrawalModal" onclick="clearForm()">
                    <i class="fas fa-plus"></i> Add Withdrawal
                </button>
            </div>

            <div class="card-body">

                <!-- Search Bar -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="searchWithdrawal" class="form-control" placeholder="Search withdrawal...">
                    </div>
                </div>

                <!-- WITHDRAWALS TABLE -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Item Code</th>
                                <th>Date</th>
                                <th>Item Description</th>
                                <th>D/S</th>
                                <th>N/S</th>
                                <th>Total Qty</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="withdrawalTable">
                            <!-- Withdrawal rows will be populated here via JavaScript -->
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <!-- ADD WITHDRAWAL MODAL -->
    <div class="modal fade" id="addWithdrawalModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-plus"></i> Add Withdrawal</h5>
                    <button class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="addWithdrawalForm">
                        <input type="hidden" id="supplierId">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" class="form-control" required id="dateWithdrawal">
                        </div>

                        <div class="form-group">
                            <label for="itemDesc">Item Description</label>
                            <select id="itemDesc" class="form-control">
                                <option value="">Loading...</option>
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>D/S</label>
                                <input type="number" class="form-control" required id = "ds">
                            </div>
                            <div class="form-group col-md-6">
                                <label>N/S</label>
                                <input type="number" class="form-control" required id = "ns">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Total Qty</label>
                            <input type="number" class="form-control" required readonly id = "totalQty">
                        </div>

                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea class="form-control" rows="2" id ="remarks"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" onclick="saveWithdrawal()">Save Withdrawal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../assets/js/withdrawals.js"></script>
</body>

</html>