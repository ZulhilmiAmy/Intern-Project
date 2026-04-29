<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Sistem Tempahan Bilik</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #4871b0);
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .page-wrap {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 460px;
            border-radius: 18px;
            padding: 32px;
            background: white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);

            opacity: 0;
            transform: translateY(30px);
            animation: fadeSlide 0.6s ease forwards;
        }

        @keyframes fadeSlide {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-title {
            font-weight: 700;
            color: #0d6efd;
            font-size: 1.35rem;
        }

        .system-title {
            font-size: 14px;
            color: #6c757d;
        }

        .login-card img {
            height: 85px;
            margin-right: 18px;
            filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.15));
        }

        .form-control {
            height: 48px;
            font-size: 16px;
        }

        .btn-login {
            height: 48px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        #togglePassword {
            min-width: 48px;
        }

        /* ==========================
           MOBILE RESPONSIVE
        ========================== */
        @media (max-width: 768px) {

            .page-wrap {
                padding: 15px;
                align-items: center;
            }

            .login-card {
                padding: 24px 20px;
                border-radius: 16px;
            }

            .login-header {
                flex-direction: column;
                text-align: center;
            }

            .login-card img {
                height: 72px;
                margin-right: 0;
                margin-bottom: 12px;
            }

            .login-title {
                font-size: 1.15rem;
            }

            .system-title {
                font-size: 13px;
            }

            .form-label {
                font-size: 0.95rem;
                margin-bottom: 6px;
            }

            .form-control {
                height: 46px;
                font-size: 16px;
            }

            .btn-login {
                height: 46px;
                font-size: 1rem;
            }

            #togglePassword {
                min-width: 46px;
            }
        }

        @media (max-width: 420px) {

            .login-card {
                padding: 20px 16px;
            }

            .login-title {
                font-size: 1rem;
            }

            .system-title {
                font-size: 12px;
            }

            .login-card img {
                height: 65px;
            }
        }
    </style>
</head>

<body>

    <div class="page-wrap">

        <div class="login-card">

            <div class="d-flex align-items-center justify-content-center mb-4 login-header">

                <img src="{{ asset('images/logo-kkm.png') }}" alt="Logo KKM">

                <div class="text-start text-md-start text-center">
                    <h4 class="login-title mb-1">Sistem Tempahan Bilik</h4>
                    <div class="system-title">Log Masuk Pentadbiran</div>
                </div>

            </div>

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email</label>

                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" autocomplete="off">

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label">Kata Laluan</label>

                    <div class="input-group">

                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror">

                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>

                    </div>

                    @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                @if(session('error'))
                    <div class="alert alert-danger py-2">
                        {{ session('error') }}
                    </div>
                @endif

                <button type="submit" class="btn btn-primary w-100 btn-login">
                    Log Masuk
                </button>

            </form>

        </div>

    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function () {

            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            if (type === 'password') {
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            } else {
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            }
        });
    </script>

</body>

</html>