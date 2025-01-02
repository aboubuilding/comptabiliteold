<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Types\Menu;
use App\Types\Sexe;
use App\Models\Detail;
use App\Models\Mouvement;
use App\Types\TypePaiement;
use App\Types\TypeMouvement;
use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Types\StatutPaiement;
use App\Types\StatutValidation;
use App\Types\TypeInscription;

class TableauController extends Controller
{


    /**
     * Affiche la  liste des  categories
     *
     * @return \Illuminate\Http\Response
     */
    public function tableau ()
    {


        $session = session()->get('LoginUser');
        $annee_id = $session['annee_id'];
        $compte_id = $session['compte_id'];

        // totaux des eleves

        // Tableau de bord des inscriptions


        $total_eleves  = Inscription::getTotal($annee_id, null,  null, null, null, null,null,  StatutValidation::VALIDE);
        $total_nouveau = Inscription::getTotal($annee_id, null,  null, null, null, null,TypeInscription::INSCRIPTION,  StatutValidation::VALIDE);
        $total_anciens = Inscription::getTotal($annee_id, null,  null, null, null, null,TypeInscription::REINSCRIPTION,  StatutValidation::VALIDE);
        $total_garcons = Inscription::getTotal($annee_id, null,  null, null, null, null,null,  StatutValidation::VALIDE, null, null, null, null, null, null, Sexe::MASCULIN);

        $total_filles = Inscription::getTotal($annee_id, null,  null, null, null, null,null,  StatutValidation::VALIDE, null, null, null, null, null, null, Sexe::MASCULIN);

        // tableau de bord des encaissements

        $debutsemaine = \Illuminate\Support\Carbon::now()->startOfWeek();
        $finsemaine = Carbon::now()->endOfWeek();



        // aujourdhui

        $aujourdhui = Carbon::today();

        $debutmois = \Illuminate\Support\Carbon::now()->startOfMonth();
        $finmois = Carbon::now()->endOfMonth();



        // Totaux paiements
        $total_encaissement_montant = Detail::getMontantTotal($annee_id, null,  null, null,null,  StatutPaiement::ENCAISSE);
        $total_encaissement_montant_mois = Detail::getMontantTotal($annee_id, null,  null, null,null,  StatutPaiement::ENCAISSE,$debutmois, $finmois);
        $total_encaissement_montant_semaine = Detail::getMontantTotal($annee_id, null,  null, null,null,  StatutPaiement::ENCAISSE,  $debutsemaine, $finsemaine);
        $total_encaissement_montant_jour = Detail::getMontantTotal($annee_id, null,  null, null, null, StatutPaiement::ENCAISSE, $aujourdhui);


$total_cantine = Detail::getMontantTotal($annee_id, null,  TypePaiement::CANTINE, null, null, StatutPaiement::ENCAISSE);
$total_bus = Detail::getMontantTotal($annee_id, null,  TypePaiement::BUS, null, null, StatutPaiement::ENCAISSE);;
$total_scolarite = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_SCOLARITE, null, null, StatutPaiement::ENCAISSE);;
$total_inscription = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_INSCRIPTION, null, null, StatutPaiement::ENCAISSE);;
$total_assurance = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_ASSURANCE, null, null, StatutPaiement::ENCAISSE);;
$total_livre = Detail::getMontantTotal($annee_id, null,  TypePaiement::LIVRE, null, null, StatutPaiement::ENCAISSE);;
$total_produit = Detail::getMontantTotal($annee_id, null,  TypePaiement::PRODUIT, null, null, StatutPaiement::ENCAISSE);;
$total_frais_examen = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_EXAMEN, null, null, StatutPaiement::ENCAISSE);;


// Details du mois

$total_mois_cantine = Detail::getMontantTotal($annee_id, null,  TypePaiement::CANTINE, null, null, StatutPaiement::ENCAISSE,$debutmois, $finmois);
$total_mois_bus = Detail::getMontantTotal($annee_id, null,  TypePaiement::BUS, null, null, StatutPaiement::ENCAISSE,$debutmois, $finmois);;
$total_mois_scolarite = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_SCOLARITE, null, null, StatutPaiement::ENCAISSE,$debutmois, $finmois);;
$total_mois_inscription = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_INSCRIPTION, null, null, StatutPaiement::ENCAISSE,$debutmois, $finmois);;
$total_mois_assurance = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_ASSURANCE, null, null, StatutPaiement::ENCAISSE,$debutmois, $finmois);;
$total_mois_livre = Detail::getMontantTotal($annee_id, null,  TypePaiement::LIVRE, null, null, StatutPaiement::ENCAISSE,$debutmois, $finmois);;
$total_mois_produit = Detail::getMontantTotal($annee_id, null,  TypePaiement::PRODUIT, null, null, StatutPaiement::ENCAISSE,$debutmois, $finmois);;
$total_mois_frais_examen = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_EXAMEN, null, null, StatutPaiement::ENCAISSE,$debutmois, $finmois);;




// Details de la semaine

