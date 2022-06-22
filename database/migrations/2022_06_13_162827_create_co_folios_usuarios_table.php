<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoFoliosUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('co_folios_usuarios', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->bigIncrements('id');
            $table->bigInteger('id_usuario',FALSE,TRUE);
            $table->bigInteger('contador')->default(0);
            $table->bigInteger('limite')->default(0);
            $table->dateTime('fecha_expiracion')->nullable();
            $table->string('observaciones')->nullable();
            $table->bigInteger('id_usuario_registra',FALSE,TRUE)->nullable();
            $table->bigInteger('id_acceso_registra',FALSE,TRUE)->nullable();
            $table->string('registrado_por')->nullable();
            $table->timestamps();

            $table->index('id_usuario');
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
        Schema::dropIfExists('co_folios_usuarios');
    }
}
