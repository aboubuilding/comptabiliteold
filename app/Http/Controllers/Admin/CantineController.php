<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Cantine;
use App\Models\Detail;
use App\Models\Souscription;
use App\Types\TypePaiement;
use Carbon\Carbon;
use Illuminate\Http\Request;


class CantineController extends Controller
{

    /**
     * Affiche la  liste des  années
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= [] ;

        $session = session()->get('LoginUser');
        $annee_id = $session['annee_id'];

        $cantines = Souscription::getListe(null, $annee_id, null, null, TypePaiement::CANTINE );

        foreach($cantines as $cantine ){
            $data []  = array(


                "inscription_id"=>$cantine->inscription_id == null ? ' ' :$cantine->inscription_id,
                "date_souscription"=>$cantine->date_souscription == null ? ' ' :$cantine->date_souscription,
                "montant_prevu"=>$cantine->montant_prevu == null ? ' ' :$cantine->montant_prevu,

                "montant_total"=>$cantine->montant_total == null ? ' ' :$cantine->montant_total,
                "nom_prenom"=>$cantine->inscription_id == null ? ' ' :$cantine->inscription->eleve->nom.''.$cantine->inscription->eleve->prenom,

                "type_offre"=>$cantine->frais_ecole_id == null ? ' ' : $cantine->fraisecole->libelle,
                "niveau_libelle"=>$cantine->niveau_id == null ? ' ' : $cantine->niveau->libelle,
                "periode"=>$cantine->periode_id == null ? ' ' : $cantine->periode->libelle,
                 "statut"=>$cantine->statut == null ? ' ' : $cantine->statut,

               

            );
        }

        return view('admin.cantine.index')->with(
            [
                'data' => $data,

            ]


        );


    }




    public function store(Request $request){

        $session = session()->get('LoginUser');
        $annee_id = $session['annee_id'];


        $validator = \Validator::make($request->all(),[
            'inscription_id'=>'required',
            'periode_id'=>'required',
            'frais_ecole_id'=>'required',




        ],[
            'inscription_id.required'=>'Le choix de l eleve   est obligatoire ',

            'periode_id.required'=>'La periode    est obligatoire  ',
            'frais_ecole_id.required'=>'Le type de frais    est obligatoire  ',




        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{


                 Souscription::addSouscription(

                   Carbon::today(),
                    $request->montant_prevu,
                    $request->montant_total,
                    $request->type_paiement,
                    $request->montant_total,
                    $request->frais_ecole_id,
                    $request->niveau_id,
                     $annee_id,
                    $request->inscription_id,
                    $request->periode_id,
                   
                    $request->statut,


                );



                return response()->json(['code'=>1,'msg'=>'Souscription   ajoutée avec succès ']);
            }
        }



    public function update(Request $request, $id){

        $session = session()->get('LoginUser');
        $annee_id = $session['annee_id'];
        $validator = \Validator::make($request->all(),[

            'inscription_id'=>'required',
            'periode_id'=>'required',
            'frais_ecole_id'=>'required',

        ],[
            'inscription_id.required'=>'Le choix de l eleve   est obligatoire ',

            'periode_id.required'=>'La periode    est obligatoire  ',
            'frais_ecole_id.required'=>'Le type de frais    est obligatoire  ',


        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{

            $cantine = Souscription::rechercheSouscriptionById($id);

            Souscription::updateSouscription(

                    Carbon::today(),
                    $request->montant_prevu,
                    $request->montant_total,
                    $request->type_paiement,
                    $request->montant_total,
                    $request->frais_ecole_id,
                    $request->niveau_id,
                     $annee_id,
                    $request->inscription_id,
                    $request->periode_id,
                   
                    $request->statut,


                    $id


                );



                return response()->json(['code'=>1,'msg'=>'Cantine modifié  avec succès ']);
            }
        }






    /**
     * Afficher  un Cantine
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit ($id)
    {

        $cantine = Cantine::rechercheCantineById($id);


        return response()->json(['code'=>1, 'cantine'=>$cantine]);


    }







    /**
     * Supprimer   une  Cantine scolaire .
     *
     * @param  int  $int
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request,$id)
    {



        $delete = Cantine::deleteCantine($id);


        // check data deleted or not
        if ($delete) {
            $success = true;
            $message = "Souscription  supprimée ";
        } else {
            $success = true;
            $message = "Souscription  non trouvée   ";
        }


        //  return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }



}
