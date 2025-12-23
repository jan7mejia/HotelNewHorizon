@extends('layouts.app')

@section('content')

<style>
/* ===== ESTILOS BASE (COPIA EXACTA EVENTOS) ===== */
body {
    background-color: #000 !important;
}

.hero-banner {
    position: relative;
    width: 100%;
    min-height: 500px;
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                url('{{ asset('img/bannerH.jpg') }}') center/cover no-repeat;
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

/* ===== TARJETAS (ESTÁTICAS - SIN HOVER) ===== */
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
    color: #c2c2c2;
    font-size: .95rem;
    line-height: 1.6;
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

/* ===== FORMULARIO Y ALERTAS (COPIA EVENTOS) ===== */
.form-control { 
    background-color: #fff !important; 
    color: #000 !important; 
    border-radius: 4px;
}

.error-msg {
    color: #ff4d4d;
    font-size: 0.85rem;
    margin-top: 5px;
    display: none;
}

.modal-content {
    border-radius: 15px;
    border: 1px solid #444;
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
            <h1>HOTEL NEW HORIZON</h1>
            <p>Elegancia contemporánea y hospitalidad boliviana</p>
        </div>
    </section>

    {{-- SECCIÓN DE LISTADO --}}
    <section id="habitaciones" class="py-5">
        <div class="container">
            
            <h2 class="text-center section-title">Nuestras Habitaciones</h2>
            <div class="divider"></div>

            <div class="row g-4">
                @foreach($rooms as $room)
                    @php $disponibles = max(0, $room->stock); @endphp

                    <div class="col-md-6 col-lg-4">
                        <div class="pro-card d-flex flex-column text-light">
                            
                            <div style="overflow:hidden; height:250px;">
                                <img src="{{ asset('img/'.$room->imagen) }}" alt="{{ $room->nombre }}">
                            </div>

                            <div class="card-body">
                                <h5>{{ $room->nombre }}</h5>
                                <p>{{ Str::limit($room->descripcion, 100) }}</p>
                                
                                <div class="mb-3">
                                    <p class="mb-1"><b>Precio:</b> Bs. {{ number_format($room->precio, 2) }}</p>
                                    <p class="mb-1"><b>Capacidad:</b> {{ $room->capacidad }} personas</p>
                                    <p class="mb-1"><b>Disponibles:</b> {{ $disponibles }}</p>
                                </div>

                                <div class="mt-auto pt-2">
                                    @auth
                                        @if($disponibles > 0)
                                            <button class="btn btn-primary w-100 fw-bold py-2" data-bs-toggle="modal" data-bs-target="#modalHab{{ $room->id_habitacion }}">
                                                Reservar Ahora
                                            </button>
                                        @else
                                            <button class="btn btn-danger w-100 py-2" disabled>No Disponible</button>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-warning w-100 fw-semibold py-2">Inicia sesión</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL (ESTRUCTURA VISUAL DE EVENTOS) --}}
                    @auth
                    <div class="modal fade" id="modalHab{{ $room->id_habitacion }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content bg-dark text-light">
                                <form method="POST" action="{{ route('habitaciones.reservar') }}" class="form-reserva-hab"
                                    data-precio="{{ $room->precio }}" 
                                    data-capacidad="{{ $room->capacidad }}" 
                                    data-stock="{{ $disponibles }}">
                                    @csrf
                                    <input type="hidden" name="id_habitacion" value="{{ $room->id_habitacion }}">
                                    
                                    <div class="modal-header border-secondary">
                                        <h5 class="modal-title">Reservar {{ $room->nombre }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="mb-2 fw-bold">Fecha llegada</label>
                                            <input type="date" name="fecha_llegada" class="form-control f-llegada" min="{{ date('Y-m-d') }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="mb-2 fw-bold">Fecha salida</label>
                                            <input type="date" name="fecha_salida" class="form-control f-salida" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="mb-2 fw-bold">Habitaciones (Máx: {{ $disponibles }})</label>
                                            <input type="number" name="cantidad_habitaciones" class="form-control c-hab" min="1" max="{{ $disponibles }}" value="1" required>
                                            <div class="error-msg m-hab">Stock insuficiente.</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="mb-2 fw-bold">Total Huéspedes</label>
                                            <input type="number" name="cantidad_huespedes" class="form-control c-hues" min="1" value="1" required>
                                            <div class="error-msg m-hues">Excede capacidad.</div>
                                        </div>

                                        {{-- CAJA DE PRECIO IGUAL A EVENTOS --}}
                                        <div class="p-3 mt-4" style="background: rgba(255,255,255,0.05); border-radius: 10px;">
                                            <p class="text-center mb-1 small" style="color: #aaa;">Total a pagar</p>
                                            <h3 class="text-center text-success fw-bold mb-0 display-total">Bs. 0.00</h3>
                                        </div>
                                    </div>

                                    <div class="modal-footer border-secondary">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success fw-bold btn-submit">Confirmar</button>
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

{{-- LÓGICA DE CÁLCULO --}}
<script>
document.addEventListener('input', function(e) {
    const form = e.target.closest('.form-reserva-hab');
    if (!form) return;

    const precio = parseFloat(form.dataset.precio);
    const capMax = parseInt(form.dataset.capacidad);
    const stockMax = parseInt(form.dataset.stock);

    const llegada = form.querySelector('.f-llegada').value;
    const salida = form.querySelector('.f-salida');
    const nHab = parseInt(form.querySelector('.c-hab').value) || 0;
    const nHues = parseInt(form.querySelector('.c-hues').value) || 0;
    const txtTotal = form.querySelector('.display-total');
    const btn = form.querySelector('.btn-submit');

    if (e.target.classList.contains('f-llegada')) {
        salida.min = llegada;
    }

    let esValido = true;

    // Validar Stock
    if (nHab > stockMax || nHab < 1) { 
        esValido = false; 
        form.querySelector('.m-hab').style.display = 'block'; 
    } else { 
        form.querySelector('.m-hab').style.display = 'none'; 
    }

    // Validar Capacidad
    if (nHues > (nHab * capMax) || nHues < 1) { 
        esValido = false; 
        form.querySelector('.m-hues').style.display = 'block'; 
    } else { 
        form.querySelector('.m-hues').style.display = 'none'; 
    }

    // Calcular Total
    if (llegada && salida.value && nHab > 0) {
        let d1 = new Date(llegada);
        let d2 = new Date(salida.value);
        let noches = Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24));
        
        if (noches > 0) {
            let total = noches * precio * nHab;
            txtTotal.textContent = "Bs. " + total.toLocaleString('es-BO', {minimumFractionDigits: 2});
        } else {
            txtTotal.textContent = "Bs. 0.00";
            esValido = false;
        }
    }

    btn.disabled = !esValido;
});
</script>

@endsection