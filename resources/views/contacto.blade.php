@extends('layouts.app')

@section('title', 'Contacto — MoniWis Sushi')
@section('description', 'Contáctanos para reservas, consultas o feedback. MoniWis Sushi está siempre disponible para atenderte.')

@section('content')

{{-- Header --}}
<section class="py-20 relative overflow-hidden" style="background: linear-gradient(180deg, #0F1117 0%, #080A0F 100%);" aria-label="Contacto encabezado">
    <div class="absolute inset-0 pointer-events-none" aria-hidden="true"
         style="background: radial-gradient(ellipse at 50% 0%, rgba(232,25,44,0.12) 0%, transparent 60%);"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold mb-4"
             style="background: rgba(232,25,44,0.15); border: 1px solid rgba(232,25,44,0.3); color:#E8192C;">
            📞 Contáctanos
        </div>
        <h1 class="text-5xl md:text-6xl font-black text-white mb-4" style="font-family:'Playfair Display',serif;">
            Hablemos
        </h1>
        <p class="text-lg text-slate-400 max-w-2xl mx-auto">Estamos aquí para ayudarte con cualquier consulta, reserva o pedido especial.</p>
    </div>
</section>

{{-- Content --}}
<section class="py-20" style="background: #080A0F;" aria-label="Información de contacto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            {{-- Contact Info --}}
            <div class="space-y-6">
                <h2 class="text-3xl font-black text-white" style="font-family:'Playfair Display',serif;">
                    Encuéntranos
                </h2>
                <p class="text-slate-400 leading-relaxed">
                    Visítanos en nuestra tienda, pídenos por WhatsApp o escríbenos. ¡Siempre listos para preparar tu sushi favorito!
                </p>

                @php
                    $infos = [
                        ['icon'=>'📍','title'=>'Dirección','value'=>'Calle del Sushi 123, Tu Ciudad'],
                        ['icon'=>'📱','title'=>'WhatsApp','value'=>'+56 9 0000 0000','link'=>'https://wa.me/56900000000'],
                        ['icon'=>'📧','title'=>'Email','value'=>'hola@moniwissushi.cl','link'=>'mailto:hola@moniwissushi.cl'],
                        ['icon'=>'🕐','title'=>'Horario','value'=>'Lun–Dom: 12:00 – 23:00 hrs'],
                    ];
                @endphp

                @foreach($infos as $info)
                    <article class="glass-card p-5 flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl flex-shrink-0"
                             style="background: rgba(232,25,44,0.15); border: 1px solid rgba(232,25,44,0.2);">
                            {{ $info['icon'] }}
                        </div>
                        <div>
                            <h3 class="font-semibold text-white text-sm mb-1">{{ $info['title'] }}</h3>
                            @if(isset($info['link']))
                                <a href="{{ $info['link'] }}" target="_blank" rel="noopener"
                                   class="text-slate-400 hover:text-white transition-colors text-sm">
                                    {{ $info['value'] }}
                                </a>
                            @else
                                <p class="text-slate-400 text-sm">{{ $info['value'] }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach

                {{-- WhatsApp CTA --}}
                <a href="https://wa.me/{{ env('WHATSAPP_NUMBER','56900000000') }}"
                   target="_blank" rel="noopener"
                   class="btn-whatsapp w-full justify-center mt-4">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Chatear por WhatsApp
                </a>
            </div>

            {{-- Contact Form --}}
            <div class="glass-card p-8">
                <h2 class="text-2xl font-black text-white mb-6" style="font-family:'Playfair Display',serif;">
                    Envíanos un mensaje
                </h2>
                <form method="POST" action="#" class="space-y-5" aria-label="Formulario de contacto">
                    @csrf
                    <div>
                        <label for="contact-nombre" class="block text-sm font-medium text-slate-300 mb-2">Nombre completo</label>
                        <input type="text" id="contact-nombre" name="nombre" required placeholder="Tu nombre"
                               class="input-dark" autocomplete="name">
                    </div>
                    <div>
                        <label for="contact-email" class="block text-sm font-medium text-slate-300 mb-2">Correo electrónico</label>
                        <input type="email" id="contact-email" name="email" required placeholder="tu@email.com"
                               class="input-dark" autocomplete="email">
                    </div>
                    <div>
                        <label for="contact-asunto" class="block text-sm font-medium text-slate-300 mb-2">Asunto</label>
                        <select id="contact-asunto" name="asunto" class="input-dark">
                            <option value="consulta">Consulta general</option>
                            <option value="reserva">Reserva de mesa</option>
                            <option value="pedido">Pedido especial</option>
                            <option value="sugerencia">Sugerencia</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div>
                        <label for="contact-mensaje" class="block text-sm font-medium text-slate-300 mb-2">Mensaje</label>
                        <textarea id="contact-mensaje" name="mensaje" rows="4" required placeholder="Escribe tu mensaje aquí..."
                                  class="input-dark resize-none"></textarea>
                    </div>
                    <button type="submit" class="btn-primary w-full justify-center py-3">
                        📨 Enviar Mensaje
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
