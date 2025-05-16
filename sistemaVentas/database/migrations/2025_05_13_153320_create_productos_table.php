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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',50);
            $table->string('nombre',50);
            $table->integer('stock')->unsigned()->default(0);
            $table->string('descripcion',255)->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->string('imagen_path',255)->nullable();
            $table->tinyInteger('estado')->default(1);
            $table->foreignId('marca_id')->constrained('marcas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
