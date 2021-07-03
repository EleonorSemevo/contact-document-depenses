<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('organisation')->nullable();
            $table->string('poste')->nullable();
            $table->string('numero_portable1');
            $table->string('nmero_portable2')->nullable();
            $table->string('numero_bureau1')->nullable();
            $table->string('numero_bureau2')->nullable();
            $table->string('mail_professionel1')->nullable();
            $table->string('mail_professionel2')->nullable();
            $table->string('mail_prive1')->nullable();
            $table->string('mail_prive2')->nullable();
            $table->string('site_web_organisation')->nullable();
            $table->string('linkdin')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('skype')->nullable();
            $table->string('boite_postale')->nullable();
            $table->string('adresse_physique')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
