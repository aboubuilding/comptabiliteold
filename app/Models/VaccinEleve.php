<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VaccinEleve extends Model
{
    use HasFactory;

    protected $fillable = ['eleve_id', 'vaccin_id', 'etat'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->etat = 1;
    }

    /**
     * Ajouter une vaccination pour un élève
     * @param int $eleve_id
     * @param int $vaccin_id
     * @return VaccinEleve
     */
    public static function addVaccinEleve($eleve_id, $vaccin_id)
    {
        $vaccinEleve = new VaccinEleve();
        $vaccinEleve->eleve_id = $eleve_id;
        $vaccinEleve->vaccin_id = $vaccin_id;
        $vaccinEleve->created_at = Carbon::now();
        $vaccinEleve->save();

        return $vaccinEleve;
    }

    /**
     * Rechercher une vaccination par ID
     * @param int $id
     * @return VaccinEleve
     */
    public static function rechercheVaccinEleveById($id)
    {
        return VaccinEleve::findOrFail($id);
    }

    /**
     * Mettre à jour une vaccination
     * @param int $id
     * @param int $eleve_id
     * @param int $vaccin_id
     * @return bool
     */
    public static function updateVaccinEleve($id, $eleve_id, $vaccin_id)
    {
        return VaccinEleve::findOrFail($id)->update([
            'eleve_id' => $eleve_id,
            'vaccin_id' => $vaccin_id
        ]);
    }

    /**
     * Supprimer une vaccination (désactivation)
     * @param int $id
     * @return int
     */
    public static function deleteVaccinEleve($id)
    {
        $vaccinEleve = VaccinEleve::findOrFail($id)->update(['etat' => 0]);
        return $vaccinEleve ? 1 : 0;
    }

    /**
     * Retourner la liste des vaccinations actives
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getListe()
    {
        return VaccinEleve::where('etat', '!=', 0)->get();
    }

    /**
     * Retourner le nombre total des vaccinations actives
     * @return int
     */
    public static function getTotal()
    {
        return DB::table('vaccin_eleves')->where('etat', '!=', 0)->count();
    }

    /**
     * Obtenir l'élève associé
     */
    public function eleve()
    {
        return $this->belongsTo(Eleve::class, 'eleve_id');
    }

    /**
     * Obtenir le vaccin associé
     */
    public function vaccin()
    {
        return $this->belongsTo(Vaccin::class, 'vaccin_id');
    }
}
