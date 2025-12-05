<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    try {
        DB::connection()->getPdo();
        return "<h1 style='color: green;'>✔ Conectado correctamente a la Base de Datos</h1>";
    } catch (\Exception $e) {
        return "<h1 style='color: red;'>✘ Error al conectar a la Base de Datos</h1><br>" . $e->getMessage();
    }
});


