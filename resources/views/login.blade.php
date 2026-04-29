<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Church Financial System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0d1117;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .left-panel {
            background: linear-gradient(160deg, #1a6b6b, #028fa5);
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        @media (min-width: 768px) {
            body { flex-direction: row; }
            .left-panel { width: 420px; flex-shrink: 0; min-height: 100vh; padding: 80px 60px; }
        }
        @media (min-width: 1200px) {
            .left-panel { width: 520px; padding: 120px 80px; }
        }
        .left-panel h1 { color: #fff; font-size: clamp(20px, 3vw, 26px); font-weight: 700; margin-bottom: 10px; }
        .left-panel .tagline { color: rgba(255,255,255,0.8); font-size: 13px; line-height: 1.6; margin-bottom: 32px; }
        @media (max-width: 480px) {
            .features-wrapper { display: none; }
            .left-panel { padding: 36px 28px; }
            .left-panel .tagline { margin-bottom: 0; }
        }
        .feature { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; }
        .feature-icon { width: 40px; height: 40px; background: rgba(255,255,255,0.18); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .feature-icon svg { width: 18px; height: 18px; stroke: #fff; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .feature-text strong { display: block; color: #fff; font-size: 14px; font-weight: 600; }
        .feature-text span { color: rgba(255,255,255,0.7); font-size: 12px; }
        .right-panel { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px 20px; }
        @media (min-width: 768px) { .right-panel { padding: 40px 32px; } }
        .login-card { background: #161b22; border: 1px solid #21262d; border-radius: 14px; padding: 36px 28px; width: 100%; max-width: 400px; }
        @media (min-width: 480px) { .login-card { padding: 44px 40px; } }
        .login-card h2 { color: #e6edf3; font-size: 24px; font-weight: 700; text-align: center; margin-bottom: 6px; }
        .login-card .subtitle { color: #8b949e; font-size: 13px; text-align: center; margin-bottom: 32px; }
        .alert-danger { background: rgba(248,81,73,0.1); border: 1px solid rgba(248,81,73,0.3); color: #f85149; border-radius: 8px; font-size: 13px; padding: 10px 14px; margin-bottom: 20px; }
        .field-label { display: block; color: #9af7e4; font-size: 11px; font-weight: 600; letter-spacing: 0.9px; text-transform: uppercase; margin-bottom: 7px; }
        .form-control { background: #0d1117 !important; border: 1px solid #d5d2d2 !important; border-radius: 8px !important; color: #c9d1d9 !important; font-size: 14px !important; padding: 11px 14px !important; height: auto !important; transition: border-color 0.2s !important; box-shadow: none !important; }
        .form-control:focus { border-color: #00d4aa !important; box-shadow: 0 0 0 3px rgba(0,212,170,0.1) !important; }
        .form-control::placeholder { color: #484f58 !important; }
        .form-control.is-invalid { border-color: #f85149 !important; }
        .invalid-feedback { color: #f85149; font-size: 12px; }
        .btn-login { width: 100%; background: linear-gradient(90deg, #00B8DB, #6bb7c3); color: #0d1117; font-weight: 700; font-size: 15px; border: none; border-radius: 8px; padding: 13px; cursor: pointer; transition: opacity 0.2s, transform 0.1s; margin-top: 6px; }
        .btn-login:hover { opacity: 0.9; }
        .btn-login:active { transform: scale(0.99); }
    </style>
</head>
<body>

<div class="left-panel">
    <h1>Church Financial System</h1>
    <p class="tagline">Manage your church finances with confidence, transparency, and ease.</p>
    <div class="features-wrapper">
        <div class="feature">
            <div class="feature-icon">
                <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <div class="feature-text">
                <strong>Secure & Reliable</strong>
                <span>Role-based access control</span>
            </div>
        </div>
        <div class="feature">
            <div class="feature-icon">
                <svg viewBox="0 0 24 24"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
            </div>
            <div class="feature-text">
                <strong>Real-time Tracking</strong>
                <span>Monitor funds instantly</span>
            </div>
        </div>
        <div class="feature">
            <div class="feature-icon">
                <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <div class="feature-text">
                <strong>Smart Approvals</strong>
                <span>Streamline workflows</span>
            </div>
        </div>
    </div>
</div>

<div class="right-panel">
    <div class="login-card">
        <h2>Welcome Back</h2>
        <p class="subtitle">Log in to your account</p>

        @if ($errors->any())
            <div class="alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-4">
                <label for="username" class="field-label">Username</label>
                <input
                    type="text"
                    name="username"
                    id="username"
                    class="form-control @error('username') is-invalid @enderror"
                    placeholder="Enter your username"
                    value="{{ old('username') }}"
                    required>
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="field-label">Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Enter your password"
                    required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-login">Log In</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>