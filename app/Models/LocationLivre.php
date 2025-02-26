<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationLivre extends Model
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


        'marque_ordinateur',
        'numero_serie',
        'nom_machine',
        'mot de passe',
        'inscription_id',
        'annee_id',



        'etat',

    ];



    /**
     * Ajouter une Location de livre
     *

     * @param  string $marque_ordinateur
     * @param  string $numero_serie
     * @param  string $nom_machine
     * @param  string $mot de passe
     * @param  int $annee_id
     * @param  int $inscription_id



     * @return LocationLivre
     */

    public static function addLocationLivre(
        $marque_ordinateur,
        $numero_serie,
        $nom_machine,
        $mot_passe,
        $inscription_id,
        $annee_id


    )
    {
        $LocationLivre = new LocationLivre();


        $LocationLivre->marque_ordinateur = $marque_ordinateur;
        $LocationLivre->numero_serie = $numero_serie;
        $LocationLivre->nom_machine = $nom_machine;
        $LocationLivre->mot_passe = $mot_passe;
        $LocationLivre->inscription_id = $inscription_id;
        $LocationLivre->annee_id = $annee_id;

        $LocationLivre->created_at = Carbon::now();

        $LocationLivre->save();

        return $LocationLivre;
    }

    /**
     * Affichage d'une activité scolaire
     * @param int $id
     * @return  LocationLivre
     */

    public static function rechercheLocationLivreById($id)
    {

        return   $LocationLivre = Locationlivre::findOrFail($id);
    }

    /**
     * Update d'une location de livre
     * @param  string $marque_ordinateur
     * @param  string $numero_serie
     * @param  string $nom_machine
     * @param  string $mot de passe
     * @param  int $annee_id
     * @param  int $inscription_id




     * @param int $id
     * @return  LocationLivre
     */

    public static function updateLocationLivre(
        $marque_ordinateur,
        $numero_serie,
        $nom_machine,
        $mot_passe,
        $inscription_id,
        $annee_id,

        $id)
    {


        return   $LocationLivre = LocationLivre::findOrFail($id)->update([



            'marque_ordinateur' => $marque_ordinateur,
            'numero_serie' => $numero_serie,
            'nom_machine' => $nom_machine,
            'mot_passe' => $mot_passe,
            'inscription_id' => $inscription_id,
            'annee_id' => $annee_id,


            'id' => $id,


        ]);
    }




    /**
     * Supprimer une LocationLivre
     *
     * @param int $id
     * @return  boolean
     */

    public static function deleteActivite($id)
    {

        $LocationLivre = LocationLivre::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($LocationLivre) {
            return 1;
        }
        return 0;
    }



    /**
     * Retourne la liste des LocationLivre
     * @param  int $inscription_id
     * @param  int $annee_id


     *
     * @return  array
     */

    public static function getListe(

        $inscription_id = null,
        $annee_id = null



    ) {



        $query =  Inscription::where('etat', '!=', TypeStatus::SUPPRIME)
        ;


        if ($inscription_id != null) {

            $query->where('inscription_id', '=', $inscription_id);
        }


        if ($annee_id != null) {

            $query->where('annee_id', '=', $annee_id);
        }




        return    $query->get();
    }



    /**
     * Retourne le nombre  des  locationLivre

     * @param  int $inscription_id
    * @param  int $annee_id



     * @return  int $total
     */

    public static function getTotal(
        $inscription_id = null,
        $annee_id = null





    ) {

        $query =   DB::table('LocationLivres')


            ->where('LocationLivres.etat', '!=', TypeStatus::SUPPRIME);


        if ($inscription_id != null) {

            $query->where('locationLivres.niveau_id', '=', $inscription_id);
        }


        if ($annee_id != null) {

            $query->where('LocationLivres.annee_id', '=', $annee_id);
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
     * Obtenir un niveau
     *
     */
    public function inscription()
    {


        return $this->belongsTo(Inscription::class, 'inscription_id');
    }



}
