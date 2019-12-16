<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Banco extends Migration
{
    public function up()
    {
        Schema::create(
            'bancos',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('numero');
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
