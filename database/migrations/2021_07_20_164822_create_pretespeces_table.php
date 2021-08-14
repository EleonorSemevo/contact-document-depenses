<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePretespecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pretespeces', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('debiteur');
            $table->unsignedInteger('montant');
            $table->longText('motif')->nullable();
            $table->date('date_prevue')->nullable();
            $table->date('date_reelle')->nullable();
            $table->longText('obervation')->nullable();
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
        Schema::dropIfExists('pretespeces');
    }
}
