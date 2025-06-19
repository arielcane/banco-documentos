<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Verificar si la foreign key ya existe
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'files' 
            AND COLUMN_NAME = 'user_id' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        // Si no existe la foreign key, crearla
        if (empty($foreignKeys)) {
            // Primero asignar un usuario por defecto a los archivos sin user_id
            $firstUser = \App\Models\User::first();
            if ($firstUser) {
                DB::table('files')
                    ->whereNull('user_id')
                    ->update(['user_id' => $firstUser->id]);
            }

            // Agregar la foreign key constraint
            Schema::table('files', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });

            echo "✅ Foreign key agregada exitosamente\n";
        } else {
            echo "ℹ️  La foreign key ya existe\n";
        }

        // Verificar archivos sin usuario asignado
        $filesWithoutUser = DB::table('files')->whereNull('user_id')->count();
        if ($filesWithoutUser > 0) {
            echo "⚠️  Hay {$filesWithoutUser} archivos sin usuario asignado\n";
        } else {
            echo "✅ Todos los archivos tienen usuario asignado\n";
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};