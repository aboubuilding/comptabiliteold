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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();

            $table->string('libelle')->nullable();
            $table->date('date_vente')->nullable();
            $table->float('quantite')->nullable();
            $table->bigInteger('annee_id')->nullable();
            $table->float('montant')->nullable();
         
            $table->bigInteger('produit_id')->nullable();
            $table->bigInteger('personnel_id')->nullable();
            $table->bigInteger('boutique_id')->nullable();
          
           

            $table->integer('etat')->default(1);
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
        Schema::dropIfExists('ventes');
    }
};
