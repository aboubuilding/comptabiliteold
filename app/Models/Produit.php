<?php

namespace App\Models;

use App\Types\TypeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Produit extends Model
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
        'prix_unitaire_achat',
        'prix_unitaire_vente',
        'prix_unitaire_stock',
        'photo',
        'unite',
        'unite_achat',
        'equivalence',
        'type_produit',



        'etat',

    ];



    /**
     * Ajouter un Produit
     *

     * @param  string $libelle
     * @param  int $prix_unitaire_achat
     * @param  int $prix_unitaire_vente
     * @param  int $prix_unitaire_stock
     * @param  string $photo
     * @param  string $unite
     * @param  string $unite_achat
     * @param  float $equivalence
    
     * @param  int $type_produit


     * @return Produit
     */

    public static function addProduit(
        $libelle,
        $prix_unitaire_achat,
        $prix_unitaire_vente,
        $prix_unitaire_stock,
        $photo,
        $unite,
        $unite_achat,
        $equivalence,
        $type_produit
    


    )
    {
        $produit = new Produit();


        $produit->libelle = $libelle;
        $produit->prix_unitaire_achat = $prix_unitaire_achat;
        $produit->prix_unitaire_vente = $prix_unitaire_vente;
        $produit->prix_unitaire_stock = $prix_unitaire_stock;
        $produit->photo = $photo;
        $produit->unite = $unite;
        $produit->unite_achat = $unite_achat;
        $produit->equivalence = $equivalence;
        $produit->type_produit = $type_produit;


        $produit->created_at = Carbon::now();

        $produit->save();

        return $produit;
    }

    /**
     * Affichage d'une  Produit
     * @param int $id
     * @return  Produit
     */

    public static function rechercheProduitById($id)
    {

        return   $produit = Produit::findOrFail($id);
    }

    /**
     * Update d'une Produit

     * @param  string $libelle
     * @param  int $prix_unitaire_achat
     * @param  int $prix_unitaire_vente
     * @param  int $prix_unitaire_stock
     * @param  string $photo
     * @param  string $unite
     * @param  string $unite_achat
     * @param  float $equivalence
    
     * @param  int $type_produit




     * @param int $id
     * @return  Produit
     */

    public static function updateProduit(
         $libelle,
        $prix_unitaire_achat,
        $prix_unitaire_vente,
        $prix_unitaire_stock,
        $photo,
        $unite,
        $unite_achat,
        $equivalence,
        $type_produit,



        $id)
    {


        return   $produit = Produit::findOrFail($id)->update([



            'libelle' => $libelle,
            'prix_unitaire_achat' => $prix_unitaire_achat,
            'prix_unitaire_vente' => $prix_unitaire_vente,
            'prix_unitaire_stock' => $prix_unitaire_stock,
            
            'photo' => $photo,
            'unite' => $unite,
            'unite_achat' => $unite_achat,
         
            'equivalence' => $equivalence,
            'type_produit' => $type_produit,

            'id' => $id,


        ]);
    }




    /**
     * Supprimer une Produit
     *
     * @param int $id
     * @return  boolean
     */

    public static function deleteProduit($id)
    {

        $produit = Produit::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($produit) {
            return 1;
        }
        return 0;
    }






    /**
     * Retourne le nombre de produits    par  annnee ...


 * @param  int $type_produit
    
         * @return  array
     */

    public static function getListe(

  $type_produit = null,



    ){

        $query =  Produit::

           where('produits.etat', '!=', TypeStatus::SUPPRIME)

        ->orderBy('produits.libelle', 'ASC');

         if ($type_produit != null) {

            $query->where('type_produit', '=', $type_produit);
        }


          return     $query->get();

    }



    /**
     * Retourne la liste  de produits     par  annnee ...





 * @param  int $type_produit


     * @return  int $total
     */

    public static function getTotal(

 $type_produit = null,

    ){

        $query =  Produit::

           where('produits.etat', '!=', TypeStatus::SUPPRIME)
           ;


             if ($type_produit != null) {

            $query->where('type_produit', '=', $type_produit);
        }




        $total = $query ->count();

        if($total){

            return   $total;
        }

        return 0;

    }






}
