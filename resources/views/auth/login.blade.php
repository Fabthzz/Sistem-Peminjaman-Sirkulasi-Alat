<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - SPSA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #F4F6F9;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.10);
            padding: 36px 32px;
            width: 100%;
            max-width: 400px;
        }

        .brand {
            text-align: center;
            margin-bottom: 20px;
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            border: 2px solid black;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-login {
            width: 100%;
            background: #2c6bb2;
            color: white;
            border-radius: 8px;
            padding: 10px;
            font-weight: 600;
            border: none;
        }

        .info-box {
            background: #f1f1f1;
            border-radius: 10px;
            padding: 10px;
            font-size: 12px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <!-- ICON -->
        <div class="brand">
            <div class="brand-icon">
                <i class="bi bi-person-fill"></i>
            </div>
            <p class="mt-2 mb-0">Log in</p>
        </div>

        <!-- INFO -->
        <div class="info-box">
            Gunakan NIM dan password. Jika belum memiliki akun, silakan daftar ke admin / assisten lab.
        </div>

        <!-- ERROR -->
        @if(session('error'))
        <div class="alert alert-danger" style="font-size:13px;">
            {{ session('error') }}
        </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-3">
                <input type="text" name="nim"
                    class="form-control"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    maxlength="15"
                    placeholder="Masukkan NIM"
                    required>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password"
                    class="form-control"
                    placeholder="Masukkan Password"
                    required>
            </div>

            <button type="submit" class="btn-login">
                MASUK
            </button>

        </form>

    </div>

</body>

</html>