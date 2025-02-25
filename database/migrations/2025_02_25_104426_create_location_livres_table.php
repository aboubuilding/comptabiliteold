<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_livres', function (Blueprint $table) {
            $table->id();
            
            $table->string('marque_ordinateur')->nullable();
            $table->string('numero_serie')->nullable();
            $table->string('nom_machine')->nullable();
            $table->string('mot_passe')->nullable();

            $table->bigInteger('inscription_id')->nullable();
            $table->bigInteger('annee_id')->nullable();

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
        Schema::dropIfExists('location_livres');
    }
};
