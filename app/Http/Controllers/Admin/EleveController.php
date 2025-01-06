<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Models\Eleve;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EleveController extends Controller
{

    /**
     * Affiche la  liste des  années
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $session = session()->get('LoginUser');
        $annee_id = $session['annee_id'];
        $compte_id = $session['compte_id'];
        $data= [] ;

        $eleves = Inscription::getListe( $annee_id);



        return view('admin.eleve.index')->with(
            [
                'data' => $data,

            ]


        );


    }




    public function store(Request $request){

        $session = session()->get('LoginUser');
        $annee_id = $session['annee_id'];
        $compte_id = $session['compte_id'];

        $validator = \Validator::make($request->all(),[
            'nom'=>'required|string|max:100',
            'prenom'=>'required|string|max:200',
            'cycle_id'=>'required',
            'sexe'=>'required',
            'date_naissance'=>'required',
            'lieu_naissance'=>'required',

        ],[
            'nom.required'=>'Le nom  est obligatoire ',
            'prenom.string'=>'Le prenom  est obligatoire  ',

            'cycle_id'=>'Le cycle est obligatoire  ',
            'sexe'=>'Le choix du sexe  est obligatoire  ',
            'date_naissance'=>'La date de naissance  est obligatoire  ',
            'lieu_naissance'=>'Le lieu de naissance  est obligatoire ',




        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{


            try {
                DB::transaction(function () use ($request) {


                 Eleve::addEleve(

                    $request->matricule,
                    $request->nom,
                    $request->prenom,
                    $request->prenom_usuel,
                    $request->ecole_provenance,
                    $request->date_naissance,
                    $request->lieu_naissance,
                    $request->sexe,
                    $request->nationalite_id,
                    $request->espace_id,
                    $request->nom_medecin,
                    $request->personne_prevenir,
                    $request->photo,
                    $request->carte_identite,
                    $request->naissance,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    $request->montant,
                    TypePaiement::PRODUIT,

                    null,
                    null,
                    $annee_id

                );

                });

                return response()->json(['code'=>1,'msg'=>'Eleve  ajouté avec succès ']);

            } catch (\Exception $e) {
                // Gérer les erreurs
                return response()->json(['error' => 'Erreur ajout éleve', 'details' => $e->getMessage()], 500);
            }
            }
        }



    public function update(Request $request, $id){

        $session = session()->get('LoginUser');
        $annee_id = $session['annee_id'];
        $compte_id = $session['compte_id'];


        $validator = \Validator::make($request->all(),[

            'libelle'=>'required|string|max:25|unique:frais_ecoles,libelle,'.$id,


        ],[
            'libelle.required'=>'Le libellé  est obligatoire ',
            'libelle.string'=>'Le libellé  doit etre une chaine de caracteres ',
            'libelle.unique'=>'Le libellé   existe déjà ',

             'libelle.max'=>'Le libellé   ne doit pas depasser 25 caracteres  ',


        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{

                FraisEcole::updateFraisEcole(

                    $request->libelle,
                    $request->montant,
                    TypePaiement::PRODUIT,

                    null,
                    null,
                    $annee_id,

                    $id


                );



                return response()->json(['code'=>1,'msg'=>'Eleve  modifiée  avec succès ']);
            }
        }






    /**
     * Afficher  un Activite
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit ($id)
    {

        $eleve = FraisEcole::rechercheFraisEcoleById($id);


        return response()->json(['code'=>1, 'Eleve'=>$eleve]);


    }



    /**
     * Supprimer   une  Activite scolaire .
     *
     * @param  int  $int
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request,$id)
    {



        $delete = FraisEcole::deleteFraisEcole($id);


        // check data deleted or not
        if ($delete) {
            $success = true;
            $message = "Eleve  supprimée ";
        } else {
            $success = true;
            $message = "Eleve  non trouvée   ";
        }


        //  return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }









}