$total_semaine_cantine = Detail::getMontantTotal($annee_id, null,  TypePaiement::CANTINE, null, null, StatutPaiement::ENCAISSE,  $debutsemaine, $finsemaine);
$total_semaine_bus = Detail::getMontantTotal($annee_id, null,  TypePaiement::BUS, null, null, StatutPaiement::ENCAISSE,  $debutsemaine, $finsemaine);
$total_semaine_scolarite = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_SCOLARITE, null, null, StatutPaiement::ENCAISSE,  $debutsemaine, $finsemaine);
$total_semaine_inscription = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_INSCRIPTION, null, null, StatutPaiement::ENCAISSE,  $debutsemaine, $finsemaine);
$total_semaine_assurance = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_ASSURANCE, null, null, StatutPaiement::ENCAISSE,  $debutsemaine, $finsemaine);
$total_semaine_livre = Detail::getMontantTotal($annee_id, null,  TypePaiement::LIVRE, null, null, StatutPaiement::ENCAISSE,  $debutsemaine, $finsemaine);
$total_semaine_produit = Detail::getMontantTotal($annee_id, null,  TypePaiement::PRODUIT, null, null, StatutPaiement::ENCAISSE,  $debutsemaine, $finsemaine);
$total_semaine_frais_examen = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_EXAMEN, null, null, StatutPaiement::ENCAISSE,  $debutsemaine, $finsemaine);


// Details de la semaine

$total_jour_cantine = Detail::getMontantTotal($annee_id, null,  TypePaiement::CANTINE, null, null, StatutPaiement::ENCAISSE, $aujourdhui);
$total_jour_bus = Detail::getMontantTotal($annee_id, null,  TypePaiement::BUS, null, null, StatutPaiement::ENCAISSE, $aujourdhui);
$total_jour_scolarite = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_SCOLARITE, null, null, StatutPaiement::ENCAISSE, $aujourdhui);
$total_jour_inscription = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_INSCRIPTION, null, null, StatutPaiement::ENCAISSE, $aujourdhui);
$total_jour_assurance = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_ASSURANCE, null, null, StatutPaiement::ENCAISSE, $aujourdhui);
$total_jour_livre = Detail::getMontantTotal($annee_id, null,  TypePaiement::LIVRE, null, null, StatutPaiement::ENCAISSE, $aujourdhui);
$total_jour_produit = Detail::getMontantTotal($annee_id, null,  TypePaiement::PRODUIT, null, null, StatutPaiement::ENCAISSE, $aujourdhui);
$total_jour_frais_examen = Detail::getMontantTotal($annee_id, null,  TypePaiement::FRAIS_EXAMEN, null, null, StatutPaiement::ENCAISSE, $aujourdhui);



        return view('admin.tableau')->with(
            [

// Total des encaiseements
                'total_encaissement_montant' =>  $total_encaissement_montant,
                'total_encaissement_montant_mois' =>  $total_encaissement_montant_mois,
                'total_encaissement_montant_semaine' =>  $total_encaissement_montant_semaine,
                'total_encaissement_montant_jour' => $total_encaissement_montant_jour,

// totaux par type de paiements pour l ensemble

'total_cantine' => $total_cantine,
'total_bus' => $total_bus,
'total_scolarite' => $total_scolarite,
'total_inscription' => $total_inscription,
'total_assurance' => $total_assurance,
'total_livre' => $total_livre,
'total_produit' => $total_produit,
'total_frais_examen' => $total_frais_examen,

// totaux par type de paiements pour le mois

'total_mois_cantine' => $total_mois_cantine,
'total_mois_bus' => $total_mois_bus,
'total_mois_scolarite' => $total_mois_scolarite,
'total_mois_inscription' => $total_mois_inscription,
'total_mois_assurance' => $total_mois_assurance,
'total_mois_livre' => $total_mois_livre,
'total_mois_produit' => $total_mois_produit,
'total_mois_frais_examen' => $total_mois_frais_examen,

// totaux par type de paiements pour la semaine

'total_semaine_cantine' => $total_semaine_cantine,
'total_semaine_bus' => $total_semaine_bus,
'total_semaine_scolarite' => $total_semaine_scolarite,
'total_semaine_inscription' => $total_semaine_inscription,
'total_semaine_assurance' => $total_semaine_assurance,
'total_semaine_livre' => $total_semaine_livre,
'total_semaine_produit' => $total_semaine_produit,
'total_semaine_frais_examen' => $total_semaine_frais_examen,


// totaux par type de paiements pour la semaine

'total_jour_cantine' => $total_jour_cantine,
'total_jour_bus' => $total_jour_bus,
'total_jour_scolarite' => $total_jour_scolarite,
'total_jour_inscription' => $total_jour_inscription,
'total_jour_assurance' => $total_jour_assurance,
'total_jour_livre' => $total_jour_livre,
'total_jour_produit' => $total_jour_produit,
'total_jour_frais_examen' => $total_jour_frais_examen,


// totaux  DES INSCRIPTIONS


'total_eleves' => $total_eleves,
'total_nouveau' => $total_nouveau,
'total_anciens' => $total_anciens,
'total_garcons' => $total_garcons,




            ]


        );


    }





    /**
     * Affiche le tabkleau  de bord du parc
     *
     * @return \Illuminate\Http\Response
     */
    public function parc  ()
    {



        return view('admin.parc')->with(
            [


            ]


        );


    }





    /**
     * Affiche le tabkleau  de bord du parc
     *
     * @return \Illuminate\Http\Response
     */
    public function cantine  ()
    {



        return view('admin.cantine')->with(
            [


            ]


        );


    }



}
