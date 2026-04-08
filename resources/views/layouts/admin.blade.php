<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Admin')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Custom Style --}}
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #657b8f;
        }

        .navbar {
            letter-spacing: 1px;
        }

        .sidebar {
            min-height: 100vh;
        }

        .list-group-item {
            border: none;
            transition: 0.2s;
        }

        .list-group-item:hover {
            background-color: #0d6efd;
            color: #fff;
        }

        .list-group-item.active {
            background-color: #0d6efd;
            color: #fff;
            border: none;
        }

        .card {
            border-radius: 12px;
        }
    </style>
</head>

<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold fs-4" href="#">
            <i class="bi bi-speedometer2"></i> Admin Panel
        </a>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        {{-- Sidebar --}}
        <aside class="col-md-2 bg-white border-end sidebar shadow-sm p-0">
            <div class="p-3 border-bottom">
                <div class="fw-bold fs-5">Dashboard</div>
                <small class="text-muted">Admin System</small>
            </div>

            <div class="list-group list-group-flush">
                <a href="{{ route('category.list') }}" 
                   class="list-group-item list-group-item-action d-flex align-items-center gap-2">
                    <i class="bi bi-folder"></i> Categories
                </a>

                <a href="{{ url('/productList') }}" 
                   class="list-group-item list-group-item-action d-flex align-items-center gap-2">
                    <i class="bi bi-box"></i> Products
                </a>
               <a href="{{ route('admin.orders.index') }}" class="list-group-item">
                  🛒 Orders
               </a>

              <a href="{{ route('admin.orders.history') }}" class="list-group-item">
                📦 Order History
               </a> <a href="{{ route('admin.reports') }}" class="list-group-item">
                📊 Reports
               </a>
        <hr class="my-2">
                <div class="list-group list-group-flush">
                 <a href="{{ route('banner.list') }}" class="list-group-item list-group-item-action"><i class="bi bi-image"></i> Banners</a>
                </div>
                <a href="{{ route('qrcode.index') }}" 
                   class="list-group-item list-group-item-action d-flex align-items-center gap-2">
                   <i class="bi bi-qr-code-scan"></i> Manage QR Codes
               </a>
                <div class="list-group list-group-flush">
                 <a href="{{ url('/') }}" class="list-group-item list-group-item-action"><i class="bi bi-arrow-left"></i> Back to Home page</a>
                </div>
                {{-- ប៊ូតុងចាកចេញ (Logout) --}}
        <div class="p-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
            </div>

          <div class="p-3 border-bottom bg-light">
    <small class="fw-bold text-uppercase text-muted">API Settings</small>
</div>
<div class="list-group list-group-flush">
    <a href="{{ route('admin.api.public') }}" class="list-group-item list-group-item-action d-flex align-items-center gap-2 {{ request()->routeIs('admin.api.public') ? 'active' : '' }}">
        <i class="bi bi-cloud-check"></i> Public API
    </a>
    <a href="{{ route('admin.api.urls') }}" class="list-group-item list-group-item-action d-flex align-items-center gap-2 {{ request()->routeIs('admin.api.urls') ? 'active' : '' }}">
        <i class="bi bi-link-45deg"></i> API URLs
    </a>
    <a href="{{ route('admin.api.token') }}" class="list-group-item list-group-item-action d-flex align-items-center gap-2 {{ request()->routeIs('admin.api.token') ? 'active' : '' }}">
        <i class="bi bi-key"></i> Access Tokens
    </a>
</div>
        </aside>

        {{-- Content --}}
        <main class="col-md-10 p-4">

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    {{-- Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <div class="fw-bold mb-1">
                                <i class="bi bi-exclamation-triangle"></i> Validation Errors
                            </div>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Success --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> 
                            <strong>Success:</strong> {{ session('success') }}
                        </div>
                    @endif

                    {{-- Page Content --}}
                    @yield('content')

                </div>
            </div>

        </main>

    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>