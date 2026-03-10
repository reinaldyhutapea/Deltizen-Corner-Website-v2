<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Deltizen Corner - Tempat nongkrong santai dengan hidangan lezat di Balige, Sumatera Utara">
    <meta name="keywords" content="deltizen corner, cafe balige, makanan balige, minuman balige">
    <meta name="author" content="Deltizen Corner">
    <title>@yield('title', 'Deltizen Corner - Tempat Nongkrong Santai')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo_deltizen.png') }}">
    
    <!-- Google Fonts - Modern & Clean -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Vendor CSS -->
    <link href="{{ asset('template_front/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template_front/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('template_front/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('template_front/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template_front/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    
    <!-- Main CSS -->
    <link href="{{ asset('template_front/assets/css/main.css') }}" rel="stylesheet">
    
    <!-- Custom Elegant Theme -->
    <link href="{{ asset('css/custom-elegant.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="index-page">
    <!-- ======= Header ======= -->
    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="/" class="logo d-flex align-items-center me-auto">
                <img src="{{ asset('logo_deltizen.png') }}" alt="Deltizen Corner" style="max-height: 40px; margin-right: 15px;">
                <h1 class="sitename">Deltizen Corner</h1>
                <span>.</span>
            </a>
            
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="/" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
                    <li><a href="/menu" class="{{ Request::is('menu*') ? 'active' : '' }}">Menu</a></li>
                    <li><a href="{{ route('invoice.list') }}" class="{{ Request::is('invoice*') ? 'active' : '' }}">Status Pesanan</a></li>
                    <li>
                        <a href="{{ route('cart.list') }}" class="{{ Request::is('cart*') ? 'active' : '' }}">
                            <i class="bi bi-cart3"></i> Keranjang
                        </a>
                    </li>
                    @auth
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout.perform') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right"></i> Keluar
                                    </a>
                                    <form id="logout-form" action="{{ route('logout.perform') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                    @guest
                        <li><a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Masuk</a></li>
                    @endguest
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list toggle-btn"></i>
            </nav>
            
            <a class="btn-getstarted" href="/menu">
                <i class="bi bi-bag-plus me-1"></i> Buat Pesanan
            </a>
        </div>
    </header>

    <!-- ======= Main Content ======= -->
    <main class="main">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="container mt-4">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="container mt-4">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        
        @if(session('warning'))
            <div class="container mt-4">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle me-2"></i>{{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-geo-alt icon"></i>
                        <div>
                            <h4>Lokasi Kami</h4>
                            <p>
                                Sitoluama, Kec. Balige<br>
                                Toba, Sumatera Utara 22381<br>
                                Indonesia
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-telephone icon"></i>
                        <div>
                            <h4>Hubungi Kami</h4>
                            <p>
                                <strong>Telepon:</strong> +62 813-6091-2900<br>
                                <strong>Email:</strong> delitzencorner@gmail.com
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-clock icon"></i>
                        <div>
                            <h4>Jam Operasional</h4>
                            <p>
                                <strong>Senin - Jumat:</strong> 10:00 - 22:00<br>
                                <strong>Sabtu - Minggu:</strong> 10:00 - 23:00
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h4>Ikuti Kami</h4>
                    <div class="social-links d-flex">
                        <a href="https://instagram.com/delitzencorner" target="_blank" rel="noopener" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://facebook.com/delitzencorner" target="_blank" rel="noopener" aria-label="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://wa.me/6281360912900" target="_blank" rel="noopener" aria-label="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container copyright text-center mt-4">
            <p>&copy; {{ date('Y') }} <strong class="sitename">Deltizen Corner</strong>. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Scroll Top Button -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center" aria-label="Scroll to top">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS -->
    <script src="{{ asset('template_front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template_front/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('template_front/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('template_front/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('template_front/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    
    <!-- Main JS -->
    <script src="{{ asset('template_front/assets/js/main.js') }}"></script>
    
    @stack('scripts')
</body>
</html>