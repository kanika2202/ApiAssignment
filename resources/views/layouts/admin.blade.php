<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Admin')</title>

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">Admin Panel</a>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        {{-- Sidebar --}}
        <aside class="col-md-2 bg-white border-end min-vh-100 p-0">
            <div class="p-3 border-bottom">
                <div class="fw-bold">Dashboard</div>
                <small class="text-muted"></small>
            </div>

            <div class="list-group list-group-flush">
                <a href="{{ route('category.list') }}" class="list-group-item list-group-item-action">
                    Categories
                </a>
                <a href="{{ url('/productList') }}" class="list-group-item list-group-item-action">
                    Products
                </a>
            </div>
        </aside>

        {{-- Content --}}
        <main class="col-md-10 p-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <div class="fw-bold mb-1">Validation errors</div>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <strong>Success:</strong> {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
