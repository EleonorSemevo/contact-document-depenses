<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpruntespecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empruntespeces', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('creancier');
            $table->integer('montant');
            $table->string('motif')->nullable();
            $table->date('date_prevue')->nullable();
            $table->date('date_reelle')->nullable();
            $table->longText('obervation')->nullable();
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
        Schema::dropIfExists('empruntespeces');
    }
}
