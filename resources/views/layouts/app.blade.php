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
        /* ================= BACKGROUND ================= */
        body{
            background-color: #FFF9E6;
           
            background-repeat: no-repeat;
            background-position: right bottom;
            background-size: 220px;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        /* ================= NAVBAR ================= */
        .navbar{
            background:#ffffff;
            box-shadow:0 4px 15px rgba(0,0,0,0.05);
        }

        .navbar .nav-link{
            font-weight:500;
            color:#333;
            transition: .3s;
        }

        .navbar .nav-link:hover{
            color:#f4b400;
        }

        .navbar-brand img{
            height:45px;
            transition:.3s;
        }

        .navbar-brand img:hover{
            transform:scale(1.1);
        }

        /* ================= SEARCH ================= */
        .search-box input{
            border-radius:20px;
            border:none;
            box-shadow:0 5px 15px rgba(0,0,0,0.05);
        }

        /* ================= CONTENT ================= */
        .main-content{
            background:#ffffff;
            padding:35px;
            border-radius:18px;
            box-shadow:0 8px 25px rgba(0,0,0,0.08);
            margin-top:40px;
            margin-bottom:40px;
            transition: .3s;
        }

        .main-content:hover{
            transform: translateY(-4px);
        }

        /* ================= FOOTER ================= */
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

        /* ================= ICONS ================= */
        .icon-btn{
            cursor:pointer;
            transition:.3s;
        }

        .icon-btn:hover{
            color:#f4b400;
            transform: scale(1.1);
        }
    </style>
</head>

<body>

{{-- ================= NAVBAR ================= --}}
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
       
        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center fw-bold " href="{{ url('/') }}">
            <img src="{{ asset('img/hello.webp') }}" class="me-2 rounded-circle" width="40">
            Miss sunflower
        </a>

        {{-- Toggle --}}
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        {{-- Menu --}}
        <div class="collapse navbar-collapse" id="navMenu">

            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('front.category_products.index') }}">Products</a></li>
                <li class="nav-item"> <a class="nav-link {{ Request::is('promotions') ? 'active text-warning' : '' }}" 
                       href="{{ route('front.promotions') }}">Promotions</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('front.categories.index') }}">Categories</a></li>
            </ul>

            {{-- Right side --}}
            <div class="d-flex align-items-center gap-3">

                 {{-- ស្វែងរកកន្លែង Search Box ក្នុង Navbar រួចប្តូរដូចខាងក្រោម --}}
<form action="{{ route('front.search') }}" method="GET" class="search-box d-flex">
    <div class="input-group">
        <input type="text" name="query" class="form-control" placeholder="ស្វែងរកផ្កា ឬប្រភេទ..." value="{{ request('query') }}">
        <button class="btn btn-warning border-0" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </div>
</form>

               {{-- Icons --}}
               <i class="bi bi-heart fs-5 icon-btn"></i>

                <a href="{{ route('cart.index') }}">
                    <i class="bi bi-cart3 fs-5 icon-btn"></i>
                    <span class="badge bg-danger rounded-pill cart-count-badge">
                        {{ array_sum(array_column(session('cart', []), 'qty')) }}
                    </span>
                </a>
                @auth
                   <a href="{{ url('/category') }}"><i class="bi bi-person fs-5 icon-btn"></i></a>
                @else
                    <a href="{{ url('login') }} " class="btn btn-warning btn-sm">Login</a>
                @endauth
               

            </div>
        </div>
    </div>
</nav>


{{-- ================= CONTENT ================= --}}
<div class="container">
    <div class="main-content">
        @yield('content')
    </div>
</div>


{{-- ================= FOOTER ================= --}}
<footer>
    <div class="container py-5">

        <div class="row">

            <div class="col-md-4">
                <div class="d-flex align-items-center mb-2">
                    <img src="{{ asset('img/hello.webp') }}" width="50" class="me-2 rounded-circle">
                    <strong>Miss sunflower</strong>
                </div>
                <p>Beautiful flowers for your lovely moments 🌻</p>
            </div>

            <div class="col-md-3">
                <h6 class="fw-bold">More</h6>
                <ul class="list-unstyled">
                    <li><a href="#">All Products</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Blogs</a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <h6 class="fw-bold">Follow us</h6>
                <ul class="list-unstyled">
                    <li><i class="bi bi-facebook"></i> Facebook</li>
                    <li><i class="bi bi-instagram"></i> Instagram</li>
                    <li><i class="bi bi-telegram"></i> Telegram</li>
                </ul>
            </div>

            <div class="col-md-2">
                <h6 class="fw-bold">Contact</h6>
                <p class="small">
                    <i class="bi bi-telephone"></i> +855 93 333 227<br>
                    <i class="bi bi-envelope"></i> email@gmail.com<br>
                    <i class="bi bi-geo-alt"></i> Phnom Penh
                </p>
            </div>

        </div>

        <hr>

        <div class="d-flex justify-content-between small">
            <span>© {{ date('Y') }} Miss sunflower</span>
            <span>Made with Team bek sloy of Beltie International University🌼</span>
        </div>

    </div>
</footer>


{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>