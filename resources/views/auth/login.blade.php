@extends('layouts.app')

@section('title', 'Iniciar Sesión — MoniWis Sushi')
@section('description', 'Inicia sesión en MoniWis Sushi para acceder a pedidos por WhatsApp.')

@section('content')

<section class="min-h-screen flex items-center justify-center py-16 hero-bg" aria-label="Iniciar sesión">
    <div class="w-full max-w-md mx-auto px-4">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-2">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl"
                     style="background: linear-gradient(135deg, #E8192C, #B5111F); box-shadow: 0 8px 32px rgba(232,25,44,0.4);">
                    🍣
                </div>
                <span class="text-2xl font-black" style="font-family:'Playfair Display',serif; color:#F5C842;">MoniWis Sushi</span>
            </a>
            <h1 class="text-xl font-semibold text-white mt-4">Bienvenido de vuelta</h1>
            <p class="text-slate-400 text-sm mt-1">Inicia sesión para hacer tus pedidos</p>
        </div>

        {{-- Card --}}
        <div class="glass-card p-8">

            {{-- Errors --}}
            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl" style="background: rgba(232,25,44,0.1); border: 1px solid rgba(232,25,44,0.3);" role="alert">
                    <p class="text-sm font-medium mb-2" style="color:#E8192C;">⚠️ Por favor corrige los siguientes errores:</p>
                    <ul class="text-xs text-slate-300 space-y-1 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5" aria-label="Formulario de inicio de sesión" novalidate>
                @csrf

                <div>
                    <label for="login-email" class="block text-sm font-medium text-slate-300 mb-2">
                        Correo electrónico
                    </label>
                    <input type="email"
                           id="login-email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email"
                           placeholder="tu@correo.com"
                           class="input-dark @error('email') border-red-500 @enderror"
                           aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}">
                    @error('email')
                        <p id="email-error" class="mt-1 text-xs" style="color:#E8192C;" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="login-password" class="block text-sm font-medium text-slate-300">Contraseña</label>
                    </div>
                    <input type="password"
                           id="login-password"
                           name="password"
                           required
                           autocomplete="current-password"
                           placeholder="••••••••"
                           class="input-dark @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-xs" style="color:#E8192C;" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" id="remember" name="remember"
                           class="w-4 h-4 rounded accent-red-600 cursor-pointer">
                    <label for="remember" class="text-sm text-slate-400 cursor-pointer">Mantener sesión iniciada</label>
                </div>

                <button type="submit" class="btn-primary w-full justify-center py-3 text-base">
                    🔐 Iniciar Sesión
                </button>
            </form>

            <div class="mt-6 pt-6 text-center" style="border-top: 1px solid rgba(255,255,255,0.08);">
                <p class="text-sm text-slate-400">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="font-semibold hover:underline transition-colors" style="color:#E8192C;">
                        Regístrate gratis
                    </a>
                </p>
            </div>
        </div>

        <p class="text-center text-xs text-slate-600 mt-6">
            Al iniciar sesión aceptas nuestros
            <span class="text-slate-500">Términos de Servicio</span>
        </p>
    </div>
</section>

@endsection
