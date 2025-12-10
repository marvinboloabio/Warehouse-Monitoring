<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Warehouse Monitoring System - Login</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #1d3557, #457b9d);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .login-card {
            background: #ffffff;
            color: #333;
            width: 380px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.3);
        }

        .login-card h3 {
            font-weight: 700;
            color: #1d3557;
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

        .btn-login {
            background: #1d3557;
            color: #fff;
            font-weight: 600;
        }

        .btn-login:hover {
            background: #16324f;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <!-- LOGO PLACEHOLDER -->
        <div class="logo-placeholder">
            <img src="images/Archer_Daniels_Midland_logo.png" class="logo-img">
        </div>
        <h3 class="text-center mb-4">Warehouse Monitoring</h3>

        <form id="loginForm">
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-login btn-block mt-3">Login</button>
        </form>

        <p class="text-center mt-3 mb-0" style="font-size: 13px; color:#666;">
            © 2025 | Warehouse Monitoring System
        </p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</body>

</html>