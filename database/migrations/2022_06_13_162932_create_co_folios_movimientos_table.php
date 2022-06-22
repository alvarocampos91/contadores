<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoFoliosMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('co_folios_movimientos', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->bigIncrements('id');
            $table->foreignId('co_folios_usuario_id')->references('id')->on('co_folios_usuarios');
            $table->foreignId('co_folios_movimiento_id')->nullable()->references('id')->on('co_folios_movimientos');
            $table->bigInteger('folios_modificados')->default(0);
            $table->bigInteger('total_contador')->default(0);
            $table->bigInteger('total_limite')->default(0);
            $table->string('descripcion')->nullable();
            $table->string('origen')->nullable();
            $table->string('tipo')->nullable();
            $table->string('estatus')->nullable();
            $table->bigInteger('id_usuario_registra',FALSE,TRUE)->nullable();
            $table->bigInteger('id_acceso_registra',FALSE,TRUE)->nullable();
            $table->string('registrado_por')->nullable();
            $table->timestamps();

            $table->index('estatus');
            $table->index('tipo');
            $table->index('origen');
            $table->index('id_usuario_registra');
            $table->index('id_acceso_registra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('co_folios_movimientos');
    }
}
