<?php

namespace App\Models;

use App\Types\TypeStatus;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Vente extends Model
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
        'date_vente',
        'quantite',
        'annee_id',
        'montant',
        
        'personnel_id',
        'produit_id',
        
        'boutique_id',


        'etat',

    ];



    /**
     * Ajouter une Vente
     
     * @param  string $libelle
     * @param  date $date_vente
     * @param  int $quantite
     * @param  int $annee_id
     * @param  float $montant
     
     * @param  int $produit_id
     * @param  int $personnel_id
     * @param  int $boutique_id



     * @return Vente
     */

    public static function addVente (

        $libelle,
        $date_vente,
        $quantite,
        $annee_id,
         $montant,
        $personnel_id,
        $produit_id,
       
        $boutique_id,


        $id


    )
    {
        $vente = new Vente();

        $vente->libelle = $libelle;
        $vente->date_vente = $date_vente;
        $vente->quantite = $quantite;
        $vente->annee_id = $annee_id;
        $vente->montant = $montant;
        $vente->personnel_id = $personnel_id;
        $vente->produit_id = $produit_id;
        
        $vente->boutique_id = $boutique_id;



        $vente->created_at = Carbon::now();

        $vente->save();

        return $vente;
    }

    /**
     * Affichage d'une année scolaire
     * @param int $id
     * @return  Vente
     */

    public static function rechercheVenteById($id)
    {

        return   $vente= Vente::findOrFail($id);
    }

    /**
     * Update d'une Vente scolaire
     *
     *
     *
     @param  string $libelle
     * @param  date $date_vente
     * @param  int $quantite
     * @param  int $annee_id
     * @param  float $montant
     
     * @param  int $produit_id
     * @param  int $personnel_id
     * @param  int $boutique_id
     *
     * @param int $id
     * @return  Vente
     */

    public static function updateVente(
         $libelle,
        $date_vente,
        $quantite,
        $annee_id,
         $montant,
        $personnel_id,
        $produit_id,
       
        $boutique_id,




        $id)
    {


        return   $vente= Vente::findOrFail($id)->update([

            'libelle' => $libelle,

            'date_vente' => $date_vente,
            'quantite' => $quantite,
            'annee_id' => $annee_id,
            'montant' => $montant,
            'personnel_id' => $personnel_id,
            'produit_id' => $produit_id,
            
            'boutique_id' => $boutique_id,


            'id' => $id,


        ]);
    }




    /**
     * Supprimer une Vente
     *
     * @param int $id
     * @return  boolean
     */

    public static function deleteVente($id)
    {

        $vente= Vente::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($vente) {
            return 1;
        }
        return 0;
    }



    /**
     * Retourne la liste des Ventes


     * @param  int $annee_id
     * @param  int $inscription_id
     * @param  int $personnel_id
     * @param  int $produit_id
     * @param  int $detail_id
     * @param  int $boutique_id




     *
     * @return  array
     */

    public static function getListe(

         $libelle,
        $date_vente,
        $quantite,
        $annee_id,
         $montant,
        $personnel_id,
        $produit_id,
       
        $boutique_id,




        $id)

        {



        $query =  Vente::where('etat', '!=', TypeStatus::SUPPRIME)
        ;




        if ($annee_id != null) {

            $query->where('annee_id', '=', $annee_id);
        }

        if ($inscription_id != null) {

            $query->where('inscription_id', '=', $inscription_id);
        }


        if ($personnel_id != null) {

            $query->where('personnel_id', '=', $personnel_id);
        }



        if ($produit_id != null) {

            $query->where('produit_id', '=', $produit_id);
        }


         if ($detail_id != null) {

            $query->where('detail_id', '=', $detail_id);
        }


         if ($boutique_id != null) {

            $query->where('boutique_id', '=', $boutique_id);
        }




        return    $query->get();
    }



    /**
     * Retourne le nombre  des  activités
 *
     *

     * @param int $annee_id
     * * @param int $inscription_id
     * * @param int $personnel_id
     * * @param int $produit_id
     * * @param int $detail_id
     * * @param int $boutique_id
 *
     *
     * @return  int $total
     */

    public static function getTotal(

        $annee_id = null,
        $inscription_id = null,
        $personnel_id = null,
        $produit_id = null,
        $detail_id = null,
        $boutique_id = null




    ) {

        $query =   DB::table('ventes')


            ->where('ventes.etat', '!=', TypeStatus::SUPPRIME);




        if ($annee_id != null) {

            $query->where('annee_id', '=', $annee_id);
        }

        if ($inscription_id != null) {

            $query->where('inscription_id', '=', $inscription_id);
        }


        if ($personnel_id != null) {

            $query->where('personnel_id', '=', $personnel_id);
        }



        if ($produit_id != null) {

            $query->where('produit_id', '=', $produit_id);
        }




         if ($detail_id != null) {

            $query->where('detail_id', '=', $detail_id);
        }


         if ($boutique_id != null) {

            $query->where('boutique_id', '=', $boutique_id);
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
     * Obtenir une année
     *
     */
    public function inscription()
    {


        return $this->belongsTo(Inscription::class, 'inscription_id');
    }



    /**
     * Obtenir une année
     *
     */
    public function personnel()
    {


        return $this->belongsTo(personnel::class, 'personnel_id');
    }



     /**
     * Obtenir un user  
     *
     */
    public function boutique()
    {


        return $this->belongsTo(User::class, 'boutique_id');
    }





    /**
     * Obtenir un produit
     *
     */
    public function produit()
    {


        return $this->belongsTo(Produit::class, 'produit_id');
    }





    /**
     * Retourne la quantite
     *
     *

     * @param int $annee_id
     * * @param int $inscription_id
     * * @param int $personnel_id
     * * @param int $produit_id
     *
     *
     * @return  int $total
     */

    public static function getQuantiteProduit(

        $annee_id = null,
        $inscription_id = null,
        $personnel_id = null,
        $produit_id = null




    ) {




        $total = 0;
        $ventes  = Vente::getListe(
            $annee_id, $inscription_id, $personnel_id, $produit_id
        );


        foreach ($ventes as $vente ){

            $total += $vente->quantite;

        }

        if ($total) {

            return   $total;
        }

        return 0;
    }






    /**
     * Retourne la quantite
     *
     *

     * @param int $annee_id
     * * @param int $inscription_id
     * * @param int $personnel_id
     * * @param int $produit_id
     *
     *
     * @return  int $total
     */

    public static function getMontantProduit(

        $annee_id = null,
        $inscription_id = null,
        $personnel_id = null,
        $produit_id = null




    ) {




        $total = 0;
        $ventes  = Vente::getListe(
            $annee_id, $inscription_id, $personnel_id, $produit_id
        );


        foreach ($ventes as $vente ){

            $total += $vente->quantite*$vente->produit->prix;

        }

        if ($total) {

            return   $total;
        }

        return 0;
    }





}
