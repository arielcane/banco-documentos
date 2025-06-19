@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    
    <!-- Dashboard de estadísticas mejorado -->
    <div class="row mb-5">
        <div class="col-md-4 mb-4">
            <div class="card stats-card text-white border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stats-icon me-4">
                        <i class="fas fa-file-pdf" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h2 class="mb-1 fw-bold">{{ number_format($totalFiles) }}</h2>
                        <p class="mb-0 opacity-75">Total de Documentos</p>
                        <small class="opacity-50">
                            <i class="fas fa-arrow-up me-1"></i>
                            +{{ $recentUploads }} esta semana
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, #10b981, #059669);">
                <div class="card-body d-flex align-items-center text-white">
                    <div class="stats-icon me-4">
                        <i class="fas fa-hdd" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h2 class="mb-1 fw-bold">{{ number_format($totalSize / 1024 / 1024, 1) }} MB</h2>
                        <p class="mb-0 opacity-75">Espacio Utilizado</p>
                        <small class="opacity-50">
                            <i class="fas fa-database me-1"></i>
                            Storage optimizado
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <div class="card-body d-flex align-items-center text-white">
                    <div class="stats-icon me-4">
                        <i class="fas fa-upload" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h2 class="mb-1 fw-bold">{{ $recentUploads }}</h2>
                        <p class="mb-0 opacity-75">Subidos esta semana</p>
                        <small class="opacity-50">
                            <i class="fas fa-clock me-1"></i>
                            Últimos 7 días
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes de éxito/error mejorados -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0" role="alert">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-check-circle" style="font-size: 1.25rem;"></i>
                </div>
                <div>
                    <h6 class="mb-1">¡Operación exitosa!</h6>
                    <p class="mb-0">{{ session('success') }}</p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
            <div class="d-flex align-items-start">
                <div class="me-3 mt-1">
                    <i class="fas fa-exclamation-triangle" style="font-size: 1.25rem;"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-2">Se encontraron errores:</h6>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Formulario de subida mejorado -->
    <div class="card border-0 mb-5">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <div class="stats-icon" style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));">
                        <i class="fas fa-cloud-upload-alt text-white"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">Subir Nuevo Documento</h5>
                    <small class="text-muted">Agrega documentos PDF a tu biblioteca personal</small>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">
                            <i class="fas fa-tag me-2 text-primary"></i>
                            Nombre del Documento <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name" 
                               class="form-control form-control-lg @error('name') is-invalid @enderror" 
                               placeholder="Ej: Contrato de Servicio 2024" 
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tags" class="form-label fw-semibold">
                            <i class="fas fa-tags me-2 text-info"></i>
                            Etiquetas
                        </label>
                        <input type="text" name="tags" id="tags" 
                               class="form-control form-control-lg @error('tags') is-invalid @enderror" 
                               placeholder="Ej: contrato, legal, 2024" 
                               value="{{ old('tags') }}">
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Separa las etiquetas con comas para mejor organización
                        </small>
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <label for="observations" class="form-label fw-semibold">
                            <i class="fas fa-comment-alt me-2 text-warning"></i>
                            Observaciones
                        </label>
                        <textarea name="observations" id="observations" 
                                  class="form-control @error('observations') is-invalid @enderror" 
                                  rows="11" 
                                  placeholder="Describe el contenido del documento o agrega notas importantes...">{{ old('observations') }}</textarea>
                        @error('observations')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="file" class="form-label fw-semibold">
                            <i class="fas fa-file-pdf me-2 text-danger"></i>
                            Archivo PDF <span class="text-danger">*</span>
                        </label>
                        <div class="upload-zone mb-3">
                            <input type="file" name="file" id="file" 
                                   class="form-control form-control-lg @error('file') is-invalid @enderror" 
                                   accept="application/pdf" required>
                            <div class="mt-3">
                                <i class="fas fa-upload text-muted mb-2" style="font-size: 2rem;"></i>
                                <p class="text-muted mb-1">Arrastra tu archivo aquí o haz clic para seleccionar</p>
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt me-1"></i>
                                    Máximo 100MB. Solo archivos PDF permitidos.
                                </small>
                            </div>
                        </div>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center" style="height: 48px;">
                            <i class="fas fa-cloud-upload-alt me-2"></i>
                            <span>Subir Documento</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Buscador mejorado -->
    <div class="card border-0 mb-5">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <div class="stats-icon" style="width: 40px; height: 40px; background: linear-gradient(135deg, #0ea5e9, #0284c7);">
                        <i class="fas fa-search text-white"></i>
                    </div>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">Buscar Documentos</h5>
                    <small class="text-muted">Encuentra rápidamente lo que necesitas</small>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('files.index') }}" method="GET">
                <div class="search-box">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-transparent border-0">
                            <i class="fas fa-search text-primary"></i>
                        </span>
                        <input 
                            type="text" 
                            name="keyword" 
                            class="form-control border-0 bg-transparent" 
                            placeholder="Buscar por nombre, etiquetas o observaciones..." 
                            value="{{ request('keyword') }}"
                        >
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>
                            Buscar
                        </button>
                        @if(request('keyword'))
                            <a href="{{ route('files.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>
                                Limpiar
                            </a>
                        @endif
                    </div>
                </div>
            </form>            
        </div>
    </div>

    <!-- Tabla de resultados mejorada -->
    <div class="card border-0">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <div class="stats-icon" style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                            <i class="fas fa-folder-open text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">
                            @if(request('keyword'))
                                Resultados de búsqueda
                            @else
                                Biblioteca de Documentos
                            @endif
                        </h5>
                        <small class="text-muted">
                            @if(request('keyword'))
                                Para: "<strong>{{ request('keyword') }}</strong>"
                            @else
                                Todos tus documentos organizados
                            @endif
                        </small>
                    </div>
                </div>
                <div class="text-end">
                    <div class="badge bg-primary fs-6">
                        {{ number_format($files->total()) }} documentos
                    </div>
                    @if($files->hasPages())
                        <div class="mt-1">
                            <small class="text-muted">
                                Página {{ $files->currentPage() }} de {{ $files->lastPage() }}
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($files->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="border-0 ps-4">Documento</th>
                                <th class="border-0">Etiquetas</th>
                                <th class="border-0">Observaciones</th>
                                <th class="border-0">Fecha</th>
                                <th class="border-0">Autor</th>
                                <th class="border-0 text-center pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files as $file)
                                <tr class="align-middle">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="file-icon me-3">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark mb-1">{{ $file->name }}</div>
                                                @if($file->original_name && $file->original_name !== $file->name)
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-file me-1"></i>{{ $file->original_name }}
                                                    </small>
                                                @endif
                                                @if($file->file_size)
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-weight me-1"></i>{{ number_format($file->file_size / 1024, 1) }} KB
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($file->tags)
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach(explode(',', $file->tags) as $tag)
                                                    <span class="badge bg-secondary-subtle text-secondary border">
                                                        <i class="fas fa-tag me-1"></i>{{ trim($tag) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic">
                                                <i class="fas fa-minus me-1"></i>Sin etiquetas
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($file->observations)
                                            <div class="position-relative">
                                                <p class="mb-0">{{ Str::limit($file->observations, 40) }}</p>
                                                @if(strlen($file->observations) > 40)
                                                    <button class="btn btn-link btn-sm p-0 text-primary" 
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="top"
                                                            data-bs-title="{{ $file->observations }}">
                                                        <i class="fas fa-info-circle"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic">
                                                <i class="fas fa-minus me-1"></i>Sin observaciones
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <div class="fw-semibold">{{ $file->created_at->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $file->created_at->format('H:i') }}</small>
                                            <div class="mt-1">
                                                <small class="badge bg-light text-dark">
                                                    {{ $file->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2">
                                                {{ substr($file->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $file->user->name ?? 'Usuario eliminado' }}</div>
                                                <small class="text-muted">{{ $file->user->email ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('files.download', $file) }}" 
                                               class="btn btn-success btn-sm" 
                                               data-bs-toggle="tooltip" 
                                               data-bs-title="Descargar archivo">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            
                                            {{-- Mostrar botón de eliminar solo si el usuario es el dueño del archivo o es admin --}}
                                            @if(Auth::id() === $file->user_id || Auth::user()->is_admin ?? false)
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal{{ $file->id }}"
                                                        data-bs-tooltip="tooltip" 
                                                        data-bs-title="Eliminar documento">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal de confirmación para eliminar mejorado --}}
                                @if(Auth::id() === $file->user_id || Auth::user()->is_admin ?? false)
                                    <div class="modal fade" id="deleteModal{{ $file->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $file->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title d-flex align-items-center" id="deleteModalLabel{{ $file->id }}">
                                                        <div class="me-3">
                                                            <div class="rounded-circle bg-danger-subtle p-2">
                                                                <i class="fas fa-exclamation-triangle text-danger"></i>
                                                            </div>
                                                        </div>
                                                        Confirmar eliminación
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body pt-0">
                                                    <p class="mb-3">¿Estás seguro de que deseas eliminar el documento?</p>
                                                    
                                                    <div class="card bg-light border-0 mb-3">
                                                        <div class="card-body p-3">
                                                            <div class="d-flex align-items-center">
                                                                <div class="file-icon me-3" style="width: 35px; height: 35px;">
                                                                    <i class="fas fa-file-pdf" style="font-size: 1rem;"></i>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-bold">{{ $file->name }}</div>
                                                                    <small class="text-muted">
                                                                        {{ $file->user->name ?? 'Usuario eliminado' }} • 
                                                                        {{ $file->created_at->format('d/m/Y H:i') }}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="alert alert-warning border-0">
                                                        <div class="d-flex align-items-start">
                                                            <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                                                            <div>
                                                                <strong>¡Atención!</strong><br>
                                                                Esta acción no se puede deshacer. El archivo se eliminará permanentemente del servidor.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i>
                                                        Cancelar
                                                    </button>
                                                    <form action="{{ route('files.destroy', $file) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash me-1"></i>
                                                            Eliminar definitivamente
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación mejorada -->
                @if($files->hasPages())
                    <div class="card-footer bg-light border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center flex-column flex-md-row gap-3">
                            <div>
                                <small class="text-muted">
                                    Mostrando {{ $files->firstItem() }} - {{ $files->lastItem() }} de {{ number_format($files->total()) }} documentos
                                </small>
                            </div>
                            <div>
                                <nav aria-label="Navegación de documentos">
                                    {{ $files->onEachSide(1)->links('pagination::bootstrap-5') }}
                                </nav>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <!-- Estado vacío mejorado -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <div class="mx-auto" style="width: 80px; height: 80px; background: linear-gradient(135deg, #e2e8f0, #cbd5e1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-search text-muted" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <h5 class="text-muted mb-3">No se encontraron documentos</h5>
                    <p class="text-muted mb-4">
                        @if(request('keyword'))
                            No hay documentos que coincidan con tu búsqueda "<strong>{{ request('keyword') }}</strong>".
                        @else
                            Aún no has subido ningún documento a tu biblioteca.
                        @endif
                    </p>
                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                        @if(request('keyword'))
                            <a href="{{ route('files.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-list me-1"></i>
                                Ver todos los documentos
                            </a>
                        @else
                            <button class="btn btn-primary" onclick="document.getElementById('file').click()">
                                <i class="fas fa-plus me-1"></i>
                                Subir mi primer documento
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- JavaScript mejorado -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // File upload enhancement
    const fileInput = document.getElementById('file');
    const uploadZone = document.querySelector('.upload-zone');
    
    if (fileInput && uploadZone) {
        // Drag and drop functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            uploadZone.style.borderColor = 'var(--primary-color)';
            uploadZone.style.backgroundColor = 'rgba(37, 99, 235, 0.05)';
        }

        function unhighlight(e) {
            uploadZone.style.borderColor = 'var(--border-color)';
            uploadZone.style.backgroundColor = '';
        }

        uploadZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length > 0) {
                fileInput.files = files;
                updateFileDisplay(files[0]);
            }
        }

        // File input change handler
        fileInput.addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                updateFileDisplay(e.target.files[0]);
            }
        });

        function updateFileDisplay(file) {
            const uploadText = uploadZone.querySelector('p');
            if (uploadText) {
                uploadText.innerHTML = `<i class="fas fa-file-pdf text-danger me-2"></i><strong>${file.name}</strong> (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
            }
        }
    }

    // Search enhancement
    const searchInput = document.querySelector('input[name="keyword"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Auto-submit could be added here if desired
            }, 500);
        });
    }

    // Table row hover effects
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
});
</script>
@endsection