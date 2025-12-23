<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AreasComune;
use App\Models\Habitacione;
use App\Models\Promocione;
use App\Models\Atraccione;

class HomeController extends Controller
{
    /**
     * Mostrar la página principal con datos desde la base de datos.
     */
    public function index()
    {
        // Imágenes del carrusel
        $carouselImages = ['1.png','2.png','3.png'];

        // SOLO 3 instalaciones
        $areas = AreasComune::orderBy('id_area', 'asc')
                            ->take(3)
                            ->get();

        // SOLO 3 habitaciones destacadas
        $rooms = Habitacione::orderBy('id_habitacion', 'desc')
                            ->take(3)
                            ->get();

        // Promociones (pueden ser más)
        $promotions = Promocione::orderBy('id_promocion', 'desc')
                                ->get();

        // SOLO 3 atracciones cercanas
        $attractions = Atraccione::orderBy('id_atraccion', 'asc')
                                 ->take(3)
                                 ->get();

        return view('home', compact(
            'carouselImages',
            'areas',
            'rooms',
            'promotions',
            'attractions'
        ));
    }
}
