@extends('layouts.app')

@section('title', 'Crear Cuenta — MoniWis Sushi')
@section('description', 'Regístrate gratis en MoniWis Sushi y comienza a pedir tu sushi favorito por WhatsApp.')

@section('content')

<section class="min-h-screen flex items-center justify-center py-16 hero-bg" aria-label="Registro de usuario">
    <div class="w-full max-w-md mx-auto px-4">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex flex-col items-center gap-2">
                <div class="w-20 h-20 rounded-full overflow-hidden" style="box-shadow: 0 8px 20px rgba(232,25,44,0.4);">
                    <img src="{{ asset('images/logo-cat-sushi.jpg') }}" alt="MoniWis Sushi" class="w-full h-full object-cover">
                </div>
                <span class="text-2xl font-black" style="font-family:'Playfair Display',serif; color:#F5C842;">MoniWis Sushi</span>
            </a>
            <h1 class="text-xl font-semibold text-white mt-4">Crear cuenta</h1>
            <p class="text-slate-400 text-sm mt-1">Gratis y sin complicaciones</p>
        </div>

        {{-- Info badge primer usuario --}}
        @if(\App\Models\User::count() === 0)
            <div class="mb-4 p-3 rounded-xl text-center text-sm font-medium"
                 style="background: rgba(245,200,66,0.1); border: 1px solid rgba(245,200,66,0.3); color:#F5C842;">
                👑 ¡Serás el primer usuario y tendrás acceso de Administrador!
            </div>
        @endif

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

            <form method="POST" action="{{ route('register') }}" class="space-y-5" aria-label="Formulario de registro" novalidate>
                @csrf

                {{-- Nombre --}}
                <div>
                    <label for="reg-nombre" class="block text-sm font-medium text-slate-300 mb-2">
                        Nombre completo <span style="color:#E8192C;" aria-label="requerido">*</span>
                    </label>
                    <input type="text"
                           id="reg-nombre"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           autocomplete="name"
                           placeholder="Tu nombre completo"
                           class="input-dark @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-xs" style="color:#E8192C;" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="reg-email" class="block text-sm font-medium text-slate-300 mb-2">
                        Correo electrónico <span style="color:#E8192C;" aria-label="requerido">*</span>
                    </label>
                    <input type="email"
                           id="reg-email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autocomplete="email"
                           placeholder="tu@correo.com"
                           class="input-dark @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-xs" style="color:#E8192C;" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Teléfono --}}
                <div>
                    <label for="reg-telefono" class="block text-sm font-medium text-slate-300 mb-2">
                        Teléfono <span class="text-xs text-slate-500 font-normal">(opcional, para delivery)</span>
                    </label>
                    <input type="tel"
                           id="reg-telefono"
                           name="telefono"
                           value="{{ old('telefono') }}"
                           autocomplete="tel"
                           placeholder="+56 9 1234 5678"
                           class="input-dark @error('telefono') border-red-500 @enderror">
                    @error('telefono')
                        <p class="mt-1 text-xs" style="color:#E8192C;" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="reg-password" class="block text-sm font-medium text-slate-300 mb-2">
                        Contraseña <span style="color:#E8192C;" aria-label="requerido">*</span>
                    </label>
                    <input type="password"
                           id="reg-password"
                           name="password"
                           required
                           autocomplete="new-password"
                           placeholder="Mínimo 8 caracteres"
                           class="input-dark @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-xs" style="color:#E8192C;" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="reg-password-confirm" class="block text-sm font-medium text-slate-300 mb-2">
                        Confirmar contraseña <span style="color:#E8192C;" aria-label="requerido">*</span>
                    </label>
                    <input type="password"
                           id="reg-password-confirm"
                           name="password_confirmation"
                           required
                           autocomplete="new-password"
                           placeholder="Repite tu contraseña"
                           class="input-dark">
                </div>

                <button type="submit" class="btn-primary w-full justify-center py-3 text-base">
                    ✨ Crear Cuenta
                </button>
            </form>

            <div class="mt-6 pt-6 text-center" style="border-top: 1px solid rgba(255,255,255,0.08);">
                <p class="text-sm text-slate-400">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="font-semibold hover:underline transition-colors" style="color:#E8192C;">
                        Iniciar sesión
                    </a>
                </p>
            </div>
        </div>

        <p class="text-center text-xs text-slate-600 mt-6">
            Al registrarte aceptas nuestros
            <span class="text-slate-500">Términos de Servicio</span>
        </p>
    </div>
</section>

@endsection
