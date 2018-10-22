<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEquipamentoToTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            //
            $table->integer('equipamento_id')->unsigned()->nullable();
            $table->foreign('equipamento_id')
                    ->references('id')
                    ->on('equipamentos')
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
        Schema::table('tickets', function (Blueprint $table) {
            //
            $table->dropForeign('tickets_equipamento_id_foreign');
            $table->dropColumn('equipamento_id');
        });
    }
}
