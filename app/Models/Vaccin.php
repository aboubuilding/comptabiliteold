<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccin extends Model
{
    use HasFactory;

    protected $fillable = ['libelle', 'description', 'etat'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->etat = 1;
    }

    /**
     * Ajouter un vaccin
     * @param string $libelle
     * @param string $description
     * @return Vaccin
     */
    public static function addVaccin($libelle, $description)
    {
        $vaccin = new Vaccin();
        $vaccin->libelle = $libelle;
        $vaccin->description = $description;
        $vaccin->created_at = Carbon::now();
        $vaccin->save();

        return $vaccin;
    }

    /**
     * Rechercher un vaccin par ID
     * @param int $id
     * @return Vaccin
     */
    public static function rechercheVaccinById($id)
    {
        return Vaccin::findOrFail($id);
    }

    /**
     * Mettre à jour un vaccin
     * @param int $id
     * @param string $libelle
     * @param string $description
     * @return bool
     */
    public static function updateVaccin($id, $libelle, $description)
    {
        return Vaccin::findOrFail($id)->update([
            'libelle' => $libelle,
            'description' => $description
        ]);
    }

    /**
     * Supprimer un vaccin (désactivation)
     * @param int $id
     * @return int
     */
    public static function deleteVaccin($id)
    {
        $vaccin = Vaccin::findOrFail($id)->update(['etat' => 0]);
        return $vaccin ? 1 : 0;
    }

    /**
     * Retourner la liste des vaccins actifs
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getListe()
    {
        return Vaccin::where('etat', '!=', 0)->get();
    }

    /**
     * Retourner le nombre total des vaccins actifs
     * @return int
     */
    public static function getTotal()
    {
        return DB::table('vaccins')->where('etat', '!=', 0)->count();
    }
}
