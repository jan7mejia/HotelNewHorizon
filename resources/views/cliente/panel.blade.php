@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    body { background-color: #000; color: #fff; font-family: 'Segoe UI', sans-serif; }
    
    .panel-header {
        background: url('{{ asset("img/bannerPa.jpg") }}') center/cover;
        padding: 100px 0;
        border-bottom: 1px solid #333;
        text-align: center;
        margin-bottom: 30px;
        position: relative;
    }

    .panel-header h1 {
        text-shadow: 2px 2px 8px rgba(0,0,0,0.8);
    }
    .panel-header p {
        text-shadow: 1px 1px 5px rgba(0,0,0,0.8);
    }

    /* Navegación por Tabs */
    .nav-pills { justify-content: center; gap: 15px; margin-bottom: 40px; }
    .nav-pills .nav-link {
        color: #aaa;
        background: #1a1a1a;
        border: 1px solid #333;
        padding: 12px 25px;
        border-radius: 10px;
        transition: 0.3s;
    }
    .nav-pills .nav-link.active {
        background: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }

    /* Estilo de Tarjetas */
    .reserva-card {
        background: #111;
        border-radius: 15px;
        border: 1px solid #222;
        padding: 25px;
        height: 100%;
        transition: transform 0.3s;
        position: relative;
    }
    .reserva-card:hover { transform: translateY(-5px); border-color: #444; }

    .service-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 15px;
        display: block;
        color: #fff;
    }

    .label-text { font-size: 0.75rem; color: #666; text-transform: uppercase; margin-top: 15px; letter-spacing: 0.5px; }
    .value-text { font-size: 0.95rem; color: #ddd; display: flex; align-items: center; gap: 10px; margin-bottom: 5px; }
    .value-text i { color: #0d6efd; font-size: 1rem; }

    .divider { height: 1px; background: #222; margin: 20px 0; }

    .price-section { display: flex; justify-content: space-between; align-items: center; }
    .price-label { font-size: 0.8rem; color: #888; }
    .price-value { font-size: 1.5rem; font-weight: 800; }

    /* Colores por tipo */
    .border-hab { border-left: 5px solid #198754; }
    .border-eve { border-left: 5px solid #0dcaf0; }
    .border-pro { border-left: 5px solid #ffc107; }

    .badge-status {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 0.7rem;
        padding: 5px 12px;
        border-radius: 20px;
        background: rgba(255,255,255,0.05);
        border: 1px solid #333;
    }

    /* Estilo mejorado para el mensaje "No tienes reservas" */
    .no-reservas-msg {
        color: #fff !important; /* Blanco puro para máxima visibilidad */
        font-size: 1.1rem;
        font-weight: 500;
        letter-spacing: 0.5px;
        opacity: 0.9;
    }
</style>

<div class="panel-header">
    <div class="container">
        <h1 class="display-4 fw-bold text-white">Mi Panel de Usuario</h1>
        <p class="fs-5 text-white">Gestión de Reservas - New Horizon</p>
    </div>
</div>

<div class="container mb-5">
    <ul class="nav nav-pills" id="pills-tab" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="hab-tab" data-bs-toggle="pill" data-bs-target="#hab-content"><i class="bi bi-door-open me-2"></i>Habitaciones</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="eve-tab" data-bs-toggle="pill" data-bs-target="#eve-content"><i class="bi bi-calendar-event me-2"></i>Eventos</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="pro-tab" data-bs-toggle="pill" data-bs-target="#pro-content"><i class="bi bi-tag me-2"></i>Promociones</button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        
        {{-- TAB HABITACIONES --}}
        <div class="tab-pane fade show active" id="hab-content">
            <div class="row g-4">
                @forelse($reservasHabitaciones as $reserva)
                    <div class="col-md-6 col-lg-4">
                        <div class="reserva-card border-hab">
                            <span class="badge-status text-success">{{ ucfirst($reserva->estado) }}</span>
                            <span class="service-title">{{ $reserva->habitacion->nombre ?? 'Habitación Estandar' }}</span>
                            
                            <div class="label-text">Periodo de Estadía</div>
                            <div class="value-text"><i class="bi bi-calendar-range"></i> {{ $reserva->fecha_llegada }} al {{ $reserva->fecha_salida }}</div>
                            
                            <div class="label-text">Detalles de la Reserva</div>
                            <div class="value-text"><i class="bi bi-house-check"></i> {{ $reserva->cantidad_habitaciones }} Habitaciones</div>
                            <div class="value-text"><i class="bi bi-people"></i> {{ $reserva->cantidad_huespedes }} Huéspedes</div>
                            <div class="value-text"><i class="bi bi-hash"></i> Reserva #{{ $reserva->id_reserva }}</div>

                            <div class="divider"></div>
                            <div class="price-section">
                                <span class="price-label">Total Pagado:</span>
                                <span class="price-value text-success">Bs. {{ number_format($reserva->total_pagado, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="no-reservas-msg">No tienes reservas de habitaciones.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- TAB EVENTOS --}}
        <div class="tab-pane fade" id="eve-content">
            <div class="row g-4">
                @forelse($reservasEventos as $evento)
                    <div class="col-md-6 col-lg-4">
                        <div class="reserva-card border-eve">
                            <span class="badge-status text-info">{{ ucfirst($evento->estado) }}</span>
                            <span class="service-title">{{ $evento->evento->nombre ?? 'Servicio de Evento' }}</span>

                            <div class="label-text">Fecha programada</div>
                            <div class="value-text"><i class="bi bi-calendar-check"></i> {{ $evento->fecha_evento }}</div>

                            <div class="label-text">Asistencia</div>
                            <div class="value-text"><i class="bi bi-people"></i> {{ $evento->cantidad_personas }} Personas</div>

                            <div class="divider"></div>
                            <div class="price-section">
                                <span class="price-label">Total Pagado:</span>
                                <span class="price-value text-info">Bs. {{ number_format($evento->total_pagado, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="no-reservas-msg">No tienes eventos reservados.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- TAB PROMOCIONES --}}
        <div class="tab-pane fade" id="pro-content">
            <div class="row g-4">
                @forelse($reservasPromociones as $promo)
                    <div class="col-md-6 col-lg-4">
                        <div class="reserva-card border-pro">
                            <span class="badge-status text-warning">Canjeado</span>
                            
                            <span class="service-title">{{ $promo->promocione->nombre ?? 'Promoción' }}</span>

                            <div class="label-text">Vigencia del Paquete</div>
                            <div class="value-text"><i class="bi bi-clock-history"></i> {{ \Carbon\Carbon::parse($promo->fecha_inicio)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($promo->fecha_fin)->format('d/m/Y') }}</div>

                            <div class="label-text">Pago</div>
                            <div class="value-text"><i class="bi bi-credit-card-2-front"></i> Pagado vía {{ ucfirst($promo->metodo_pago) }}</div>

                            <div class="divider"></div>
                            <div class="price-section">
                                <span class="price-label">Total Final:</span>
                                <span class="price-value text-warning">Bs. {{ number_format($promo->total_pagado, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="no-reservas-msg">No has adquirido promociones.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection