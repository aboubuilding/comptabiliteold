<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Detail;
use App\Models\Produit;


use Illuminate\Http\Request;


class ProduitController extends Controller
{

    /**
     * Affiche la  liste des  années
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= [] ;



        $produits = Produit::getListe();

        foreach($produits as $produit ){
            $data []  = array(

                "id"=>$produit->id,
                "libelle"=>$produit->libelle == null ? ' ' :$produit->libelle,
                "unite"=>$produit->unite == null ? ' ' :$produit->unite,
                "prix_unitaire_achat"=>$produit->prix_unitaire_achat == null ? ' ' :$produit->prix_unitaire_achat,
               
                "type_produit"=>$produit->equivalence == null ? ' ' :$produit->type_produit,




            );
        }

        return view('admin.produit.index')->with(
            [
                'data' => $data,

            ]


        );


    }




    public function store(Request $request){

        $session = session()->get('LoginUser');
        $annee_id = $session['annee_id'];


        $validator = \Validator::make($request->all(),[
            'libelle'=>'required|string|max:25',
            'prix_unitaire_achat'=>'required',

            'unite'=>'required',
            'type_produit'=>'required',




        ],[
            'libelle.required'=>'Le libellé  est obligatoire ',
            'libelle.string'=>'Le libellé  doit etre une chaine de caracteres ',
            'libelle.max'=>'Le libellé  ne peut pas depasser 25 caracteres ',
            'prix_unitaire_achat.required'=>'Le prix d achat  est obligatoire  ',
            'unite.required'=>'L unite est obligatoire  ',
            'type_produit.required'=>'Le type de produit   est obligatoire  ',




        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{


                 Produit::addProduit(

                    $request->libelle,
                    $request->prix_unitaire_achat,
                    $request->prix_unitaire_vente,
                    $request->prix_unitaire_stock,
                  
                    $request->photo,
                    $request->unite,
                    $request->unite_achat,
                    $request->equivalence,
                    $request->type_produit,




                );



                return response()->json(['code'=>1,'msg'=>'Produit  ajouté avec succès ']);
            }
        }



    public function update(Request $request, $id){

        $session = session()->get('LoginUser');
        $annee_id = $session['annee_id'];
        $validator = \Validator::make($request->all(),[

            'libelle'=>'required|string|max:25',
            'prix_unitaire_achat'=>'required',

            'unite'=>'required',
            'type_produit'=>'required',


        ],[
            'libelle.required'=>'Le libellé  est obligatoire ',
            'libelle.string'=>'Le libellé  doit etre une chaine de caracteres ',
            'libelle.max'=>'Le libellé  ne peut pas depasser 25 caracteres ',
            'prix_unitaire_achat.required'=>'Le prix d achat  est obligatoire  ',
            'unite.required'=>'L unite est obligatoire  ',
            'type_produit.required'=>'Le type de produit   est obligatoire  ',



        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{

                Produit::updateProduit(

                    $request->libelle,
                    $request->prix_unitaire_achat,
                    $request->prix_unitaire_vente,
                    $request->prix_unitaire_stock,
                  
                    $request->photo,
                    $request->unite,
                    $request->unite_achat,
                    $request->equivalence,
                    $request->type_produit,



                    $id


                );



                return response()->json(['code'=>1,'msg'=>'Produit modifié  avec succès ']);
            }
        }






    /**
     * Afficher  un Produit
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit ($id)
    {

        $produit = Produit::rechercheProduitById($id);


        return response()->json(['code'=>1, 'produit'=>$produit]);


    }







    /**
     * Supprimer   une  Produit scolaire .
     *
     * @param  int  $int
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request,$id)
    {



        $delete = Produit::deleteProduit($id);


        // check data deleted or not
        if ($delete) {
            $success = true;
            $message = "Produit  supprimée ";
        } else {
            $success = true;
            $message = "Produit  non trouvée   ";
        }


        //  return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }







}
