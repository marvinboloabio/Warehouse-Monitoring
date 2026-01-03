<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Warehouse Dashboard</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    

    <style>
        body {
            background: #f5f6fa;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #1d3557;
            color: #fff;
            position: fixed;
            padding-top: 20px;
            box-shadow: 3px 0 8px rgba(0, 0, 0, 0.1);
        }

        .logo-placeholder {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 15px auto;
            border: 2px solid #ccc;
            overflow: hidden;
            /* prevents overflow */
        }

        .logo-placeholder .logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            /* keeps proportions */
            padding: 5px;
            /* space around logo */
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .sidebar a {
            padding: 14px 25px;
            display: block;
            color: #cbd5e1;
            font-size: 15px;
            font-weight: 500;
        }

        .sidebar a:hover {
            background: #16324f;
            text-decoration: none;
            color: #fff;
        }

        /* Content */
        .content {
            margin-left: 250px;
            padding: 25px;
        }

        .topbar {
            background: #fff;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            font-weight: 600;
        }

        .card-custom {
            border-radius: 10px;
            color: white;
            padding: 20px;
            font-weight: 700;
        }

        .bg-primary {
            background: #1d3557 !important;
        }

        .bg-warning {
            background: #e9c46a !important;
        }

        .bg-success {
            background: #2a9d8f !important;
        }

        .bg-danger {
            background: #e76f51 !important;
        }

        .card-custom i {
            font-size: 35px;
            opacity: 0.6;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo-placeholder">
            <img src="../images/Archer_Daniels_Midland_logo.png" class="logo-img">
        </div>

        <a href="dashboard.php"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a>
        <a href="trucking.php"><i class="fas fa-truck-moving mr-2"></i> Trucking Services</a>
        <a href="items.php"><i class="fas fa-box-open mr-2"></i> Items</a>
        <a href="deliveries.php"><i class="fas fa-arrow-circle-down mr-2"></i> Deliveries</a>
        <a href="withdrawals.php"><i class="fas fa-arrow-circle-up mr-2"></i> Withdrawals</a>
        <a href="warehouse.php"><i class="fas fa-clipboard-list mr-2"></i>Warehouse Monitoring</a>
        <a href="reports.php"><i class="fas fa-chart-bar mr-2"></i> Reports</a>
        <a href="login.php" class="text-danger"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="topbar d-flex justify-content-between">
            <h5 class="mb-0">Dashboard Overview</h5>
            <span><i class="fas fa-user"></i> Admin</span>
        </div>

        <!-- DASHBOARD CARDS -->
        <div class="row">

            <div class="col-md-3 mb-4">
                <div class="card-custom bg-primary shadow" data-card="total_items">
                    <i class="fas fa-box float-right"></i>
                    <h4>0</h4>
                    <p>Total Items</p>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card-custom bg-danger shadow" data-card="total_deliveries">
                    <i class="fas fa-truck float-right"></i>
                    <h4>0</h4>
                    <p>Total Deliveries</p>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card-custom bg-success shadow" data-card="total_withdrawals">
                    <i class="fas fa-arrow-down float-right"></i>
                    <h4>0</h4>
                    <p>Total Withdrawals</p>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card-custom bg-warning shadow text-dark" data-card="current_stock">
                    <i class="fas fa-warehouse float-right"></i>
                    <h4>0</h4>
                    <p>Current Stock</p>
                </div>
            </div>

        </div>

        <!-- CHARTS -->
        <div class="row">

            <!-- Bar Chart -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white font-weight-bold">Monthly Deliveries</div>
                    <div class="card-body">
                        <canvas id="deliveriesChart" height="150"></canvas>
                    </div>
                </div>
            </div>

            <!-- Line Chart -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white font-weight-bold">Monthly Withdrawals</div>
                    <div class="card-body">
                        <canvas id="withdrawalsChart" height="150"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <!-- RECENT TRANSACTIONS -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-white font-weight-bold">
                Recent Transactions
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="recentTransactionsTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Date</th>
                                <th>Item</th>
                                <th>Type</th>
                                <th>Quantity (kg)</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- AJAX-loaded transactions will appear here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- CHART JS -->
    <script>
        const recentTransactionsTable = document.querySelector('#recentTransactionsTable tbody');
        fetch('../api/recent_transactions.php')
            .then(res => res.json())
            .then(data => {
                recentTransactionsTable.innerHTML = '';
                data.forEach(tx => {
                    const row = `
                <tr>
                    <td>${tx.date}</td>
                    <td>${tx.item_name}</td>
                    <td>${tx.type}</td>
                    <td>${tx.quantity}</td>
                    <td>${tx.remarks || ''}</td>
                </tr>
            `;
                    recentTransactionsTable.innerHTML += row;
                });
            })
            .catch(err => console.error('Recent Transactions API error:', err));
        fetch('../api/warehouse_charts.php')
            .then(res => res.json())
            .then(data => {

                /* DELIVERIES - BAR CHART */
                new Chart(document.getElementById('deliveriesChart'), {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Deliveries (kg)',
                            data: data.deliveries,
                            backgroundColor: '#1d3557'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                /* WITHDRAWALS - LINE CHART */
                new Chart(document.getElementById('withdrawalsChart'), {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Withdrawals (kg)',
                            data: data.withdrawals,
                            borderColor: '#e76f51',
                            backgroundColor: 'rgba(231, 111, 81, 0.2)',
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: {
                        responsive: true
                    }
                });

            })
            .catch(err => console.error('Chart API error:', err));

        fetch('../api/dashboard_summary.php')
            .then(res => res.json())
            .then(data => {
                document.querySelectorAll('.card-custom').forEach(card => {
                    const key = card.dataset.card;
                    if (data[key] !== undefined) {
                        card.querySelector('h4').textContent = data[key];
                    }
                });
            })
            .catch(err => console.error('Dashboard summary API error:', err));
    </script>

</body>

</html>