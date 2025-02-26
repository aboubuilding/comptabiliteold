<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
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
        'file',
        'type',

        'inscription_id',
        'annee_id',


        'etat',

    ];

      /**
     * Ajouter un bulletin


     * @param  string $libelle
     * @param  string $file

     * @param  int $type
     * @param  int $inscription_id

     * @param  int $annee_id



     * @return bulletin
     */

     public static function addBulletin(
        $libelle,
        $file,

        $type,
        $annee_id,
        $inscription

    )
    {
        $bulletin = new Bulletin();


        $bulletin->libelle = $libelle;
        $bulletin->file = $file;
        $bulletin->type = $type;

        $bulletin->inscription_id = $inscription_id;
        $bulletin->annee_id = $annee_id;


        $bulletin->created_at = Carbon::now();

        $bulletin->save();

        return $bulletin;
    }

    /**
     * Affichage d'un bulletin
     * @param int $id
     * @return  Bulletin
     */

    public static function rechercheBulletinById($id)
    {

        return   $bulletin = Bulletin::findOrFail($id);
    }

    /**
     * Update d'un bulletin

    * @param  string $libelle
     * @param  string $file

     * @param  int $type
     * @param  int $inscription_id

     * @param  int $annee_id




     * @param int $id
     * @return  Bulletin
     */

    public static function updateBulletin(
        $libelle,
        $file,

        $type,
        $annee_id,
        $inscription,


        $id)
    {


        return   $bulletin = Bulletin::findOrFail($id)->update([



            'libelle' => $libelle,
            'file' => $file,

            'type' => $type,
            'annee_id' => $annee_id,
            'inscription_id' => $inscription_id,

            'id' => $id,


        ]);
    }




    /**
     * Supprimer une Bulletin
     *
     * @param int $id
     * @return  boolean
     */

    public static function deleteBulletin($id)
    {

        $bulletin = Bulletin::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($activite) {
            return 1;
        }
        return 0;
    }



    /**
     * Retourne la liste des Bulletin
     * @param  int $annee_id
     * @param  int $inscription_id

     *
     * @return  array
     */

    public static function getListe(

        $annee_id = null,

        $inscription_id = null

    ) {



        $query =  Bulletin::where('etat', '!=', TypeStatus::SUPPRIME)
        ;

        if ($annee_id != null) {

            $query->where('annee_id', '=', $annee_id);
        }

        if ($niveau_id != null) {

            $query->where('inscription_id', '=', $inscription_id);
        }




        return    $query->get();
    }



    /**
     * Retourne le nombre  des  activités


    * @param  int $annee_id
     * @param  int $niveau_id


     * @return  int $total
     */

    public static function getTotal(
        $annee_id = null,
        $inscription_id = null




    ) {

        $query =   DB::table('bulletin')


            ->where('bulletins.etat', '!=', TypeStatus::SUPPRIME);


        if ($inscription_id != null) {

            $query->where('bulletins.inscription_id', '=', $inscription_id);
        }


        if ($annee_id != null) {

            $query->where('bulletins.annee_id', '=', $annee_id);
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
     * Obtenir une inscription
     *
     */
    public function inscription()
    {


        return $this->belongsTo(Inscription::class, 'inscription_id');
    }
}
