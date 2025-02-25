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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();

            $table->date('date_inscription')->nullable();

            $table->bigInteger('eleve_id')->nullable();
            $table->bigInteger('cycle_id')->nullable();
            $table->bigInteger('niveau_id')->nullable();
            $table->bigInteger('last_niveau_id')->nullable();
            $table->bigInteger('classe_id')->nullable();
            $table->bigInteger('espace_id')->nullable();
            $table->tinyInteger('type_inscription')->nullable();
            $table->tinyInteger('statut_validation')->nullable();
            $table->bigInteger('annee_id')->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->integer('taux_remise')->nullable();

            //Validation
            $table->text('motif_rejet')->nullable();
            $table->dateTime('date_validation')->nullable();
            $table->integer('utilisateur_id')->nullable();

            

            $table->tinyInteger('programme_provenance')->nullable();
           
          
            $table->float('frais_assurance')->nullable();
            $table->float('frais_inscription')->nullable();
          
           
            $table->float('frais_examen')->nullable();



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
        Schema::dropIfExists('inscriptions');
    }
};
