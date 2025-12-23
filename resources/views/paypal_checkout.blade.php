@extends('layouts.app')

@section('content')
<section class="py-5" style="background-color:#0b0b0b; min-height: 90vh; display: flex; align-items: center;">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                
                <div class="mb-4 text-start">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-light small fw-bold">Paso 2 de 2: Finalizar Pago</span>
                        <span class="text-light small">100%</span>
                    </div>
                    <div class="progress" style="height: 6px; background-color: #333; border-radius: 10px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; box-shadow: 0 0 10px #007bff;"></div>
                    </div>
                </div>

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg" height="40" class="mb-3">
                        <h3 class="fw-bold text-primary mb-4">Pago Seguro</h3>
                        
                        <div class="p-4 bg-light rounded-3 mb-4 shadow-sm border">
                            <small class="text-muted d-block fw-bold">Monto en moneda local</small>
                            <span class="h4 fw-bold text-dark">Bs. {{ number_format($totalBs, 2) }}</span>
                            <div class="border-top mt-2 pt-2">
                                <small class="text-muted d-block fw-bold">Equivalente a pagar:</small>
                                <span class="h5 fw-bold text-primary">$ {{ $totalUSD }} USD</span>
                            </div>
                        </div>

                        <div id="paypal-button-container"></div>

                        <a href="{{ route('habitaciones') }}" class="btn btn-link mt-3 text-muted text-decoration-none small">
                            <i class="bi bi-arrow-left"></i> Cancelar y volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://www.paypal.com/sdk/js?client-id=AQpMYhOXIdrOrk6_vH0tC1FJrUKkVGiA_3sTsxgL67IxvqGpJ03LA7bHPipeVGQJv8nTOfpeQ_evPysE&currency=USD"></script>

<script>
    paypal.Buttons({
        style: { layout: 'vertical', color: 'gold', shape: 'rect', label: 'paypal' },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    description: "Reserva Hotel New Horizon #{{ $reserva->id_reserva }}",
                    amount: { currency_code: 'USD', value: '{{ $totalUSD }}' }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                document.querySelector('#paypal-button-container').innerHTML = 
                    '<div class="py-3 text-center"><div class="spinner-border text-primary"></div><p class="mt-2 fw-bold">¡Pago aceptado! Confirmando tu habitación...</p></div>';
                window.location.href = "{{ route('habitaciones.confirmar', $reserva->id_reserva) }}";
            });
        }
    }).render('#paypal-button-container');
</script>
@endsection