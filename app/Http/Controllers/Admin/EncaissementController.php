<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;



use App\Models\Annee;
use App\Models\Caisse;

use App\Models\Detail;
use App\Models\Mouvement;

use App\Models\Inscription;

use App\Models\Paiement;


use App\Models\User;


use App\Types\StatutPaiement;
use App\Types\TypeMouvement;
use App\Types\TypePaiement;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Excel;

class EncaissementController extends Controller
{



    /**
     * Affiche la  liste de tous les encaissements
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= [] ;
        $session = session()->get('LoginUser');
        $annee_id = $session['annee_id'];
        $compte_id = $session['compte_id'];

        $user = User::rechercheUserById($compte_id);


        $role = null;
        if ($user->role == \App\Types\Role::COMPTABLE) {

            $role = $compte_id;
        }

        $debutsemaine = \Illuminate\Support\Carbon::now()->startOfWeek()->format('Y-m-d');
        $finsemaine = \Carbon\Carbon::now()->endOfWeek()->format('Y-m-d');

        // aujourdhui

        $aujourdhui = Carbon::today()->format('Y-m-d');

        $debutmois = \Illuminate\Support\Carbon::now()->startOfMonth()->format('Y-m-d');
        $finmois = Carbon::now()->endOfMonth()->format('Y-m-d');

        $encaissements = Mouvement::getListe($annee_id, null, $role, null, TypeMouvement::ENCAISSEMENT );




        // Totaux paiements
        $total = Mouvement::getTotal($annee_id, null, $role, null, TypeMouvement::ENCAISSEMENT);
        $total_mois = Mouvement::getTotal($annee_id, null,  $role, null,$debutmois, $finmois);
        $total_semaine = Mouvement::getTotal($annee_id, null,  $role, null, null, $debutsemaine, $finsemaine);
        $total_jour = Mouvement::getTotal($annee_id, null,  $role, null, null,  $aujourdhui);




        foreach($encaissements as  $encaissement ){


            $data[]  = array(

                "id" => $encaissement->id,
                "reference" => $encaissement->paiement->reference == null ? ' ' : $encaissement->paiement->reference,
                "date_operation" => $encaissement->created_at == null ? ' ' : $encaissement->created_at,
                "paiement_id" => $encaissement->paiement_id == null ? ' ' : $encaissement->paiement_id,
                "montant" => $encaissement->montant == null ? ' ' : $encaissement->montant,

                "caisse" => $encaissement->caisse_id == null ? ' ' : $encaissement->caisse->libelle,
                "responsable" => $encaissement->caisse_id == null ? ' ' : $encaissement->caisse->responsable->nom.' '.$encaissement->caisse->responsable->prenom,


                "eleve" => $encaissement->paiement->inscription->eleve == null ? ' ' : $encaissement->paiement->inscription->eleve->nom . ' ' . $encaissement->paiement->inscription->eleve->prenom,

            );
        }

        return view('admin.encaissement.index')->with(
            [
                'data' => $data,

                'total' => $total,
                'total_mois' => $total_mois,
                'total_semaine' => $total_semaine,
                'total_jour' => $total_jour,




            ]


        );


    }
















    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function pdf($id)
    {

        $session = session()->get('LoginUser');
        $annee_id = $session['annee_id'];

        $compte_id = $session['compte_id'];

        $encaissement = Mouvement::rechercheMouvementById($id);

        $paiement = $encaissement->paiement;
        $inscription = Inscription::rechercheInscriptionById($paiement->inscription_id) ;
        $paiement = $encaissement->paiement;
        $annee = Annee::rechercheAnneeById($encaissement->annee_id);
        $caisse = Caisse::rechercheCaisseById($encaissement->caisse_id);




        $details = Detail::getListe($paiement->id);
        $caissier = User::rechercheUserById($caisse->responsable_id);
        $name = "Recu" . $paiement->reference;

        $montant_deja_payer = Detail::getMontantTotal($annee_id, null,TypePaiement::FRAIS_SCOLARITE, $inscription->id, null, StatutPaiement::ENCAISSE );


        $montant_scolarite =$inscription->frais_scolarite;
        $reste =$montant_scolarite - $montant_deja_payer;





        // }else{
        $pdf = PDF::loadView(
            'admin.encaissement.pdf',
            [

                'details' => $details,
                'annee' => $annee,
                'paiement' => $paiement,
                'encaissement' => $encaissement,
                "caissier" => $caissier,
                'montant_deja_payer' => $montant_deja_payer,
                'montant_scolarite' => $montant_scolarite,
                'reste' => $reste,
            ]
        );


        // }

        return $pdf->download($name . '.pdf');
    }






    public function store(Request $request)
    {

        $session = session()->get('LoginUser');
        $annee_id = $session['annee_id'];

        $compte_id = $session['compte_id'];

        $validator = \Validator::make($request->all(), [

            'paiement_id' => 'required',
            'montant_encaisse' => 'required',


        ], [

            'paiement_id.required' => 'Le choix du paiement    est obligatoire ',
            'montant_encaisse.required' => 'Le montant  est obligatoire ',


        ]);

        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {



         DB::beginTransaction();

       try {

            $paiement = Paiement::recherchePaiementById( $request->paiement_id);

             $ligne_details = $request->ligne_details;

            $caisse_id = $request->caisse_id;




            // Enregistrement du mouvement d encaissement


            $eleve =  $paiement->inscription->eleve->nom . ' ' . $paiement->inscription->eleve->prenom;

            $mouvement = Mouvement::addMouvement(

                "Encaissement des frais",
                $eleve,
                null,
                Carbon::now(),
                $request->montant_encaisse,
                TypeMouvement::ENCAISSEMENT,
                $caisse_id,
                $compte_id,
                $paiement->id,
                null,
                $annee_id,
                null,
                null



            );

            // Mise a jour du statut de paiement

            Paiement::updatePaiement(

                $paiement->reference,
                $paiement->payeur,
                $paiement->motif_suppression,
                $paiement->telephone_payeur,
                $paiement->date_paiement,
                StatutPaiement::ENCAISSE,
                $paiement->mode_paiement,
                $paiement->inscription_id,
                $paiement->utilisateur_id,
                $paiement->cheque_id,
                $paiement->annee_id,
                $paiement->id,


            );


            // mise a jour des details

             if ($request->ligne_details) {

                 foreach ($ligne_details as $ligne) {

                     $detail = Detail::rechercheDetailById($ligne['id']);





                     $detail_modifier=  Detail::updateDetail(
                         $detail->montant,
                         $detail->libelle,
                         $detail->paiement_id,
                         $detail->type_paiement,
                         $detail->inscription_id,
                         $detail->frais_ecole_id,
                         StatutPaiement::ENCAISSE,
                         $detail->annee_id,
                         $detail->souscription_id,
                         (int) $caisse_id,
                         $detail->comptable_id,
                         $compte_id,
                         $detail->date_paiement,
                         Carbon::now(),
                         $detail->id,


                     );




                 }
             }









             DB::commit();

            return response()->json(
                [
                    'code' => 1,
                    'msg' => 'Encaissement   enregistré  avec succès ',
                    'id' => $mouvement->id,





                ]

            );
  } catch (\Exception $e) {
                // En cas d'erreur, annulez la transaction
                DB::rollback();

                // Gérez l'erreur ou lancez une exception personnalisée
                // throw new CustomException('Une erreur s'est produite');

                return response()->json(
                    [
                        'code' => 0,
                        'msg' => "Une erreur s'est produite !",
                        'data' => $request->all()


                    ]

                );
            }
        }
    }



    /**
     * Afficher  un  detail d un encaissement
     *
     * @param  int $id

     * * @return \Illuminate\Http\JsonResponse
     */
    public function detail ($id)
    {
        $data= [] ;
        $encaissement = Mouvement::rechercheMouvementById($id);
        $caisse  = Caisse::rechercheCaisseById($encaissement->caisse_id);
        $responsable  = User::rechercheUserById($caisse->responsable_id);
        $paiement = Inscription::rechercheInscriptionById($encaissement->paiement_id);
        $responsable_name  = $responsable->nom.' '.$responsable->prenom ;

        $details = Detail::getListe($paiement->id);

        foreach($details as  $detail ){


            $data []  = array(

                "id" => $detail->id,
                "libelle" => $detail->libelle == null ? ' ' : $detail->libelle,
                "type_paiement" => $detail->type_paiement == null ? ' ' : $detail->type_paiement,
                "frais_ecole" => $detail->frais_ecole_id == null ? ' ' : $detail->fraisecole->libelle,
                "statut_paiement" => $detail->statut_paiement == null ? ' ' : $detail->statut_paiement,
                "souscription_id" => $detail->souscription_id == null ? ' ' : $detail->souscription_id,
                "montant" => $detail->montant == null ? ' ' : $detail->montant,

            );
        }

        return response()->json(

            ['code'=>1,

                'encaissement'=>$encaissement,
                'paiement'=>$paiement,
                'caisse'=>$caisse,
                'responsable_name'=>$responsable_name,
                'data'=>$data,


            ]);


    }





}
