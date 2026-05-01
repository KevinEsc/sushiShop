@extends('layouts.app')

@section('title', 'Menú — MoniWis Sushi')
@section('description', 'Explora nuestro menú completo de sushi artesanal. Rolls, nigiri, sashimi, combos y bebidas. Encuentra tu favorito y pide por WhatsApp.')
@section('keywords', 'menú sushi, rolls, nigiri, sashimi, combos sushi, bebidas japonesas, MoniWis')

@section('content')

{{-- Page Header --}}
<section class="py-20 relative overflow-hidden" style="background: linear-gradient(180deg, #0F1117 0%, #080A0F 100%);" aria-label="Encabezado de tienda">
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true"
         style="background: radial-gradient(ellipse at 50% 0%, rgba(232,25,44,0.12) 0%, transparent 60%);">
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold mb-4"
             style="background: rgba(232,25,44,0.15); border: 1px solid rgba(232,25,44,0.3); color:#E8192C;">
            🍱 Menú Completo
        </div>
        <h1 class="text-5xl md:text-6xl font-black text-white mb-4" style="font-family:'Playfair Display',serif;">
            Nuestro <span class="text-gradient-red">Menú</span>
        </h1>
        <p class="text-lg text-slate-400 max-w-2xl mx-auto">
            Cada pieza es elaborada con técnica tradicional japonesa y los ingredientes más frescos del día.
        </p>
    </div>
</section>

{{-- Category Filters --}}
<section class="sticky top-16 md:top-20 z-40 py-4" style="background: rgba(8,10,15,0.95); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.06);" aria-label="Filtros de categoría">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 overflow-x-auto pb-1 scrollbar-hide" role="tablist" aria-label="Categorías del menú">
            <a href="{{ route('tienda') }}"
               class="category-tab flex-shrink-0 {{ $categoriaActiva === 'todos' ? 'active' : '' }}"
               role="tab"
               aria-selected="{{ $categoriaActiva === 'todos' ? 'true' : 'false' }}">
                🍽️ Todos
            </a>
            @foreach($categorias as $key => $label)
                <a href="{{ route('tienda', ['categoria' => $key]) }}"
                   class="category-tab flex-shrink-0 {{ $categoriaActiva === $key ? 'active' : '' }}"
                   role="tab"
                   aria-selected="{{ $categoriaActiva === $key ? 'true' : 'false' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Products Grid --}}
<section class="py-16" style="background: #080A0F;" aria-label="Productos">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($productos->isEmpty())
            {{-- Empty state --}}
            <div class="text-center py-24">
                <div class="text-8xl mb-6">🥢</div>
                <h2 class="text-2xl font-bold text-white mb-3">Próximamente...</h2>
                <p class="text-slate-400 mb-8">Estamos preparando algo delicioso para esta categoría.</p>
                <a href="{{ route('tienda') }}" class="btn-primary">Ver todo el menú</a>
            </div>
        @else
            {{-- Count --}}
            <div class="flex items-center justify-between mb-8">
                <p class="text-sm text-slate-400">
                    <span class="text-white font-semibold">{{ $productos->count() }}</span> productos encontrados
                    @if($categoriaActiva !== 'todos')
                        en <span class="font-medium" style="color:#E8192C;">{{ $categorias[$categoriaActiva] ?? $categoriaActiva }}</span>
                    @endif
                </p>
                @guest
                    <p class="text-sm text-slate-500">
                        <a href="{{ route('register') }}" class="font-medium hover:text-white transition-colors" style="color:#E8192C;">Regístrate</a>
                        para hacer pedidos
                    </p>
                @endguest
            </div>

            {{-- Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($productos as $producto)
                    <article class="product-card" itemscope itemtype="https://schema.org/Product">
                        {{-- Image --}}
                        <div class="overflow-hidden relative" style="height: 200px;">
                            <img src="{{ $producto->imagen_url }}"
                                 alt="{{ $producto->nombre }}"
                                 class="product-img"
                                 loading="lazy"
                                 itemprop="image">

                            {{-- Category badge --}}
                            <div class="absolute top-3 left-3">
                                <span class="text-xs font-medium px-2 py-1 rounded-full"
                                      style="background: rgba(8,10,15,0.8); backdrop-filter: blur(10px); border: 1px solid rgba(232,25,44,0.3); color:#E8192C;">
                                    {{ \App\Models\Producto::categorias()[$producto->categoria] ?? $producto->categoria }}
                                </span>
                            </div>

                            {{-- Stock badge --}}
                            @if($producto->stock <= 5 && $producto->stock > 0)
                                <div class="absolute top-3 right-3">
                                    <span class="text-xs font-bold px-2 py-1 rounded-full"
                                          style="background: rgba(245,200,66,0.2); border: 1px solid rgba(245,200,66,0.4); color:#F5C842;">
                                        ¡Últimas {{ $producto->stock }}!
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="p-5">
                            <h3 class="text-base font-bold text-white mb-2 leading-tight" style="font-family:'Playfair Display',serif;" itemprop="name">
                                {{ $producto->nombre }}
                            </h3>
                            @if($producto->descripcion)
                                <p class="text-xs text-slate-400 mb-4 leading-relaxed line-clamp-2" itemprop="description">
                                    {{ $producto->descripcion }}
                                </p>
                            @endif

                            <div class="flex items-center justify-between pt-3" style="border-top: 1px solid rgba(255,255,255,0.06);">
                                <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                    <meta itemprop="priceCurrency" content="CLP">
                                    <span class="text-xl font-black text-gradient-gold" itemprop="price" content="{{ $producto->precio }}">
                                        ${{ number_format($producto->precio, 0, ',', '.') }}
                                    </span>
                                </div>

                                @auth
                                    <a href="{{ route('pedido.index') }}"
                                       class="btn-primary text-xs px-3 py-2">
                                        🛒 Pedir
                                    </a>
                                @else
                                    <a href="{{ route('register') }}"
                                       title="Regístrate para hacer pedidos"
                                       class="btn-secondary text-xs px-3 py-2">
                                        🔐 Pedir
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- CTA Banner --}}
@guest
<section class="py-16" style="background: #0F1117;" aria-label="Registro para pedidos">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="glass-card p-10">
            <div class="text-5xl mb-4">🔐</div>
            <h2 class="text-2xl font-black text-white mb-3" style="font-family:'Playfair Display',serif;">
                Para hacer pedidos necesitas una cuenta
            </h2>
            <p class="text-slate-400 mb-8">Es gratis y solo tarda 1 minuto. Luego puedes pedir directo por WhatsApp.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="btn-primary px-8 py-3">✨ Crear Cuenta Gratis</a>
                <a href="{{ route('login') }}" class="btn-secondary px-8 py-3">Iniciar Sesión</a>
            </div>
        </div>
    </div>
</section>
@endguest

@endsection

@push('head')
<style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush
