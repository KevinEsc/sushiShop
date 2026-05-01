@extends('layouts.app')

@section('title', 'MoniWis Sushi — Sabor Japonés Auténtico')
@section('description', 'Descubre el auténtico sabor del sushi artesanal en MoniWis. Rolls premium, nigiri, sashimi y combos especiales. Pedidos directos por WhatsApp.')
@section('keywords', 'sushi artesanal, rolls premium, nigiri, sashimi, delivery sushi, MoniWis Sushi')

@section('content')

{{-- ═══════════════════════════════════════════════════════
     HERO SECTION
════════════════════════════════════════════════════════ --}}
<section class="hero-bg relative overflow-hidden min-h-screen flex items-center" aria-label="Bienvenida">

    {{-- Decorative particles --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
        <div class="particle w-64 h-64 opacity-10 rounded-full" style="background: radial-gradient(circle, #E8192C, transparent); top: 10%; left: -5%; animation-delay: 0s;"></div>
        <div class="particle w-48 h-48 opacity-8 rounded-full" style="background: radial-gradient(circle, #F5C842, transparent); top: 60%; right: -3%; animation-delay: 2s;"></div>
        <div class="particle w-32 h-32 opacity-10 rounded-full" style="background: radial-gradient(circle, #E8192C, transparent); bottom: 20%; left: 30%; animation-delay: 4s;"></div>

        {{-- Grid pattern --}}
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px); background-size: 60px 60px;"></div>

        {{-- Emoji decorativos flotantes --}}
        <div class="absolute text-6xl select-none" style="top: 15%; right: 8%; animation: float-particle 6s ease-in-out infinite; opacity: 0.15;">🍱</div>
        <div class="absolute text-5xl select-none" style="top: 45%; right: 15%; animation: float-particle 8s ease-in-out infinite 1s; opacity: 0.12;">🥢</div>
        <div class="absolute text-4xl select-none" style="bottom: 25%; left: 8%; animation: float-particle 7s ease-in-out infinite 2s; opacity: 0.12;">🍣</div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- Hero Text --}}
            <div class="text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold mb-6 animate-fade-in"
                     style="background: rgba(232,25,44,0.15); border: 1px solid rgba(232,25,44,0.3); color:#E8192C;">
                    🍣 &nbsp; Auténtica Cocina Japonesa
                </div>

                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black leading-none mb-6 animate-fade-in-up"
                    style="font-family:'Playfair Display',serif;">
                    <span class="text-white">El arte del</span><br>
                    <span class="text-gradient-red">sushi</span>
                    <span class="text-white"> en cada</span><br>
                    <span class="text-gradient-gold">bocado.</span>
                </h1>

                <p class="text-lg text-slate-400 max-w-xl mx-auto lg:mx-0 leading-relaxed mb-10 animate-fade-in-up delay-200">
                    Rolls artesanales elaborados con los ingredientes más frescos, técnica japonesa y un toque creativo único. Tu mesa favorita, ahora con delivery.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start animate-fade-in-up delay-300">
                    <a href="{{ route('tienda') }}" class="btn-primary text-base px-8 py-4">
                        🍱 Ver Menú Completo
                    </a>
                    @auth
                        <a href="{{ route('pedido.index') }}" class="btn-secondary text-base px-8 py-4">
                            📱 Hacer Pedido
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-secondary text-base px-8 py-4">
                            ✨ Únete Gratis
                        </a>
                    @endauth
                </div>

                {{-- Stats --}}
                <div class="flex items-center justify-center lg:justify-start gap-8 mt-12 animate-fade-in-up delay-400">
                    <div class="text-center">
                        <div class="text-3xl font-black text-gradient-gold">50+</div>
                        <div class="text-xs text-slate-500 mt-1 uppercase tracking-wider">Variedades</div>
                    </div>
                    <div class="h-8 w-px" style="background: rgba(255,255,255,0.1);"></div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-gradient-red">100%</div>
                        <div class="text-xs text-slate-500 mt-1 uppercase tracking-wider">Fresco</div>
                    </div>
                    <div class="h-8 w-px" style="background: rgba(255,255,255,0.1);"></div>
                    <div class="text-center">
                        <div class="text-3xl font-black" style="color:#25D366;">📱</div>
                        <div class="text-xs text-slate-500 mt-1 uppercase tracking-wider">WhatsApp</div>
                    </div>
                </div>
            </div>

            {{-- Hero Image / Visual --}}
            <div class="relative flex items-center justify-center animate-fade-in delay-200">
                <div class="relative w-80 h-80 sm:w-96 sm:h-96">
                    {{-- Glow ring --}}
                    <div class="absolute inset-0 rounded-full" style="background: radial-gradient(circle, rgba(232,25,44,0.3) 0%, transparent 70%); animation: pulse-red 3s infinite;"></div>

                    {{-- Central element --}}
                    <div class="absolute inset-8 rounded-full flex items-center justify-center"
                         style="background: linear-gradient(135deg, rgba(232,25,44,0.2), rgba(245,200,66,0.1)); border: 2px solid rgba(232,25,44,0.3); backdrop-filter: blur(10px);">
                        <div class="text-center">
                            <div class="text-8xl mb-2" style="filter: drop-shadow(0 10px 30px rgba(232,25,44,0.5));">🍣</div>
                            <div class="text-sm font-semibold text-white">MoniWis Sushi</div>
                            <div class="text-xs text-slate-400">Est. 2024</div>
                        </div>
                    </div>

                    {{-- Orbiting badges --}}
                    <div class="absolute glass-card px-3 py-2 top-0 right-0 flex items-center gap-2 text-xs font-medium text-white" style="animation: float-particle 5s ease-in-out infinite;">
                        🌀 Rolls Fresh
                    </div>
                    <div class="absolute glass-card px-3 py-2 bottom-10 left-0 flex items-center gap-2 text-xs font-medium text-white" style="animation: float-particle 6s ease-in-out infinite 1.5s;">
                        🐟 Sashimi Grade
                    </div>
                    <div class="absolute glass-card px-3 py-2 top-20 left-0 flex items-center gap-2 text-xs font-medium text-white" style="animation: float-particle 7s ease-in-out infinite 3s;">
                        🎁 Combos Especiales
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-pulse-red" aria-hidden="true">
        <span class="text-xs text-slate-500 uppercase tracking-widest">Descubrir</span>
        <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     FEATURES / VALUE PROPS
