@extends('layouts.app')

@section('content')

<style>
/* ===== BANNER PRINCIPAL (UNIFICADO 500PX) ===== */
.hero-banner {
    position: relative;
    width: 100%;
    min-height: 500px; 
    /* Imagen específica de promociones con filtro oscuro */
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                url('{{ asset('img/bannerP.jpg') }}') center/cover no-repeat;
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

/* ===== TARJETAS PROFESIONALES ===== */
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

.pro-card img {
    height: 250px;
    object-fit: cover;
    width: 100%;
    display: block;
    transition: transform 0.5s ease;
}

.pro-card:hover img {
    transform: scale(1.05);
}

.pro-card .card-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
}

.pro-card h5 {
    font-weight: 600;
    margin-bottom: .6rem;
    font-size: 1.3rem;
    color: #fff;
}

.pro-card p, .pro-card b {
    color: #c2c2c2;
    font-size: .95rem;
    line-height: 1.6;
    margin-bottom: 0.5rem;
}

/* ===== TÍTULOS Y DIVISORES ===== */
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

/* Nota de advertencia dentro del modal */
.alert-warning-custom {
    background-color: rgba(255, 243, 205, 0.1);
    color: #ffda6a;
    border: 1px solid #664d03;
    padding: 10px;
    border-radius: 8px;
    font-size: 0.9rem;
    margin-top: 10px;
}

.form-control { background-color: #fff !important; color: #000 !important; }

body {
    background-color: #000 !important;
}

@media (max-width: 768px) {
    .hero-banner { min-height: 400px; }
    .hero-content h1 { font-size: 2.5rem; }
}
</style>

<div style="background-color: #000; min-height: 100vh;">

    {{-- BANNER HERO --}}
    <section class="hero-banner">
        <div class="hero-content">
            <h1>PROMOCIONES</h1>
            <p>Ofertas exclusivas para una estancia perfecta</p>
        </div>
    </section>

    {{-- CONTENIDO --}}
    <section class="py-5">
        <div class="container">
            <h2 class="text-center section-title">Promociones Especiales</h2>
            <div class="divider"></div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4 justify-content-center">
                @foreach($promotions as $promo)
                    <div class="col-12 col-md-6"> 
                        <div class="pro-card text-light d-flex flex-column">
                            <div style="overflow:hidden; height:250px;">
                                <img src="{{ asset('img/'.$promo->imagen) }}" alt="{{ $promo->nombre }}">
                            </div>

                            <div class="card-body">
                                <h5>{{ $promo->nombre }}</h5>
                                <p>{{ Str::limit($promo->descripcion, 130) }}</p>
                                
                                <div class="mb-3">
                                    <p class="mb-1"><b>Precio:</b> Bs. {{ number_format($promo->precio, 2) }}</p>
                                    <p class="mb-1"><b>Duración:</b> {{ $promo->duracion_noches }} noche(s)</p>
                                    <p class="mb-1"><b>Disponibles:</b> {{ $promo->stock_actual }} unidades</p>
                                </div>

                                <div class="mt-auto pt-2">
                                    @auth
                                        @if($promo->stock_actual > 0)
                                            <button class="btn btn-primary w-100 fw-bold py-2" data-bs-toggle="modal" data-bs-target="#modal{{ $promo->id_promocion }}">
                                                Reservar Promoción
                                            </button>
                                        @else
                                            <button class="btn btn-danger w-100 py-2" disabled>No Disponible</button>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-warning w-100 fw-semibold py-2">Inicia sesión para reservar</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL --}}
                    @auth
                    <div class="modal fade" id="modal{{ $promo->id_promocion }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark text-light" style="border-radius: 15px; border: 1px solid #444;">
                                <form method="POST" action="{{ route('promociones.reservar') }}">
                                    @csrf
                                    <div class="modal-header border-secondary">
                                        <h5 class="modal-title">Reservar {{ $promo->nombre }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body text-start">
                                        <input type="hidden" name="id_promocion" value="{{ $promo->id_promocion }}">
                                        
                                        <div class="mb-3">
                                            <label class="mb-2 fw-bold">¿Cuándo deseas iniciar?</label>
                                            <input type="date" name="fecha_inicio" class="form-control date-check" 
                                                data-promo-name="{{ strtolower($promo->nombre) }}"
                                                min="{{ date('Y-m-d') }}" required>
                                            
                                            <p class="mt-2 mb-0 small" style="color: #aaa;">
                                                Incluye {{ $promo->duracion_noches }} noche(s) de estadía.
                                            </p>

                                            @if(str_contains(strtolower($promo->nombre), 'fin de semana'))
                                                <div class="alert-warning-custom">
                                                    <i class="fas fa-info-circle"></i> Válido iniciando los días sábados.
                                                </div>
                                            @endif
                                        </div>

                                        <div class="p-3 mt-4" style="background: rgba(255,255,255,0.05); border-radius: 10px;">
                                            <p class="text-center mb-1 small" style="color: #aaa;">Total a pagar</p>
                                            <h3 class="text-center text-success fw-bold mb-0">
                                                Bs. {{ number_format($promo->precio, 2) }}
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="modal-footer border-secondary">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success fw-bold">Confirmar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endauth
                @endforeach
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Quitar paddings de main
    const mainElement = document.querySelector('main');
    if(mainElement) { mainElement.style.padding = "0"; }

    // 2. Unir footer
    const footer = document.querySelector('footer');
    if(footer) {
        footer.style.marginTop = "0";
        footer.style.backgroundColor = "#111";
        footer.style.borderTop = "1px solid #222";
    }

    // 3. Validación de fechas
    const dateInputs = document.querySelectorAll('.date-check');
    dateInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (!this.value) return;
            const dateParts = this.value.split('-');
            const selectedDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
            const day = selectedDate.getDay(); 
            const promoName = this.getAttribute('data-promo-name');

            if (promoName.includes('fin de semana') && day !== 6) {
                alert('Atención: Esta promoción solo es válida iniciando los días Sábados.');
                this.value = '';
            }
        });
    });
});
</script>

@endsection