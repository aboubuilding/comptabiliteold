<?php

namespace App\Models;

use App\Types\TypeStatus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Cantine extends Model
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
        'montant',
        'annee_id',
        



        'etat',

    ];



    /**
     * Ajouter un Cantine
     *

     * @param  string $libelle
     * @param  string $montant

     * @param  int $annee_id



     * @return Cantine
     */

    public static function addCantine(
        $libelle,
        $montant,
        $annee_id,
        $etat

    )
    {
        $Cantine = new Cantine();


        $Cantine->libelle = $libelle;
        $Cantine->montant = $montant;

        $Cantine->annee_id = $annee_id;
        $Cantine->etat = $etat;

        $Cantine->created_at = Carbon::now();

        $Cantine->save();

        return $Cantine;
    }

    /**
     * Affichage d'un Cantine
     * @param int $id
     * @return  Cantine
     */

    public static function rechercheCantineById($id)
    {

        return   $Cantine = Cantine::findOrFail($id);
    }

    /**
     * Update d'une Cantine scolaire

    * @param  string $libelle
     * @param  string $montant
    


     * @param  int $annee_id
     * @param  int $etat
    


     * @param int $id
     * @return  Cantine
     */

    public static function updateCantine(
        $libelle,
        $montant,
        $type_offre,

        $annee_id,
        


        $id)
    {


        return   $Cantine = Cantine::findOrFail($id)->update([



            'libelle' => $libelle,
            'montant' => $montant,
            

            'annee_id' => $annee_id,
        



            'id' => $id,


        ]);
    }




    /**
     * Supprimer une Cantine
     *
     * @param int $id
     * @return  boolean
     */

    public static function deleteCantine($id)
    {

        $Cantine = Cantine::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($Cantine) {
            return 1;
        }
        return 0;
    }



    /**
     * Retourne la liste des Cantines


     * @param  int $annee_id

     * @param  int $inscription_id
     * @param  int $type_offre

     *
     * @return  array
     */

    public static function getListe(


        $annee_id = null,
       


    ) {



        


        ->where('cantines.etat', '!=', TypeStatus::SUPPRIME)


        ;

        if ($annee_id != null) {

            $query->where('cantines.annee_id', '=', $annee_id);
        }


        if ($inscription_id != null) {

            $query->where('cantines.libelle', '=', $libelle);
        }

        
  if ($inscription_id != null) {

            $query->where('cantines.montant', '=', $montant);
        }

      


       





        return    $query->get();
    }



    /**
     * Retourne le nombre  des  Cantines


   * @param  int $annee_id
   * @param  int $libelle
     * @param  int montant
    


     
     */

    public static function getTotal(
        $annee_id = null,
       





    ) {

        



        ->where('cantines.etat', '!=', TypeStatus::SUPPRIME);


        if ($inscription_id != null) {

            $query->where('cantines.libelle', '=', $libelle);
        }

        if ($niveau_id != null) {

            $query->where('cantines.montant', '=', $niveau_id);
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
     * Obtenir un fournisseur
     *
     */
    




}
