<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        return view('files.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tags' => 'nullable|string',
            'observations' => 'nullable|string',
            'file' => 'required|file|mimes:pdf|max:102400', // 100 MB limit
        ]);

        // Almacenamos el archivo en el directorio 'uploads' en el disco 'public'
        $filePath = $request->file('file')->store('uploads', 'public'); // Esto guarda el archivo en storage/app/public/uploads

        // Guardar la información del archivo en la base de datos
        File::create([
            'name' => $request->name,
            'tags' => $request->tags,
            'observations' => $request->observations,
            'file_path' => $filePath,  // Guardamos la ruta del archivo
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
}