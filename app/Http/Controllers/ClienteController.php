<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ReservasHabitacion;
use App\Models\ReservasPromocione;
use App\Models\ReservasEvento;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $usuarioId = Auth::id();

        // Habitaciones: ordenar por id_reserva si existe, sino solo get()
        $reservasHabitaciones = ReservasHabitacion::where('id_usuario', $usuarioId)
            ->when(\Schema::hasColumn('reservas_habitacion', 'fecha_creacion'), function($query) {
                $query->orderBy('fecha_creacion', 'desc');
            })
            ->get();

        // Promociones: ordenar por id_promocion si existe
        $reservasPromociones = ReservasPromocione::where('id_usuario', $usuarioId)
            ->when(\Schema::hasColumn('reservas_promociones', 'id_reserva'), function($query) {
                $query->orderBy('id_reserva', 'desc');
            })
            ->get();

        // Eventos: ordenar por id_evento si existe
        $reservasEventos = ReservasEvento::where('id_usuario', $usuarioId)
            ->when(\Schema::hasColumn('reservas_eventos', 'id_reserva'), function($query) {
                $query->orderBy('id_reserva', 'desc');
            })
            ->get();

        return view('cliente.panel', compact(
            'reservasHabitaciones',
            'reservasPromociones',
            'reservasEventos'
        ));
    }
}
