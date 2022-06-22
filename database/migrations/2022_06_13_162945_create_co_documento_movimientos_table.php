<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoDocumentoMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('co_documento_movimientos', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->bigIncrements('id');
            $table->foreignId('co_folios_movimiento_id')->constrained();
            $table->uuid('uuid');
            $table->string('tipo_documento')->nullable();
            $table->bigInteger('id_documento',FALSE,TRUE)->nullable();
            $table->bigInteger('id_numeracion',FALSE,TRUE)->nullable();
            $table->string('prefijo')->nullable();
            $table->bigInteger('folio')->default(0);
            $table->timestamps();

            $table->index('id_documento');
            $table->index('tipo_documento');
            $table->index('uuid');
            $table->index('id_numeracion');
            $table->index(['prefijo','folio']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('co_documento_movimientos');
    }
}
