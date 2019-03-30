<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutorials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->string('palavras_chave');
            $table->longText('conteudo');
            $table->timestamps();
        });

        Schema::create('setor_tutorial', function (Blueprint $table) {
            $table->increments('id');  

            $table->integer('setor_id')->unsigned();
            $table->foreign('setor_id')
                    ->references('id')
                    ->on('setors')
                    ->onDelete('cascade');           

            $table->integer('tutorial_id')->unsigned();
            $table->foreign('tutorial_id')
                    ->references('id')
                    ->on('tutorials')
                    ->onDelete('cascade'); 

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setor_tutorial');
        Schema::dropIfExists('tutorials');
    }
}
