@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    
    <!-- Dashboard de estadísticas -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-file-pdf text-danger me-2" style="font-size: 1.5rem;"></i>
                        <h3 class="mb-0 text-primary">{{ number_format($totalFiles) }}</h3>
                    </div>
                    <p class="text-muted mb-0">Total de Documentos</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-hdd text-info me-2" style="font-size: 1.5rem;"></i>
                        <h3 class="mb-0 text-primary">{{ number_format($totalSize / 1024 / 1024, 1) }} MB</h3>
                    </div>
                    <p class="text-muted mb-0">Espacio Utilizado</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-upload text-success me-2" style="font-size: 1.5rem;"></i>
                        <h3 class="mb-0 text-primary">{{ $recentUploads }}</h3>
                    </div>
                    <p class="text-muted mb-0">Subidos esta semana</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes de éxito/error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Error:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Formulario de subida mejorado -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-cloud-upload-alt me-2"></i>Subir Nuevo Documento</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nombre del Documento <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Ej: Contrato de Servicio 2024" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tags" class="form-label">Etiquetas</label>
                        <input type="text" name="tags" id="tags" class="form-control @error('tags') is-invalid @enderror" 
                               placeholder="Ej: contrato, legal, 2024" value="{{ old('tags') }}">
                        <small class="form-text text-muted">Separa las etiquetas con comas</small>
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-12">
                        <label for="observations" class="form-label">Observaciones</label>
                        <textarea name="observations" id="observations" class="form-control @error('observations') is-invalid @enderror" 
                                  rows="2" placeholder="Observaciones adicionales (opcional)">{{ old('observations') }}</textarea>
                        @error('observations')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-8">
                        <label for="file" class="form-label">Archivo PDF <span class="text-danger">*</span></label>
                        <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" 
                               accept="application/pdf" required>
                        <small class="form-text text-muted">Máximo 100MB. Solo archivos PDF.</small>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-upload me-2"></i>Subir Documento
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Buscador mejorado -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="fas fa-search me-2"></i>Buscar Documentos</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('files.index') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input 
                        type="text" 
                        name="keyword" 
                        class="form-control" 
                        placeholder="Buscar por nombre, etiquetas o observaciones..." 
                        value="{{ request('keyword') }}"
                    >
                    <button type="submit" class="btn btn-outline-primary">Buscar</button>
                    @if(request('keyword'))
                        <a href="{{ route('files.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                    @endif
                </div>
            </form>            
        </div>
    </div>

    <!-- Tabla de resultados mejorada -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-folder-open me-2"></i>
                @if(request('keyword'))
                    Resultados de búsqueda para: "<strong>{{ request('keyword') }}</strong>"
                @else
                    Biblioteca de Documentos
                @endif
            </h5>
            <small class="text-muted">
                Mostrando {{ $files->firstItem() ?? 0 }} - {{ $files->lastItem() ?? 0 }} de {{ $files->total() }} documentos
            </small>
        </div>
        <div class="card-body p-0">
            @if($files->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Documento</th>
                                <th class="border-0">Etiquetas</th>
                                <th class="border-0">Observaciones</th>
                                <th class="border-0">Fecha</th>
                                <th class="border-0 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-pdf text-danger me-3" style="font-size: 1.2rem;"></i>
                                            <div>
                                                <div class="fw-bold">{{ $file->name }}</div>
                                                @if($file->original_name && $file->original_name !== $file->name)
                                                    <small class="text-muted">{{ $file->original_name }}</small>
                                                @endif
                                                @if($file->file_size)
                                                    <small class="text-muted d-block">{{ number_format($file->file_size / 1024, 1) }} KB</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($file->tags)
                                            @foreach(explode(',', $file->tags) as $tag)
                                                <span class="badge bg-secondary me-1">{{ trim($tag) }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Sin etiquetas</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($file->observations)
                                            {{ Str::limit($file->observations, 50) }}
                                            @if(strlen($file->observations) > 50)
                                                <a href="#" class="text-primary" data-bs-toggle="tooltip" 
                                                   data-bs-title="{{ $file->observations }}">
                                                    <i class="fas fa-info-circle"></i>
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-muted">Sin observaciones</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>
                                            {{ $file->created_at->format('d/m/Y') }}<br>
                                            <span class="text-muted">{{ $file->created_at->format('H:i') }}</span>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('files.download', $file) }}" 
                                               class="btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-title="Descargar">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a href="{{ Storage::url($file->file_path) }}" target="_blank" 
                                               class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-title="Ver en línea">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                @if($files->hasPages())
                    <div class="card-footer bg-light py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    Página {{ $files->currentPage() }} de {{ $files->lastPage() }}
                                </small>
                            </div>
                            <div>
                                {{ $files->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search text-muted mb-3" style="font-size: 3rem;"></i>
                    <h5 class="text-muted">No se encontraron documentos</h5>
                    <p class="text-muted">
                        @if(request('keyword'))
                            No hay documentos que coincidan con tu búsqueda.
                        @else
                            Aún no has subido ningún documento.
                        @endif
                    </p>
                    @if(request('keyword'))
                        <a href="{{ route('files.index') }}" class="btn btn-outline-primary">Ver todos los documentos</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- JavaScript para tooltips -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>
@endsection