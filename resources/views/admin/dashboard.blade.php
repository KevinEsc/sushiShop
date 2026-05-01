@extends('layouts.app')

@section('title', 'Dashboard Admin — MoniWis Sushi')
@section('description', 'Panel de administración de inventario MoniWis Sushi.')

@section('content')

<section class="py-16" style="background: #080A0F; min-height: 100vh;" aria-label="Dashboard de administración">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl"
                         style="background: linear-gradient(135deg, #F5C842, #C9A52A);">⚙️</div>
                    <div>
                        <h1 class="text-2xl font-black text-white" style="font-family:'Playfair Display',serif;">Dashboard Admin</h1>
                        <p class="text-xs text-slate-400">Bienvenido, <span style="color:#F5C842;">{{ auth()->user()->name }}</span> 👑</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('admin.productos.create') }}" class="btn-primary">
                ＋ Nuevo Producto
            </a>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            @php
                $total = \App\Models\Producto::count();
                $activos = \App\Models\Producto::where('activo', true)->count();
                $stockBajo = \App\Models\Producto::where('stock', '<=', 5)->where('activo', true)->count();
                $categoriasMas = \App\Models\Producto::groupBy('categoria')->orderByRaw('COUNT(*) DESC')->pluck('categoria')->first();
            @endphp
            @foreach([
                ['label' => 'Total Productos', 'value' => $total, 'icon' => 'cat', 'color' => '#E8192C'],
                ['label' => 'Activos', 'value' => $activos, 'icon' => '✅', 'color' => '#25D366'],
                ['label' => 'Stock Bajo', 'value' => $stockBajo, 'icon' => '⚠️', 'color' => '#F5C842'],
                ['label' => 'Categorías', 'value' => count(\App\Models\Producto::categorias()), 'icon' => '📂', 'color' => '#60a5fa'],
            ] as $stat)
                <div class="glass-card p-5">
                    @if($stat['icon'] === 'cat')
                        <div class="w-8 h-8 rounded-lg overflow-hidden mb-2">
                            <img src="{{ asset('images/logo-cat.png') }}" alt="productos" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="text-2xl mb-2">{{ $stat['icon'] }}</div>
                    @endif
                    <div class="text-2xl font-black" style="color:{{ $stat['color'] }};">{{ $stat['value'] }}</div>
                    <div class="text-xs text-slate-400 mt-1">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>

        {{-- Products Table --}}
        <div class="glass-card overflow-hidden">
            <div class="p-6" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                <h2 class="text-lg font-bold text-white">Inventario de Productos</h2>
            </div>

            @if($productos->isEmpty())
                <div class="p-16 text-center">
                    <div class="text-6xl mb-4">📦</div>
                    <p class="text-white font-semibold mb-2">No hay productos aún</p>
                    <p class="text-slate-400 text-sm mb-6">Crea tu primer producto para comenzar.</p>
                    <a href="{{ route('admin.productos.create') }}" class="btn-primary">＋ Crear primer producto</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full admin-table" aria-label="Lista de productos">
                        <thead>
                            <tr>
                                <th class="text-left">Producto</th>
                                <th class="text-left hidden md:table-cell">Categoría</th>
                                <th class="text-right">Precio</th>
                                <th class="text-center hidden sm:table-cell">Stock</th>
                                <th class="text-center hidden md:table-cell">Estado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $producto)
                                <tr>
                                    {{-- Nombre + imagen --}}
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0"
                                                 style="background: rgba(255,255,255,0.05);">
                                                <img src="{{ $producto->imagen_url }}"
                                                     alt="{{ $producto->nombre }}"
                                                     class="w-full h-full object-cover"
                                                     loading="lazy">
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-white">{{ $producto->nombre }}</p>
                                                @if($producto->descripcion)
                                                    <p class="text-xs text-slate-500 truncate max-w-xs">{{ Str::limit($producto->descripcion, 40) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Categoría --}}
                                    <td class="hidden md:table-cell">
                                        <span class="text-xs px-2 py-1 rounded-full capitalize"
                                              style="background: rgba(232,25,44,0.1); color:#E8192C; border: 1px solid rgba(232,25,44,0.2);">
                                            {{ \App\Models\Producto::categorias()[$producto->categoria] ?? $producto->categoria }}
                                        </span>
                                    </td>

                                    {{-- Precio --}}
                                    <td class="text-right">
                                        <span class="font-bold" style="color:#F5C842;">
                                            ${{ number_format($producto->precio, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    {{-- Stock --}}
                                    <td class="text-center hidden sm:table-cell">
                                        <span class="font-semibold text-sm {{ $producto->stock <= 5 ? 'text-yellow-400' : 'text-white' }}">
                                            {{ $producto->stock }}
                                        </span>
                                    </td>

                                    {{-- Estado --}}
                                    <td class="text-center hidden md:table-cell">
                                        @if($producto->activo)
                                            <span class="badge-active">Activo</span>
                                        @else
                                            <span class="badge-inactive">Inactivo</span>
                                        @endif
                                    </td>

                                    {{-- Acciones --}}
                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.productos.edit', $producto) }}"
                                               class="text-xs px-3 py-1.5 rounded-lg font-medium transition-colors"
                                               style="background: rgba(96,165,250,0.15); color:#60a5fa; border: 1px solid rgba(96,165,250,0.2);"
                                               aria-label="Editar {{ $producto->nombre }}">
                                                ✏️ Editar
                                            </a>
                                            <form method="POST" action="{{ route('admin.productos.destroy', $producto) }}"
                                                  onsubmit="return confirm('¿Eliminar «{{ $producto->nombre }}»? Esta acción no se puede deshacer.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-xs px-3 py-1.5 rounded-lg font-medium transition-colors"
                                                        style="background: rgba(232,25,44,0.15); color:#E8192C; border: 1px solid rgba(232,25,44,0.2);"
                                                        aria-label="Eliminar {{ $producto->nombre }}">
                                                    🗑️ Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($productos->hasPages())
                    <div class="p-6" style="border-top: 1px solid rgba(255,255,255,0.06);">
                        {{ $productos->links() }}
                    </div>
                @endif
            @endif
        </div>

        {{-- Quick links --}}
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('tienda') }}" target="_blank" class="text-sm text-slate-400 hover:text-white transition-colors flex items-center gap-2">
                🏪 Ver tienda →
            </a>
            <a href="{{ route('home') }}" target="_blank" class="text-sm text-slate-400 hover:text-white transition-colors flex items-center gap-2">
                🏠 Ver inicio →
            </a>
        </div>
    </div>
</section>

@endsection
