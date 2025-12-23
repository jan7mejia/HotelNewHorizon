<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hotel New Horizon</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
    /* --- ESTILOS DE NAVEGACIÓN --- */
    .navbar-nav .nav-link {
        transition: all 0.3s ease !important;
        position: relative;
    }

    .navbar-nav .nav-link:hover {
        color: #0d6efd !important; 
        transform: translateY(-2px); 
    }

    .navbar-nav .nav-link::after {
        content: '';
        position: absolute;
        width: 0; height: 2px; bottom: 0; left: 0;
        background-color: #0d6efd;
        transition: width 0.3s ease;
    }

    .navbar-nav .nav-link:hover::after { width: 100%; }

    /* --- ESTILO UNIFICADO DE USUARIO (BASADO EN TUS CAPTURAS) --- */
    .user-nav-wrapper {
        display: flex;
        align-items: center;
        text-decoration: none !important;
        padding: 8px 0;
        position: relative;
        transition: all 0.3s ease;
        border-bottom: 2px solid #0d6efd; /* Línea azul de tu imagen de referencia */
    }

    .user-nav-wrapper:hover {
        opacity: 0.8;
    }

    .user-nav-icon {
        font-size: 1.5rem;
        color: #0d6efd;
        margin-right: 12px;
        display: flex;
        align-items: center;
    }

    .user-text-stack {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }

    .user-main-title {
        color: #fff;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .user-subtitle {
        color: #0d6efd;
        font-size: 0.7rem;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    /* Menú desplegable estilo oscuro premium simplificado */
    .dropdown-menu-custom {
        background-color: #0a0a0a;
        border: 1px solid #222;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.8);
        margin-top: 15px !important;
        padding: 8px;
        min-width: 210px;
    }

    .dropdown-item-custom {
        color: #ffffff !important; /* Texto en blanco según lo solicitado */
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        transition: 0.2s ease;
    }

    .dropdown-item-custom:hover {
        background-color: #1a1a1a !important;
        color: #0d6efd !important;
    }

    .dropdown-item-custom i {
        margin-right: 12px;
        font-size: 1.1rem;
        color: #0d6efd; /* Iconos en azul para mantener el estilo */
    }

    .dropdown-divider-custom {
        border-top: 1px solid #222;
        margin: 5px 0;
    }

    .dropdown-toggle::after {
        display: none; /* Sin flecha para look limpio */
    }
  </style>
</head>

<body>

<nav class="navbar navbar-expand-lg shadow-sm fixed-top" style="background-color:#000; height:110px; padding:0 2rem; z-index:1030;">
  <div class="container-fluid">

    <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
      <img src="{{ asset('img/logo.jpeg') }}" alt="Hotel New Horizon" style="height:90px; width:auto;">
    </a>

    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbarNav">

      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a href="{{ route('home') }}" class="nav-link text-white px-3">Inicio</a></li>
        <li class="nav-item"><a href="{{ route('habitaciones') }}" class="nav-link text-white px-3">Habitaciones</a></li>
        <li class="nav-item"><a href="{{ route('areas_comunes') }}" class="nav-link text-white px-3">Áreas Comunes</a></li>
        <li class="nav-item"><a href="{{ route('eventos') }}" class="nav-link text-white px-3">Eventos & Servicios</a></li>
        <li class="nav-item"><a href="{{ route('atracciones') }}" class="nav-link text-white px-3">Atracciones</a></li>
        <li class="nav-item"><a href="{{ route('promociones') }}" class="nav-link text-white px-3">Promociones</a></li>
      </ul>

      <ul class="navbar-nav align-items-center">
        @guest
        <li class="nav-item">
          <a href="{{ route('login') }}" class="user-nav-wrapper">
            <span class="user-nav-icon"><i class="bi bi-person-circle"></i></span>
            <span class="user-text-stack">
                <span class="user-main-title">Iniciar Sesión</span>
            </span>
          </a>
        </li>
        @endguest

        @auth
        <li class="nav-item dropdown">
          <a class="dropdown-toggle user-nav-wrapper" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="user-nav-icon"><i class="bi bi-person-check-fill"></i></span>
            <div class="user-text-stack">
                <span class="user-main-title">{{ Auth::user()->name }}</span>
                <span class="user-subtitle">Gestionar cuenta</span>
            </div>
          </a>
          
          <ul class="dropdown-menu dropdown-menu-end shadow dropdown-menu-custom">
            <li>
                <a class="dropdown-item dropdown-item-custom" href="{{ route('cliente.panel') }}">
                    <i class="bi bi-grid-1x2-fill"></i> Mi Panel de Reservas
                </a>
            </li>
            
            <li class="dropdown-divider-custom"></li>

            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item dropdown-item-custom text-danger w-100 text-start border-0 bg-transparent">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </button>
              </form>
            </li>
          </ul>
        </li>
        @endauth
      </ul>

    </div>
  </div>
</nav>

<main class="container-fluid px-0" style="margin-top:110px;">
  @yield('content')
</main>

<footer class="bg-dark text-light py-4 text-center mt-5">
  <p class="mb-1">Teléfono: +591 4 44 89 520 | Email: info@hotelnewhorizon.bo</p>
  <p class="mb-3">Dirección: Cochabamba, Bolivia</p>
  <p class="mt-3 mb-0">&copy; 2025 Hotel New Horizon</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>