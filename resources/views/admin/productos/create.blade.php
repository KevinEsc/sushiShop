@extends('layouts.app')

@section('title', 'Nuevo Producto — Admin MoniWis Sushi')

@section('content')

<section class="py-16" style="background: #080A0F; min-height: 100vh;" aria-label="Crear producto">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-slate-400 mb-8" aria-label="Ruta de navegación">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
            <span>›</span>
            <span class="text-white">Nuevo Producto</span>
        </nav>

        <div class="glass-card p-8">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl"
                     style="background: linear-gradient(135deg, #E8192C, #B5111F);">＋</div>
                <h1 class="text-2xl font-black text-white" style="font-family:'Playfair Display',serif;">Nuevo Producto</h1>
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

            <form method="POST" action="{{ route('admin.productos.store') }}" enctype="multipart/form-data" class="space-y-6" aria-label="Formulario de nuevo producto" novalidate>
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Nombre --}}
                    <div class="sm:col-span-2">
                        <label for="prod-nombre" class="block text-sm font-medium text-slate-300 mb-2">
                            Nombre del producto <span style="color:#E8192C;">*</span>
                        </label>
                        <input type="text" id="prod-nombre" name="nombre" value="{{ old('nombre') }}"
                               required placeholder="Ej: Dragon Roll Premium"
                               class="input-dark @error('nombre') border-red-500 @enderror">
                        @error('nombre')<p class="mt-1 text-xs" style="color:#E8192C;">{{ $message }}</p>@enderror
                    </div>

                    {{-- Categoría --}}
                    <div>
                        <label for="prod-categoria" class="block text-sm font-medium text-slate-300 mb-2">
                            Categoría <span style="color:#E8192C;">*</span>
                        </label>
                        <select id="prod-categoria" name="categoria" required class="input-dark @error('categoria') border-red-500 @enderror">
                            @foreach($categorias as $key => $label)
                                <option value="{{ $key }}" {{ old('categoria') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('categoria')<p class="mt-1 text-xs" style="color:#E8192C;">{{ $message }}</p>@enderror
                    </div>

                    {{-- Precio --}}
                    <div>
                        <label for="prod-precio" class="block text-sm font-medium text-slate-300 mb-2">
                            Precio (CLP) <span style="color:#E8192C;">*</span>
                        </label>
                        <input type="number" id="prod-precio" name="precio" value="{{ old('precio') }}"
                               required min="0" step="50" placeholder="Ej: 8500"
                               class="input-dark @error('precio') border-red-500 @enderror">
                        @error('precio')<p class="mt-1 text-xs" style="color:#E8192C;">{{ $message }}</p>@enderror
                    </div>

                    {{-- Stock --}}
                    <div>
                        <label for="prod-stock" class="block text-sm font-medium text-slate-300 mb-2">
                            Stock <span style="color:#E8192C;">*</span>
                        </label>
                        <input type="number" id="prod-stock" name="stock" value="{{ old('stock', 10) }}"
                               required min="0" placeholder="Ej: 20"
                               class="input-dark @error('stock') border-red-500 @enderror">
                        @error('stock')<p class="mt-1 text-xs" style="color:#E8192C;">{{ $message }}</p>@enderror
                    </div>

                    {{-- Activo --}}
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="prod-activo" name="activo" value="1"
                               {{ old('activo', true) ? 'checked' : '' }}
                               class="w-5 h-5 rounded accent-red-600 cursor-pointer">
                        <label for="prod-activo" class="text-sm font-medium text-slate-300 cursor-pointer">
                            Producto activo (visible en tienda)
                        </label>
                    </div>
                </div>

                {{-- Descripción --}}
                <div>
                    <label for="prod-desc" class="block text-sm font-medium text-slate-300 mb-2">
                        Descripción <span class="text-xs text-slate-500 font-normal">(opcional)</span>
                    </label>
                    <textarea id="prod-desc" name="descripcion" rows="3"
                              placeholder="Describe los ingredientes, sabores y características del producto..."
                              class="input-dark resize-none @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
                    @error('descripcion')<p class="mt-1 text-xs" style="color:#E8192C;">{{ $message }}</p>@enderror
                </div>

                {{-- Imagen --}}
                <div>
                    <label for="prod-imagen" class="block text-sm font-medium text-slate-300 mb-2">
                        Imagen del producto <span class="text-xs text-slate-500 font-normal">(JPG, PNG, WebP, máx 2MB)</span>
                    </label>
                    <div class="relative">
                        <input type="file" id="prod-imagen" name="imagen" accept="image/*"
                               class="input-dark cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:cursor-pointer"
                               style="file-selector-button: background: rgba(232,25,44,0.2); color: #E8192C;"
                               onchange="previewImage(event)">
                    </div>
                    <div id="img-preview" class="mt-3 hidden">
                        <img id="preview-img" src="" alt="Vista previa" class="w-32 h-32 object-cover rounded-xl"
                             style="border: 2px solid rgba(232,25,44,0.3);">
                    </div>
                    @error('imagen')<p class="mt-1 text-xs" style="color:#E8192C;">{{ $message }}</p>@enderror
                </div>

                {{-- Buttons --}}
                <div class="flex gap-4 pt-4" style="border-top: 1px solid rgba(255,255,255,0.08);">
                    <button type="submit" class="btn-primary flex-1 justify-center">
                        💾 Guardar Producto
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
