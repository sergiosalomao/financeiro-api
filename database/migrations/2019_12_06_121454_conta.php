<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Conta extends Migration
{
    public function up()
    {
        Schema::create(
            'contas',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('descricao');
                $table->integer('banco_id');
                $table->integer('agencia');
                $table->timestamps();
            }
        );
    }
    

    public function down()
    {
        //
    }
}
