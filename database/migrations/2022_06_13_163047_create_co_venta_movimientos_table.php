<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoVentaMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('co_venta_movimientos', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->bigIncrements('id');
            $table->foreignId('co_folios_movimiento_id')->constrained();
            $table->bigInteger('id_venta',FALSE,TRUE)->nullable();
            $table->string('paquete')->nullable();
            $table->bigInteger('timbres')->default(0);
            $table->timestamps();

            $table->index('id_venta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('co_venta_movimientos');
    }
}
