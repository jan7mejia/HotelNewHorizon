@extends('layouts.app')

@section('content')
<style>
    /* 1. CONFIGURACIÓN GLOBAL */
    body, #app, main {
        background-color: #111 !important; 
        margin: 0 !important;
        padding: 0 !important;
    }

    /* 2. SOLUCIÓN DEFINITIVA: CARRUSEL A ANCHO COMPLETO SIN RECORTES */
    #heroCarousel {
        width: 100%;
        background-color: #000;
        margin: 0;
        padding: 0;
    }

    .carousel-inner {
        width: 100%;
    }

    .carousel-item {
        width: 100%;
        height: auto; /* La altura se adapta a la imagen original */
    }

    .carousel-item img {
        width: 100% !important; /* Ocupa todo el ancho de la página */
        height: auto !important; /* Mantiene la proporción original para NO CORTAR nada */
        display: block;
        object-fit: fill; /* Asegura que cubra de extremo a extremo */
    }

    /* Flechas del carrusel */
    .carousel-control-prev, .carousel-control-next {
        width: 5%;
        z-index: 10;
    }

    /* 3. CONFIGURACIÓN DE TARJETAS (Instalaciones, Habitaciones, etc.) */
    .img-container-fix {
        width: 100%;
        height: 220px;
        background-color: #2a2a2a;
        overflow: hidden;
        position: relative;
    }

    .pro-card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        display: block;
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    .img-loaded {
        opacity: 1 !important;
    }

    .pro-card {
        background: #1e1e1e;
        border: 1px solid #2e2e2e;
        border-radius: 14px;
        overflow: hidden;
        transition: transform .3s ease, box-shadow .3s ease;
        height: 100%;
    }

    .pro-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(0,0,0,.6);
    }

    .pro-card .card-body {
        padding: 1.5rem;
    }

    .section-title {
        font-size: 2.3rem;
        font-weight: 700;
        color: #fff;
    }

    .divider {
        width: 80px;
        height: 4px;
        background: #666;
        margin: 15px auto 35px;
        border-radius: 10px;
    }
</style>

