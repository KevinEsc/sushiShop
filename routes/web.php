<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\Admin\ProductoController;

// ─── PÁGINAS PÚBLICAS ─────────────────────────────────────────────────────────
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/tienda', [PublicController::class, 'tienda'])->name('tienda');
Route::get('/contacto', [PublicController::class, 'contacto'])->name('contacto');

// ─── AUTENTICACIÓN ────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ─── PEDIDOS (solo usuarios autenticados) ────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/pedido', [PedidoController::class, 'index'])->name('pedido.index');
    Route::post('/pedido/whatsapp', [PedidoController::class, 'generarWhatsApp'])->name('pedido.whatsapp');
});

// ─── ADMIN DASHBOARD (solo administradores) ──────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('dashboard');
    Route::get('/productos/crear', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{producto}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
});
