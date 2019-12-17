<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Titulo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'titulos',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('cedente_id');
                $table->date('vencimento');
                $table->string('sacado');
                $table->unsignedBigInteger('conta_id');
                $table->foreign('conta_id')->references('id')->on('contas');
                $table->unsignedBigInteger('fluxo_id');
                $table->foreign('fluxo_id')->references('id')->on('fluxos');
                $table->double('valor', 8, 2);
                $table->enum('tipo', ['Credito', 'Debito']);
                $table->enum('status', ['Pago', 'Aberto']);
                $table->timestamps();
            }
        );
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
