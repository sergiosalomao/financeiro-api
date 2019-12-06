<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Lancamento extends Migration
{
    
    public function up()
    {
        Schema::create(
            'lancamentos',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->enum('tipo', ['Credito', 'Debito']);
                $table->unsignedBigInteger('conta_id');
                $table->foreign('conta_id')->references('id')->on('contas');               
                $table->unsignedBigInteger('fluxo_id');
                $table->foreign('fluxo_id')->references('id')->on('fluxos');               
                $table->integer('titulo_id')->nullable();
                $table->double('valor',8,2);
                $table->string('descricao');
                $table->timestamps();
            }
        );
    }

    
    public function down()
    {
        //
    }
}
