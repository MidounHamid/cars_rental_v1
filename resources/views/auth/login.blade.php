<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-uoyEPZTxG+..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Roboto", sans-serif;
        }
        
        body, html {
            height: 100%;
        }

        .background-overlay {
            background: url('/images/loginImage.jpg') no-repeat center center/cover;
            height: 100vh;
            width: 100%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .background-overlay::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: linear-gradient(to right, rgba(255, 140, 0, 0.5), rgba(255, 153, 51, 0.2));
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            display: flex;
            max-width: 1200px;
            width: 100%;
            padding: 40px;
            justify-content: space-between;
            align-items: center;
        }

        .left-section {
            color: white;
            flex: 1;
            padding: 40px;
            align-self: flex-start;
            margin-top: 20px;
        }

        .left-section h2 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .left-section h3 {
            font-size: 24px;
            font-weight: 300;
        }

        /* Nouveau style pour la section droite, inspiré de l'image */
        .right-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(248, 245, 243, 0.4);
            padding: 40px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);

        }

        .formcontent {
            width: 100%;
            height: 70vh;
            max-width: 350px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Titre Login */
        .form-title {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 25px;
            text-align: center;
            color: white;
        }

        /* Style amélioré des champs */
        .input-group {
            position: relative;
            margin-bottom: 20px;
            width: 100%;
        }

        /* Icon style */
        .input-group i {
            position: absolute;
            right: 12px; /* Déplacé à droite comme dans l'image */
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.8);
            z-index: 2;
        }

        /* Label style */
        .block {
            display: block;
            margin-bottom: 7px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
        }

        /* Input style */
        .input-with-icon {
            padding: 12px 40px 12px 15px;
            background-color: rgba(182, 80, 12, 0.89) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            border-radius: 25px !important;
            color: white !important;
            width: 100% !important;
            height: 45px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .input-with-icon:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.6) !important;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.2);
        }

        /* Remember me style */
        .remember-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin: 15px 0;
        }

        .inline-flex {
            display: flex;
            align-items: center;
        }

        input[type="checkbox"] {
            margin-right: 8px;
            accent-color: #f4eff5;
        }

        /* Forgot password link */
        .forgot-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 0.85rem;
        }
        
        .forgot-link:hover {
            text-decoration: underline;
            color: white;
        }

        /* Button style */
        .login-button {
            background-color: white;
            color: #eb8219d7;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .login-button:hover {
            background-color: #f5f5f5;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        /* Register link */
        .register-link {
            margin-top: 15px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
        }

        .register-link a {
            color: white;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="background-overlay">
        <div class="container">
            <div class="left-section">
                <h2>Welcome</h2>
                <h3>Discover Our Team's Story</h3>
            </div>

            <div class="right-section">
                <div class="formcontent">
                    <h2 class="form-title">Login</h2>
                    <form method="POST" action="{{ route('login') }}" style="width: 100%;">
                        @csrf

                        <!-- Email/Username Address -->
                        <div class="input-group">
                            <label class="block" for="email">Username</label>
                            <input 
                                id="email" 
                                class="input-with-icon" 
                                type="email" 
                                name="email" 
                                required 
                                autofocus 
                                autocomplete="username" 
                            />
                            <i class="fas fa-user"></i>
                        </div>

                        <!-- Password -->
                        <div class="input-group">
                            <label class="block" for="password">Password</label>
                            <input 
                                id="password" 
                                class="input-with-icon" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="current-password" 
                            />
                            <i class="fas fa-lock"></i>
                        </div>

                        <!-- Remember Me and Forgot Password -->
                        <div class="remember-section">
                            <label class="inline-flex" for="remember_me">
                                <input id="remember_me" type="checkbox" name="remember">
                                <span>Remember me</span>
                            </label>
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                        </div>

                        <button type="submit" class="login-button">
                            Login
                        </button>
                        
                        <div class="register-link">
                            Don't have an account? <a href="{{ route('register') }}">Register</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>