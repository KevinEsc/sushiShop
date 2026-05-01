<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO --}}
    <title>@yield('title', 'MoniWis Sushi — Sabor Japonés Auténtico')</title>
    <meta name="description" content="@yield('description', 'MoniWis Sushi — La mejor experiencia de sushi en tu ciudad. Rolls artesanales, nigiri, sashimi y combos especiales. Pedidos por WhatsApp.')">
    <meta name="keywords" content="@yield('keywords', 'sushi, rolls, nigiri, sashimi, comida japonesa, delivery sushi, MoniWis')">
    <meta name="author" content="MoniWis Sushi">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', 'MoniWis Sushi — Sabor Japonés Auténtico')">
    <meta property="og:description" content="@yield('og_description', 'La mejor experiencia de sushi artesanal. Pedidos directos por WhatsApp.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="MoniWis Sushi">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'MoniWis Sushi')">
    <meta name="twitter:description" content="@yield('description', 'Sushi artesanal con delivery por WhatsApp.')">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;600;700;800&display=swap" rel="stylesheet">

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="min-h-screen flex flex-col" style="background-color: #080A0F; font-family: 'Outfit', sans-serif;">

    {{-- ═══════════════ NAVBAR ═══════════════ --}}
    <header id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300" style="background: rgba(8,10,15,0.7); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.06);">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" aria-label="Navegación principal">
            <div class="flex items-center justify-between h-16 md:h-20">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group" aria-label="MoniWis Sushi - Inicio">
                    <div class="w-12 h-12 group-hover:scale-110 transition-transform duration-300 flex-shrink-0"
                         style="filter: drop-shadow(0 4px 10px rgba(232,25,44,0.4));">
                        <img src="{{ asset('images/logo-cat-normal.png') }}" alt="MoniWis Sushi logo gato cálico" class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col leading-none">
                        <span class="font-black text-lg tracking-tight" style="font-family:'Playfair Display',serif; color:#F5C842;">MoniWis</span>
                        <span class="text-xs font-medium tracking-widest uppercase" style="color:rgba(226,232,240,0.6);">Sushi</span>
                    </div>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('home') ? 'text-white bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/8' }}">
                        Inicio
                    </a>
                    <a href="{{ route('tienda') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('tienda') ? 'text-white bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/8' }}">
                        Menú
                    </a>
                    <a href="{{ route('contacto') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('contacto') ? 'text-white bg-white/10' : 'text-slate-300 hover:text-white hover:bg-white/8' }}">
                        Contacto
                    </a>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                               class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                               style="color:#F5C842;">
                                ⚙️ Dashboard
                            </a>
                        @endif
                        <a href="{{ route('pedido.index') }}"
                           class="btn-primary text-sm py-2 px-5">
                            🛒 Hacer Pedido
                        </a>
                        <div class="relative group">
                            <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-slate-300 hover:text-white hover:bg-white/8 transition-all duration-200">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white"
                                     style="background: linear-gradient(135deg, #E8192C, #B5111F);">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                {{ explode(' ', auth()->user()->name)[0] }}
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div class="absolute right-0 top-full mt-2 w-44 rounded-xl overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200"
                                 style="background: #1E2330; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 20px 60px rgba(0,0,0,0.5);">
                                <div class="p-3 border-b" style="border-color: rgba(255,255,255,0.08);">
                                    <p class="text-xs text-slate-400">Conectado como</p>
                                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                                    @if(auth()->user()->isAdmin())
                                        <span class="text-xs font-bold" style="color:#F5C842;">👑 Administrador</span>
                                    @endif
                                </div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-slate-300 hover:bg-white/5 hover:text-white transition-colors duration-200 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-white/8 transition-all duration-200">
                            Iniciar Sesión
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary text-sm py-2 px-5">
                            Registrarse
                        </a>
                    @endauth
                </div>

                {{-- Mobile menu button --}}
                <button id="menu-btn" class="md:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/8 transition-colors" aria-label="Abrir menú" aria-expanded="false" aria-controls="mobile-menu">
                    <svg id="icon-open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg id="icon-close" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="hidden md:hidden pb-4" role="navigation" aria-label="Menú móvil">
                <div class="flex flex-col gap-1 pt-2" style="border-top: 1px solid rgba(255,255,255,0.08);">
                    <a href="{{ route('home') }}" class="px-4 py-3 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-white/8 transition-all">Inicio</a>
                    <a href="{{ route('tienda') }}" class="px-4 py-3 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-white/8 transition-all">Menú</a>
                    <a href="{{ route('contacto') }}" class="px-4 py-3 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-white/8 transition-all">Contacto</a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-3 rounded-lg text-sm font-medium transition-all" style="color:#F5C842;">⚙️ Dashboard Admin</a>
                        @endif
                        <a href="{{ route('pedido.index') }}" class="px-4 py-3 rounded-lg text-sm font-medium text-white transition-all" style="background: linear-gradient(135deg,#E8192C,#B5111F);">🛒 Hacer Pedido</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 rounded-lg text-sm font-medium text-slate-400 hover:text-white hover:bg-white/8 transition-all">Cerrar sesión</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-3 rounded-lg text-sm font-medium text-slate-300 hover:text-white hover:bg-white/8 transition-all">Iniciar sesión</a>
                        <a href="{{ route('register') }}" class="px-4 py-3 rounded-lg text-sm font-medium text-white text-center transition-all" style="background: linear-gradient(135deg,#E8192C,#B5111F);">Registrarse</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    {{-- ═══════════════ FLASH MESSAGES ═══════════════ --}}
    @if(session('success') || session('error'))
        <div id="flash-msg" class="fixed top-20 right-4 z-50 max-w-sm w-full animate-fade-in-up" role="alert" aria-live="polite">
            @if(session('success'))
                <div class="flex items-start gap-3 p-4 rounded-xl" style="background: rgba(37,211,102,0.15); border: 1px solid rgba(37,211,102,0.3); backdrop-filter: blur(20px);">
                    <span class="text-xl flex-shrink-0">✅</span>
                    <p class="text-sm font-medium" style="color: #25D366;">{{ session('success') }}</p>
                    <button onclick="document.getElementById('flash-msg').remove()" class="ml-auto text-white/40 hover:text-white transition-colors">✕</button>
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-start gap-3 p-4 rounded-xl" style="background: rgba(232,25,44,0.15); border: 1px solid rgba(232,25,44,0.3); backdrop-filter: blur(20px);">
                    <span class="text-xl flex-shrink-0">❌</span>
                    <p class="text-sm font-medium" style="color: #E8192C;">{{ session('error') }}</p>
                    <button onclick="document.getElementById('flash-msg').remove()" class="ml-auto text-white/40 hover:text-white transition-colors">✕</button>
                </div>
            @endif
        </div>
    @endif

    {{-- ═══════════════ MAIN CONTENT ═══════════════ --}}
    <main class="flex-1 pt-16 md:pt-20">
        @yield('content')
    </main>

    {{-- ═══════════════ FOOTER ═══════════════ --}}
    <footer style="background: #0F1117; border-top: 1px solid rgba(255,255,255,0.06);" role="contentinfo">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 flex-shrink-0" style="filter: drop-shadow(0 4px 10px rgba(232,25,44,0.3));">
                            <img src="{{ asset('images/logo-cat-normal.png') }}" alt="MoniWis Sushi" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <span class="font-black text-lg" style="font-family:'Playfair Display',serif; color:#F5C842;">MoniWis</span>
                            <span class="text-xs block text-slate-500 tracking-widest uppercase">Sushi</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">Auténtica cocina japonesa hecha con pasión. Cada roll es una obra de arte.</p>
                </div>

                {{-- Links --}}
                <nav aria-label="Enlaces del footer">
                    <h3 class="text-sm font-semibold text-white mb-4 uppercase tracking-widest">Navegación</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Inicio</a></li>
                        <li><a href="{{ route('tienda') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Menú</a></li>
                        <li><a href="{{ route('contacto') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Contacto</a></li>
                        @auth
                            <li><a href="{{ route('pedido.index') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Hacer Pedido</a></li>
                        @else
                            <li><a href="{{ route('register') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Registrarse</a></li>
                        @endauth
                    </ul>
                </nav>

                {{-- Contact --}}
                <div>
                    <h3 class="text-sm font-semibold text-white mb-4 uppercase tracking-widest">Contacto</h3>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-sm text-slate-400">
                            <span>📍</span> Tu ciudad, País
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-400">
                            <span>📱</span>
                            <a href="https://wa.me/{{ config('app.whatsapp_number') }}" target="_blank" rel="noopener" class="hover:text-white transition-colors">
                                WhatsApp
                            </a>
                        </li>
                        <li class="flex items-center gap-3 text-sm text-slate-400">
                            <span>🕐</span> Lun–Dom: 12:00–23:00
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 pt-6 flex flex-col md:flex-row items-center justify-between gap-4" style="border-top: 1px solid rgba(255,255,255,0.06);">
                <p class="text-xs text-slate-600">© {{ date('Y') }} MoniWis Sushi. Todos los derechos reservados.</p>
                <p class="text-xs text-slate-600">Hecho con ❤️ y mucho 🍣</p>
            </div>
        </div>
    </footer>

    {{-- Auto-dismiss flash after 5s --}}
    <script>
        setTimeout(() => {
            const flash = document.getElementById('flash-msg');
            if (flash) flash.style.opacity = '0', flash.style.transition = 'opacity 0.5s', setTimeout(() => flash.remove(), 500);
        }, 5000);
    </script>

    @stack('scripts')
</body>
</html>
