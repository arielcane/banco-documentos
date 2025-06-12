@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Log de Actividad de Documentos</h2>
                <a href="{{ route('files.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al Banco
                </a>
            </div>

            <!-- Filtros -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Filtros</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('files.logs') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="user" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="user" name="user" 
                                       value="{{ request('user') }}" placeholder="Buscar por usuario">
                            </div>
                            <div class="col-md-2">
                                <label for="action" class="form-label">Acción</label>
                                <select class="form-select" id="action" name="action">
                                    <option value="">Todas</option>
                                    @foreach($actions as $action)
                                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                            {{ ucfirst($action) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="document" class="form-label">Documento</label>
                                <input type="text" class="form-control" id="document" name="document" 
                                       value="{{ request('document') }}" placeholder="Nombre del documento">
                            </div>
                            <div class="col-md-2">
                                <label for="date_from" class="form-label">Desde</label>
                                <input type="date" class="form-control" id="date_from" name="date_from" 
                                       value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="date_to" class="form-label">Hasta</label>
                                <input type="date" class="form-control" id="date_to" name="date_to" 
                                       value="{{ request('date_to') }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                                <a href="{{ route('files.logs') }}" class="btn btn-outline-secondary">Limpiar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de Logs -->
            <div class="card">
                <div class="card-body">
                    @if($logs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Fecha/Hora</th>
                                        <th>Usuario</th>
                                        <th>Acción</th>
                                        <th>Documento</th>
                                        <th>Tamaño</th>
                                        <th>IP</th>
                                        <th>Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>
                                                <small>
                                                    {{ $log->created_at->format('d/m/Y H:i:s') }}<br>
                                                    <span class="text-muted">{{ $log->created_at->diffForHumans() }}</span>
                                                </small>
                                            </td>
                                            <td>
                                                <strong>{{ $log->user->name }}</strong><br>
                                                <small class="text-muted">{{ $log->user->email }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $log->action_badge_color }}">
                                                    {{ ucfirst($log->action) }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>{{ $log->document_name }}</strong>
                                                @if($log->metadata && isset($log->metadata['original_filename']))
                                                    <br><small class="text-muted">{{ $log->metadata['original_filename'] }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $log->formatted_file_size }}</td>
                                            <td><small>{{ $log->ip_address }}</small></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-info" type="button" 
                                                        data-bs-toggle="collapse" data-bs-target="#details-{{ $log->id }}">
                                                    Ver más
                                                </button>
                                                <div class="collapse mt-2" id="details-{{ $log->id }}">
                                                    <div class="card card-body">
                                                        <small>
                                                            <strong>User Agent:</strong><br>
                                                            {{ Str::limit($log->user_agent, 60) }}<br><br>
                                                            @if($log->metadata)
                                                                <strong>Metadata:</strong><br>
                                                                @foreach($log->metadata as $key => $value)
                                                                    <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}<br>
                                                                @endforeach
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-center">
                            {{ $logs->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No se encontraron registros con los filtros aplicados.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection