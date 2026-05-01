@extends('layouts.app')

@section('title', 'Hacer Pedido — MoniWis Sushi')
@section('description', 'Selecciona tus rolls favoritos y envía tu pedido directamente por WhatsApp.')

@section('content')

<section class="py-20 hero-bg" aria-label="Formulario de pedido">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold mb-4"
                 style="background: rgba(37,211,102,0.15); border: 1px solid rgba(37,211,102,0.3); color:#25D366;">
                📱 Pedido por WhatsApp
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white mb-3" style="font-family:'Playfair Display',serif;">
                Tu pedido, <span class="text-gradient-red">listo para enviar</span>
            </h1>
            <p class="text-slate-400">Selecciona los productos, cantidad y dirección. Te redirigiremos a WhatsApp con todo listo.</p>
        </div>

        @if($productos->isEmpty())
            <div class="glass-card p-16 text-center">
                <div class="text-7xl mb-4">🍽️</div>
                <h2 class="text-2xl font-bold text-white mb-2">Aún no hay productos disponibles</h2>
                <p class="text-slate-400 mb-6">El administrador está preparando el menú. Vuelve pronto.</p>
                <a href="{{ route('home') }}" class="btn-primary">← Volver al inicio</a>
            </div>
        @else

        <form method="POST" action="{{ route('pedido.whatsapp') }}" id="pedido-form" aria-label="Formulario de pedido por WhatsApp">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- LEFT: Product Selection --}}
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-white">Selecciona tus productos</h2>
                        <span id="selected-count" class="text-sm px-3 py-1 rounded-full font-medium"
                              style="background: rgba(232,25,44,0.15); border: 1px solid rgba(232,25,44,0.2); color:#E8192C;">
                            0 seleccionados
                        </span>
                    </div>

                    @foreach($categorias as $catKey => $catLabel)
                        @php $catProductos = $productos->where('categoria', $catKey); @endphp
                        @if($catProductos->count() > 0)
                            <div class="mb-6">
                                <h3 class="text-sm font-semibold mb-3 uppercase tracking-widest" style="color:#F5C842;">
                                    {{ $catLabel }}
                                </h3>
                                <div class="space-y-3">
                                    @foreach($catProductos as $i => $producto)
                                        <div class="pedido-item" id="item-{{ $producto->id }}">
                                            <div class="flex items-center gap-4">
                                                {{-- Checkbox --}}
                                                <input type="checkbox"
                                                       id="check-{{ $producto->id }}"
                                                       class="product-checkbox w-5 h-5 rounded accent-red-600 cursor-pointer flex-shrink-0"
                                                       data-id="{{ $producto->id }}"
                                                       onchange="toggleItem({{ $producto->id }})">

                                                {{-- Info --}}
                                                <label for="check-{{ $producto->id }}" class="flex-1 cursor-pointer">
                                                    <div class="flex items-start justify-between gap-3">
                                                        <div>
                                                            <p class="font-semibold text-white text-sm">{{ $producto->nombre }}</p>
                                                            @if($producto->descripcion)
                                                                <p class="text-xs text-slate-400 mt-0.5 leading-relaxed">{{ Str::limit($producto->descripcion, 80) }}</p>
                                                            @endif
                                                        </div>
                                                        <span class="font-black flex-shrink-0 text-sm" style="color:#F5C842;">
                                                            ${{ number_format($producto->precio, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                </label>

                                                {{-- Quantity --}}
                                                <div class="flex items-center gap-2 flex-shrink-0" id="qty-control-{{ $producto->id }}" style="display:none!important;">
                                                    <button type="button" onclick="changeQty({{ $producto->id }}, -1)"
                                                            class="w-7 h-7 rounded-full flex items-center justify-center text-white font-bold text-sm transition-colors"
                                                            style="background: rgba(232,25,44,0.3);"
                                                            aria-label="Disminuir cantidad">−</button>
                                                    <span id="qty-{{ $producto->id }}" class="text-white font-bold text-sm w-6 text-center">1</span>
                                                    <button type="button" onclick="changeQty({{ $producto->id }}, 1)"
                                                            class="w-7 h-7 rounded-full flex items-center justify-center text-white font-bold text-sm transition-colors"
                                                            style="background: rgba(37,211,102,0.3);"
                                                            aria-label="Aumentar cantidad">+</button>
                                                </div>
                                            </div>

                                            {{-- Hidden inputs --}}
                                            <input type="hidden" name="items[{{ $i }}][id]" value="{{ $producto->id }}" id="hidden-id-{{ $producto->id }}" disabled>
                                            <input type="hidden" name="items[{{ $i }}][cant]" value="1" id="hidden-cant-{{ $producto->id }}" disabled>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- RIGHT: Order Summary & Delivery --}}
                <div class="space-y-6">

                    {{-- Summary Card --}}
                    <div class="glass-card p-6 sticky top-28">
                        <h2 class="text-lg font-bold text-white mb-4">Resumen del pedido</h2>

                        <div id="order-summary" class="space-y-2 mb-4 min-h-12">
                            <p id="empty-msg" class="text-sm text-slate-500 italic">Selecciona productos...</p>
                        </div>

                        <div style="border-top: 1px solid rgba(255,255,255,0.08);" class="pt-4 mb-6">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-400">Total estimado</span>
                                <span id="total-display" class="text-xl font-black text-gradient-gold">$0</span>
                            </div>
                        </div>

                        {{-- Delivery Info --}}
                        <div class="space-y-4">
                            <div>
                                <label for="direccion" class="block text-sm font-medium text-slate-300 mb-2">
                                    📍 Dirección de entrega <span style="color:#E8192C;">*</span>
                                </label>
                                <textarea id="direccion" name="direccion" rows="2" required
                                          placeholder="Ej: Calle 123, Depto 4, Ciudad"
                                          class="input-dark resize-none text-sm @error('direccion') border-red-500 @enderror"></textarea>
                                @error('direccion')
                                    <p class="mt-1 text-xs" style="color:#E8192C;" role="alert">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="notas" class="block text-sm font-medium text-slate-300 mb-2">
                                    📝 Notas adicionales <span class="text-xs text-slate-500 font-normal">(opcional)</span>
                                </label>
                                <textarea id="notas" name="notas" rows="2"
                                          placeholder="Sin cebolla, extra salsa, etc."
                                          class="input-dark resize-none text-sm"></textarea>
                            </div>
                        </div>

                        {{-- Errors --}}
                        @if($errors->any())
                            <div class="mt-4 p-3 rounded-xl" style="background: rgba(232,25,44,0.1); border: 1px solid rgba(232,25,44,0.3);" role="alert">
                                <ul class="text-xs space-y-1" style="color:#E8192C;">
                                    @foreach($errors->all() as $e)
                                        <li>• {{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <button type="submit" id="submit-btn" disabled
                                class="btn-whatsapp w-full justify-center mt-6 opacity-50 cursor-not-allowed transition-opacity"
                                style="opacity: 0.5;">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Enviar por WhatsApp
                        </button>

                        <p class="text-center text-xs text-slate-500 mt-3">
                            Serás redirigido a WhatsApp con tu pedido ya listo ✅
                        </p>
                    </div>
                </div>
            </div>
        </form>

        @endif
    </div>
</section>

@endsection

@push('scripts')
<script>
// ─── Pedido interactivo ───────────────────────────────────────────────────────
const productData = @json($productos->map(fn($p) => ['id' => $p->id, 'nombre' => $p->nombre, 'precio' => (float)$p->precio]));
const selected = new Map(); // id → { nombre, precio, cant }

function toggleItem(id) {
    const checkbox = document.getElementById(`check-${id}`);
    const qtyCtrl  = document.getElementById(`qty-control-${id}`);
    const card     = document.getElementById(`item-${id}`);
    const hiddenId = document.getElementById(`hidden-id-${id}`);
    const hiddenCant = document.getElementById(`hidden-cant-${id}`);

    if (checkbox.checked) {
        const p = productData.find(x => x.id === id);
        selected.set(id, { nombre: p.nombre, precio: p.precio, cant: 1 });
        qtyCtrl.style.display = 'flex';
        card.classList.add('selected');
        hiddenId.disabled = false;
        hiddenCant.disabled = false;
    } else {
        selected.delete(id);
        qtyCtrl.style.display = 'none !important';
        qtyCtrl.style.cssText = 'display:none!important';
        card.classList.remove('selected');
        hiddenId.disabled = true;
        hiddenCant.disabled = true;
    }
    updateSummary();
}

function changeQty(id, delta) {
    if (!selected.has(id)) return;
    const item = selected.get(id);
    item.cant = Math.max(1, item.cant + delta);
    document.getElementById(`qty-${id}`).textContent = item.cant;
    document.getElementById(`hidden-cant-${id}`).value = item.cant;
    updateSummary();
}

function formatPrice(n) {
    return '$' + Math.round(n).toLocaleString('es-CL');
}

function updateSummary() {
    const summary = document.getElementById('order-summary');
    const emptyMsg = document.getElementById('empty-msg');
    const totalDisplay = document.getElementById('total-display');
    const countDisplay = document.getElementById('selected-count');
    const submitBtn = document.getElementById('submit-btn');

    if (selected.size === 0) {
        summary.innerHTML = '<p id="empty-msg" class="text-sm text-slate-500 italic">Selecciona productos...</p>';
        totalDisplay.textContent = '$0';
        countDisplay.textContent = '0 seleccionados';
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.5';
        submitBtn.style.cursor = 'not-allowed';
        return;
    }

    let total = 0;
    let html = '';
    selected.forEach((item, id) => {
        const sub = item.precio * item.cant;
        total += sub;
        html += `<div class="flex justify-between items-start gap-2 text-xs">
            <span class="text-slate-300 leading-tight">${item.nombre} ×${item.cant}</span>
            <span class="text-white font-semibold flex-shrink-0">${formatPrice(sub)}</span>
        </div>`;
    });

    summary.innerHTML = html;
    totalDisplay.textContent = formatPrice(total);
    countDisplay.textContent = `${selected.size} seleccionado${selected.size > 1 ? 's' : ''}`;
    submitBtn.disabled = false;
    submitBtn.style.opacity = '1';
    submitBtn.style.cursor = 'pointer';
}
</script>
@endpush
