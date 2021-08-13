<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestissementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('investissements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('domaine_id')->constrained('domaines')->onDelete('cascade');
            $table->foreignId('localite_id')->constrained('localites')->onDelete('cascade');
            $table->date('date');
            $table->integer('numero_piece');
            $table->integer('cout_intrant')->nullable();;
            $table->integer('cout_main_oeuvre')->nullable();;
            $table->integer('cout_transport')->nullable();;
            $table->string('prestataire');
            $table->string('mail')->nullable();;
            $table->integer('telephone')->nullable();;
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investissements');
    }
}
