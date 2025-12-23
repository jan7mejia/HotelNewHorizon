<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacione;
use App\Models\ReservasHabitacion;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HabitacionesController extends Controller
{
    public function index()
    {
        $rooms = Habitacione::orderBy('id_habitacion', 'asc')->get();
        return view('habitaciones', compact('rooms'));
    }

    public function guardarReserva(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'id_habitacion' => 'required|exists:habitaciones,id_habitacion',
            'fecha_llegada' => 'required|date|after_or_equal:today',
            'fecha_salida' => 'required|date|after:fecha_llegada',
            'cantidad_habitaciones' => 'required|integer|min:1',
            'cantidad_huespedes' => 'required|integer|min:1'
        ]);

        $habitacion = Habitacione::findOrFail($request->id_habitacion);

        // MEJORA: Validar contra el stock actual real
        if ($request->cantidad_habitaciones > $habitacion->stock) {
            return back()->with('error', 'Lo sentimos, solo quedan ' . $habitacion->stock . ' habitaciones disponibles.');
        }

        $capacidadMax = $habitacion->capacidad * $request->cantidad_habitaciones;
        if ($request->cantidad_huespedes > $capacidadMax) {
            return back()->with('error', 'La cantidad de huéspedes supera la capacidad permitida.');
        }

        $dias = Carbon::parse($request->fecha_llegada)->diffInDays(Carbon::parse($request->fecha_salida));
        $totalBs = $habitacion->precio * $request->cantidad_habitaciones * $dias;
        $totalUSD = round($totalBs / 6.96, 2);

        $reserva = ReservasHabitacion::create([
            'id_usuario' => Auth::id(),
            'id_habitacion' => $habitacion->id_habitacion,
            'fecha_llegada' => $request->fecha_llegada,
            'fecha_salida' => $request->fecha_salida,
            'cantidad_huespedes' => $request->cantidad_huespedes,
            'cantidad_habitaciones' => $request->cantidad_habitaciones,
            'total_pagado' => $totalBs,
            'estado' => 'pendiente',
            'metodo_pago' => 'paypal',
            'pago_confirmado' => 0
        ]);

        return view('paypal_checkout', compact('reserva', 'totalBs', 'totalUSD'));
    }

    public function confirmarPago($id_reserva)
    {
        $reserva = ReservasHabitacion::findOrFail($id_reserva);

        if ($reserva->pago_confirmado) {
            return redirect()->route('habitaciones');
        }

        // 1. Confirmar pago
        $reserva->update([
            'pago_confirmado' => 1,
            'estado' => 'confirmada'
        ]);

        // 2. Descontar stock físico (Solo si no se ha descontado antes)
        $habitacion = Habitacione::find($reserva->id_habitacion);
        if($habitacion->stock >= $reserva->cantidad_habitaciones) {
            $habitacion->decrement('stock', $reserva->cantidad_habitaciones);
        }

        return redirect()->route('habitaciones')
            ->with('success', '¡Reserva confirmada y pago realizado con éxito!');
    }
}