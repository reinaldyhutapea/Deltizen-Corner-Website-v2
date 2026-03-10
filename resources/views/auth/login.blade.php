<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Login - Deltizen Corner</title>
    <meta name="description" content="Login ke akun Deltizen Corner Anda">
    
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Bootstrap & Icons --}}
    <link href="{{ asset('template_front/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template_front/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('template_front/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    
    <style>
        :root {
            /* Primary Colors (Pristine Light) */
            --dc-primary: #ffffff;
            --dc-primary-light: #f8fafc;
            --dc-primary-dark: #0f172a;
            
            /* Accent Colors (Premium Champagne Gold) */
            --dc-accent: #c29b62;        /* Champagne Gold */
            --dc-accent-dark: #9c7b4b;   /* Deep Gold */
            
            /* Text Colors */
            --dc-text: #1e293b;
            --dc-text-light: #64748b;
            --dc-white: #ffffff;
            
            /* Neutral Colors / Backgrounds */
            --dc-surface: #ffffff;
            --dc-border: rgba(0, 0, 0, 0.08);
            
            --dc-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08); /* Soft dark shadow on light */
            --dc-shadow-glow: 0 0 15px rgba(194, 155, 98, 0.2);
            --dc-radius: 16px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at center, var(--dc-primary-light) 0%, rgba(226, 232, 240, 0.5) 100%);
            color: var(--dc-text);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .login-wrapper {
            width: 100%;
            max-width: 440px;
        }
        
        .login-card {
            background: var(--dc-surface);
            border: 1px solid var(--dc-border);
            border-radius: var(--dc-radius);
            box-shadow: var(--dc-shadow);
            overflow: hidden;
        }
        
        .login-header {
            background: transparent;
            border-bottom: 1px solid var(--dc-border);
            padding: 40px 30px;
            text-align: center;
            color: var(--dc-primary-dark);
        }
        
        .login-header .logo {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        
        .login-header .logo span {
            background: linear-gradient(135deg, var(--dc-accent) 0%, var(--dc-accent-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }
        
        .login-header p {
            color: var(--dc-text-light);
            font-size: 14px;
            margin-bottom: 0;
        }
        
        .login-body {
            padding: 40px 30px;
        }
        
        .form-floating {
            margin-bottom: 25px;
        }
        
        .form-floating > .form-control {
            background-color: var(--dc-primary-light);
            color: var(--dc-text);
            border: 1px solid var(--dc-border);
            border-radius: 8px;
            height: 56px;
            font-size: 15px;
            transition: all 0.3s;
        }
        
        .form-floating > .form-control:focus {
            background-color: var(--dc-white);
            color: var(--dc-text);
            border-color: var(--dc-accent);
            box-shadow: var(--dc-shadow-glow);
        }
        
        .form-floating > .form-control::placeholder {
            color: transparent;
        }
        
        .form-floating > label {
            color: var(--dc-text-light);
            padding: 16px 20px;
        }
        
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            color: var(--dc-accent);
            transform: scale(0.85) translateY(-0.75rem) translateX(0.15rem);
            background-color: transparent;
        }
        
        .password-wrapper {
            position: relative;
        }
        
        .password-wrapper .form-floating {
            margin-bottom: 0;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--dc-text-light);
            cursor: pointer;
            z-index: 10;
            font-size: 18px;
            padding: 5px;
            transition: color 0.3s;
        }
        
        .password-toggle:hover {
            color: var(--dc-accent);
        }
        
        .btn-login {
            background: var(--dc-accent);
            border: none;
            color: var(--dc-white);
            padding: 14px 28px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            width: 100%;
            transition: all 0.3s;
            margin-top: 15px;
        }
        
        .btn-login:hover {
            background: var(--dc-accent-dark);
            transform: translateY(-2px);
            box-shadow: var(--dc-shadow-glow);
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 30px 0;
            color: var(--dc-text-light);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--dc-border);
        }
        
        .divider span {
            padding: 0 15px;
        }
        
        .btn-guest {
            display: block;
            text-align: center;
            padding: 12px;
            border: 1px solid var(--dc-border);
            background: transparent;
            border-radius: 8px;
            color: var(--dc-text);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-guest:hover {
            border-color: rgba(0,0,0,0.2);
            background: rgba(0,0,0,0.02);
            color: var(--dc-primary-dark);
        }
        
        .login-footer {
            text-align: center;
            padding: 0 30px 30px;
            color: var(--dc-text-light);
            font-size: 14px;
            border-top: none;
        }
        
        .login-footer a {
            color: var(--dc-accent);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .login-footer a:hover {
            color: var(--dc-accent-dark);
        }
        
        .alert {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--dc-text-light);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 20px;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: var(--dc-accent);
        }
    </style>
</head>
<body>
    <div class="login-wrapper" data-aos="fade-up">
        <a href="/" class="back-link">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>
        
        <div class="login-card">
            <div class="login-header">
                <div class="logo">Deltizen <span>Corner</span></div>
                <p>Masuk untuk melanjutkan pesanan Anda</p>
            </div>
            
            <div class="login-body">
                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                        </div>
                    @endif
                    
                    @error('email')
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                        </div>
                    @enderror
                    
                    <div class="form-floating">
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               placeholder="nama@email.com"
                               value="{{ old('email') }}" 
                               required 
                               autofocus>
                        <label for="email"><i class="bi bi-envelope me-2"></i>Email</label>
                    </div>
                    
                    <div class="form-floating password-wrapper">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Password"
                               required>
                        <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                    </button>
                    
                    <div class="divider">
                        <span>atau</span>
                    </div>
                    
                    <a href="{{ route('welcome') }}" class="btn-guest">
                        <i class="bi bi-person me-2"></i>Lanjutkan sebagai Tamu
                    </a>
                </form>
            </div>
            
            <div class="login-footer">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('template_front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template_front/assets/vendor/aos/aos.js') }}"></script>
    <script>
        AOS.init({ duration: 600 });
        
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
</body>
</html>