════════════════════════════════════════════════════════ --}}
<section class="py-24" style="background: #0F1117;" aria-label="Características">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-16">
            <p class="text-xs font-semibold uppercase tracking-widest mb-3" style="color:#E8192C;">Por qué elegirnos</p>
            <h2 class="text-4xl md:text-5xl font-black text-white" style="font-family:'Playfair Display',serif;">
                Más que sushi,<br><span class="text-gradient-gold">una experiencia</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $features = [
                    ['icon' => '🐟', 'title' => 'Ingredientes Premium', 'desc' => 'Seleccionamos el salmón, atún y mariscos más frescos cada día. Sin compromisos con la calidad.', 'color' => '#E8192C'],
                    ['icon' => '👨‍🍳', 'title' => 'Maestros Sushimen', 'desc' => 'Nuestros chefs tienen años de formación en técnica japonesa auténtica para ofrecerte lo mejor.', 'color' => '#F5C842'],
                    ['icon' => '📱', 'title' => 'Pedido por WhatsApp', 'desc' => 'Elige tus rolls, envía tu pedido por WhatsApp y recibe tu sushi en la puerta de tu casa.', 'color' => '#25D366'],
                ];
            @endphp

            @foreach($features as $f)
                <article class="glass-card p-8 text-center group">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl flex items-center justify-center text-3xl transition-transform duration-300 group-hover:scale-110"
                         style="background: rgba(255,255,255,0.05); border: 1px solid {{ $f['color'] }}33;">
                        {{ $f['icon'] }}
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3" style="font-family:'Playfair Display',serif;">{{ $f['title'] }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════
     PRODUCTOS DESTACADOS
════════════════════════════════════════════════════════ --}}
@if($destacados->count() > 0)
<section class="py-24 hero-bg" aria-label="Productos destacados">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-16">
            <p class="text-xs font-semibold uppercase tracking-widest mb-3" style="color:#E8192C;">Nuestras estrellas</p>
            <h2 class="text-4xl md:text-5xl font-black text-white" style="font-family:'Playfair Display',serif;">
                Lo más <span class="text-gradient-red">pedido</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach($destacados as $producto)
                <article class="product-card">
                    <div class="overflow-hidden" style="height: 220px;">
                        <img src="{{ $producto->imagen_url }}"
                             alt="{{ $producto->nombre }}"
                             class="product-img"
                             loading="lazy">
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-medium px-3 py-1 rounded-full capitalize"
                              style="background: rgba(232,25,44,0.15); color:#E8192C; border: 1px solid rgba(232,25,44,0.2);">
                            {{ Producto::categorias()[$producto->categoria] ?? $producto->categoria }}
                        </span>
                        <h3 class="text-lg font-bold text-white mt-3 mb-2" style="font-family:'Playfair Display',serif;">
                            {{ $producto->nombre }}
                        </h3>
                        <p class="text-sm text-slate-400 mb-4 line-clamp-2">{{ $producto->descripcion }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-black text-gradient-gold">
                                ${{ number_format($producto->precio, 0, ',', '.') }}
                            </span>
                            @auth
                                <a href="{{ route('pedido.index') }}" class="btn-primary text-xs px-4 py-2">Pedir</a>
                            @else
                                <a href="{{ route('register') }}" class="btn-secondary text-xs px-4 py-2">Pedir</a>
                            @endauth
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('tienda') }}" class="btn-primary px-10 py-4 text-base">
                Ver Menú Completo →
            </a>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════
     CTA FINAL
════════════════════════════════════════════════════════ --}}
<section class="py-24" style="background: #0F1117;" aria-label="Llamada a la acción">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="glass-card p-12 md:p-16 relative overflow-hidden">
            <div class="absolute inset-0 opacity-5" aria-hidden="true"
                 style="background: radial-gradient(circle at 50% 50%, #E8192C, transparent 70%);"></div>

            <div class="text-6xl mb-6">🥢</div>
            <h2 class="text-4xl md:text-5xl font-black text-white mb-6" style="font-family:'Playfair Display',serif;">
                ¿Listo para tu<br><span class="text-gradient-red">próximo pedido?</span>
            </h2>
            <p class="text-slate-400 text-lg mb-10 max-w-2xl mx-auto">
                Regístrate gratis, elige tus rolls favoritos y envía tu pedido por WhatsApp. ¡Así de simple!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('pedido.index') }}" class="btn-whatsapp">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Hacer mi pedido ahora
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary px-10 py-4 text-base">✨ Crear Cuenta Gratis</a>
                    <a href="{{ route('tienda') }}" class="btn-secondary px-10 py-4 text-base">🍱 Ver el Menú</a>
                @endauth
            </div>
        </div>
    </div>
</section>

@endsection

@push('head')
<style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endpush

@php use App\Models\Producto; @endphp
