<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annee;
use App\Models\User;

use App\Types\Menu;
use App\Types\StatutAnnee;
use App\Types\TypeStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UtilisateurController extends Controller
{

    /**
     * Affiche la  liste des  années
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= [] ;

        $users = User::getListe();

        foreach($users as $user ){
            $data []  = array(

                "id"=>$user->id,
                "nom_prenom" => $user->prenom == null ? ' ' : $user->nom.' '.$user->prenom,
                "login"=>$user->login == null ? ' ' :$user->login,
                "email"=>$user->email == null ? ' ' :$user->email,
                "role"=>$user->role == null ? ' ' :$user->role,
            );
        }

        return view('admin.user.index')->with(
            [
                'data' => $data,

            ]


        );


    }




    public function store(Request $request){



        $validator = \Validator::make($request->all(),[
            'nom'=>'required',
            'prenom'=>'required',
            'login'=>'required|string|unique:Users',
            'mot_passe'=>'required',
            'role'=>'required',


        ],[
            'nom.required'=>'Le nom   est obligatoire ',
            'prenom.required'=>'Le prenom   est obligatoire ',
            'login.required'=>'Le login    est obligatoire',
            'mot_passe.required'=>'Le mot de passe    est obligatoire ',
            'role.required'=>'Le role   est  obligatoire ',
            'login.unique'=>'Le login   existe déjà ',


        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{

              $file_name = null;

            if ($request->hasFile('photo')) {


                $file = $request->file('photo');
                $ext = $file->getClientOriginalExtension();


                $file_name = time().'_'.$file->getClientOriginalName().'.'.$ext;;



                $file->move('uploads/users/' ,$file_name);




            }

                 User::addUser(

                    $request->nom,
                    $request->prenom,
                    $request->login,

                    // $request->mot_passe,
                    Hash::make($request->mot_passe),
                    $request->role,
                    $request->email,

                     $file_name


                );



                return response()->json(['code'=>1,'msg'=>'User  ajoutée avec succès ']);
            }
        }



    public function update(Request $request, $id){

        $user = User::rechercheUserById($id);
        $validator = \Validator::make($request->all(),[

            'nom'=>'required',
            'prenom'=>'required',
            'login'=>'required|string|unique:Users,login,'.$id,
            'mot_passe'=>'required',
            'role'=>'required',


        ],[
            'nom.required'=>'Le nom   est obligatoire ',
            'prenom.required'=>'Le prenom   est obligatoire ',
            'login.required'=>'Le login    est obligatoire ',
            'mot_passe.required'=>'Le mot de passe    est obligatoire ',
            'role.required'=>'Le role   est  obligatoire ',
            'login.unique'=>'Le login   existe déjà ',



        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{

             $file_name = $user->photo;

            if ($request->hasFile('photo')) {
                $path = 'uploads/utilisateurs/'.$user->photo;
                if(File::exists($path))
                {
                    File::delete($path);
                }

                $file = $request->file('photo');
                $ext = $file->getClientOriginalExtension();


                $file_name = time().'_'.$file->getClientOriginalName().'.'.$ext;;



                $file->move('uploads/utilisateurs/' ,$file_name);

            }


            User::updateUser(

                $request->nom,
                $request->prenom,
                    $request->login,

                    $request->role,
                    $request->email,

                     $file_name,

                    $id


                );



                return response()->json(['code'=>1,'msg'=>'Utilisateur modifiée  avec succès ']);
            }
        }






    /**
     * Afficher  un User
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit ($id)
    {

        $user = User::rechercheUserById($id);


        return response()->json(['code'=>1, 'utilisateur'=>$user]);


    }



    /**
     * Supprimer   une  User scolaire .
     *
     * @param  int  $int
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request,$id)
    {



        $delete = User::deleteUser($id);


        // check data deleted or not
        if ($delete) {
            $success = true;
            $message = "Utilisateur  supprimée ";
        } else {
            $success = true;
            $message = "Utilisateur  non trouvée   ";
        }


        //  return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }






    /**
     * Authentifier   un User
     *
     * @param  int  $int
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\JsonResponse

     */
    public function authenticate(Request $request)
    {

        $compte = null;



        $compte = User::login_User($request->login);

        $total_annee = Annee::getTotal();
        $total_annee_ouverte = Annee::getTotal(StatutAnnee::OUVERT);

        if (!$total_annee || !$total_annee_ouverte) {

            Annee::genererAnneePremiere();
        }

        $annee_id = Annee::getAnneeOuverte();
        $code = 0;
        $message = '';
        $is_true = false;

        // $is_true = Hash::check($request->mot_passe, $compte->mot_passe);

        if ($compte && Hash::check($request->mot_passe, $compte->mot_passe)) {

            if ($compte->etat == TypeStatus::SUPPRIME) {
                $message = "Votre compte a été supprimé.";
            } else {
                $is_true = true;
                $request->session()->put('LoginUser', [
                    'compte_id' => $compte->id,
                    'annee_id' => $annee_id,
                    'role' => (int) $compte->role,

                ]);
                $code = 1;
            }
        } else {
            $message = "Login ou mot de passe incorrect";
        }


        return response()->json(

            [
                'code' => $code,
                'msg' => $message,
                'compte' => $compte,
                'is_true' => $is_true


            ]


        );
    }

}
