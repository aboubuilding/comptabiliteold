<?php

namespace App\Models;

use App\Types\TypeStatus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Car extends Model
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


        'date_souscription',
        'adresse_map',
        'annee_id',
        'souscription_id',
        'ligne_id',
        'zone_id',



        'etat',

    ];



    /**
     * Ajouter un Car
     *

     * @param  date $date_souscription
     * @param  text $adresse_map
     * @param  int $annee_id

     * @param  int $souscription_id
     * @param  int $ligne_id
     * @param  int $zone_id




     * @return Car
     */

    public static function addCar(
        $date_souscription,
        $adresse_map,
        $annee_id,
        $souscription_id,
        $ligne_id,
        $zone_id

    )
    {
        $car = new Car();


        $car->date_souscription = $date_souscription;

        $car->adresse_map = $adresse_map;


        $car->annee_id = $annee_id;
        $car->souscription_id = $souscription_id;
        $car->ligne_id = $ligne_id;
        $car->zone_id = $zone_id;

        $car->created_at = Carbon::now();

        $car->save();

        return $car;
    }

    /**
     * Affichage d'un Car
     * @param int $id
     * @return  Car
     */

    public static function rechercheCarById($id)
    {

        return   $car = Car::findOrFail($id);
    }

    /**
     * Update d'une Car scolaire



     *

     * @param  date $date_souscription
     * @param  text $adresse_map
     * @param  int $annee_id

     * @param  int $souscription_id
     * @param  int $ligne_id
     * @param  int $zone_id




     * @return Car
     */

    public static function updateCar(
        $date_souscription,
        $adresse_map,
        $annee_id,
        $souscription_id,
        $ligne_id,
        $zone_id,


        $id)
    {


        return   $car = Car::findOrFail($id)->update([



            'date_souscription' => $date_souscription,

            'adresse_map' => $adresse_map,
            'annee_id' => $annee_id,
            'souscription_id' => $souscription_id,
            'ligne_id' => $ligne_id,
            'zone_id' => $zone_id,


            'id' => $id,


        ]);
    }




    /**
     * Supprimer une Car
     *
     * @param int $id
     * @return  boolean
     */

    public static function deleteCar($id)
    {

        $car = Car::findOrFail($id)->update([
            'etat' => TypeStatus::SUPPRIME

        ]);

        if ($car) {
            return 1;
        }
        return 0;
    }



    /**
     * Retourne la liste des Cars


     * @param  int $annee_id

     * @param  int $souscription_id


     * @param  int $zone_id
     * @param  int $ligne_id

     *
     * @return  array
     */

    public static function getListe(

        $annee_id = null,
        $souscription_id = null,

        $ligne_id = null,
        $zone_id = null,


    ) {



        $query =  cars::where('etat', '!=', TypeStatus::SUPPRIME)
        ;

         if ($date_souscription != null) {

            $query->where('date_souscription', '=', $date_souscription);
        }

         if ($adresse_map != null) {

            $query->where('adresse_map', '=', $adresse_map);
        }

        if ($annee_id != null) {

            $query->where('annee_id', '=', $annee_id);
        }

        if ($souscription_id != null) {

            $query->where('souscription_id', '=', $souscription_id);
        }





            if ($ligne_id != null) {

            $query->where('ligne_id', '=', $ligne_id);
        }

         if ($zone_id != null) {

            $query->where('zone_id', '=', $zone_id);
        }





        return    $query->get();
    }



    /**
     * Retourne le nombre  des  Cars


  * @param  int $annee_id

     * @param  int $souscription_id

     * @param  int $zone_id
     * @param  int $ligne_id


     * @return  int $total
     */

 public static function getTotal(
           $annee_id = null,
        $souscription_id = null,

        $ligne_id = null,
        $zone_id = null,







    ) {

        $query =   DB::table('cars')


            ->where('cars.etat', '!=', TypeStatus::SUPPRIME);


       if ($annee_id != null) {

            $query->where('date_souscription', '=', $date_souscription);
        }

        if ($adresse_map != null) {

            $query->where('adresse_map', '=', $adresse_map);
        }



         if ($annee_id != null) {

            $query->where('annee_id', '=', $annee_id);
        }


            if ($souscription_id != null) {

            $query->where('souscription_id', '=', $souscription_id);
        }


  if ($ligne_id!= null) {

            $query->where('ligne_id', '=', $ligne_id);
        }


  if ($zone_id!= null) {

            $query->where('zone_id', '=', $zone_id);
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
     * Obtenir une souscription
     *
     */
    public function souscription_id()
    {


        return $this->belongsTo(souscription::class, 'souscription_id');
    }





     /**
     * Obtenir un fournisseur
     *
     */
    public function zone()
    {


        return $this->belongsTo(Zone::class, 'zone_id');
    }





}
