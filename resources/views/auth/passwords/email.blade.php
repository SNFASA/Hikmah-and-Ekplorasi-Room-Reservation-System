<!DOCTYPE html>
<html lang="en">
<head>
    @include('backend.layouts.head')
    <title>PTTA Reservation || Forgot Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="modern-forgot-container">
        <div class="modern-forgot-card">
            <div class="modern-forgot-row">
                <!-- Left Side - Logo Section -->
                <div class="modern-logo-section">
                    <div class="logo-container">
                        <img src="/images/PTTA Logo Footer.png" alt="PTTA Logo" class="img-fluid">
                        <div class="brand-text">PTTA Reservation</div>
                        <div class="brand-subtitle"></div>
                    </div>
                </div>
                
                <!-- Right Side - Forgot Password Form -->
                <div class="modern-form-section">
                    <div class="form-header">
                        <h1 class="form-title">Forgot Your Password?</h1>
                        <p class="form-subtitle">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
                    </div>
                    
                    @if (session('status'))
                        <div class="modern-alert modern-alert-success">
                            <div class="alert-icon">✓</div>
                            <div class="alert-message">{{ session('status') }}</div>
                        </div>
                    @endif
                    
                    <form class="modern-form" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        
                        <!-- Email Input -->
                        <div class="modern-form-group">
                            <input type="email"
                                   class="modern-input @error('email') is-invalid @enderror"
                                   id="exampleInputEmail"
                                   name="email"
                                   value="{{ old('email') }}"
                                   aria-describedby="emailHelp"
                                   placeholder="Enter your email address..."
                                   required
                                   autocomplete="email"
                                   autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <!-- Reset Button -->
                        <button type="submit" class="modern-forgot-btn">
                            Reset Password
                        </button>
                    </form>
                    
                    <!-- Links Section -->
                    <div class="form-divider"></div>
                    <div class="form-links">
                        <a class="modern-link" href="{{ route('login') }}">
                            Already have an account? Login!
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<style>
/* Forgot Password Page */
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            overflow: hidden; /* Prevent scrolling */
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        /* Modern Container */
        .modern-forgot-container {
            width: 100%;
            max-width: 1000px;
            height: calc(100vh - 2rem);
            max-height: 700px;
            margin: 0 auto;
        }

        .modern-forgot-card {
            background: white;
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            position: relative;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .modern-forgot-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2);
        }

        .modern-forgot-row {
            display: flex;
            flex: 1;
            min-height: 0;
        }

        /* Left Side - Logo/Branding */
        .modern-logo-section {
            flex: 1;
            background: linear-gradient(135deg, #1a1660 0%, #2d2b7a 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            position: relative;
            overflow: hidden;
            min-height: 0;
        }

        .modern-logo-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(255,255,255,0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .logo-container {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 100%;
        }

        .logo-container img {
            max-width: 220px;
            width: 100%;
            height: auto;
            transition: all 0.3s ease;
        }

        .logo-container img:hover {
            transform: scale(1.05);
        }

        .brand-text {
            color: white;
            font-size: 1.3rem;
            font-weight: 700;
            margin-top: 1.5rem;
            text-align: center;
            letter-spacing: 1px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            margin-top: 0.5rem;
            font-weight: 400;
        }

        /* Right Side - Forgot Password Form */
        .modern-form-section {
            flex: 1;
            padding: 2rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(135deg, #fafbff 0%, #f8f9ff 100%);
            min-height: 0;
            overflow-y: auto;
        }

        .form-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-title {
            color: #1a1660;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
        }

        .form-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: linear-gradient(135deg, #1a1660 0%, #2d2b7a 100%);
            border-radius: 2px;
        }

        .form-subtitle {
            color: #6c757d;
            font-size: 0.95rem;
            font-weight: 500;
            margin-top: 1rem;
            line-height: 1.5;
        }

        /* Success Alert */
        .modern-alert {
            display: flex;
            align-items: center;
            padding: 1rem 1.2rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .modern-alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-icon {
            margin-right: 0.75rem;
            font-size: 1.2rem;
            font-weight: bold;
            background: #28a745;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .alert-message {
            flex: 1;
            line-height: 1.4;
        }

        /* Modern Form Styles */
        .modern-form {
            width: 100%;
        }

        .modern-form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .modern-input {
            width: 100%;
            padding: 1rem 1.2rem;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            background: white;
            font-size: 1rem;
            color: #1a1660;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(26, 22, 96, 0.05);
        }

        .modern-input:focus {
            outline: none;
            border-color: #1a1660;
            background: #fafbff;
            box-shadow: 0 4px 20px rgba(26, 22, 96, 0.15);
            transform: translateY(-1px);
        }

        .modern-input::placeholder {
            color: #adb5bd;
            font-weight: 400;
        }

        .modern-input.is-invalid {
            border-color: #dc3545;
            background: #fef7f7;
            box-shadow: 0 4px 20px rgba(220, 53, 69, 0.15);
        }

        .modern-input.is-invalid:focus {
            box-shadow: 0 4px 20px rgba(220, 53, 69, 0.25);
        }

        /* Error Messages */
        .invalid-feedback {
            display: flex;
            align-items: center;
            color: #dc3545;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 0.5rem;
            padding: 0.5rem 0.75rem;
            background: #fef7f7;
            border-radius: 8px;
            border-left: 4px solid #dc3545;
        }

        .invalid-feedback::before {
            content: "⚠";
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        /* Forgot Button */
        .modern-forgot-btn {
            width: 100%;
            background: linear-gradient(135deg, #1a1660 0%, #2d2b7a 100%);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 1rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(26, 22, 96, 0.3);
            margin-bottom: 1.5rem;
        }

        .modern-forgot-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s;
        }

        .modern-forgot-btn:hover::before {
            left: 100%;
        }

        .modern-forgot-btn:hover {
            background: linear-gradient(135deg, #141050 0%, #252269 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(26, 22, 96, 0.4);
        }

        .modern-forgot-btn:active {
            transform: translateY(-1px);
        }

        /* Form Divider */
        .form-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e9ecef, transparent);
            margin: 1rem 0;
        }

        /* Links */
        .form-links {
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .modern-link {
            color: #1a1660;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            padding: 0.4rem;
            border-radius: 8px;
        }

        .modern-link:hover {
            color: #2d2b7a;
            background: rgba(26, 22, 96, 0.05);
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .modern-logo-section {
                display: none;
            }
            
            .modern-form-section {
                flex: none;
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 0.5rem;
            }
            
            .modern-forgot-container {
                height: calc(100vh - 1rem);
                max-height: none;
            }
            
            .modern-forgot-card {
                border-radius: 20px;
            }
            
            .modern-form-section {
                padding: 1.5rem 1.2rem;
            }
            
            .form-title {
                font-size: 1.6rem;
            }
            
            .form-header {
                margin-bottom: 1.2rem;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 0.25rem;
            }

            .modern-forgot-container {
                height: calc(100vh - 0.5rem);
            }
            
            .modern-form-section {
                padding: 1.2rem 1rem;
            }
            
            .form-title {
                font-size: 1.4rem;
            }
            
            .form-subtitle {
                font-size: 0.85rem;
            }
            
            .modern-input {
                padding: 0.9rem 1rem;
                font-size: 0.95rem;
            }
            
            .modern-forgot-btn {
                padding: 0.9rem 1.2rem;
                font-size: 0.95rem;
            }

            .modern-form-group {
                margin-bottom: 1.2rem;
            }

            .modern-alert {
                padding: 0.75rem 1rem;
                font-size: 0.85rem;
            }
        }

        @media (max-height: 600px) {
            .modern-forgot-container {
                max-height: none;
                height: calc(100vh - 1rem);
            }

            .form-header {
                margin-bottom: 1rem;
            }

            .modern-form-group {
                margin-bottom: 1rem;
            }

            .modern-forgot-btn {
                margin-bottom: 1rem;
            }

            .form-title {
                font-size: 1.5rem;
            }
        }

        /* Very small height devices */
        @media (max-height: 500px) {
            .modern-form-section {
                padding: 1rem;
                overflow-y: auto;
            }

            .form-header {
                margin-bottom: 0.75rem;
            }

            .form-title {
                font-size: 1.3rem;
            }

            .form-subtitle {
                font-size: 0.8rem;
                margin-top: 0.5rem;
            }

            .modern-form-group {
                margin-bottom: 0.75rem;
            }

            .modern-forgot-btn {
                margin-bottom: 0.75rem;
                padding: 0.75rem 1rem;
            }

            .modern-alert {
                margin-bottom: 1rem;
                padding: 0.5rem 0.75rem;
            }
        }

        /* Animation for page load */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Override any existing container styles */
        .container {
            max-width: none !important;
            width: 100% !important;
            height: 100vh !important;
            margin: 0 !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .row {
            width: 100% !important;
            margin: 0 !important;
            height: 100% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .col-xl-10, .col-lg-12, .col-md-9 {
            width: 100% !important;
            max-width: none !important;
            flex: none !important;
            padding: 1rem !important;
        }

        /* Hide original card styles */
        .card {
            display: none !important;
        }
</style>
</html>