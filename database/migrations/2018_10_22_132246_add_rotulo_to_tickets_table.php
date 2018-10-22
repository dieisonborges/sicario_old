<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRotuloToTicketsTable extends Migration
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
            // Rotulos de Criticidade
            // Nenhum           - 4 - Nenhum
            // Baixo            - 3 - Rotina de Manutenção
            // Médio            - 2 - Intermediária (avaliar componente)
            // Alto             - 1 - Urgência (reparar o mais rápido possível)
            // Crítico          - 0 - Emergência (reparar imediatamente) 

            $table->integer('rotulo')->unsigned()->default(0);
            
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
            $table->dropColumn('rotulo');
        });
    }
}
