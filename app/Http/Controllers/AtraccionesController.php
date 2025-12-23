<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atraccione;

class AtraccionesController extends Controller
{
    /**
     * Mostrar la página de atracciones cercanas.
     */
    public function index()
    {
        $attractions = Atraccione::orderBy('id_atraccion','asc')->get();

        return view('atracciones', compact('attractions'));
    }
}
