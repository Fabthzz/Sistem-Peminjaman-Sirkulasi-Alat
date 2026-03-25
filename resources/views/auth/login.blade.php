<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #f0f0f0;
        }

        .card-login {
            border: none;
            border-radius: 16px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12);
            margin-top: 100px;
        }

        .nav-tabs .nav-link {
            color: #999;
            font-weight: 600;
            border: none;
            border-bottom: 2px solid transparent;
            padding: 10px 30px;
        }

        .nav-tabs .nav-link.active {
            color: #111;
            border-bottom: 2px solid #111;
            background: transparent;
        }

        .nav-tabs {
            border-bottom: 1px solid #eee;
        }

        .avatar-circle {
            width: 64px;
            height: 64px;
            border: 2px solid #111;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 6px;
        }

        .avatar-circle i {
            font-size: 34px;
            color: #111;
        }

        .form-control {
            background: #d9d9d9;
            border: none;
            padding: 12px 14px;
            border-radius: 6px;
        }

        .form-control:focus {
            background: #ccc;
            box-shadow: none;
            border: none;
        }

        .form-control::placeholder {
            color: #777;
        }

        .btn-masuk {
            background: #1565C0;
            color: #fff;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 10px 36px;
            border-radius: 6px;
            text-transform: uppercase;
            border: none;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-masuk:hover {
            background: #0d47a1;
            color: #fff;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>

    <div class="header-orange"></div>

    <div class="container" style="max-width: 420px;">
        <div class="card card-login">
            <div class="card-body p-4">

                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <ul class="nav nav-tabs justify-content-around mb-4" id="loginTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="mahasiswa-tab" data-bs-toggle="tab"
                            data-bs-target="#mahasiswa" type="button" role="tab">
                            Mahasiswa
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="admin-tab" data-bs-toggle="tab"
                            data-bs-target="#admin" type="button" role="tab">
                            Admin
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="loginTabContent">

                    {{-- TAB MAHASISWA --}}
                    <div class="tab-pane fade show active" id="mahasiswa" role="tabpanel">
                        <div class="text-center mb-3">
                            <div class="avatar-circle">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <p class="fw-semibold mb-0">Log in</p>
                        </div>

                        <form method="POST" action="{{ route('login.mahasiswa') }}">
                            @csrf
                            <input type="hidden" name="role" value="mahasiswa">

                            <div class="mb-3">
                                <label class="form-label small fw-medium text-secondary">Nama</label>
                                <input type="text" name="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    placeholder="Dosen/Mahasiswa"
                                    value="{{ old('nama') }}" required>
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <select name="jurusan" class="form-control @error('jurusan') is-invalid @enderror" required>
                                    <option value="" disabled selected>Pilih Fakultas/Jurusan</option>
                                    <option value="Ilmu Komputer" {{ old('jurusan') == 'Ilmu Komputer' ? 'selected' : '' }}>Ilmu Komputer</option>
                                    <option value="Sistem Informasi" {{ old('jurusan') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                    <option value="Sistem Komputer" {{ old('jurusan') == 'Sistem Komputer' ? 'selected' : '' }}>Sistem Komputer</option>
                                    <option value="Teknik Informatika" {{ old('jurusan') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                </select>
                                @error('jurusan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-masuk">MASUK</button>
                            </div>
                        </form>
                    </div>

                    {{-- TAB ADMIN --}}
                    <div class="tab-pane fade" id="admin" role="tabpanel">
                        <div class="text-center mb-3">
                            <div class="avatar-circle">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <p class="fw-semibold mb-0">Log in</p>
                            <span class="badge mt-1" style="background:#E87D0D;">Administrator</span>
                        </div>

                        <form method="POST" action="{{ route('login.admin') }}">
                            @csrf
                            <input type="hidden" name="role" value="admin">

                            <div class="mb-3">
                                <label class="form-label small fw-medium text-secondary">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Email Admin"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-medium text-secondary">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="adminPassword"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Password" required>
                                    <button class="btn" type="button"
                                        style="background:#ccc; border:none; border-radius:0 6px 6px 0;"
                                        onclick="togglePassword()">
                                        <i class="bi bi-eye" id="eyeIcon"></i>
                                    </button>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-masuk">MASUK</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="footer-orange mt-4"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            var oldRole = "{{ old('role') }}";
            if (oldRole === 'admin') {
                var adminTab = new bootstrap.Tab(document.getElementById('admin-tab'));
                adminTab.show();
            }
        });

        function togglePassword() {
            const input = document.getElementById('adminPassword');
            const icon = document.getElementById('eyeIcon');
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