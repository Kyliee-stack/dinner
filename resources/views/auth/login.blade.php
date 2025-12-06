<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Asumsi menggunakan Tailwind CSS atau style Admin yang serupa -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --color-primary: #e3342f; /* Merah Gacoan */
            --color-secondary: #f4f6f9;
            --color-dark: #343a40;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-secondary);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .header h2 {
            color: var(--color-primary);
            font-weight: 800;
            margin: 0;
            font-size: 1.75rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--color-dark);
        }
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
            border-radius: 8px;
            box-sizing: border-box;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-control:focus {
            border-color: var(--color-primary);
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(227, 52, 47, 0.25);
        }
        .btn-primary {
            width: 100%;
            background-color: var(--color-primary);
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .btn-primary:hover {
            background-color: #c72c27; /* Sedikit lebih gelap */
        }
        .error-message {
            color: var(--color-primary);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="header">
            <h2><i class="fas fa-lock" style="margin-right: 10px;"></i> ADMIN LOGIN</h2>
            <p style="color: #6c757d; font-size: 0.9rem;">Panel Kontrol Pesanan</p>
        </div>

        {{-- Menampilkan pesan kesalahan login dari session --}}
        @if (session('status'))
            <div style="background-color: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid #c3e6cb;">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="error-message" style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid #f5c6cb;">
                Login gagal. Periksa kembali email dan password Anda.
            </div>
        @endif
        
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            {{-- Email Input --}}
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                @error('email') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            {{-- Password Input --}}
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
                @error('password') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            {{-- Remember Me (Opsional) --}}
            <div class="form-group" style="margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; font-weight: normal;">
                    <input type="checkbox" name="remember" style="margin-right: 8px;">
                    Ingat Saya
                </label>
            </div>

            <button type="submit" class="btn-primary">
                <i class="fas fa-sign-in-alt"></i> Masuk
            </button>
        </form>
    </div>

</body>
</html>