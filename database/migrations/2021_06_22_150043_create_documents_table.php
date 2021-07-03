<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('langue_id')->constrained('langues')->onDelete('cascade');
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
        Schema::dropIfExists('documents');
    }
}
