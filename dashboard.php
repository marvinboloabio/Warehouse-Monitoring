<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Warehouse Dashboard</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo-placeholder">
            <img src="images/Archer_Daniels_Midland_logo.png" class="logo-img">
        </div>

        <a href="dashboard.php"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a>

    <a href="beginning.php"><i class="fas fa-boxes mr-2"></i> Beginning Inventory</a>

    <a href="trucking.php"><i class="fas fa-truck-moving mr-2"></i> Trucking Services</a>

    <a href="items.php"><i class="fas fa-box-open mr-2"></i> Items</a>

    <a href="deliveries.php"><i class="fas fa-arrow-circle-down mr-2"></i> Deliveries</a>

    <a href="withdrawals.php"><i class="fas fa-arrow-circle-up mr-2"></i> Withdrawals</a>

    <a href="doh.php"><i class="fas fa-calendar-alt mr-2"></i> Days On Hand</a>

    <a href="reports"><i class="fas fa-chart-bar mr-2"></i>Reports</a>

    <a href="stockCard.php"><i class="fas fa-clipboard-list mr-2"></i> Stock Card</a>

    <a href="login.php" class="text-danger"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="topbar d-flex justify-content-between">
            <h5 class="mb-0">Dashboard Overview</h5>
            <span><i class="fas fa-user"></i> Admin</span>
        </div>

        <!-- CARDS -->
        <div class="row">

            <div class="col-md-3 mb-4">
                <div class="card-custom bg-primary shadow">
                    <i class="fas fa-box float-right"></i>
                    <h4>1,245</h4>
                    <p>Total Items</p>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card-custom bg-danger shadow">
                    <i class="fas fa-exclamation-triangle float-right"></i>
                    <h4>12</h4>
                    <p>Low Stock Items</p>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card-custom bg-success shadow">
                    <i class="fas fa-arrow-down float-right"></i>
                    <h4>89</h4>
                    <p>Recieved Today</p>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card-custom bg-warning shadow text-dark">
                    <i class="fas fa-arrow-up float-right"></i>
                    <h4>54</h4>
                    <p>Withdrawals Today</p>
                </div>
            </div>
        </div>

        <!-- SPACE FOR CHARTS OR TABLES -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-white font-weight-bold">
                Recent Transactions
            </div>
            <div class="card-body">
                <p class="text-muted">You can place your stock-in/out table, logs, or charts here.</p>
            </div>
        </div>

    </div>

</body>

</html>