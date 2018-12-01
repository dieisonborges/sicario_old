<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusTecnicosAcoesToLivrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('livros', function (Blueprint $table) {
            //
            //Status 0-Aberto 1-Aprovado 
            $table->integer('status')->default(0);
            $table->longText('acoes');
        });

        Schema::create('livro_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('livro_id')->unsigned();
            

            $table->foreign('livro_id')
                    ->references('id')
                    ->on('livros')
                    ->onDelete('cascade');

            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
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
        Schema::table('livros', function (Blueprint $table) {
            //
            $table->dropColumn('status');
            $table->dropColumn('tecnicos');
            $table->dropColumn('acoes');

        });

        Schema::dropIfExists('livro_user');
    }
}
