<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePaiement extends Model
{
    use HasFactory;
    protected $fillable = ['libelle', 'etat'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->etat = 1;
    }

    /**
     * Ajouter un type de paiement
     * @param string $libelle
     * @return TypePaiement
     */
    public static function addTypePaiement($libelle)
    {
        $typePaiement = new TypePaiement();
        $typePaiement->libelle = $libelle;
        $typePaiement->created_at = Carbon::now();
        $typePaiement->save();

        return $typePaiement;
    }

    /**
     * Rechercher un type de paiement par ID
     * @param int $id
     * @return TypePaiement
     */
    public static function rechercheTypePaiementById($id)
    {
        return TypePaiement::findOrFail($id);
    }

    /**
     * Mettre à jour un type de paiement
     * @param int $id
     * @param string $libelle
     * @return bool
     */
    public static function updateTypePaiement($id, $libelle)
    {
        return TypePaiement::findOrFail($id)->update(['libelle' => $libelle]);
    }

    /**
     * Supprimer un type de paiement (désactivation)
     * @param int $id
     * @return int
     */
    public static function deleteTypePaiement($id)
    {
        $typePaiement = TypePaiement::findOrFail($id)->update(['etat' => 0]);
        return $typePaiement ? 1 : 0;
    }

    /**
     * Retourner la liste des types de paiement actifs
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getListe()
    {
        return TypePaiement::where('etat', '!=', 0)->get();
    }

    /**
     * Retourner le nombre total des types de paiement actifs
     * @return int
     */
    public static function getTotal()
    {
        return DB::table('type_paiements')->where('etat', '!=', 0)->count();
    }
}
