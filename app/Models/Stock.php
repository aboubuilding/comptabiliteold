<?php

namespace App\Models;

use App\Types\TypeStatus;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Stock extends Model
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

        'date_stock',
        'produit_id',
        'magasin_id',
        'bon_id',
        'annee_id',
        'quantite',
        'type_mouvement',



        'etat',

    ];



    
/**
 * Ajouter un Stock
 *
 * @param  int $bon_id
 * @param  int $produit_id
 * @param  int $magasin_id
 * @param  int|null $boutique_id
 * @param  int $annee_id
 * @param  float $quantite
 * @param  int $type_mouvement
 * @return Stock
 */
public static function addStock(
    $bon_id,
    $produit_id,
    $magasin_id,
    $boutique_id = null,
    $annee_id,
    $quantite,
    $type_mouvement
) {
    $stock = new Stock();

    $stock->date_stock = Carbon::now(); 
    $stock->bon_id = $bon_id;
    $stock->produit_id = $produit_id;
    $stock->magasin_id = $magasin_id;
    $stock->boutique_id = $boutique_id;
    $stock->annee_id = $annee_id;
    $stock->quantite = $quantite;
    $stock->type_mouvement = $type_mouvement;
    $stock->etat = 1; 
    $stock->save();

    return $stock;
}

   
    /**
 * Recherche d'un Stock par ID
 *
 * @param int $id
 * @return Stock
 */
public static function rechercheStockById($id)
{
    return Stock::findOrFail($id);
}

/**
 * Mise à jour d'un Stock
 *
 * @param int $id
 * @param int $bon_id
 * @param int $produit_id
 * @param int $magasin_id
 * @param int|null $boutique_id
 * @param int $annee_id
 * @param float $quantite
 * @param int $type_mouvement
 * @param int $etat
 * @return Stock
 */
public static function updateStock(
    $id,
    $bon_id,
    $produit_id,
    $magasin_id,
    $boutique_id = null,
    $annee_id,
    $quantite,
    $type_mouvement,
    $etat = 1
) {
    $stock = Stock::findOrFail($id);

    $stock->update([
        'bon_id' => $bon_id,
        'produit_id' => $produit_id,
        'magasin_id' => $magasin_id,
        'boutique_id' => $boutique_id,
        'annee_id' => $annee_id,
        'quantite' => $quantite,
        'type_mouvement' => $type_mouvement,
        'etat' => $etat,
    ]);

    return $stock;
}



    /**
     * Supprimer une Stock
     *
     * @param int $id
     * @return  boolean
     */

    public static function deleteStock($id)
    {

        $stock= Stock::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($stock) {
            return 1;
        }
        return 0;
    }



   /**
 * Retourne la liste des Stocks
 *
 * @param int|null $annee_id
 * @param int|null $type_mouvement
 * @param int|null $bon_id
 * @param int|null $magasin_id
 * @param int|null $produit_id
 * @param int|null $boutique_id
 * @param int $etat
 * @return \Illuminate\Database\Eloquent\Collection
 */
public static function getListe(
    $annee_id = null,
    $type_mouvement = null,
    $bon_id = null,
    $magasin_id = null,
    $produit_id = null,
    $boutique_id = null,
    $etat = 1
) {
    $query = Stock::where('etat', '!=', TypeStatus::SUPPRIME);

    if (!is_null($annee_id)) {
        $query->where('annee_id', $annee_id);
    }

    if (!is_null($type_mouvement)) {
        $query->where('type_mouvement', $type_mouvement);
    }

    if (!is_null($bon_id)) {
        $query->where('bon_id', $bon_id);
    }

    if (!is_null($produit_id)) {
        $query->where('produit_id', $produit_id);
    }

    if (!is_null($magasin_id)) {
        $query->where('magasin_id', $magasin_id);
    }

    if (!is_null($boutique_id)) {
        $query->where('boutique_id', $boutique_id);
    }

    if (!is_null($etat)) {
        $query->where('etat', $etat);
    }

    return $query->get();
}

   /**
 * Retourne le nombre total des activités en stock.
 *
 * @param int|null $annee_id
 * @param int|null $type_mouvement
 * @param int|null $bon_id
 * @param int|null $magasin_id
 * @param int|null $produit_id
 * @param int|null $boutique_id
 * @param int $etat
 * @return int
 */
public static function getTotal(
    $annee_id = null,
    $type_mouvement = null,
    $bon_id = null,
    $magasin_id = null,
    $produit_id = null,
    $boutique_id = null,
    $etat = 1
) {
    $query = DB::table('stocks')->where('etat', '!=', TypeStatus::SUPPRIME);

    if (!is_null($annee_id)) {
        $query->where('annee_id', $annee_id);
    }

    if (!is_null($type_mouvement)) {
        $query->where('type_mouvement', $type_mouvement);
    }

    if (!is_null($bon_id)) {
        $query->where('bon_id', $bon_id);
    }

    if (!is_null($produit_id)) {
        $query->where('produit_id', $produit_id);
    }

    if (!is_null($magasin_id)) {
        $query->where('magasin_id', $magasin_id);
    }

    if (!is_null($boutique_id)) {
        $query->where('boutique_id', $boutique_id);
    }

    if (!is_null($etat)) {
        $query->where('etat', $etat);
    }

    return $query->count();
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
     * Obtenir un bon
     *
     */
    public function bon()
    {


        return $this->belongsTo(Bon::class, 'bon_id');
    }





     /**
     * Obtenir un bon
     *
     */
    public function magasin()
    {


        return $this->belongsTo(Magasin::class, 'magasin_id');
    }


 /**
     * Obtenir une boutique
     *
     */
    public function boutique()
    {


        return $this->belongsTo(Boutique::class, 'boutique_id');
    }


     /**
     * Obtenir un produit
     *
     */
    public function produit()
    {


        return $this->belongsTo(Produit::class, 'produit_id');
    }










}
