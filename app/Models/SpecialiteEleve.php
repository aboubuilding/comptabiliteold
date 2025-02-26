<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialiteEleve extends Model
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
    protected $table = 'specialite_eleves';
    protected $fillable = [
        'inscription_id',
        'specialite_id',
        'statut',
        'annee_id',
        'etat',
    ];

   

    public static function addSpecialiteEleve($inscription_id, $specialite_id, $statut, $annee_id)
    {
        $specialiteEleve = new SpecialiteEleve();
        $specialiteEleve->inscription_id = $inscription_id;
        $specialiteEleve->specialite_id = $specialite_id;
        $specialiteEleve->statut = $statut;
        $specialiteEleve->annee_id = $annee_id;
        $specialiteEleve->created_at = Carbon::now();
        $specialiteEleve->save();

        return $specialiteEleve;
    }

    public static function rechercheSpecialiteEleveById($id)
    {
        return SpecialiteEleve::findOrFail($id);
    }

    public static function updateSpecialiteEleve($id, $inscription_id, $specialite_id, $statut, $annee_id)
    {
        return SpecialiteEleve::findOrFail($id)->update([
            'inscription_id' => $inscription_id,
            'specialite_id' => $specialite_id,
            'statut' => $statut,
            'annee_id' => $annee_id,
        ]);
    }

    public static function deleteSpecialiteEleve($id)
    {
        $specialiteEleve = SpecialiteEleve::findOrFail($id)->update(['etat' => TypeStatus::SUPPRIME]);
        return $specialiteEleve ? 1 : 0;
    }

    public static function getListe($annee_id = null, $statut = null)
    {
        $query = SpecialiteEleve::where('etat', '!=', TypeStatus::SUPPRIME);
        if ($annee_id !== null) {
            $query->where('annee_id', '=', $annee_id);
        }
        if ($statut !== null) {
            $query->where('statut', '=', $statut);
        }
        return $query->get();
    }

    public static function getTotal($annee_id = null, $statut = null)
    {
        $query = DB::table('specialite_eleves')->where('etat', '!=', TypeStatus::SUPPRIME);
        if ($annee_id !== null) {
            $query->where('annee_id', '=', $annee_id);
        }
        if ($statut !== null) {
            $query->where('statut', '=', $statut);
        }
        return $query->count() ?: 0;
    }

    public function annee()
    {
        return $this->belongsTo(Annee::class, 'annee_id');
    }

    public function inscription()
    {
        return $this->belongsTo(Inscription::class, 'inscription_id');
    }

    public function specialite()
    {
        return $this->belongsTo(Specialite::class, 'specialite_id');
    }


}
