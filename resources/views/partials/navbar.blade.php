<nav class="fixed-top bg-white pt-4 pb-2">
    <div class="navbar navbar-expand navbar-light">
        <div class="container">
            <a href="{{ route('home') }}" class="navbar-brand me-5 fw-bold">
                {{ config('app.name') }}
            </a>

            <div class="w-100 d-none d-lg-block">
                <form class="d-flex ms-2" action="{{ route('customer.produk.index') }}" method="get">
                    <input class="form-control form-control-sm me-1" type="search" name="search" placeholder="Search" value="{{ request('search') }}">
                    <button class="btn btn-sm btn-success" type="submit">
                        <i class="fas fa-fw fa-search"></i>
                    </button>
                </form>
            </div>

            <div class="ms-3 collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    @auth
                    <li class="nav-item">
                        <a href="{{ route('customer.keranjang.index') }}" class="nav-link">
                            <div class="position-relative">
                                <i class="fas fa-fw fa-shopping-cart"></i>
                                @php($count = auth()->user()->keranjangs()->count())
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">@if ($count > 0) <small>{{ $count }}</small>@endif</span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item position-relative">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-fw fa-user"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link small">
                            Login
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
    <div class="container d-block d-lg-none">
        <form class="d-flex" action="{{ route('customer.produk.index') }}" method="get">
            <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Search" value="{{ request('search') }}">
            <button class="btn btn-sm btn-success" type="submit">
                <i class="fas fa-fw fa-search"></i>
            </button>
        </form>
    </div>
</nav>

<div style="margin-top: 125px"></div>