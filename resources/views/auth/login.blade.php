<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login RME Polije</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f0f2f5 0%, #e5e7eb 100%);
            min-height: 100vh;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
        .login-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: 12px 12px 0 0;
            padding: 2rem 1.5rem;
            text-align: center;
        }
        .login-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 24px;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .btn-primary {
            background: var(--primary);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">

    <div class="card login-card">
        <div class="login-header">
            <div class="login-icon">
                <i class="fas fa-hospital-user"></i>
            </div>
            <h4 class="mb-0 fw-bold">RME POLIJE</h4>
            <p class="mb-0 opacity-75 small">Silakan login untuk melanjutkan</p>
        </div>

        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <form id="loginForm" method="POST" action="/login">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label fw-bold text-muted small text-uppercase">Username / Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-user text-muted"></i>
                        </span>
                        <input type="text" id="username" name="username" class="form-control border-start-0 ps-0" placeholder="Masukkan username" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-bold text-muted small text-uppercase">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-lock text-muted"></i>
                        </span>
                        <input type="password" id="password" name="password" class="form-control border-start-0 ps-0" placeholder="Masukkan password" required>
                        <button class="btn btn-light border border-start-0" type="button" id="togglePassword">
                            <i class="fas fa-eye text-muted"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember">
                        <label class="form-check-label small text-muted" for="remember">Ingat Saya</label>
                    </div>
                    <a href="#" class="small text-decoration-none text-primary">Lupa Password?</a>
                </div>

                <div id="loginAlert" class="alert d-none" role="alert"></div>

                <button type="submit" id="loginBtn" class="btn btn-primary w-100 mb-3 shadow-sm">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk Sistem
                </button>
            </form>
        </div>
        <div class="card-footer bg-light text-center py-3 border-top-0 rounded-bottom">
            <small class="text-muted">&copy; {{ date('Y') }} RME Klinik Polije. All rights reserved.</small>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // AJAX Login Handler
        const form = document.getElementById('loginForm');
        const alertBox = document.getElementById('loginAlert');
        const loginBtn = document.getElementById('loginBtn');
        const originalBtnText = loginBtn.innerHTML;

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            // UI Loading State
            alertBox.classList.add('d-none');
            loginBtn.disabled = true;
            loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';

            const data = new FormData(form);
            const token = document.querySelector('input[name="_token"]').value;

            try {
                const res = await fetch('/login', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                    body: data
                });

                if (res.ok) {
                    const json = await res.json();
                    if (json.redirect) {
                        window.location.href = json.redirect;
                    } else {
                        window.location.reload();
                    }
                } else {
                    const json = await res.json().catch(() => ({ message: 'Login gagal' }));
                    alertBox.classList.remove('d-none');
                    alertBox.classList.remove('alert-success');
                    alertBox.classList.add('alert-danger');
                    alertBox.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i> ' + (json.message || 'Username atau password salah');

                    // Shake animation for error
                    document.querySelector('.login-card').animate([
                        { transform: 'translateX(0)' },
                        { transform: 'translateX(-10px)' },
                        { transform: 'translateX(10px)' },
                        { transform: 'translateX(0)' }
                    ], {
                        duration: 300,
                        iterations: 1
                    });
                }
            } catch (error) {
                alertBox.classList.remove('d-none');
                alertBox.classList.add('alert-danger');
                alertBox.textContent = 'Terjadi kesalahan koneksi.';
            } finally {
                loginBtn.disabled = false;
                loginBtn.innerHTML = originalBtnText;
            }
        });
    </script>
</body>
</html>
