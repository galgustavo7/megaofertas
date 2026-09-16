@extends('layouts.app')

@section('title', 'Contacto — MegaOfertas')

@section('content')
<section class="page-head">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Ruta">
            <a href="{{ route('home') }}">Inicio</a> <span>/</span> <strong>Contacto</strong>
        </nav>
        <h1>Hablemos 💬</h1>
        <p>¿Dudas con un producto, una sugerencia o quieres anunciarte? Responderemos en menos de 24 h.</p>
    </div>
</section>

<section class="section">
    <div class="container contact-layout">
        <div class="contact-cards">
            <div class="contact-card">
                <span class="cc-icon">📧</span>
                <h3>Correo</h3>
                <p>hola@megaofertas.com</p>
                <small>Respuesta en 24 h</small>
            </div>
            <div class="contact-card">
                <span class="cc-icon">💬</span>
                <h3>WhatsApp</h3>
                <p>+1 (555) 012-3456</p>
                <small>Lun–Vie · 9am–5pm VET</small>
            </div>
            <div class="contact-card">
                <span class="cc-icon">📍</span>
                <h3>Base</h3>
                <p>Barquisimeto, Venezuela</p>
                <small>100% en línea</small>
            </div>
        </div>

        <form class="contact-form" method="POST" action="{{ route('contact.store') }}">
            @csrf
            <div class="form-row">
                <div class="field">
                    <label for="name">Nombre *</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}" placeholder="Tu nombre">
                    @error('name')<span class="field-error">{{ $message }}</span>@enderror
                </div>
                <div class="field">
                    <label for="email">Correo *</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}" placeholder="tu@correo.com">
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="field">
                <label for="subject">Asunto</label>
                <input id="subject" name="subject" type="text" value="{{ old('subject') }}" placeholder="¿Sobre qué es?">
                @error('subject')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <div class="field">
                <label for="message">Mensaje *</label>
                <textarea id="message" name="message" rows="6" required placeholder="Cuéntanos con detalle…">{{ old('message') }}</textarea>
                @error('message')<span class="field-error">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Enviar mensaje 🚀</button>
        </form>
    </div>
</section>
@endsection
