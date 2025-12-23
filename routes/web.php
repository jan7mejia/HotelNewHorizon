<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HabitacionesController;
use App\Http\Controllers\AreasComunesController;
use App\Http\Controllers\AtraccionesController;
use App\Http\Controllers\PromocionesController;
use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EventosController;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/habitaciones', [HabitacionesController::class, 'index'])->name('habitaciones');
Route::get('/areas-comunes', [AreasComunesController::class, 'index'])->name('areas_comunes');
Route::get('/atracciones', [AtraccionesController::class, 'index'])->name('atracciones');
Route::get('/promociones', [PromocionesController::class, 'index'])->name('promociones');
Route::get('/eventos', [EventosController::class, 'index'])->name('eventos');

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::get('/login', [AutenticacionController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [AutenticacionController::class, 'iniciarSesion'])->name('login.submit');
Route::post('/registro', [AutenticacionController::class, 'registrarCuenta'])->name('registro.submit');
Route::post('/logout', [AutenticacionController::class, 'cerrarSesion'])->name('logout');

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (SOLO USUARIOS LOGUEADOS)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // 📌 PANEL DEL CLIENTE (VISTA: views/cliente/panel.blade.php)
    Route::get('/panel-cliente', [ClienteController::class, 'index'])->name('cliente.panel');

    // HABITACIONES
    Route::post('/habitaciones/reservar', [HabitacionesController::class, 'guardarReserva'])->name('habitaciones.reservar');
    Route::get('/habitaciones/confirmar/{id}', [HabitacionesController::class, 'confirmarPago'])->name('habitaciones.confirmar');

    // PROMOCIONES
    Route::get('/promociones/reservar/{id}', [PromocionesController::class, 'reservarForm'])->name('promociones.reservar.form');
    Route::post('/promociones/reservar', [PromocionesController::class, 'reservar'])->name('promociones.reservar');
    Route::get('/promociones/confirmar/{id}', [PromocionesController::class, 'confirmarPago'])->name('promociones.confirmar');
    Route::get('/promociones/cancelar/{id}', [PromocionesController::class, 'cancelarPago'])->name('promociones.cancelar');
    Route::post('/promociones/confirmar-pago', [PromocionesController::class, 'confirmarPagoExitoso'])->name('promociones.confirmar_pago');
    
    // EVENTOS
    Route::post('/eventos/reservar', [EventosController::class, 'reservar'])->name('eventos.reservar');
    Route::get('/eventos/confirmar/{id}', [EventosController::class, 'confirmarPago']);
});