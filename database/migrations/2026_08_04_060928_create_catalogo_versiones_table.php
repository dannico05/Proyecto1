<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('catalogo_versiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrera_id')->constrained()->onDelete('cascade');
            $table->foreignId('curso_id')->constrained()->onDelete('cascade');
            $table->integer('version')->default(1);
            $table->string('acuerdo'); // es OBLIGATORIO
            $table->string('gaceta');  // es OBLIGATORIO
            $table->json('grados_atinentes'); // Ej: ["Maestría en Software", "Lic. Computación"]
            $table->date('fecha_inicio_vigencia');
            $table->date('fecha_fin_vigencia')->nullable();
            $table->timestamps();

            // Para evitar duplicados de versión por la mismo carrera y curso
            $table->unique(['carrera_id', 'curso_id', 'version']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogo_versiones');
    }
};
