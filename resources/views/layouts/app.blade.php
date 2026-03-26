<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Glisten Blossom')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body{
            background:#f8f9fa;
        }

        /* NAVBAR */
        .navbar{
            background:#fff;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

        .navbar .nav-link{
            font-weight:500;
            color:#333;
        }

        .navbar .nav-link:hover{
            color:#0d6efd;
        }

        /* BRAND */
        .brand img{
            height:50px;
            transition:.3s;
        }

        .brand img:hover{
            transform:scale(1.1);
        }

        /* FOOTER */
        footer{
            background:#0f2a2a;
            color:#fff;
        }

        footer a{
            color:#fff;
            text-decoration:none;
        }

        footer a:hover{
            text-decoration:underline;
        }
    </style>
</head>

<body>

{{-- ================= NAVBAR ================= --}}
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">

        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ url('/') }}">
            <img src="{{ asset('logo.png') }}" width="40" class="me-2">
            Glisten Blossom
        </a>

        {{-- Toggle --}}
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu --}}
        <div class="collapse navbar-collapse" id="navMenu">

            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Promotions</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('front.categories.index') }}">Categories</a></li>
                {{-- Blog --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Blog</a>
                </li>
            </ul>
​​
            {{-- Right icons --}}
            <div class="d-flex align-items-center gap-3">
                {{-- Search --}}
                <div class="position-relative">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control pill" placeholder="Search product name...">
                    <button class="btn btn-dark position-absolute top-0 end-0 rounded-pill px-2">
                        <i class="bi bi-search"></i>
                </div>

                <img src="https://flagcdn.com/w40/us.png" width="25">

                <i class="bi bi-heart fs-5"></i>

                <a href="{{ url('/cart') }}">
                    <i class="bi bi-cart3 fs-5"></i>
                </a>

                @auth
                    <i class="bi bi-person fs-5"></i>
                @else
                    <a href="{{ url('login') }}" class="btn btn-outline-dark btn-sm">Login</a>
                @endauth

            </div>
        </div>
    </div>
</nav>




{{-- ================= CONTENT ================= --}}
<div class="container my-4">
    @yield('content')
</div>


{{-- ================= FOOTER ================= --}}
<footer>
    <div class="container py-5 mt-3 text-light">
        <div class="row">

            {{-- Logo --}}
            <div class="col-md-4">
                <div class="d-flex align-items-center mb-2">
                    <img src="{{ asset('logo.png') }}" width="50" class="me-2">
                    <strong>Glisten Blossom</strong>
                </div>
                <p>Welcome to our little Site</p>
            </div>

            {{-- More --}}
            <div class="col-md-3">
                <h6 class="fw-bold">Mores</h6>
                <ul class="list-unstyled">
                    <li><a href="#">All Products</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Blogs</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            {{-- Follow --}}
            <div class="col-md-3">
                <h6 class="fw-bold">Follow us</h6>
                <ul class="list-unstyled">
                    <li><i class="bi bi-facebook"></i> Facebook</li>
                    <li><i class="bi bi-instagram"></i> Instagram</li>
                    <li><i class="bi bi-telegram"></i> Telegram</li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="col-md-2">
                <h6 class="fw-bold">Contact us</h6>
                <p class="small">
                    <i class="bi bi-telephone"></i> +855 93 333 227<br>
                    <i class="bi bi-envelope"></i> email@gmail.com<br>
                    <i class="bi bi-geo-alt"></i> Phnom Penh
                </p>
            </div>

        </div>

        <hr class="border-light">

        <div class="d-flex justify-content-between small">
            <span>Copyright © {{ date('Y') }} by Glisten Blossom</span>
            <span>Powered by KrubKrong</span>
        </div>
    </div>
</footer>


{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>