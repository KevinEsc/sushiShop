@extends('layouts.app')

@section('title', 'Editar Producto — Admin MoniWis Sushi')

@section('content')

<section class="py-16" style="background: #080A0F; min-height: 100vh;" aria-label="Editar producto">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-slate-400 mb-8" aria-label="Ruta de navegación">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
            <span>›</span>
            <span class="text-white truncate">{{ Str::limit($producto->nombre, 30) }}</span>
        </nav>

        <div class="glass-card p-8">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl"
                     style="background: rgba(96,165,250,0.2); border: 1px solid rgba(96,165,250,0.3);">✏️</div>
                <div>
                    <h1 class="text-2xl font-black text-white" style="font-family:'Playfair Display',serif;">Editar Producto</h1>
                    <p class="text-xs text-slate-400">ID #{{ $producto->id }}</p>
                </div>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl" style="background: rgba(232,25,44,0.1); border: 1px solid rgba(232,25,44,0.3);" role="alert">
                    <ul class="text-sm space-y-1" style="color:#E8192C;">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.productos.update', $producto) }}" enctype="multipart/form-data" class="space-y-6" aria-label="Formulario editar producto" novalidate>
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Nombre --}}
                    <div class="sm:col-span-2">
                        <label for="edit-nombre" class="block text-sm font-medium text-slate-300 mb-2">
                            Nombre del producto <span style="color:#E8192C;">*</span>
                        </label>
                        <input type="text" id="edit-nombre" name="nombre"
                               value="{{ old('nombre', $producto->nombre) }}"
                               required placeholder="Nombre del producto"
                               class="input-dark @error('nombre') border-red-500 @enderror">
                        @error('nombre')<p class="mt-1 text-xs" style="color:#E8192C;">{{ $message }}</p>@enderror
                    </div>

                    {{-- Categoría --}}
                    <div>
                        <label for="edit-categoria" class="block text-sm font-medium text-slate-300 mb-2">
                            Categoría <span style="color:#E8192C;">*</span>
                        </label>
                        <select id="edit-categoria" name="categoria" required class="input-dark @error('categoria') border-red-500 @enderror">
                            @foreach($categorias as $key => $label)
                                <option value="{{ $key }}" {{ old('categoria', $producto->categoria) === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria')<p class="mt-1 text-xs" style="color:#E8192C;">{{ $message }}</p>@enderror
                    </div>

                    {{-- Precio --}}
                    <div>
                        <label for="edit-precio" class="block text-sm font-medium text-slate-300 mb-2">
                            Precio (CLP) <span style="color:#E8192C;">*</span>
                        </label>
                        <input type="number" id="edit-precio" name="precio"
                               value="{{ old('precio', $producto->precio) }}"
                               required min="0" step="50"
                               class="input-dark @error('precio') border-red-500 @enderror">
                        @error('precio')<p class="mt-1 text-xs" style="color:#E8192C;">{{ $message }}</p>@enderror
                    </div>

                    {{-- Stock --}}
                    <div>
                        <label for="edit-stock" class="block text-sm font-medium text-slate-300 mb-2">
                            Stock <span style="color:#E8192C;">*</span>
                        </label>
                        <input type="number" id="edit-stock" name="stock"
                               value="{{ old('stock', $producto->stock) }}"
                               required min="0"
                               class="input-dark @error('stock') border-red-500 @enderror">
                        @error('stock')<p class="mt-1 text-xs" style="color:#E8192C;">{{ $message }}</p>@enderror
                    </div>

                    {{-- Activo --}}
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="edit-activo" name="activo" value="1"
                               {{ old('activo', $producto->activo) ? 'checked' : '' }}
                               class="w-5 h-5 rounded accent-red-600 cursor-pointer">
                        <label for="edit-activo" class="text-sm font-medium text-slate-300 cursor-pointer">
                            Producto activo (visible en tienda)
                        </label>
                    </div>
                </div>

                {{-- Descripción --}}
                <div>
                    <label for="edit-desc" class="block text-sm font-medium text-slate-300 mb-2">Descripción</label>
                    <textarea id="edit-desc" name="descripcion" rows="3"
                              placeholder="Describe los ingredientes..."
                              class="input-dark resize-none @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    @error('descripcion')<p class="mt-1 text-xs" style="color:#E8192C;">{{ $message }}</p>@enderror
                </div>

                {{-- Imagen actual --}}
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Imagen</label>
                    @if($producto->imagen)
                        <div class="mb-3 flex items-center gap-4">
                            <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}"
                                 class="w-20 h-20 object-cover rounded-xl"
                                 style="border: 2px solid rgba(232,25,44,0.3);">
                            <p class="text-xs text-slate-400">Imagen actual. Sube una nueva para reemplazarla.</p>
                        </div>
                    @endif
                    <input type="file" id="edit-imagen" name="imagen" accept="image/*"
                           class="input-dark cursor-pointer"
                           onchange="previewImage(event)">
                    <div id="img-preview" class="mt-3 hidden">
                        <img id="preview-img" src="" alt="Vista previa" class="w-32 h-32 object-cover rounded-xl"
                             style="border: 2px solid rgba(245,200,66,0.3);">
                        <p class="text-xs text-slate-400 mt-1">Nueva imagen (previa)</p>
                    </div>
                    @error('imagen')<p class="mt-1 text-xs" style="color:#E8192C;">{{ $message }}</p>@enderror
                </div>

                {{-- Buttons --}}
                <div class="flex gap-4 pt-4" style="border-top: 1px solid rgba(255,255,255,0.08);">
                    <button type="submit" class="btn-primary flex-1 justify-center">
                        💾 Guardar Cambios
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn-secondary flex-1 justify-center text-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('img-preview').classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
