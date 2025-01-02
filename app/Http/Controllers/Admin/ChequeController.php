<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cheque;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChequeController extends Controller
{

    /**
     * Affiche la  liste des  années
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= [] ;

        $cheques = Cheque::getListe();

        foreach($cheques as $cheque ){
            $data []  = array(

                "id"=>$cheque->id,
                "numero"=> $cheque->numero == null ? ' ' : $cheque->numero,
                "emetteur"=> $cheque->emetteur == null ? ' ' : $cheque->emetteur,
                "reference"=> $cheque->paiement_id == null ? ' ' : $cheque->paiement->reference,
                "statut"=> $cheque->statut == null ? ' ' : $cheque->statut,
                "banque_id"=> $cheque->banque_id == null ? ' ' : $cheque->banque->libelle,



            );
        }

        return view('admin.cheque.index')->with(
            [
                'data' => $data,

            ]


        );


    }








    public function update(Request $request, $id){


        $validator = \Validator::make($request->all(),[

            'numero'=>'required|string|max:25|unique:cheques,numero,'.$id,


        ],[
            'numero.required'=>'Le numero   est obligatoire ',


        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{

                Cheque::updateCheque(

                    $request->numero,
                    $request->emetteur,
                    $request->annee_id,
                    $request->paiement_id,
                    $request->date_emission,
                    $request->statut,
                    $request->date_encaissement,
                    $request->banque_id,


                    $id


                );



                return response()->json(['code'=>1,'msg'=>'Cheque modifiée  avec succès ']);
            }
        }






    /**
     * Afficher  un Cheque
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit ($id)
    {

        $cheque = Cheque::rechercheChequeById($id);


        return response()->json(['code'=>1, 'Cheque'=>$cheque]);


    }



    /**
     * Supprimer   une  Cheque scolaire .
     *
     * @param  int  $int
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request,$id)
    {



        $delete = Cheque::deleteCheque($id);


        // check data deleted or not
        if ($delete) {
            $success = true;
            $message = "Cheque  supprimée ";
        } else {
            $success = true;
            $message = "Cheque  non trouvée ";
        }


        //  return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }









}
