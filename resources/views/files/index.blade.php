@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Formulario compacto de subida -->
    <!-- Formulario compacto de subida -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Subir PDF</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-2 mb-2">
                    <!-- Nombre y Etiquetas en la misma línea -->
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Nombre" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="tags" class="form-control" placeholder="Etiquetas">
                    </div>
                </div>
                <div class="mb-2">
                    <!-- Observaciones en una línea completa -->
                    <textarea name="observations" class="form-control" rows="2" placeholder="Observaciones (opcional)"></textarea>
                </div>
                <div class="row g-2 align-items-center">
                    <!-- Carga de archivo y botón en la misma línea -->
                    <div class="col-md-8">
                        <input type="file" name="file" class="form-control" accept="application/pdf" required>
                    </div>
                    <div class="col-md-4 text-end">
                        <button type="submit" class="btn btn-primary">Subir</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Buscador -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Búsqueda de archivos</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('files.index') }}" method="GET">
                <div class="input-group">
                    <input 
                        type="text" 
                        name="keyword" 
                        class="form-control" 
                        placeholder="Search files by name, tags, or observations..." 
                        value="{{ request('keyword') }}"
                    >
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>            
        </div>
    </div>

    <!-- Tabla de resultados -->
    <div class="card">
        <div class="card-header">
            <h5>Listado de archivos</h5>
        </div>
        <div class="card-body">
            @if($files->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Etiquetas</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <td>{{ $file->name }}</td>
                                    <td>{{ $file->tags }}</td>
                                    <td>{{ $file->observations }}</td>
                                    <td>
                                        <a href="storage/{{ $file->file_path }}" target="_blank" class="btn btn-success btn-sm">
                                            Descargar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-muted">No se encontraron archivos. Intenta otro criterio de búsqueda.</p>
            @endif
        </div>
    </div>
</div>
@endsection
