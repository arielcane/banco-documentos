<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_id', 
        'action',
        'document_name',
        'file_path',
        'file_size',
        'ip_address',
        'user_agent',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con File
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    // Método para formatear el tamaño del archivo
    public function getFormattedFileSizeAttribute()
    {
        if (!$this->file_size) return 'N/A';
        
        $bytes = (int) $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        return number_format($bytes / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }

    // Método para obtener el color del badge según la acción
    public function getActionBadgeColorAttribute()
    {
        return match($this->action) {
            'uploaded' => 'success',
            'downloaded' => 'info', 
            'deleted' => 'danger',
            'updated' => 'warning',
            default => 'secondary'
        };
    }
}