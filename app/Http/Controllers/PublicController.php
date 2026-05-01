<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Página de inicio.
     */
    public function home()
    {
        $destacados = Producto::activos()
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('home', compact('destacados'));
    }

    /**
     * Página de tienda / menú completo.
     */
    public function tienda(Request $request)
    {
        $categoriaActiva = $request->get('categoria', 'todos');
        $categorias = Producto::categorias();

        $query = Producto::activos()->orderBy('nombre');

        if ($categoriaActiva !== 'todos') {
            $query->where('categoria', $categoriaActiva);
        }

        $productos = $query->get();

        return view('tienda', compact('productos', 'categorias', 'categoriaActiva'));
    }

    /**
     * Página de contacto.
     */
    public function contacto()
    {
        return view('contacto');
    }
}
