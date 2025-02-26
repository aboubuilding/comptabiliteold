<?php

namespace App\Models;

use App\Types\TypeStatus;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Souscription extends Model
{
    use HasFactory;

    public function __construct(array $attributes=[])
    {
        parent::__construct($attributes);
        $this->etat=TypeStatus::ACTIF;
    }

    protected $table = 'souscriptions';

    protected $fillable = [
        'date_souscription',
        'montant_prevu',
        'type_paiement',
        'cantine_id',
        'ligne_id',
        'livre_location_id',
        'activite_id',
        'annee_id',
        'inscription_id',
        'periode_id',
        'statut',
        'etat',
    ];





   /**
 * Ajouter une Souscription
 *
 * @param  string $date_souscription
 * @param  float $montant_prevu
 * @param  int $type_paiement
 * @param  int $cantine_id
 * @param  int $ligne_id
 * @param  int $livre_location_id
 * @param  int $activite_id
 * @param  int $annee_id
 * @param  int $inscription_id
 * @param  int $periode_id
 * @param  int $statut
 *
 * @return Souscription
 */
public static function addSouscription(
    $date_souscription,
    $montant_prevu,
    $type_paiement,
    $cantine_id,
    $ligne_id,
    $livre_location_id,
    $activite_id,
    $annee_id,
    $inscription_id,
    $periode_id,
    $statut
) {
    $souscription = new Souscription();

    $souscription->date_souscription = $date_souscription;
    $souscription->montant_prevu = $montant_prevu;
    $souscription->type_paiement = $type_paiement;
    $souscription->cantine_id = $cantine_id;
    $souscription->ligne_id = $ligne_id;
    $souscription->livre_location_id = $livre_location_id;
    $souscription->activite_id = $activite_id;
    $souscription->annee_id = $annee_id;
    $souscription->inscription_id = $inscription_id;
    $souscription->periode_id = $periode_id;
    $souscription->statut = $statut;
    $souscription->etat = TypeStatus::ACTIF;
    $souscription->created_at = Carbon::now();

    $souscription->save();

    return $souscription;
}


    /**
     * Affichage d'une année scolaire
     * @param int $id
     * @return  Souscription
     */

    public static function rechercheSouscriptionById($id)
    {

        return   $souscription= Souscription::findOrFail($id);
    }

   /**
 * Mettre à jour une Souscription scolaire
 *
 * @param  string $date_souscription
 * @param  float $montant_prevu
 * @param  int $type_paiement
 * @param  int $cantine_id
 * @param  int $ligne_id
 * @param  int $livre_location_id
 * @param  int $activite_id
 * @param  int $annee_id
 * @param  int $inscription_id
 * @param  int $periode_id
 * @param  int $statut
 * @param  int $id
 * @return Souscription
 */
public static function updateSouscription(
    $date_souscription,
    $montant_prevu,
    $type_paiement,
    $cantine_id,
    $ligne_id,
    $livre_location_id,
    $activite_id,
    $annee_id,
    $inscription_id,
    $periode_id,
    $statut,
    $id
) {
    $souscription = Souscription::findOrFail($id);

    $souscription->update([
        'date_souscription' => $date_souscription,
        'montant_prevu' => $montant_prevu,
        'type_paiement' => $type_paiement,
        'cantine_id' => $cantine_id,
        'ligne_id' => $ligne_id,
        'livre_location_id' => $livre_location_id,
        'activite_id' => $activite_id,
        'annee_id' => $annee_id,
        'inscription_id' => $inscription_id,
        'periode_id' => $periode_id,
        'statut' => $statut,
    ]);

    return $souscription;
}

    /**
     * Supprimer une Souscription
     *
     * @param int $id
     * @return  boolean
     */

    public static function deleteSouscription($id)
    {

        $souscription= Souscription::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($souscription) {
            return 1;
        }
        return 0;
    }



   /**
 * Retourne la liste des Souscriptions
 *
 * @param  int|null $ligne_id
 * @param  int|null $annee_id
 * @param  int|null $inscription_id
 * @param  int|null $cantine_id
 * @param  int|null $type_paiement
 * @param  int|null $periode_id
 * @param  int|null $statut
 * @param  int|null $livre_location_id
 * @param  int|null $activite_id
 * @return \Illuminate\Database\Eloquent\Collection
 */
public static function getListe(
    $ligne_id = null,
    $annee_id = null,
    $inscription_id = null,
    $cantine_id = null,
    $type_paiement = null,
    $periode_id = null,
    $statut = null,
    $livre_location_id = null,
    $activite_id = null
) {
    $query = Souscription::where('etat', '!=', TypeStatus::SUPPRIME);

    if (!is_null($ligne_id)) {
        $query->where('ligne_id', $ligne_id);
    }

    if (!is_null($annee_id)) {
        $query->where('annee_id', $annee_id);
    }

    if (!is_null($inscription_id)) {
        $query->where('inscription_id', $inscription_id);
    }

    if (!is_null($cantine_id)) {
        $query->where('cantine_id', $cantine_id);
    }

    if (!is_null($type_paiement)) {
        $query->where('type_paiement', $type_paiement);
    }

    if (!is_null($periode_id)) {
        $query->where('periode_id', $periode_id);
    }

    if (!is_null($statut)) {
        $query->where('statut', $statut);
    }

    if (!is_null($livre_location_id)) {
        $query->where('livre_location_id', $livre_location_id);
    }

    if (!is_null($activite_id)) {
        $query->where('activite_id', $activite_id);
    }

    return $query->get();
}


   /**
 * Retourne le nombre total des souscriptions en fonction des filtres
 *
 * @param  int|null $ligne_id
 * @param  int|null $annee_id
 * @param  int|null $inscription_id
 * @param  int|null $cantine_id
 * @param  int|null $type_paiement
 * @param  int|null $periode_id
 * @param  int|null $statut
 * @param  int|null $livre_location_id
 * @param  int|null $activite_id
 * @return int
 */
public static function getTotal(
    $ligne_id = null,
    $annee_id = null,
    $inscription_id = null,
    $cantine_id = null,
    $type_paiement = null,
    $periode_id = null,
    $statut = null,
    $livre_location_id = null,
    $activite_id = null
) {
    $query = DB::table('souscriptions')
        ->where('etat', '!=', TypeStatus::SUPPRIME);

    if (!is_null($ligne_id)) {
        $query->where('ligne_id', $ligne_id);
    }

    if (!is_null($annee_id)) {
        $query->where('annee_id', $annee_id);
    }

    if (!is_null($inscription_id)) {
        $query->where('inscription_id', $inscription_id);
    }

    if (!is_null($cantine_id)) {
        $query->where('cantine_id', $cantine_id);
    }

    if (!is_null($type_paiement)) {
        $query->where('type_paiement', $type_paiement);
    }

    if (!is_null($periode_id)) {
        $query->where('periode_id', $periode_id);
    }

    if (!is_null($statut)) {
        $query->where('statut', $statut);
    }

    if (!is_null($livre_location_id)) {
        $query->where('livre_location_id', $livre_location_id);
    }

    if (!is_null($activite_id)) {
        $query->where('activite_id', $activite_id);
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
     * Obtenir livre_location
     *
     */
    public function livre_location()
    {


        return $this->belongsTo(livre_location::class, 'livre_location_id');
    }


 /**
     * Obtenir une cantine
     *
     */
    public function cantine()
    {


        return $this->belongsTo(Cantine::class, 'cantine_id');
    }



     /**
     * Obtenir une ligne
     *
     */
    public function ligne()
    {


        return $this->belongsTo(Ligne::class, 'ligne_id');
    }



     /**
     * Obtenir un utilisateur
     *
     */
    public function utilisateur()
    {


        return $this->belongsTo(User::class, 'utilisateur_id');
    }





     /**
     * Obtenir une inscription
     *
     */
    public function inscription()
    {


        return $this->belongsTo(Inscription::class, 'inscription_id');
    }







    /**
     * Obtenir une periode
     *
     */
    public function periode()
    {


        return $this->belongsTo(Periode::class, 'periode_id');
    }




  /**
 * Retourne une souscription
 *
 * @param  int|null $ligne_id
 * @param  int|null $annee_id
 * @param  int|null $inscription_id
 * @param  int|null $cantine_id
 * @param  int|null $type_paiement
 * @param  int|null $livre_location_id
 * @param  int|null $activite_id
 * @return Souscription|null
 */
public static function getPrix(
    $ligne_id = null,
    $annee_id = null,
    $inscription_id = null,
    $cantine_id = null,
    $type_paiement = null,
    $livre_location_id = null,
    $activite_id = null
) {
    $query = Souscription::where('etat', '!=', TypeStatus::SUPPRIME);

    if (!is_null($ligne_id)) {
        $query->where('ligne_id', $ligne_id);
    }

    if (!is_null($annee_id)) {
        $query->where('annee_id', $annee_id);
    }

    if (!is_null($inscription_id)) {
        $query->where('inscription_id', $inscription_id);
    }

    if (!is_null($cantine_id)) {
        $query->where('cantine_id', $cantine_id);
    }

    if (!is_null($type_paiement)) {
        $query->where('type_paiement', $type_paiement);
    }

    if (!is_null($livre_location_id)) {
        $query->where('livre_location_id', $livre_location_id);
    }

    if (!is_null($activite_id)) {
        $query->where('activite_id', $activite_id);
    }

    return $query->first();
}

}

