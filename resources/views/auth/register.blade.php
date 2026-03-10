<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Daftar - Deltizen Corner</title>
    <meta name="description" content="Daftar akun Deltizen Corner untuk kemudahan pemesanan">
    
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Bootstrap & Icons --}}
    <link href="{{ asset('template_front/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template_front/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('template_front/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    
    <style>
        :root {
            --dc-primary: #2c3e50;
            --dc-accent: #e67e22;
            --dc-success: #27ae60;
            --dc-danger: #e74c3c;
            --dc-text: #2c3e50;
            --dc-text-light: #7f8c8d;
            --dc-bg-light: #f8f9fa;
            --dc-border: #e9ecef;
            --dc-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --dc-radius: 12px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .register-wrapper {
            width: 100%;
            max-width: 480px;
        }
        
        .register-card {
            background: white;
            border-radius: var(--dc-radius);
            box-shadow: var(--dc-shadow);
            overflow: hidden;
        }
        
        .register-header {
            background: linear-gradient(135deg, var(--dc-primary) 0%, #34495e 100%);
            padding: 35px 30px;
            text-align: center;
            color: white;
        }
        
        .register-header .logo {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .register-header .logo span {
            color: var(--dc-accent);
        }
        
        .register-header p {
            opacity: 0.9;
            font-size: 14px;
        }
        
        .register-body {
            padding: 35px 30px;
        }
        
        .form-floating {
            margin-bottom: 18px;
        }
        
        .form-floating > .form-control {
            border: 2px solid var(--dc-border);
            border-radius: 10px;
            height: 54px;
            font-size: 15px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        .form-floating > .form-control:focus {
            border-color: var(--dc-accent);
            box-shadow: 0 0 0 4px rgba(230, 126, 34, 0.1);
        }
        
        .form-floating > label {
            color: var(--dc-text-light);
        }
        
        .password-wrapper {
            position: relative;
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
        }
        
        .password-toggle:hover {
            color: var(--dc-accent);
        }
        
        .btn-register {
            background: var(--dc-accent);
            border: none;
            color: white;
            padding: 14px 28px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn-register:hover {
            background: #d35400;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(230, 126, 34, 0.3);
        }
        
        .register-footer {
            text-align: center;
            padding: 20px 30px 30px;
            color: var(--dc-text-light);
            font-size: 14px;
        }
        
        .register-footer a {
            color: var(--dc-accent);
            text-decoration: none;
            font-weight: 600;
        }
        
        .register-footer a:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 18px;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--dc-text-light);
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 20px;
            transition: color 0.3s;
        }
        
        .back-link:hover {
            color: var(--dc-accent);
        }
        
        .password-hint {
            font-size: 12px;
            color: var(--dc-text-light);
            margin-top: -12px;
            margin-bottom: 18px;
            padding-left: 5px;
        }
    </style>
</head>
<body>
    <div class="register-wrapper" data-aos="fade-up">
        <a href="/" class="back-link">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>
        
        <div class="register-card">
            <div class="register-header">
                <div class="logo">Deltizen <span>Corner</span></div>
                <p>Daftar untuk kemudahan pemesanan</p>
            </div>
            
            <div class="register-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            @foreach($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="form-floating">
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               placeholder="Nama Lengkap"
                               value="{{ old('name') }}" 
                               required 
                               autofocus>
                        <label for="name"><i class="bi bi-person me-2"></i>Nama Lengkap</label>
                    </div>
                    
                    <div class="form-floating">
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               placeholder="nama@email.com"
                               value="{{ old('email') }}" 
                               required>
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
                        <button type="button" class="password-toggle" onclick="togglePassword('password', 'toggleIcon1')">
                            <i class="bi bi-eye" id="toggleIcon1"></i>
                        </button>
                    </div>
                    <p class="password-hint">Minimal 8 karakter</p>
                    
                    <div class="form-floating password-wrapper">
                        <input type="password" 
                               class="form-control" 
                               id="password-confirm" 
                               name="password_confirmation" 
                               placeholder="Konfirmasi Password"
                               required>
                        <label for="password-confirm"><i class="bi bi-lock-fill me-2"></i>Konfirmasi Password</label>
                        <button type="button" class="password-toggle" onclick="togglePassword('password-confirm', 'toggleIcon2')">
                            <i class="bi bi-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                    
                    <button type="submit" class="btn-register">
                        <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                    </button>
                </form>
            </div>
            
            <div class="register-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('template_front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template_front/assets/vendor/aos/aos.js') }}"></script>
    <script>
        AOS.init({ duration: 600 });
        
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
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