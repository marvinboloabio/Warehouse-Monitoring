<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Warehouse Reports</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<style>
    body {
        background: #f5f6fa;
    }

    .topbar {
        background: #fff;
        padding: 15px 25px;
        border-radius: 8px;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        font-weight: 600;
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

<body>

    <?php include 'sidebar.php'; ?> <!-- Your existing sidebar -->
    <div class="content p-4">
        <div class="topbar d-flex justify-content-between">
            <h5 class="mb-0">Reports</h5>
            <span><i class="fas fa-user"></i> Admin</span>
        </div>
        <!-- Filters -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label>Start Date</label>
                <input type="date" id="startDate" class="form-control">
            </div>
            <div class="col-md-3">
                <label>End Date</label>
                <input type="date" id="endDate" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Item</label>
                <select id="itemFilter" class="form-control">
                    <option value="">All Items</option>
                    <?php
                    // Load items for filter
                    require_once '../config/Database.php';
                    $conn = (new Database())->connect();
                    $stmt = $conn->query("SELECT item_id, item_description FROM items ORDER BY item_description ASC");
                    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($items as $i) {
                        echo "<option value='{$i['item_id']}'>{$i['item_description']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button id="exportBtn" class="btn btn-success btn-block">Export CSV</button>
            </div>
        </div>

        <!-- Reports Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="reportsTable">
                <thead class="thead-light">
                    <tr>
                        <th>Item Code</th>
                        <th>Item Description</th>
                        <th>Total Deliveries (kg)</th>
                        <th>Total Withdrawals (kg)</th>
                        <th>Stock Balance (kg)</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data loaded via AJAX -->
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {

            function loadReports() {
                const start = $('#startDate').val();
                const end = $('#endDate').val();
                const item = $('#itemFilter').val();

                $.ajax({
                    url: '../api/reports.php',
                    type: 'GET',
                    data: {
                        start_date: start,
                        end_date: end,
                        item_id: item
                    },
                    dataType: 'json',
                    success: function(data) {
                        const tbody = $('#reportsTable tbody');
                        tbody.empty();
                        data.forEach(row => {
                            tbody.append(`
                        <tr>
                            <td>${row.item_code}</td>
                            <td>${row.item_description}</td>
                            <td>${parseFloat(row.total_deliveries).toFixed(2)}</td>
                            <td>${parseFloat(row.total_withdrawals).toFixed(2)}</td>
                            <td>${parseFloat(row.stock_balance).toFixed(2)}</td>
                        </tr>
                    `);
                        });
                    },
                    error: function(xhr) {
                        console.error('Error loading reports:', xhr.responseText);
                    }
                });
            }

            $('#startDate, #endDate, #itemFilter').change(loadReports);

            $('#exportBtn').click(function() {
                const start = $('#startDate').val();
                const end = $('#endDate').val();
                const item = $('#itemFilter').val();
                window.location.href = `../../api/reports.php?export=csv&start_date=${start}&end_date=${end}&item_id=${item}`;
            });

            loadReports(); // initial load
        });
    </script>

</body>

</html>