<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\DocumentLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $query = File::query();

        // Si hay una palabra clave, realiza la búsqueda
        if ($request->has('keyword')) {
            $query->where('name', 'like', "%{$request->keyword}%")
                ->orWhere('tags', 'like', "%{$request->keyword}%")
                ->orWhere('observations', 'like', "%{$request->keyword}%");
        }

        $files = $query->get();

        return view('files.index', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tags' => 'nullable|string',
            'observations' => 'nullable|string',
            'file' => 'required|file|mimes:pdf|max:102400', // 100 MB limit
        ]);

        // Almacenar el archivo en el servidor
        try {
            $filePath = $request->file('file')->store('uploads', 'public');
            $fileSize = $request->file('file')->getSize();
            $originalName = $request->file('file')->getClientOriginalName();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['file' => 'Failed to upload file: ' . $e->getMessage()]);
        }

        // Guardar la información del archivo en la base de datos
        $file = File::create([
            'name' => $request->name,
            'tags' => $request->tags,
            'observations' => $request->observations,
            'file_path' => $filePath,
        ]);

        // ===== REGISTRAR EN EL LOG =====
        DocumentLog::create([
            'user_id' => Auth::id(),
            'file_id' => $file->id,
            'action' => 'uploaded',
            'document_name' => $request->name,
            'file_path' => $filePath,
            'file_size' => $fileSize,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'metadata' => [
                'original_filename' => $originalName,
                'tags' => $request->tags,
                'observations' => $request->observations,
                'file_extension' => $request->file('file')->getClientOriginalExtension(),
            ]
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully.');
    }

    public function search(Request $request)
    {
        $query = File::query();

        if ($request->has('keyword')) {
            $query->where('name', 'like', "%{$request->keyword}%")
                  ->orWhere('tags', 'like', "%{$request->keyword}%")
                  ->orWhere('observations', 'like', "%{$request->keyword}%");
        }

        $files = $query->get();

        return view('files.search', compact('files'));
    }

    // ===== NUEVO MÉTODO PARA MOSTRAR LOGS =====
    public function logs(Request $request)
    {
        $query = DocumentLog::with(['user', 'file'])
            ->orderBy('created_at', 'desc');

        // Filtros opcionales
        if ($request->has('user') && $request->user) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', "%{$request->user}%");
            });
        }

        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        if ($request->has('document') && $request->document) {
            $query->where('document_name', 'like', "%{$request->document}%");
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(20);

        // Obtener datos para los filtros
        $users = \App\Models\User::pluck('name', 'id');
        $actions = DocumentLog::distinct()->pluck('action');

        return view('files.logs', compact('logs', 'users', 'actions'));
    }
}