<div style="background: #000; margin: 0; padding: 0;">

    {{-- Carrusel a Ancho Completo --}}
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($carouselImages as $i => $img)
                <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                    <img src="{{ asset('img/'.$img) }}" class="d-block w-100" alt="Banner {{ $i }}">
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    {{-- Sobre Nosotros --}}
    <section class="py-5 bg-dark text-light text-center">
        <div class="container">
            <h2 class="section-title">Sobre Nosotros</h2>
            <div class="divider"></div>
            <p class="fs-5 mx-auto" style="max-width:900px; line-height:1.7;">
                En <strong>Hotel New Horizon</strong> combinamos elegancia contemporánea con la hospitalidad boliviana para ofrecerte confort, modernidad y una experiencia inolvidable en Cochabamba.
            </p>
        </div>
    </section>

    {{-- Nuestras Instalaciones --}}
    <section class="py-5" style="background:#111;">
        <div class="container">
            <h2 class="text-center text-light section-title">Nuestras Instalaciones</h2>
            <div class="divider"></div>
            <div class="row g-4">
                @foreach($areas as $area)
                    <div class="col-md-4">
                        <div class="pro-card h-100 text-light">
                            <div class="img-container-fix">
                                <img src="{{ asset('img/'.$area->imagen) }}" class="lazy-img" onload="this.classList.add('img-loaded')">
                            </div>
                            <div class="card-body">
                                <h5>{{ $area->nombre }}</h5>
                                <p>{{ Str::limit($area->descripcion, 120) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Habitaciones Destacadas --}}
    <section class="py-5 bg-dark">
        <div class="container">
            <h2 class="text-center text-light section-title">Habitaciones Destacadas</h2>
            <div class="divider"></div>
            <div class="row g-4">
                @foreach($rooms as $room)
                    <div class="col-md-4">
                        <div class="pro-card h-100 text-light">
                            <div class="img-container-fix">
                                <img src="{{ asset('img/'.$room->imagen) }}" class="lazy-img" onload="this.classList.add('img-loaded')">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5>{{ $room->nombre }}</h5>
                                <p>{{ Str::limit($room->descripcion, 110) }}</p>
                                <p class="fw-bold text-light mt-2">Bs. {{ number_format($room->precio,2) }}</p>
                                <a href="{{ route('habitaciones') }}" class="btn btn-primary mt-auto w-100">Ver catálogo</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Promociones --}}
    <section class="py-5" style="background:#111;">
        <div class="container">
            <h2 class="text-center text-light section-title">Promociones</h2>
            <div class="divider"></div>
            <div class="row g-4">
                @foreach($promotions as $promo)
                    <div class="col-md-6">
                        <div class="pro-card h-100 text-light">
                            <div class="img-container-fix">
                                <img src="{{ asset('img/'.$promo->imagen) }}" class="lazy-img" onload="this.classList.add('img-loaded')">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5>{{ $promo->nombre }}</h5>
                                <p>{{ Str::limit($promo->descripcion, 140) }}</p>
                                <p class="fw-bold mt-2">Bs. {{ $promo->precio ? number_format($promo->precio,2) : '—' }}</p>
                                <a href="{{ route('promociones') }}" class="btn btn-primary mt-auto w-100">Ver promociones</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Atracciones Cercanas --}}
    <section class="py-5 bg-dark">
        <div class="container">
            <h2 class="text-center text-light section-title">Atracciones Cercanas</h2>
            <div class="divider"></div>
            <div class="row g-4">
                @foreach($attractions as $attr)
                    <div class="col-md-4">
                        <div class="pro-card h-100 text-light">
                            <div class="img-container-fix">
                                <img src="{{ asset('img/'.$attr->imagen) }}" class="lazy-img" onload="this.classList.add('img-loaded')">
                            </div>
                            <div class="card-body">
                                <h5>{{ $attr->nombre }}</h5>
                                <p>{{ Str::limit($attr->descripcion, 130) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Eventos & Servicios --}}
    <section class="py-5" style="background:#111;">
        <div class="container">
            <h2 class="text-center text-light section-title">Eventos & Servicios</h2>
            <div class="divider"></div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="pro-card h-100 text-light">
                        <div class="img-container-fix">
                            <img src="{{ asset('img/evento1.jfif') }}" class="lazy-img" onload="this.classList.add('img-loaded')">
                        </div>
                        <div class="card-body">
                            <h5>Salones Equipados</h5>
                            <p>Espacios modernos para bodas, conferencias y eventos sociales.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pro-card h-100 text-light">
                        <div class="img-container-fix">
                            <img src="{{ asset('img/evento2.jfif') }}" class="lazy-img" onload="this.classList.add('img-loaded')">
                        </div>
                        <div class="card-body">
                            <h5>Servicio de Buffet</h5>
                            <p>Opciones gastronómicas elegantes para eventos corporativos.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pro-card h-100 text-light">
                        <div class="img-container-fix">
                            <img src="{{ asset('img/evento3.jfif') }}" class="lazy-img" onload="this.classList.add('img-loaded')">
                        </div>
                        <div class="card-body">
                            <h5>Paquetes Especiales</h5>
                            <p>Soluciones completas para celebraciones memorables.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ajustar el footer para que no deje espacios blancos
        const footer = document.querySelector('footer');
        if(footer) {
            footer.style.marginTop = "0";
            footer.style.backgroundColor = "#111";
            footer.style.borderTop = "1px solid #2e2e2e";
        }

        // Carga suave de imágenes
        document.querySelectorAll('.lazy-img').forEach(img => {
            if (img.complete) {
                img.classList.add('img-loaded');
            }
        });
    });
</script>
@endsection