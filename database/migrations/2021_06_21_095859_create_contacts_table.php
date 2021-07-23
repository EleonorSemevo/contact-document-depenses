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
            $table->string('numero_portable');
            $table->string('numero_whatsapp')->nullable();
            $table->string('numero_bureau_1')->nullable();
             $table->string('numero_bureau_2')->nullable();
            $table->string('mail_professionel_1')->nullable();
            $table->string('mail_professionel_2')->nullable();
            $table->string('mail_prive_1')->nullable();
            $table->string('mail_prive_2')->nullable();
            $table->string('site_web_organisation')->nullable();
            $table->string('linkdin')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('skype')->nullable();
            $table->string('viber')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
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
