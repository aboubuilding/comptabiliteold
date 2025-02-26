<?php

namespace App\Models;

use App\Types\TypeStatus;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Periode extends Model
{
    use HasFactory;




    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->etat = TypeStatus::ACTIF;
    
    }

    protected $table = 'periodes';

    protected $fillable = [
        'libelle',
        'date_debut',
        'date_fin',
        'annee_id',
        'statut',
        'etat',
    ];





    /**
     * Ajouter une Periode
     *

     * @param  int $libelle
     * @param  int $inscription_id
     * @param  int $annee_id
     * @param  date $date_Periode
     * @param  date $date_retour_Periode
     * @param  date $date_retour_reel
     * @param  int $statut_Periode



     * @return Periode
     */

    public static function addPeriode(
        $libelle,
        $inscription_id,
        $annee_id,
        $date_Periode,
        $date_retour_Periode,
        $date_retour_reel,
        $statut_Periode


    )
    {
        $Periode = new Periode();


        $Periode->libelle = $libelle;
        $Periode->inscription_id = $inscription_id;
        $Periode->annee_id = $annee_id;
        $Periode->date_Periode = $date_Periode;
        $Periode->date_retour_Periode = $date_retour_Periode;
        $Periode->date_retour_reel = $date_retour_reel;
        $Periode->statut_Periode = $statut_Periode;


        $Periode->created_at = Carbon::now();

        $Periode->save();

        return $Periode;
    }

    /**
     * Affichage d'une activité scolaire
     * @param int $id
     * @return  Periode
     */

    public static function recherchePeriodeById($id)
    {

        return   $Periode = Periode::findOrFail($id);
    }

    /**
     * Update d'une Periode scolaire

    * @param  int $libelle
     * @param  int $inscription_id
     * @param  int $annee_id
     * @param  date $date_Periode
     * @param  date $date_retour_Periode
     * @param  date $date_retour_reel
     * @param  int $statut_Periode




     * @param int $id
     * @return  Periode
     */

    public static function updatePeriode(
        $libelle,
        $inscription_id,
        $annee_id,
        $date_Periode,
        $date_retour_Periode,
        $date_retour_reel,
        $statut_Periode,

        $id)
    {


        return   $Periode = Periode::findOrFail($id)->update([



            'libelle' => $libelle,
            'inscription_id' => $inscription_id,
            'annee_id' => $annee_id,
            'date_Periode' => $date_Periode,
            'date_retour_Periode' => $date_retour_Periode,
            'date_retour_reel' => $date_retour_reel,
            'statut_Periode' => $statut_Periode,

            'id' => $id,


        ]);
    }




    /**
     * Supprimer une Periode
     *
     * @param int $id
     * @return  boolean
     */

    public static function deletePeriode($id)
    {

        $Periode = Periode::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Periode) {
            return 1;
        }
        return 0;
    }



    /**
     * Retourne la liste des Periodes
     * @param  int $libelle
     * @param  int $inscription_id
     * @param  int $annee_id

     *
     * @return  array
     */

    public static function getListe(

        $libelle = null,

        $inscription_id = null,
        $annee_id = null

    ) {



        $query =  Periode::where('etat', '!=', TypeStatus::SUPPRIME)
        ;

        if ($libelle != null) {

            $query->where('libelle', '=', $libelle);
        }

        if ($inscription_id != null) {

            $query->where('inscription_id', '=', $inscription_id);
        }


        if ($annee_id != null) {

            $query->where('annee_id', '=', $annee_id);
        }




        return    $query->get();
    }



    /**
     * Retourne le nombre  des  activités


    * @param  int $libelle
     * @param  int $inscription_id
     * @param  int $annee_id

     * @return  int $total
     */

    public static function getTotal(
        $libelle = null,

        $inscription_id = null,
        $annee_id = null




    ) {

        $query =   DB::table('Periodes')


            ->where('Periodes.etat', '!=', TypeStatus::SUPPRIME);


            if ($libelle != null) {

                $query->where('libelle', '=', $libelle);
            }

            if ($inscription_id != null) {

                $query->where('inscription_id', '=', $inscription_id);
            }


            if ($annee_id != null) {

                $query->where('annee_id', '=', $annee_id);
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


    /**
     * Obtenir une periode
     *
     */
    public function inscription()
    {


        return $this->belongsTo(Inscription::class, 'inscription_id');
    }


      /**
     * Obtenir un employe
     *
     */
    public function livre()
    {


        return $this->belongsTo(Livre::class, 'libelle');
    }


}
