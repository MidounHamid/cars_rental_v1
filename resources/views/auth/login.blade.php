<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: url('/images/loginImage.jpg') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.4));
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 1;
            min-height: 90vh;
        }

        .left-content {
            flex: 1;
            max-width: 500px;
            padding-right: 50px;
        }

        .welcome-text h1 {
            color: #fff;
            font-size: 48px;
            font-weight: 600;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .welcome-text p {
            color: #fff;
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.9;
        }

        .right-content {
            width: 420px;
        }

        .form-container {
            width: 100%;
            background: rgba(128, 128, 128, 0.2);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 20px;
            padding: 40px;
            min-height: 65vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-container form {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group:last-of-type {
            margin-bottom: 25px;
        }

        .form-group input {
            width: 100%;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 10px;
            padding: 0 45px;
            color: #fff;
            font-size: 15px;
        }

        .form-group input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .form-group input:-webkit-autofill,
        .form-group input:-webkit-autofill:hover,
        .form-group input:-webkit-autofill:focus {
            -webkit-text-fill-color: #fff;
            -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.1) inset;
            transition: background-color 5000s ease-in-out 0s;
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.8);
        }

        .form-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.8);
            font-size: 18px;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.8);
            font-size: 18px;
            cursor: pointer;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .password-toggle:focus {
            outline: none;
        }

        .password-toggle i {
            position: static;
            transform: none;
            width: auto;
            height: auto;
            left: auto;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }

        .remember-me span,
        .forgot-password {
            color: #fff;
            font-size: 14px;
            text-decoration: none;
        }

        .login-btn {
            width: 100%;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background 0.3s;
        }

        .login-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .register-link {
            text-align: center;
            color: #fff;
            font-size: 14px;
        }

        .register-link a {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            margin-left: 5px;
        }

        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
                text-align: center;
                padding: 40px 20px;
            }

            .left-content {
                padding-right: 0;
                margin-bottom: 40px;
            }

            .right-content {
                width: 100%;
                max-width: 420px;
            }
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 30px 20px;
            }

            .welcome-text h1 {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-content">
            <div class="welcome-text">
                <h1>Welcome Back</h1>
                <p>Please login to your account to access our car rental services and manage your bookings.</p>
            </div>
        </div>
        <div class="right-content">
            <div class="form-container">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <i class="fas fa-user"></i>
                        <input type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword(this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="remember-forgot">
                        <label class="remember-me">
                            <input type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                    </div>
                    <button type="submit" class="login-btn">Sign In</button>
                    <div class="register-link">
                        Don't have an account? <a href="{{ route('register') }}">Register Now</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(button) {
            const input = button.parentElement.querySelector('input');
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
