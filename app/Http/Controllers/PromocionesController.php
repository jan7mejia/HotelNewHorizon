<?php

namespace App\Http\Controllers;

use App\Models\Promocione;
use App\Models\ReservasPromocione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PromocionesController extends Controller
{
    public function index()
    {
        $promotions = Promocione::orderBy('id_promocion', 'desc')->get();
        return view('promociones', compact('promotions'));
    }

    public function reservar(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        $promo = Promocione::findOrFail($request->id_promocion);
        $fechaInicio = Carbon::parse($request->fecha_inicio);
        
        // 1. Validar Stock
        if ($promo->stock_actual <= 0) {
            return redirect()->route('promociones')->with('error', 'Sin cupos disponibles.');
        }

        // 2. REGLA: Validación de Sábado para "Fin de Semana"
        if (str_contains(strtolower($promo->nombre), 'fin de semana')) {
            if ($fechaInicio->dayOfWeek !== Carbon::SATURDAY) {
                return redirect()->route('promociones')->with('error', 'Esta promoción solo inicia en Sábado.');
            }
        }

        // 3. REGLA: Solo dejamos pasar a PayPal si NO tiene una reserva ya PAGADA (confirmada) ese día.
        // Quitamos el estado 'pendiente' de la validación para que si no pagó, pueda volver a intentar.
        $yaTienePagoConfirmado = ReservasPromocione::where('id_usuario', Auth::id())
            ->whereDate('fecha_inicio', $fechaInicio->format('Y-m-d'))
            ->where('estado', 'confirmada') 
            ->exists();

        if ($yaTienePagoConfirmado) {
            return redirect()->route('promociones')->with('error', 'Ya tienes una reserva confirmada para esta fecha.');
        }

        // NO GUARDAMOS EN BD AQUÍ. 
        // Pasamos los datos necesarios a la vista de PayPal.
        $totalUSD = round($promo->precio / 6.96, 2);
        $datosReserva = [
            'id_promocion' => $promo->id_promocion,
            'fecha_inicio' => $fechaInicio->format('Y-m-d'),
            'fecha_fin' => $fechaInicio->copy()->addDays($promo->duracion_noches)->format('Y-m-d'),
            'precio' => $promo->precio
        ];

        return view('paypal_promocion', compact('promo', 'totalUSD', 'datosReserva'));
    }

    // Esta función la llamará PayPal mediante JS cuando el pago sea EXITOSO
    public function confirmarPagoExitoso(Request $request) {
        $reserva = ReservasPromocione::create([
            'id_usuario' => Auth::id(),
            'id_promocion' => $request->id_promocion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => 'confirmada', // Se guarda directamente como confirmada
            'metodo_pago' => 'paypal',
            'pago_confirmado' => 1,
            'total_pagado' => $request->total_pagado,
            'fecha_creacion' => now()
        ]);

        return response()->json(['success' => true, 'reserva_id' => $reserva->id_reserva_promocion]);
    }
}