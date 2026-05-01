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

    /**
     * Procesar formulario de contacto.
     */
    public function contactoEnviar(Request $request)
    {
        $request->validate([
            'nombre'  => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'asunto'  => 'required|string|max:100',
            'mensaje' => 'required|string|max:2000',
        ], [
            'nombre.required'  => 'El nombre es obligatorio.',
            'email.required'   => 'El correo es obligatorio.',
            'email.email'      => 'Ingresa un correo válido.',
            'mensaje.required' => 'El mensaje no puede estar vacío.',
        ]);

        // Redirigir el mensaje por WhatsApp al admin
        $numero = config('app.whatsapp_number');
        $texto  = "📨 *Nuevo mensaje de contacto*\n\n"
                . "*Nombre:* {$request->nombre}\n"
                . "*Email:* {$request->email}\n"
                . "*Asunto:* {$request->asunto}\n\n"
                . "*Mensaje:*\n{$request->mensaje}";

        $whatsappUrl = 'https://wa.me/' . $numero . '?text=' . urlencode($texto);

        return redirect()->away($whatsappUrl);
    }
}
