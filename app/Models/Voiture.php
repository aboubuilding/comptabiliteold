<?php

namespace App\Models;

use App\Types\TypeStatus;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Voiture extends Model
{
    use HasFactory;

    public function __construct(array $attributes=[])
    {
        parent::__construct($attributes);
        $this->etat=TypeStatus::ACTIF;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [



        'marque',
        'plaque',
        'nombre_place',
        'date_acquisition',


        'etat',

    ];



    /**
     * Ajouter une Voiture
     *


     * @param  string $marque
     * @param  string $plaque
     * @param  int $nombre_place
     * @param  int $date_acquisition



     * @return Voiture
     */

    public static function addVoiture (


        $marque,
        $plaque,
        $nombre_place,
        $date_acquisition





    )
    {
        $voiture = new Voiture();



        $voiture->marque = $marque;
        $voiture->plaque = $plaque;
        $voiture->nombre_place = $nombre_place;
        $voiture->date_acquisition = $date_acquisition;



        $voiture->created_at = Carbon::now();

        $voiture->save();

        return $voiture;
    }

    /**
     * Affichage d'une année scolaire
     * @param int $id
     * @return  Voiture
     */

    public static function rechercheVoitureById($id)
    {

        return   $voiture= Voiture::findOrFail($id);
    }

    /**
     * Update d'une Voiture scolaire
     *
     *


     * @param  string $marque
     * @param  string $plaque
     * @param  int $nombre_place
     * @param  int $date_acquisition
     *
     *
     * @param int $id
     * @return  Voiture
     */

    public static function updateVoiture(

        $marque,
        $plaque,
        $nombre_place,
        $date_acquisition,



        $id)
    {


        return   $voiture= Voiture::findOrFail($id)->update([




            'marque' => $marque,
            'plaque' => $plaque,
            'nombre_place' => $nombre_place,
            'date_acquisition' => $date_acquisition,



            'id' => $id,


        ]);
    }




    /**
     * Supprimer une Voiture
     *
     * @param int $id
     * @return  boolean
     */

    public static function deleteVoiture($id)
    {

        $voiture= Voiture::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($voiture) {
            return 1;
        }
        return 0;
    }



    /**
     * Retourne la liste des Voitures



     * @param  int $date_acquisition




     *
     * @return  array
     */

    public static function getListe(



        $date_acquisition = null



    ) {



        $query =  Voiture::where('etat', '!=', TypeStatus::SUPPRIME)
        ;





        if ($date_acquisition != null) {

            $query->where('date_acquisition', '=', $date_acquisition);
        }





        return    $query->get();
    }



    /**
     * Retourne le nombre  des  activités
     *
     *

     * * @param int $date_acquisition

 *
     *
     * @return  int $total
     */

    public static function getTotal(


        $date_acquisition = null


    ) {

        $query =   DB::table('voitures')


            ->where('voitures.etat', '!=', TypeStatus::SUPPRIME);




        if ($date_acquisition != null) {

            $query->where('date_acquisition', '=', $date_acquisition);
        }


        $total = $query->count();

        if ($total) {

            return   $total;
        }

        return 0;
    }



    /**
     * Obtenir une année
     *
     */
    public function annee()
    {


        return $this->belongsTo(Annee::class, 'plaque');
    }









}
