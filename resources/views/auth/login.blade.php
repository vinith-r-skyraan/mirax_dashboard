<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #c2c6c0ff;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }
        .card-header img{
            width: 40%;
            height: 50%;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border-radius: 10px;
        }

        @media (min-width: 768px) {
            .login-card {
                max-width: 450px;
            }
        }

        @media (min-width: 1200px) {
            .login-card {
                max-width: 400px;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">

        <div class="card shadow login-card">

            <div class="card-header text-center bg-white border-0 pt-4">
                <img src="{{ asset('images/logo.png') }}" >
                <h2 class="fw-bold mb-0 text-black"><i>Mirax Technologies</i></h2><br>
                <h5 class="fw-bold mb-0 text-secondary">Login</h5>
            </div>

            <div class="card-body px-4 pb-4">

                @if (session('error'))
                    <div class="alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        Login
                    </button>

                </form>

            </div>
        </div>

    </div>

</body>

</html>
