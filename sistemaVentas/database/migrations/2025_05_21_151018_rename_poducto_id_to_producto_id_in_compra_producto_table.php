<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('compra_producto', function (Blueprint $table) {
            // Elimina la restricción de llave foránea (si existe)
            $table->dropForeign(['poducto_id']);

            // Renombra la columna mal escrita
            $table->renameColumn('poducto_id', 'producto_id');
        });

        Schema::table('compra_producto', function (Blueprint $table) {
            // Vuelve a agregar la restricción de llave foránea con el nombre correcto
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('compra_producto', function (Blueprint $table) {
            $table->dropForeign(['producto_id']);
            $table->renameColumn('producto_id', 'poducto_id');
        });

        Schema::table('compra_producto', function (Blueprint $table) {
            $table->foreign('poducto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }
};

