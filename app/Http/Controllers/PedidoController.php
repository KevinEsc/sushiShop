<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Muestra el formulario de pedido.
     * Solo usuarios autenticados (protegido por middleware 'auth' en rutas).
     */
    public function index()
    {
        $productos = Producto::activos()->orderBy('categoria')->orderBy('nombre')->get();
        $categorias = Producto::categorias();

        return view('pedido.index', compact('productos', 'categorias'));
    }

    /**
     * Genera el enlace de WhatsApp con el resumen del pedido.
     */
    public function generarWhatsApp(Request $request)
    {
        $request->validate([
            'items'        => 'required|array|min:1',
            'items.*.id'   => 'required|exists:productos,id',
            'items.*.cant' => 'required|integer|min:1',
            'direccion'    => 'required|string|max:500',
            'notas'        => 'nullable|string|max:300',
        ], [
            'items.required'      => 'Selecciona al menos un producto.',
            'items.min'           => 'Selecciona al menos un producto.',
            'direccion.required'  => 'La dirección de entrega es obligatoria.',
        ]);

        $productosSeleccionados = collect($request->items)->map(function ($item) {
            $producto = Producto::find($item['id']);
            return [
                'nombre'    => $producto->nombre,
                'cantidad'  => $item['cant'],
                'precio'    => $producto->precio,
                'subtotal'  => $producto->precio * $item['cant'],
            ];
        });

        $total = $productosSeleccionados->sum('subtotal');
        $usuario = auth()->user();

        // Construir mensaje de WhatsApp
        $mensaje = "🍣 *NUEVO PEDIDO - MoniWis Sushi*\n\n";
        $mensaje .= "👤 *Cliente:* {$usuario->name}\n";
        $mensaje .= "📧 *Email:* {$usuario->email}\n";
        if ($usuario->telefono) {
            $mensaje .= "📱 *Teléfono:* {$usuario->telefono}\n";
        }
        $mensaje .= "\n📦 *DETALLE DEL PEDIDO:*\n";

        foreach ($productosSeleccionados as $item) {
            $subtotal = number_format($item['subtotal'], 0, ',', '.');
            $mensaje .= "• {$item['nombre']} x{$item['cantidad']} — \${$subtotal}\n";
        }

        $totalFormato = number_format($total, 0, ',', '.');
        $mensaje .= "\n💰 *TOTAL: \${$totalFormato}*\n\n";
        $mensaje .= "📍 *Dirección:* {$request->direccion}\n";

        if ($request->notas) {
            $mensaje .= "📝 *Notas:* {$request->notas}\n";
        }

        $mensaje .= "\n⏰ Pedido realizado el " . now()->format('d/m/Y H:i') . " hrs";

        $whatsappNumber = config('app.whatsapp_number', env('WHATSAPP_NUMBER', '56900000000'));
        $url = 'https://wa.me/' . $whatsappNumber . '?text=' . urlencode($mensaje);

        return redirect()->away($url);
    }
}
