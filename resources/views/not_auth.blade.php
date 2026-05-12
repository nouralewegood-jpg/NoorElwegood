<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .unauthorized-container {
            text-align: center;
            padding: 3rem;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            max-width: 600px;
        }

        .icon {
            font-size: 5rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="unauthorized-container">
            <div class="icon">
                <i class="bi bi-shield-lock"></i>
                ⚠️
            </div>
            <h1 class="mb-4">Unauthorized Access</h1>
            <p class="lead mb-4">Sorry, you don't have permission to access this page. This area is restricted to
                authorized personnel only.</p>

            <div class="mb-4">
                @if (Auth::check())
                    <p>You are logged in as <strong>{{ Auth::user()->name }}</strong> with role
                        <strong>{{ Auth::user()->role }}</strong>.
                    </p>
                @else
                    <p>You are currently not logged in. Please log in to access the content.</p>
                @endif
            </div>

            <div class="d-flex justify-content-center gap-3">
                @if (Auth::check())
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Go to Admin Dashboard</a>
                    @elseif(Auth::user()->role === 'moderator')
                        <a href="{{ route('moderator.dashboard') }}" class="btn btn-primary">Go to Moderator
                            Dashboard</a>
                    @else
                        <a href="{{ route('home') }}" class="btn btn-primary">Go to Homepage</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
