<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — TechShop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #0a0a0f;
            --accent:  #ff4c00;
            --accent2: #ff8c42;
            --surface: #111118;
            --card:    #18181f;
            --border:  #2a2a35;
            --text:    #e8e8f0;
            --muted:   #888899;
            --danger:  #ff3b5c;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--primary);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* LEFT SIDE - Branding */
        .left-panel {
            flex: 1;
            background: var(--surface);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            border-right: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(255,76,0,0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .brand {
            font-family: 'Syne', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
        }

        .brand span { color: var(--accent); }

        .hero-text {
            position: relative;
        }

        .hero-tag {
            display: inline-block;
            background: rgba(255, 76, 0, 0.12);
            border: 1px solid rgba(255, 76, 0, 0.25);
            color: var(--accent);
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 6px 14px;
            border-radius: 20px;
            margin-bottom: 20px;
        }

        .hero-title {
            font-family: 'Syne', sans-serif;
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.1;
            color: #fff;
            margin-bottom: 16px;
        }

        .hero-title .highlight {
            background: linear-gradient(135deg, var(--accent), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.6;
            max-width: 380px;
        }

        .features {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--muted);
            font-size: 0.85rem;
        }

        .feature-icon {
            width: 30px; height: 30px;
            border-radius: 8px;
            background: rgba(255, 76, 0, 0.1);
            display: flex; align-items: center; justify-content: center;
            color: var(--accent);
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        /* RIGHT SIDE - Form */
        .right-panel {
            width: 480px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
        }

        .login-box { width: 100%; }

        .login-header { margin-bottom: 36px; }

        .login-header h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1.8rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 6px;
        }

        .login-header p { color: var(--muted); font-size: 0.9rem; }

        .form-group { margin-bottom: 18px; }

        label.field-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap i {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 1rem;
            pointer-events: none;
        }

        .field-input {
            width: 100%;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            color: var(--text);
            padding: 12px 14px 12px 42px;
            font-size: 0.9rem;
            transition: all 0.2s;
            font-family: 'DM Sans', sans-serif;
        }

        .field-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(255, 76, 0, 0.12);
            background: rgba(24, 24, 31, 0.9);
        }

        .field-input.is-invalid {
            border-color: var(--danger);
        }

        .error-msg {
            color: var(--danger);
            font-size: 0.78rem;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .toggle-password {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: var(--muted);
            cursor: pointer;
            padding: 0;
            font-size: 1rem;
            transition: color 0.2s;
        }

        .toggle-password:hover { color: var(--text); }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .remember-check {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .remember-check input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .remember-check span { font-size: 0.85rem; color: var(--muted); }

        .btn-login {
            width: 100%;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-family: 'Syne', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            background: var(--accent2);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(255, 76, 0, 0.3);
        }

        .btn-login:active { transform: translateY(0); }

        .demo-creds {
            margin-top: 24px;
            background: rgba(255, 76, 0, 0.06);
            border: 1px solid rgba(255, 76, 0, 0.15);
            border-radius: 12px;
            padding: 16px;
        }

        .demo-creds .demo-title {
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .demo-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.82rem;
            color: var(--muted);
            margin-bottom: 4px;
        }

        .demo-row strong { color: var(--text); font-weight: 500; }

        @media (max-width: 900px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; }
        }
    </style>
</head>
<body>

{{-- LEFT PANEL --}}
<div class="left-panel">
    <div class="brand">Tech<span>Shop</span></div>

    <div class="hero-text">
        <div class="hero-tag">Sistem Manajemen</div>
        <h1 class="hero-title">
            Kelola Stok<br>
            <span class="highlight">Smartphone</span><br>
            dengan Mudah
        </h1>
        <p class="hero-desc">
            Platform terpadu untuk manajemen inventaris, penjualan,
            dan pelaporan produk smartphone terkini.
        </p>
    </div>

    <div class="features">
        <div class="feature-item">
            <div class="feature-icon"><i class="bi bi-phone"></i></div>
            Manajemen produk smartphone lengkap
        </div>
        <div class="feature-item">
            <div class="feature-icon"><i class="bi bi-bar-chart"></i></div>
            Pantau stok dan margin keuntungan
        </div>
        <div class="feature-item">
            <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
            Sistem autentikasi aman dengan enkripsi
        </div>
    </div>
</div>

{{-- RIGHT PANEL --}}
<div class="right-panel">
    <div class="login-box">
        <div class="login-header">
            <h2>Selamat Datang</h2>
            <p>Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label class="field-label">Alamat Email</label>
                <div class="input-wrap">
                    <i class="bi bi-envelope"></i>
                    <input
                        type="email"
                        name="email"
                        class="field-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        value="{{ old('email') }}"
                        placeholder="admin@techshop.com"
                        autocomplete="email"
                        autofocus
                    >
                </div>
                @error('email')
                    <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label class="field-label">Password</label>
                <div class="input-wrap">
                    <i class="bi bi-lock"></i>
                    <input
                        type="password"
                        name="password"
                        id="passwordInput"
                        class="field-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                    >
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="form-options">
                <label class="remember-check">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-arrow-right-circle"></i>
                Masuk ke Sistem
            </button>
        </form>

        {{-- Demo Credentials --}}
        <div class="demo-creds">
            <div class="demo-title"><i class="bi bi-info-circle"></i> Akun Demo</div>
            <div class="demo-row">
                <span>Email:</span>
                <strong>admin@techshop.com</strong>
            </div>
            <div class="demo-row">
                <span>Password:</span>
                <strong>password123</strong>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
</body>
</html>
