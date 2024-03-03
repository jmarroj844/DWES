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
        Schema::create('tareas_etiquetas', function (Blueprint $table) {
            $table->foreignId("tareas_id")->constrained()->onDelete('cascade');
            $table->foreignId("etiquetas_id")->constrained()->onDelete('cascade');
            $table->primary(["tareas_id", "etiquetas_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas_etiquetas');
    }
};
