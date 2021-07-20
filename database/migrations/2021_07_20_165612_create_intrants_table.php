<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('intrants', function (Blueprint $table) {
            $table->id();
            $table->string('piece');
            $table->foreignId('domaine_id')->constrained('domaines')->onDelete('cascade');
            $table->string('localite')->nullable();
            $table->date('date');
            $table->unsignedInteger('montant');
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
        Schema::dropIfExists('intrants');
    }
}
