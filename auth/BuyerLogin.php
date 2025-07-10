<?php
session_start();
include("../Includes/db.php");

if (isset($_POST['login'])) {
    $phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = '2345678910111211';
    $encryption_key = "DE";

    $encryption = openssl_encrypt(
        $password,
        $ciphering,
        $encryption_key,
        $options,
        $encryption_iv
    );

    $query = "select * from buyerregistration where buyer_phone = '$phonenumber' and buyer_password = '$encryption'";
    $run_query = mysqli_query($con, $query);
    $count_rows = mysqli_num_rows($run_query);
    if ($count_rows == 0) {
        echo "<script>alert('Please Enter Valid Details');</script>";
        echo "<script>window.open('BuyerLogin.php','_self')</script>";
    }
    while ($row = mysqli_fetch_array($run_query)) {
        $id = $row['buyer_id'];
    }

    $_SESSION['phonenumber'] = $phonenumber;
    echo "<script>window.open('../BuyerPortal2/bhome.php','_self')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Login | DIRECT MARKET</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;600&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2e7d32;
            --primary-light: #60ad5e;
            --secondary: #ff8f00;
            --dark: #263238;
            --light: #f5f5f5;
            --golden: #daa520;
            --form-bg: #ffffff;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Raleway', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            height: 100vh;
            overflow: hidden;
        }
        
        .split-container {
            display: flex;
            height: 100vh;
        }
        
        /* Left Section - Animated Farmer Theme */
        .left-section {
            flex: 1;
            background: linear-gradient(135deg, rgba(46, 125, 50, 0.9), rgba(46, 125, 50, 0.7));
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            animation: fadeInLeft 1s ease-out;
        }
        
        .left-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.1) 0%, transparent 20%);
            z-index: 0;
        }
        
        .welcome-text {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .tagline {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            text-align: center;
            max-width: 80%;
            z-index: 1;
            line-height: 1.6;
        }
        
        .farmer-icon {
            font-size: 8rem;
            margin: 2rem 0;
            color: white;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2));
            transform: scale(1);
            transition: transform 0.5s ease;
            z-index: 1;
        }
        
        .farmer-icon:hover {
            transform: scale(1.1) rotate(10deg);
        }
        
        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 2rem;
            z-index: 1;
        }
        
        .feature-item {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            border-radius: 10px;
            padding: 1rem;
            width: 150px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            cursor: pointer;
        }
        
        .feature-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: var(--golden);
        }
        
        /* Right Section - Login Form */
        .right-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--form-bg);
            padding: 2rem;
            position: relative;
            overflow: hidden;
            animation: fadeInRight 1s ease-out;
        }
        
        .right-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 80% 20%, rgba(255, 143, 0, 0.05) 0%, transparent 20%),
                radial-gradient(circle at 20% 80%, rgba(46, 125, 50, 0.05) 0%, transparent 20%);
            z-index: 0;
        }
        
        .login-card {
            width: 100%;
            max-width: 500px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            z-index: 1;
            background-color: white;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--dark), #1a1a1a);
            color: var(--golden);
            padding: 1.8rem;
            border-bottom: 4px solid var(--golden);
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            text-align: center;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }
        
        .card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }
        
        .card-body {
            padding: 2.5rem;
            background-color: white;
        }
        
        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.95rem;
        }
        
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 14px 18px;
            font-size: 1rem;
            transition: all 0.3s;
            background-color: #f9f9f9;
            width: 100%;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.2);
            background-color: white;
        }
        
        .input-icon {
            position: absolute;
            right: 15px;
            top: 38px;
            color: #999;
            transition: all 0.3s;
        }
        
        .form-control:focus + .input-icon {
            color: var(--primary);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--dark), #1a1a1a);
            color: var(--golden);
            border: none;
            padding: 14px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.4s;
            width: 100%;
            cursor: pointer;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 1rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, #1a1a1a, var(--dark));
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .forgot-password, .create-account {
            color: var(--dark);
            transition: color 0.3s;
            display: block;
            margin-top: 1rem;
            text-align: center;
            font-size: 0.9rem;
            position: relative;
        }
        
        .forgot-password::after, .create-account::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 1px;
            background: var(--primary);
            transition: all 0.3s;
        }
        
        .forgot-password:hover, .create-account:hover {
            color: var(--primary);
            text-decoration: none;
        }
        
        .forgot-password:hover::after, .create-account:hover::after {
            width: 100%;
            left: 0;
        }
        
        /* Floating elements */
        .floating {
            position: absolute;
            opacity: 0.1;
            z-index: 0;
            animation: float 15s infinite linear;
        }
        
        .form-floating {
            position: absolute;
            font-size: 1.2rem;
            color: rgba(46, 125, 50, 0.2);
            z-index: 0;
            animation: floatForm 20s infinite linear;
        }
        
        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(50px, 50px) rotate(90deg); }
            50% { transform: translate(100px, 0) rotate(180deg); }
            75% { transform: translate(50px, -50px) rotate(270deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }
        
        @keyframes floatForm {
            0% { transform: translate(0, 0) rotate(0deg) scale(1); opacity: 0.1; }
            50% { transform: translate(50px, -30px) rotate(180deg) scale(1.2); opacity: 0.15; }
            100% { transform: translate(0, 0) rotate(360deg) scale(1); opacity: 0.1; }
        }
        
        /* Animations */
        @keyframes fadeInLeft {
            from { 
                opacity: 0;
                transform: translateX(-50px);
            }
            to { 
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInRight {
            from { 
                opacity: 0;
                transform: translateX(50px);
            }
            to { 
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Responsive design */
        @media (max-width: 992px) {
            .split-container {
                flex-direction: column;
                height: auto;
                overflow-y: auto;
            }
            
            .left-section, .right-section {
                flex: none;
                width: 100%;
                height: auto;
                min-height: 50vh;
            }
            
            .left-section {
                padding: 3rem 1rem;
            }
            
            .right-section {
                padding: 2rem 1rem;
            }
            
            .welcome-text {
                font-size: 2rem;
            }
            
            .farmer-icon {
                font-size: 5rem;
            }
            
            .feature-item {
                width: 120px;
                padding: 0.8rem;
            }
            
            .login-card {
                max-width: 100%;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="split-container">
        <!-- Left Section - Farmer Theme -->
        <div class="left-section">
            <!-- Floating elements -->
            <i class="floating fas fa-leaf" style="top:10%; left:10%; font-size: 3rem; animation-delay: 0s;"></i>
            <i class="floating fas fa-apple-alt" style="top:20%; right:15%; font-size: 2.5rem; animation-delay: 2s;"></i>
            <i class="floating fas fa-tractor" style="bottom:15%; left:15%; font-size: 3rem; animation-delay: 4s;"></i>
            <i class="floating fas fa-seedling" style="bottom:25%; right:20%; font-size: 2.5rem; animation-delay: 6s;"></i>
            
            <h1 class="welcome-text">Connect Directly With Farmers</h1>
            <p class="tagline">Get fresh produce straight from the farm to your table with our secure marketplace platform</p>
            <i class="farmer-icon fas fa-user-tie"></i>
            
            <div class="features">
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-carrot"></i></div>
                    <div>Fresh Produce</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-money-bill-wave"></i></div>
                    <div>Fair Prices</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-truck"></i></div>
                    <div>Fast Delivery</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon"><i class="fas fa-handshake"></i></div>
                    <div>Direct Trade</div>
                </div>
            </div>
        </div>
        
        <!-- Right Section - Login Form -->
        <div class="right-section">
            <!-- Form floating elements -->
            <i class="form-floating fas fa-shopping-basket" style="top:15%; left:15%; animation-delay: 1s;"></i>
            <i class="form-floating fas fa-credit-card" style="top:25%; right:20%; animation-delay: 3s;"></i>
            <i class="form-floating fas fa-truck-loading" style="bottom:20%; left:20%; animation-delay: 5s;"></i>
            
            <div class="login-card card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-sign-in-alt mr-2"></i>BUYER LOGIN</h4>
                </div>
                <div class="card-body">
                    <form name="my-form" action="BuyerLogin.php" method="post">
                        <div class="form-group">
                            <label for="phone_number"><i class="fas fa-phone-alt mr-2"></i>Phone Number</label>
                            <input type="text" id="phone_number" class="form-control" name="phonenumber" placeholder="Enter your phone number" required>
                            <i class="input-icon fas fa-mobile-alt"></i>
                        </div>
                        
                        <div class="form-group">
                            <label for="p1"><i class="fas fa-lock mr-2"></i>Password</label>
                            <input id="p1" class="form-control" type="password" name="password" placeholder="Enter your password" required>
                            <i class="input-icon fas fa-eye-slash"></i>
                        </div>
                        
                        <button type="submit" class="btn btn-login" name="login" value="Login">
                            <i class="fas fa-sign-in-alt mr-2"></i>LOGIN
                        </button>
                        
                        <a href="BuyerForgotPassword.php" class="forgot-password mt-3">
                            <i class="fas fa-key mr-1"></i>Forgot your password?
                        </a>
                        <a href="BuyerRegistration.php" class="create-account mt-2">
                            <i class="fas fa-user-plus mr-1"></i>Create New Account
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>