<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quartier extends Model
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


        'libelle',


        'etat',

    ];



    /**
     * Ajouter une Activite
     *

     * @param  string $libelle



     * @return Quartier
     */

    public static function addQuartier(
        $libelle


    )

    {
        $quartier = new Quartier();


        $quartier->libelle = $libelle;

        $quartier->created_at = Carbon::now();

        $quartier->save();

        return $quartier;
    }

    /**
     * Affichage d'une activité scolaire
     * @param int $id
     * @return  Quartier
     */

    public static function rechercheQuartierById($id)
    {

        return   $quartier = Quartier::findOrFail($id);
    }

    /**
     * Update d'une Activite scolaire

     * @param  string $libelle




     * @param int $id
     * @return  Quartier
     */

    public static function updateQuartier(
        $libelle,

        $id)
    {


        return   $quartier = Quartier::findOrFail($id)->update([



            'libelle' => $libelle,


            'id' => $id,


        ]);
    }




    /**
     * Supprimer un Quartier
     *
     * @param int $id
     * @return  boolean
     */

    public static function deleteQuartier($id)
    {

        $quartier = Quartier::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($quartier) {
            return 1;
        }
        return 0;
    }



    /**
     * Retourne la liste des Quartier
     * @param  int $annee_id
     * @param  int $niveau_id

     *
     * @return  array
     */

    public static function getListe(

        $libelle = null

    ) {

        $query =  Quartier::where('etat', '!=', TypeStatus::SUPPRIME)
        ;

        if ($libelle != null) {

            $query->where('libelle', '=', $libelle);
        }
        return    $query->get();
    }



    /**
     * Retourne le nombre  des  activités


    * @param  int $annee_id
     * @param  int $niveau_id


     * @return  int $total
     */

    public static function getTotal(
        $libelle = null,


    ) {

        $query =   DB::table('Quartier')


            ->where('Quartiers.etat', '!=', TypeStatus::SUPPRIME);


        if ($libelle != null) {

            $query->where('Quartiers.libelle', '=', $libelle);
        }






        $total = $query->count();

        if ($total) {

            return   $total;
        }

        return 0;
    }



   

}


