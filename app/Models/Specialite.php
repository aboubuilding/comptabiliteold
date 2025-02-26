<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
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
     * Ajouter une Specialite
     *

     * @param  string $libelle



     * @return Specialite
     */

    public static function addSpecialite(
        $libelle


    )

    {
        $specialite = new Specialite();


        $specialite->libelle = $libelle;

        $specialite->created_at = Carbon::now();

        $specialite->save();

        return $specialite;
    }

    /**
     * Affichage d'une activité scolaire
     * @param int $id
     * @return  Specialite
     */

    public static function rechercheSpecialiteById($id)
    {

        return   $specialite = Specialite::findOrFail($id);
    }

    /**
     * Update d'une specialite

     * @param  string $libelle




     * @param int $id
     * @return  specialite
     */

    public static function updateSpecialite(
        $libelle,

        $id)
    {


        return   $specialite = Specialite::findOrFail($id)->update([



            'libelle' => $libelle,


            'id' => $id,


        ]);
    }




    /**
     * Supprimer une specialite
     *
     * @param int $id
     * @return  boolean
     */

    public static function deleteSpecialite($id)
    {

        $specialite = Specialite::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($specialite) {
            return 1;
        }
        return 0;
    }



    /**
     * Retourne la liste des Specialite
     * @param  string $libelle


     *
     * @return  array
     */

    public static function getListe(

        $libelle = null

    ) {

        $query =  Specialite::where('etat', '!=', TypeStatus::SUPPRIME)
        ;

        if ($libelle != null) {

            $query->where('libelle', '=', $libelle);
        }
        return    $query->get();
    }



    /**
     * Retourne le nombre  des  specialité


    * @param  string $libelle
     


     * @return  int $total
     */

    public static function getTotal(
        $libelle = null,


    ) {

        $query =   DB::table('Specialite')


            ->where('Specialites.etat', '!=', TypeStatus::SUPPRIME);


        if ($libelle != null) {

            $query->where('Specialites.libelle', '=', $libelle);
        }






        $total = $query->count();

        if ($total) {

            return   $total;
        }

        return 0;
    }




}
