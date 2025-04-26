<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            justify-content: center;
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
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 450px;
            padding: 15px;
            margin: 1rem auto;
        }

        .form-container {
            width: 100%;
            background: rgba(128, 128, 128, 0.2);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 20px;
            padding: 25px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-title {
            color: #ffffff;
            font-size: 28px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 0;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-label {
            color: #ffffff;
            font-size: 14px;
            font-weight: 400;
            margin-left: 5px;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .form-group input {
            width: 100%;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0 48px;
            color: #ffffff;
            font-size: 14px;
        }

        .form-group input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.8);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.8);
            font-size: 20px;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.8);
            font-size: 20px;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
        }

        .bottom-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0;
            padding: 0 5px;
        }

        .login-link {
            color: #ffffff;
            text-decoration: none;
            font-size: 13px;
            opacity: 0.9;
        }

        .register-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 500;
            padding: 10px 25px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .register-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 15px;
            }

            .form-container {
                padding: 30px;
            }

            .form-title {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1 class="form-title">Create Account</h1>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">Name</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input 
                            type="text" 
                            name="name" 
                            placeholder="Enter your name"
                            required 
                        />
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input 
                            type="email" 
                            name="email" 
                            placeholder="Enter your email"
                            required 
                        />
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            required 
                        />
                        <button type="button" class="password-toggle" onclick="togglePassword(this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            type="password"
                            name="password_confirmation"
                            placeholder="Confirm your password"
                            required 
                        />
                        <button type="button" class="password-toggle" onclick="togglePassword(this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="bottom-content">
                    <a class="login-link" href="{{ route('login') }}">
                        Already have an account? Login
                    </a>
                    <button type="submit" class="register-btn">
                        Register
                    </button>
                </div>
            </form>
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