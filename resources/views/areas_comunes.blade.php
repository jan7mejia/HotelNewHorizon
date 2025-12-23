@extends('layouts.app')

@section('content')

<style>
/* ===== BANNER PRINCIPAL (CON IMAGEN REAL) ===== */
.hero-banner {
    position: relative;
    width: 100%;
    min-height: 500px; 
    /* Usamos la imagen de áreas comunes con un filtro oscuro para que resalte el texto */
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                url('{{ asset('img/bannerA.jpg') }}') center/cover no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #fff;
    padding: 20px;
}

.hero-content h1 {
    font-size: 4rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 4px;
    margin-bottom: 10px;
    text-shadow: 2px 2px 10px rgba(0,0,0,0.8);
}

.hero-content p {
    font-size: 1.5rem;
    font-weight: 300;
    color: #f0f0f0;
    margin-bottom: 30px;
}

/* ===== TARJETAS (GRIS OSCURO PROFESIONAL) ===== */
.pro-card {
    background: #1e1e1e;
    border: 1px solid #2e2e2e;
    border-radius: 14px;
    overflow: hidden;
    height: 100%;
    transition: transform 0.3s ease, border-color 0.3s ease;
}

.pro-card:hover {
    transform: translateY(-5px);
    border-color: #555;
}

.img-container-fix {
    width: 100%;
    height: 250px;
    background-color: #1e1e1e;
    overflow: hidden;
}

.pro-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    display: block;
    transition: transform 0.5s ease;
}

.pro-card:hover img {
    transform: scale(1.05);
}

.pro-card .card-body {
    padding: 1.5rem;
}

.pro-card h5 {
    font-weight: 600;
    margin-bottom: .6rem;
    font-size: 1.2rem;
    color: #fff;
}

.pro-card p {
    color: #c2c2c2;
    font-size: .95rem;
    line-height: 1.6;
    margin-bottom: 0;
}

/* ===== TÍTULOS DE SECCIÓN ===== */
.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.divider {
    width: 80px;
    height: 4px;
    background: #fff; 
    margin: 15px auto 35px;
    border-radius: 10px;
}

/* Ajuste móvil */
@media (max-width: 768px) {
    .hero-banner { min-height: 400px; }
    .hero-content h1 { font-size: 2.5rem; }
    .hero-content p { font-size: 1.1rem; }
}

body {
    background-color: #000 !important;
}
</style>

<div style="background-color: #000; min-height: 100vh;">

    {{-- BANNER CON IMAGEN --}}
    <section class="hero-banner">
        <div class="hero-content">
            <h1>ÁREAS COMUNES</h1>
            <p>Espacios diseñados para tu confort y relajación</p>
        </div>
    </section>

    {{-- SECCIÓN DE LISTADO --}}
    <section id="areas" class="py-5">
        <div class="container">
            
            <h2 class="text-center section-title">Nuestros Espacios</h2>
            <div class="divider"></div>

            <div class="row g-4 justify-content-center">
                @foreach($areas as $area)
                    <div class="col-md-6 col-lg-4">
                        <div class="pro-card d-flex flex-column text-light">
                            
                            <div class="img-container-fix">
                                <img src="{{ asset('img/'.$area->imagen) }}" alt="{{ $area->nombre }}">
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h5>{{ $area->nombre }}</h5>
                                <p>{{ $area->descripcion }}</p>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</div>

{{-- SCRIPT PARA AJUSTES FINALES --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const footer = document.querySelector('footer');
        if(footer) {
            footer.style.marginTop = "0";
            footer.style.borderTop = "1px solid #222";
            footer.style.backgroundColor = "#111";
        }
        
        const mainContainer = document.querySelector('main.py-4');
        if(mainContainer) {
            mainContainer.classList.remove('py-4');
            mainContainer.style.padding = "0";
        }
    });
</script>

@endsection