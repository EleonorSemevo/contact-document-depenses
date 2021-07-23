<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmprunsdocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('emprunsdocs', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('preteur')->nullable();
            $table->date('date');
            $table->string('sous_titre')->nullable();
            $table->string('auteur');
            $table->string('co_auteur')->nullable();
            $table->integer('ISBN')->nullable();
            $table->longText('mots_cles')->nullable();
            $table->string('resume')->nullable();
            $table->year('annee_edition')->nullable();
            $table->string('ville_edition')->nullable();
            $table->string('lieu_edition')->nullable();
            $table->integer('nombre_page')->nullable();
            $table->string('pp')->nullable();
            $table->string('editeur')->nullable();
            $table->string('edition')->nullable();
            $table->date('date_prevue')->nullable();
            $table->date('date_reelle')->nullable();
            $table->longText('observation')->nullable();
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
        Schema::dropIfExists('emprunsdocs');
    }
}
