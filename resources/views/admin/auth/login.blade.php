<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingreso de super usuario · MegaOfertas</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='24' fill='%234F46E5'/%3E%3Ctext x='50' y='72' font-size='62' text-anchor='middle'%3E%E2%9A%A1%3C/text%3E%3C/svg%3E">
    <link rel="stylesheet" href="{{ asset('css/store.css') }}">
</head>
<body class="login-body">
    <div class="login-wrap">
        <div class="login-card">
            <a class="logo logo-login" href="{{ route('home') }}">
                <span class="logo-badge">⚡</span>
                <span class="logo-text">Mega<em>Ofertas</em></span>
            </a>
            <h1>Panel de super usuario</h1>
            <p class="login-sub">Acceso restringido al administrador de la tienda</p>

            @if ($errors->any())
                <div class="flash flash-error">{{ $errors->first() }}</div>
            @endif
            @if (session('status'))
                <div class="flash flash-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login.attempt') }}" class="login-form">
                @csrf
                <div class="field">
                    <label for="email">Correo electrónico</label>
                    <input id="email" name="email" type="email" required autofocus autocomplete="username"
                           value="{{ old('email') }}" placeholder="admin@megaofertas.com">
                </div>
                <div class="field">
                    <label for="password">Contraseña</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="••••••••">
                </div>
                <label class="fcheck">
                    <input type="checkbox" name="remember" value="1"> Recordarme en este dispositivo
                </label>
                <button type="submit" class="btn btn-primary btn-lg btn-block">Ingresar al panel →</button>
            </form>

            <div class="login-demo">
                <strong>Demo:</strong> admin@megaofertas.com · admin1234
            </div>
            <a class="login-back" href="{{ route('home') }}">← Volver a la tienda</a>
        </div>
    </div>
</body>
</html>
