<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSistemaToEquipamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipamentos', function (Blueprint $table) {
            //
            $table->integer('sistema_id')->unsigned()->nullable();
            $table->foreign('sistema_id')
                    ->references('id')
                    ->on('sistemas')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipamentos', function (Blueprint $table) {
            //
            $table->dropForeign('equipamentos_sistema_id_foreign');
            $table->dropColumn('sistema_id');
        });
    }
}
