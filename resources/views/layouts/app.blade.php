<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Banco de documentos')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #0ea5e9;
            --light-color: #f8fafc;
            --dark-color: #0f172a;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --border-radius: 0.75rem;
            --transition: all 0.2s ease-in-out;
        }

        [data-bs-theme="dark"] {
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --secondary-color: #94a3b8;
            --light-color: #1e293b;
            --dark-color: #f1f5f9;
            --border-color: #334155;
            --bs-body-bg: #0f172a;
            --bs-body-color: #f1f5f9;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            transition: var(--transition);
        }

        [data-bs-theme="dark"] body {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
        }

        [data-bs-theme="dark"] .navbar {
            background: rgba(15, 23, 42, 0.95) !important;
            border-bottom-color: var(--border-color);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link {
            font-weight: 500;
            color: var(--secondary-color) !important;
            transition: var(--transition);
            border-radius: 0.5rem;
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
            background-color: rgba(37, 99, 235, 0.1);
        }

        .theme-toggle {
            background: none;
            border: 1px solid var(--border-color);
            color: var(--secondary-color);
            border-radius: 0.5rem;
            padding: 0.5rem;
            transition: var(--transition);
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-toggle:hover {
            background-color: rgba(37, 99, 235, 0.1);
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .main-content {
            background: transparent;
            padding: 2rem 0;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
        }

        [data-bs-theme="dark"] .card {
            background: rgba(30, 41, 59, 0.95);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        .card-header {
            background: rgba(37, 99, 235, 0.05);
            border-bottom: 1px solid rgba(37, 99, 235, 0.1);
            border-radius: calc(var(--border-radius) - 1px) calc(var(--border-radius) - 1px) 0 0 !important;
            padding: 1.25rem;
        }

        [data-bs-theme="dark"] .card-header {
            background: rgba(59, 130, 246, 0.1);
            border-bottom-color: rgba(59, 130, 246, 0.2);
        }

        .stats-card {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
        }

        .stats-card .card-body {
            padding: 2rem 1.5rem;
        }

        .stats-icon {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .form-control, .form-select {
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.8);
        }

        [data-bs-theme="dark"] .form-control, 
        [data-bs-theme="dark"] .form-select {
            background: rgba(30, 41, 59, 0.8);
            border-color: var(--border-color);
            color: var(--dark-color);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
            background: rgba(255, 255, 255, 1);
        }

        .table {
            background: transparent;
        }

        .table th {
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: var(--secondary-color);
            padding: 1rem 0.75rem;
        }

        .table td {
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: rgba(37, 99, 235, 0.05);
        }

        [data-bs-theme="dark"] .table tbody tr:hover {
            background: rgba(59, 130, 246, 0.1);
        }

        .badge {
            font-weight: 500;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
        }

        .alert {
            border: none;
            border-radius: 0.5rem;
            padding: 1rem 1.25rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
        }

        .pagination .page-link {
            border: 1px solid var(--border-color);
            color: var(--secondary-color);
            background: rgba(255, 255, 255, 0.8);
            margin: 0 0.125rem;
            border-radius: 0.375rem;
        }

        [data-bs-theme="dark"] .pagination .page-link {
            background: rgba(30, 41, 59, 0.8);
            border-color: var(--border-color);
        }

        .pagination .page-link:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .footer {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-top: 1px solid var(--border-color);
            margin-top: 4rem;
        }

        [data-bs-theme="dark"] .footer {
            background: rgba(15, 23, 42, 0.95);
        }

        .file-icon {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border-radius: 0.5rem;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-avatar {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .btn-group .btn {
            border-radius: 0.375rem;
            margin: 0 0.125rem;
        }

        .modal-content {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--shadow-lg);
        }

        .search-box {
            background: rgba(255, 255, 255, 0.9);
            border-radius: var(--border-radius);
            padding: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        [data-bs-theme="dark"] .search-box {
            background: rgba(30, 41, 59, 0.9);
        }

        .upload-zone {
            border: 2px dashed var(--border-color);
            border-radius: var(--border-radius);
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
        }

        .upload-zone:hover {
            border-color: var(--primary-color);
            background: rgba(37, 99, 235, 0.05);
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem 0;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .stats-card .card-body {
                padding: 1.5rem 1rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('files.index') }}">
                <i class="fas fa-folder-open"></i>
                Banco de Documentos
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav me-auto">
                    <a class="nav-link" href="{{ route('files.index') }}">
                        <i class="fas fa-file-alt me-1"></i>
                        Documentos
                    </a>
                    <a class="nav-link" href="{{ route('files.logs') }}">
                        <i class="fas fa-history me-1"></i>
                        Logs
                    </a>
                </div>
                
                <div class="navbar-nav ms-auto d-flex align-items-center">
                    <button class="theme-toggle me-3" onclick="toggleTheme()" title="Cambiar tema">
                        <i class="fas fa-moon" id="theme-icon"></i>
                    </button>
                    
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><h6 class="dropdown-header">{{ Auth::user()->email }}</h6></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>
                                            Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

    <footer class="footer text-center py-4">
        <div class="container">
            <p class="mb-0 text-muted">
                &copy; {{ date('Y') }} Banco de Documentos. 
                Desarrollado con <i class="fas fa-heart text-danger"></i> por 
                <strong>Lic. Ariel Canepuccia</strong>
            </p>
        </div>
    </footer>    

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Theme toggle functionality
        function toggleTheme() {
            const html = document.documentElement;
            const themeIcon = document.getElementById('theme-icon');
            const currentTheme = html.getAttribute('data-bs-theme');
            
            if (currentTheme === 'dark') {
                html.setAttribute('data-bs-theme', 'light');
                themeIcon.className = 'fas fa-moon';
                localStorage.setItem('theme', 'light');
            } else {
                html.setAttribute('data-bs-theme', 'dark');
                themeIcon.className = 'fas fa-sun';
                localStorage.setItem('theme', 'dark');
            }
        }

        // Load saved theme
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            const html = document.documentElement;
            const themeIcon = document.getElementById('theme-icon');
            
            html.setAttribute('data-bs-theme', savedTheme);
            if (savedTheme === 'dark') {
                themeIcon.className = 'fas fa-sun';
            } else {
                themeIcon.className = 'fas fa-moon';
            }

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Add fade-in animation to cards
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('fade-in');
                }, index * 100);
            });
        });

        // Form loading states
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.classList.add('loading');
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando...';
                }
            });
        });
    </script>
</body>
</html>