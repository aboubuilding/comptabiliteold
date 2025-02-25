<?php

namespace App\Models;

use App\Types\TypeStatus;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Boutique extends Model
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
        'description',
        'responsable',
        

        'etat',

    ];



    /**
     * Ajouter une Boutique
     *

     * @param  string $libelle
     * @param  int $description
     * @param  int $responsable
    



     * @return Boutique
     */

    public static function addBoutique(
        $libelle,
        $description,
        $responsable
      

    )
    {
        $boutique = new Boutique();


        $boutique->libelle = $libelle;
        $boutique->description = $description;
        $boutique->responsable = $responsable;
       


        $boutique->created_at = Carbon::now();

        $boutique->save();

        return $boutique;
    }

    /**
     * Affichage d'une activité scolaire 
     * @param int $id
     * @return  Boutique
     */

    public static function rechercheBoutiqueById($id)
    {

        return   $boutique = Boutique::findOrFail($id);
    }

    /**
     * Update d'une Boutique scolaire

     * @param  string $libelle
     * @param  int $description
     * @param  int $responsable
    




     * @param int $id
     * @return  Boutique
     */

    public static function updateBoutique(
        $libelle,
        $description,
        $responsable,
       
        $id)
    {


        return   $boutique = Boutique::findOrFail($id)->update([



            'libelle' => $libelle,
            'description' => $description,
            'responsable' => $responsable,
           

            'id' => $id,


        ]);
    }




    /**
     * Supprimer une Boutique
     *
     * @param int $id
     * @return  boolean
     */

    public static function deleteBoutique($id)
    {

        $boutique = Boutique::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($boutique) {
            return 1;
        }
        return 0;
    }



    /**
     * Retourne la liste des Boutiques
   

     *
     * @return  array
     */

    public static function getListe(

       

    ) {

      

        $query =  Boutique::where('etat', '!=', TypeStatus::SUPPRIME)
        ;

        

       


        return    $query->get();
    }



    /**
     * Retourne le nombre  des  activités 


    


     * @return  int $total
     */

    public static function getTotal(
       




    ) {

        $query =   DB::table('Boutiques')


            ->where('Boutiques.etat', '!=', TypeStatus::SUPPRIME);


       




        $total = $query->count();

        if ($total) {

            return   $total;
        }

        return 0;
    }



    


}
