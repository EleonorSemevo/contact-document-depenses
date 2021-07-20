<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmprunsespecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emprunsespeces', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('creancier');
            $table->integer('montant');
            $table->string('motif')->nullable();
            $table->date('date_prevue')->nullable();
            $table->date('date_reelle')->nullable();
            $table->string('obervation')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('emprunsespeces');
    }
}
