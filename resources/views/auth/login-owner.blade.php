<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Owner</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #ccccccce;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            max-width: 350px;
            margin: 80px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            text-align: center;
        }

        .login-box .icon {
            width: 80px;
            height: 80px;
            background-color: #4C6E50;
            border-radius: 50%;
            margin: -60px auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box .icon i {
            font-size: 36px;
            color: rgb(255, 255, 255);
        }

        .btn-custom {
            background-color: #4C6E50;
            color: rgb(255, 255, 255);
            width: 100%;
        }

        .btn-custom:hover {
            background-color: rgb(0, 187, 0);
        }

        label {
            float: left;
        }
    </style>
    <!-- Bootstrap Icons (untuk avatar user) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="login-box">
        <div class="icon">
            <i class="bi bi-person-fill"></i>
        </div>
        <h4 class="mb-4">Login Owner</h4>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('owner.login') }}" method="POST">
            @csrf
            <div class="mb-3 text-start">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3 text-start">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-custom">Sign In</button>
        </form>
    </div>
</body>
</html>
