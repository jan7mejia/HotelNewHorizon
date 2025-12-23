<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\ReservasEvento;
use Illuminate\Support\Facades\Auth;

class EventosController extends Controller
{
    public function index()
    {
        $eventos = Evento::all();
        return view('eventos', compact('eventos'));
    }

    public function reservar(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para reservar.');
        }

        $evento = Evento::findOrFail($request->id_evento);

        // Validación de seguridad para la cantidad de personas
        $cantidadSolicitada = intval($request->cantidad_personas);
        if ($cantidadSolicitada <= 0 || $cantidadSolicitada > $evento->capacidad) {
            return back()->with('error', 'Cantidad de personas no válida o supera el cupo disponible.');
        }

        if ($evento->tipo === 'salon') {
            $existe = ReservasEvento::where('id_evento', $evento->id_evento)
                ->whereDate('fecha_evento', $request->fecha_evento)
                ->where('pago_confirmado', 1)
                ->exists();

            if ($existe) {
                return back()->with('error', 'Lo sentimos, el salón ya está reservado para esa fecha.');
            }

            $cantidadPersonas = $evento->capacidad; 
            $totalBs = $evento->precio;
        } else {
            $cantidadPersonas = $cantidadSolicitada;
            $totalBs = $evento->precio * $cantidadPersonas;
        }

        $reserva = ReservasEvento::create([
            'id_usuario'        => Auth::id(),
            'id_evento'         => $evento->id_evento,
            'fecha_evento'      => $request->fecha_evento,
            'cantidad_personas' => $cantidadPersonas,
            'total_pagado'      => $totalBs,
            'estado'            => 'pendiente',
            'metodo_pago'       => 'paypal',
            'pago_confirmado'   => 0
        ]);

        $totalUSD = round($totalBs / 6.96, 2);
        return view('paypal_evento', compact('reserva', 'totalBs', 'totalUSD'));
    }

    public function confirmarPago($id)
    {
        $reserva = ReservasEvento::findOrFail($id);
        
        if ($reserva->pago_confirmado == 1) {
            return redirect()->route('eventos');
        }

        // 1. Confirmar la reserva
        $reserva->update([
            'estado' => 'confirmada',
            'pago_confirmado' => 1
        ]);

        // 2. DESCONTAR CAPACIDAD DE LA BASE DE DATOS
        $evento = Evento::find($reserva->id_evento);
        if ($evento->tipo === 'buffet') {
            $nuevaCapacidad = $evento->capacidad - $reserva->cantidad_personas;
            
            // Si llega a 0, lo ponemos como no disponible
            $nuevoEstado = ($nuevaCapacidad <= 0) ? 'no_disponible' : 'disponible';
            
            $evento->update([
                'capacidad' => max(0, $nuevaCapacidad),
                'estado' => $nuevoEstado
            ]);
        }

        return redirect()->route('eventos')->with('success', '¡Reserva confirmada y cupos actualizados!');
    }
}