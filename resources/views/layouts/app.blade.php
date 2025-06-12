<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Banco de documentos')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('files.index') }}">Banco de Documentos</a>
            
            <div class="navbar-nav ms-auto">
                @auth
                    <span class="navbar-text me-3">Hola, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Cerrar Sesión</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="bg-light text-center py-3">
        <p>&copy; {{ date('Y') }} Banco de Documentos. Desarrollado por <strong>{{ 'Lic. Ariel Canepuccia' }}</strong></p>
    </footer>    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
