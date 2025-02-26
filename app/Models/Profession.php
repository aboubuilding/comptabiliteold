<?php

namespace App\Models;

use App\Types\TypeStatus;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Profession extends Model
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
        'salaire_base',

        'etat',

    ];



    /**
     * Ajouter une Profession
     *

     * @param  string $libelle
     * @param  int $salaire_base

     * @param  int $annee_id




     * @return Profession
     */

    public static function addProfession(
        $libelle,
        $salaire_base,



    )
    {
        $profession = new Profession();


        $profession->libelle = $libelle;
        $profession->salaire_base = $salaire_base;


        $profession->created_at = Carbon::now();

        $profession->save();

        return $profession;
    }

    /**
     * Affichage d'une activité scolaire
     * @param int $id
     * @return  Profession
     */

    public static function rechercheProfessionById($id)
    {

        return   $profession = Profession::findOrFail($id);
    }

    /**
     * Update d'une Profession scolaire

     * @param  string $libelle
     * @param  int $salaire_base

     * @param  int $annee_id





     * @param int $id
     * @return  Profession
     */

    public static function updateProfession(
        $libelle,
        $salaire_base,



        $id)
    {


        return   $profession = Profession::findOrFail($id)->update([



            'libelle' => $libelle,
            'salaire_base' => $salaire_base,



            'id' => $id,


        ]);
    }




    /**
     * Supprimer une Profession
     *
     * @param int $id
     * @return  boolean
     */

    public static function deleteProfession($id)
    {

        $profession = Profession::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($profession) {
            return 1;
        }
        return 0;
    }



    /**
     * Retourne la liste des Professions
     * @param  int $annee_id

     *
     * @return  array
     */

    public static function getListe(

        $libelle= null,
        $salaire_base = null





    ) {



        $query =  Profession::where('etat', '!=', TypeStatus::SUPPRIME)
        ;

        if ($libelle != null) {

            $query->where('libelle', '=', $libelle);
        }

         if ($salaire_base != null) {

            $query->where('salaire_base', '=', $salaire_base);
        }




        return    $query->get();
    }



    /**
     * Retourne le nombre  des  activités


    * @param  int $annee_id



     * @return  int $total
     */

    public static function getTotal(
        $libelle= null,
        $salaire_base = null







    ) {

        $query =   DB::table('professions')


            ->where('professions.etat', '!=', TypeStatus::SUPPRIME);



        if ($libelle != null) {

            $query->where('libelle', '=', $libelle);
        }

         if ($salaire_base != null) {

            $query->where('salaire_base', '=', $salaire_base);
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


        return $this->belongsTo(Annee::class, 'annee_id');
    }




}
