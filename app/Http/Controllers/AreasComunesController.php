<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AreasComune;

class AreasComunesController extends Controller
{
    /**
     * Mostrar la página de Áreas Comunes con los datos de la base de datos.
     */
    public function index()
    {
        $areas = AreasComune::orderBy('id_area', 'asc')->get();

        return view('areas_comunes', compact('areas'));
    }
}
