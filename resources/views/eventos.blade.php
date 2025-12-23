@extends('layouts.app')

@section('content')

<style>
/* ===== ESTILOS BASE ===== */
body {
    background-color: #000 !important;
}

.hero-banner {
    position: relative;
    width: 100%;
    min-height: 500px; 
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                url('{{ asset('img/bannerE.jpg') }}') center/cover no-repeat;
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

/* ===== TARJETAS ESTÁTICAS ===== */
.pro-card {
    background: #1e1e1e;
    border: 1px solid #2e2e2e;
    border-radius: 14px;
    overflow: hidden;
    height: 100%;
}

.pro-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    display: block;
}

.pro-card .card-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
}

.pro-card h5 {
    font-weight: 600;
    margin-bottom: .6rem;
    font-size: 1.2rem;
    color: #fff;
}

.pro-card p, .pro-card b {
    color: #c2c2c2; /* Color de letra estándar solicitado */
    font-size: .95rem;
    line-height: 1.6;
}

/* ===== TÍTULOS ===== */
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

/* ===== MODAL Y FORMULARIO (ESTILO SEGÚN CAPTURA) ===== */
.modal-content {
    background-color: #212529 !important; /* Fondo oscuro del modal */
    border-radius: 12px;
    border: 1px solid #333;
}

.modal-header {
    border-bottom: 1px solid #333;
}

.modal-footer {
    border-top: 1px solid #333;
}

.form-label-custom {
    color: #fff;
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
}

.form-control-custom {
    background-color: #fff !important;
    color: #000 !important;
    border: none;
    border-radius: 6px;
    padding: 10px;
}

.total-box {
    background-color: #2b3035;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    margin-top: 20px;
}

.display-total {
    color: #28a745 !important; /* Color verde para el monto */
    font-weight: 800;
    margin: 0;
}

@media (max-width: 768px) {
    .hero-banner { min-height: 400px; }
    .hero-content h1 { font-size: 2.5rem; }
}
</style>

<div style="background-color: #000; min-height: 100vh;">

    <section class="hero-banner">
        <div class="hero-content">
            <h1>EVENTOS</h1>
            <p>Momentos inolvidables en el mejor ambiente</p>
        </div>
    </section>

    <section id="eventos" class="py-5">
        <div class="container">
            
            <h2 class="text-center section-title">Nuestros Eventos</h2>
            <div class="divider"></div>

            <div class="row g-4 justify-content-center">
                @foreach($eventos as $evento)
                    @php 
                        $disponible = ($evento->estado === 'disponible' && $evento->capacidad > 0);
                    @endphp

                    <div class="col-md-6 col-lg-4">
                        <div class="pro-card d-flex flex-column text-light">
                            
                            <div style="overflow:hidden; height:250px;">
                                <img src="{{ asset('img/'.$evento->imagen) }}" alt="{{ $evento->nombre }}">
                            </div>
                            
                            <div class="card-body">
                                <h5>{{ $evento->nombre }}</h5>
                                <p>{{ Str::limit($evento->descripcion, 100) }}</p>
                                
                                <div class="mb-3">
                                    <p class="mb-1"><b>Tipo:</b> {{ ucfirst($evento->tipo) }}</p>
                                    <p class="mb-1"><b>Precio:</b> Bs. {{ number_format($evento->precio, 2) }} {{ $evento->tipo == 'buffet' ? '/ pers.' : '' }}</p>
                                    
                                    @if($evento->tipo === 'buffet')
                                        <p class="mb-1"><b>Cupos Restantes:</b> {{ $evento->capacidad }}</p>
                                    @else
                                        <p class="mb-1"><b>Salón Privado</b> (Cap. {{ $evento->capacidad }})</p>
                                    @endif
                                </div>

                                <div class="mt-auto pt-2">
                                    @auth
                                        @if($disponible)
                                            <button class="btn btn-primary w-100 fw-bold py-2" data-bs-toggle="modal" data-bs-target="#modalEvento{{ $evento->id_evento }}">
                                                Reservar
                                            </button>
                                        @else
                                            <button class="btn btn-danger w-100 py-2" disabled>Agotado / No Disponible</button>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-warning w-100 fw-semibold py-2">Inicia sesión</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL --}}
                    @auth
                    <div class="modal fade" id="modalEvento{{ $evento->id_evento }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('eventos.reservar') }}" class="form-evento">
                                    @csrf
                                    <input type="hidden" name="id_evento" value="{{ $evento->id_evento }}">
                                    
                                    <div class="modal-header">
                                        <h5 class="modal-title text-white">Reservar {{ $evento->nombre }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body text-start">
                                        <div class="mb-3">
                                            <label class="form-label-custom">Fecha del Evento</label>
                                            <input type="date" name="fecha_evento" class="form-control form-control-custom" min="{{ date('Y-m-d') }}" required>
                                        </div>

                                        @if($evento->tipo === 'buffet')
                                            <div class="mb-3">
                                                <label class="form-label-custom">Cantidad de Personas (Máx: {{ $evento->capacidad }})</label>
                                                <input type="number" name="cantidad_personas" class="form-control form-control-custom input-qty" 
                                                       data-precio="{{ $evento->precio }}" 
                                                       data-max="{{ $evento->capacidad }}"
                                                       min="1" max="{{ $evento->capacidad }}" value="1" required>
                                            </div>
                                        @else
                                            <div class="mb-3">
                                                <label class="form-label-custom">Confirmación</label>
                                                <input type="hidden" name="cantidad_personas" value="1">
                                                <p style="color: #aaa; font-size: 0.9rem;">Se reservará el salón completo por el precio establecido.</p>
                                            </div>
                                        @endif

                                        <div class="total-box">
                                            <p style="color: #aaa; font-size: 0.85rem; margin-bottom: 5px;">Total a pagar</p>
                                            <h3 class="display-total">
                                                Bs. {{ number_format($evento->precio, 2) }}
                                            </h3>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success px-4 fw-bold">Confirmar Reserva</button>
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
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('input-qty')) {
        const input = e.target;
        const max = parseInt(input.dataset.max);
        const precio = parseFloat(input.dataset.precio);
        const form = input.closest('.form-evento');
        const display = form.querySelector('.display-total');

        if (parseInt(input.value) > max) {
            input.value = max;
        }
        if (parseInt(input.value) < 1) {
            input.value = 1;
        }
        
        const cantidad = parseInt(input.value) || 0;
        const total = precio * cantidad;
        display.textContent = 'Bs. ' + total.toLocaleString('es-BO', {minimumFractionDigits: 2});
    }
});
</script>

@endsection