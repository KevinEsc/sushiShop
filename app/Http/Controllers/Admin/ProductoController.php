<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('categoria')->orderBy('nombre')->paginate(12);
        $categorias = Producto::categorias();

        return view('admin.dashboard', compact('productos', 'categorias'));
    }

    public function create()
    {
        $categorias = Producto::categorias();
        return view('admin.productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'precio'      => 'required|numeric|min:0',
            'categoria'   => 'required|in:' . implode(',', array_keys(Producto::categorias())),
            'stock'       => 'required|integer|min:0',
            'imagen'      => 'nullable|image|mimes:jpg,jpeg,png,webp,heic,heif|max:10240',
            'activo'      => 'boolean',
        ], [
            'nombre.required'   => 'El nombre del producto es obligatorio.',
            'precio.required'   => 'El precio es obligatorio.',
            'precio.numeric'    => 'El precio debe ser un número.',
            'precio.min'        => 'El precio no puede ser negativo.',
            'stock.required'    => 'El stock es obligatorio.',
            'imagen.image'      => 'El archivo debe ser una imagen (jpg, png, webp).',
            'imagen.mimes'      => 'Formato no permitido. Usa jpg, png o webp.',
            'imagen.max'        => 'La imagen no puede superar 10MB.',
            'imagen.uploaded'   => 'Error al subir la imagen. Verifica que el archivo no sea mayor a 10MB.',
        ]);

        $data = $request->except('imagen');
        $data['activo'] = $request->boolean('activo', true);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', config('filesystems.default'));
        }

        Producto::create($data);

        return redirect()->route('admin.dashboard')
            ->with('success', "Producto «{$request->nombre}» creado exitosamente.");
    }

    public function edit(Producto $producto)
    {
        $categorias = Producto::categorias();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'precio'      => 'required|numeric|min:0',
            'categoria'   => 'required|in:' . implode(',', array_keys(Producto::categorias())),
            'stock'       => 'required|integer|min:0',
            'imagen'      => 'nullable|image|mimes:jpg,jpeg,png,webp,heic,heif|max:10240',
        ], [
            'imagen.image'    => 'El archivo debe ser una imagen.',
            'imagen.mimes'    => 'Formato no permitido. Usa jpg, png o webp.',
            'imagen.max'      => 'La imagen no puede superar 10MB.',
            'imagen.uploaded' => 'Error al subir la imagen. Verifica que el archivo no sea mayor a 10MB.',
        ]);

        $data = $request->except(['imagen', '_method', '_token']);
        $data['activo'] = $request->boolean('activo');

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior
            if ($producto->imagen) {
                Storage::disk(config('filesystems.default'))->delete($producto->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('productos', config('filesystems.default'));
        }

        $producto->update($data);

        return redirect()->route('admin.dashboard')
            ->with('success', "Producto «{$producto->nombre}» actualizado correctamente.");
    }

    public function destroy(Producto $producto)
    {
        $nombre = $producto->nombre;

        if ($producto->imagen) {
            Storage::disk(config('filesystems.default'))->delete($producto->imagen);
        }

        $producto->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', "Producto «{$nombre}» eliminado.");
    }
}
