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
        Schema::create('souscriptions', function (Blueprint $table) {
            $table->id();

            $table->date('date_souscription')->nullable();
            $table->float('montant_prevu')->nullable();
         
            $table->tinyInteger('type_paiement')->nullable();
            $table->bigInteger('cantine_id')->nullable();
            $table->bigInteger('ligne_id')->nullable();
            $table->bigInteger('livre_location_id')->nullable();
            $table->bigInteger('activite_id')->nullable();
           
            $table->bigInteger('annee_id')->nullable();
            $table->bigInteger('inscription_id')->nullable();
           
            $table->bigInteger('periode_id')->nullable();
            
            $table->integer('statut')->default(1);
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
        Schema::dropIfExists('souscriptions');
    }
};
