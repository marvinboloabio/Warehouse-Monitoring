<style>
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

    .sidebar {
        width: 250px;
        height: 100vh;
        background: #1d3557;
        color: #fff;
        position: fixed;
        padding-top: 20px;
        box-shadow: 3px 0 8px rgba(0, 0, 0, 0.1);
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
</style>
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