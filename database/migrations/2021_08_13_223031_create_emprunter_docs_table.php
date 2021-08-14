<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmprunterDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emprunter_docs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->date('date_prevue')->nullable();
            $table->date('date_reelle')->nullable();
            $table->string('creancier');
            $table->string('motif')->nullable();
            $table->longText('observation')->nullable();
            $table->string('titre');
            $table->string('sous_titre')->nullable();
            $table->string('auteur');
            $table->string('co_auteur')->nullable();
            $table->integer('ISBN')->nullable();
            $table->longText('mots_cles')->nullable();
            $table->longText('resume')->nullable();
            $table->year('annee_edition')->nullable();
            $table->string('ville_edition')->nullable();
            $table->string('lieu_edition')->nullable();
            $table->integer('nombre_page')->nullable();
            $table->string('pp')->nullable();
            $table->string('editeur')->nullable();
            $table->string('edition')->nullable();
            $table->text('status')->nullable();
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
        Schema::dropIfExists('emprunter_docs');
    }
}
