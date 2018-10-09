<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('id');
            $table->date('fecha');
            $table->string('beneficiario');
            $table->float('salidas', 10, 2);
            $table->float('saldo', 10, 2);
            $table->string('bancos');
            $table->string('tipo_mov');
            $table->string('empresa');
            $table->string('naturaleza');
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
        Schema::dropIfExists('transactions');
    }
}
